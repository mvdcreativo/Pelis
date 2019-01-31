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
	// Auth
    public function __construct()
    {
        $this->middleware('auth');
	}
	
	
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
			if($response->getStatusCode() == 501){
				echo 'error En el Servidor de Openload';
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

							$imagen = $crawler->filter('.mvic-thumb > img')->first()->attr('src');
			

							
							//Armamos el array de datos
							$datos = [
								'title' => $titulo,
								//'title_origin' => implode($titulo_origen),
								// 'description' => $descripcion,
								// 'ano' => $ano,
								// 'duration' => $duracion,
								'image' => $imagen,
								//'rating' => $rating,
								'url_origin' => $urlOrigin,
								'state' => 0,
								// 'director_id' => $director_id,
								'id_upload' => $upload_id,
								
							];
							//////GUARDAMOS EN LA BD
							$movies = Movie::firstOrCreate(['title' => $datos['title']], $datos );

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
		$n_paginas =2;

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



