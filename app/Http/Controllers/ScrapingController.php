<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Collection as Collection;
use Symfony\Component\DomCrawler\Crawler;

use App\Movie;
use App\Director;
use App\Actor;
use App\Genre;


//ALL PELIS
class ScrapingController extends Controller
{

//METODO PARA SUBIR A OPENLOAD
	public function upload($urlOrigen, $titulo)
	{
		if($urlOrigen){
			$client = new \GuzzleHttp\Client();
			$response = $client->request('GET', 'https://api.openload.co/1/remotedl/add', [
				'query' => [
					// 'login' => '4c27f06e8bc67437',
					// 'key' => 'wIZfdNAC',
					// 'url' => $urlOrigen,
					// 'folder' => 6385040
					'login' => '3c1cef2383ac50d1',
					'key' => 'mgatOun9',
					'url' => $urlOrigen,
					'folder' => 6162544
				]
			]);

			if($response->getStatusCode() == 200){
				$result = json_decode($response->getBody()->getContents());

				$upload = [];
				$upload['result'] = $result->result;

				if(isset( $upload['result']->id)){
					return $upload;
				}else{

					$status = $result->status;
					if( $status == 403){
						return $error = ['status' => 'error', 'code' => 403, 'msg' =>'Se termino por hoy'];
					}else{
						return $error = ['status' => 'error', 'code' => 401, 'msg' =>'Ocurrio un ERROR'];
					};					
				};

				////si es 403 por limite de Uploads


			};


		}
	}

//METODO DE SCRAPING
    public function scrape($url_objetivo)
    {
		//$url_objetivo = "https://www.inkapelis.com/page/2/?anio=2018&genero&calidad=FULLHD&idioma=Latino&s";
		 //$url_objetivo = "http://fanpelis.com/movies/page/10/";
		//$url_objetivo = "http://fanpelis.com/movies/";
		$cliente = new Client;
		$crawler = new Crawler;
    	$crawler  = $cliente->request('GET', $url_objetivo);


		
		$peliculas = $crawler->filter('.MovItem > a')->each(function($peli_node){
					return $peli_node->attr('href');
				});

		//echo json_encode($peliculas);
		if($peliculas){


			
			$i=1;

			foreach ($peliculas as $pelicula) {
				$crawler  = $cliente->request('GET', $pelicula);
				
				
			////conseguimos el link de descarga
				$dwlZone = $crawler->filter('#list-dl > div > .embed-selector > a')->each(function($node){

					$openload = stripos($node->text(), 'openload');
					if($openload !== false)
					{
						return $node->attr('href');
					}

				});
				$url_descargas = array_filter($dwlZone);
				$linkDwl = array_values($url_descargas);
				if(isset($linkDwl[0])){
					$linkDwl = $linkDwl[0];

					$crawlerDwl  = $cliente->request('GET', $linkDwl);

					$urlOrigin =  $crawlerDwl->filter('.full > a')->first()->attr('href');
				////////////////	
					
					////TITULO
					$titulo =  $crawler->filter('.mvic-desc > h3')->first()->text();
	
	// 				$titulo_origen =  $crawler->filter('#informacion > p')->eq(2)->each(function($node){
	// 								return $node->filter('.ab')->first()->text();
	// 							});
					
					//////Si la pelicula no existe en la bd, se envia y se guarda
					$movie = Movie::where('title',$titulo)->get();
	
					if($movie->isEmpty()){
						//////ENVIO A OPNLOAD
						$upload_id = $this->upload($urlOrigin, $titulo);
						
						//////////////////////////////
						/// si el envio es correcto	
						if(isset($upload_id['result']->id)){
							echo $upload_id['result']->id.'<br>';
							$upload_id = $upload_id['result']->id;
							////DESCRIPCION / SINOPSIS
							$if_p = $crawler->filter('.mvic-desc > .desc ')->first()->html();
							$pos = strpos($if_p, "<p>");
							if($pos !== false){
								$descripcion = $crawler->filter('.mvic-desc > .desc > p')->first()->text();	
							}else{
								$descripcion = "Sin Descripción";
							};
							
			
							////AÑO
							$ano = $crawler->filter('.mvic-info > .mvici-right > p')->eq(2)->each(function($node){
								return $node->filter('a')->first()->text();
							});
							if($ano != null){
								$ano = implode($ano);
							}else{
								$ano = 0;
							}
							
			
							////DURACION
							$duracion = $crawler->filter('.mvic-info > .mvici-right > p')->eq(0)->each(function($node){
								return $node->filter( 'span')->first()->text();
							});
							$duracion = implode($duracion);
			
							/////REPARTO
							$reparto = $crawler->filter('.mvic-info > .mvici-left > p')->eq(3)->each(function($node){
											return $node->filter('span > a')->each(function($node_a){
			
												$actor = Actor::firstOrCreate(['name' => $node_a->text()]);
												return $actor->id;
											});
										});
							/////////////
							/////Genre
							$generos = $crawler->filter('.mvic-info > .mvici-left > p')->eq(1)->each(function($node){
											return $node->filter('a')->each(function($node_a){
												$genre = Genre::firstOrCreate(['name' => $node_a->text()]);
												return $genre->id;
											});
										});
							////////////
							$imagen = $crawler->filter('.mvic-thumb > img')->first()->attr('src');
			
							///////DIRECTOR
							$director = $crawler->filter('.mvic-info > .mvici-left > p')->eq(2)->each(function($node){
											return $node->filter('span > a')->first()->each(function($node_a){
												$dire = Director::firstOrCreate(['name' =>  $node_a->text()]);
												return $dire->id;
											});
										});
							if($director != null)
							{
								$director_id = implode($director[0]);
							}else{
								$director_id = 0;
							}
							//////////////	

							// ////////RATING
							// $rating = $crawler->filter('.imdb_r > p > span')->first()->text();
							// //////////////

							
							//Armamos el array de datos
							$datos = [
								'title' => $titulo,
								//'title_origin' => implode($titulo_origen),
								'description' => $descripcion,
								'ano' => $ano,
								'duration' => $duracion,
								'image' => $imagen,
								//'rating' => $rating,
								'url_origin' => $urlOrigin,
								'state' => 0,
								'director_id' => $director_id,
								'id_upload' => $upload_id,
								
							];
							// 	echo '<pre>';
							// var_dump($datos);
							//////GUARDAMOS EN LA BD
							$movies = Movie::firstOrCreate(['title' => $datos['title']], $datos );
							$movies->genres()->sync($generos[0]);
							if(isset($reparto[0])){
								$movies->actors()->sync($reparto[0]);
							}
						}else{
							
							if($upload_id['code'] == 403){
								$this.exit($upload_id['msg']);
							}
						
						}
					
					}else{
						echo 'Existe en la bd<br>';
					}
				
				}
				
 			};
 		};


	}
	
////METODO LANZADOR
	public function tomar_datos(Client $cliente,  Crawler $crawler)
	{
		$URL= "http://fanpelis.com/movies/";

		$crawler  = $cliente->request('GET', $URL);


		
		$paginas = $crawler->filter('.pagination > li')->eq(3)->each(function($node){
					return $node->filter(' a ')->first()->attr('href');
					
				});

		//$n_paginas = basename(implode($paginas));
		$n_paginas = 20;

		for ($i=0; $i <= $n_paginas; $i++) {
			if($i==0){
				$url_objetivo = "http://fanpelis.com/movies/";
			}else{
				$url_objetivo = "http://fanpelis.com/movies/page/".$i."/";
			}
			$this->scrape($url_objetivo);
		}
	}
}



