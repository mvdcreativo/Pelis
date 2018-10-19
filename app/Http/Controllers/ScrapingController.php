<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Collection as Collection;
use Symfony\Component\DomCrawler\Crawler;

use App\Movie;
use App\Director;


class ScrapingController extends Controller
{
    //


    public function scrape(Client $cliente, Crawler $crawler )
    {




    	$url_objetivo = "https://www.inkapelis.com/?anio=&genero=&calidad=FULLHD&idioma=Latino&s=";

    	$crawler  = $cliente->request('GET', $url_objetivo);


		
		$peliculas = $crawler->filter('.postsh > .poster-media-card > .info > a')->each(function($peli_node){
				    // $peli_node->attr('href');
					//echo $peli_node->html();
					return $peli_node->attr('href');
				});

		//echo json_encode($peliculas);
		if($peliculas){




			foreach ($peliculas as $pelicula) {
				$crawler  = $cliente->request('GET', $pelicula);

			////conseguimos el link de descarga
				$dwlZone = $crawler->filter('#dlnmt > table > tbody > tr')
					->each(function($dl_node){
						
						$tdIdioma = $dl_node->filter('td')->eq(2)->text();
						$tdServer = $dl_node->filter('td > span')->first()->text();

						if($tdIdioma == "Latino"){
							if($tdServer == "1fichier"){
								return $dl_node->filter('td > a')->eq(0)->attr('href');
							}
							
						}else{
							return null;
						}
					});

				$linkOrigen = array_values(array_filter($dwlZone)) ;
				/////

				$titulo =  $crawler->filter('#informacion > p')->eq(1)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});
				$titulo_origen =  $crawler->filter('#informacion > p')->eq(2)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});

				$descripcion = $crawler->filter('#informacion > p')->first()->text();

				$ano = $crawler->filter('#informacion > p')->eq(3)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});

				$genero = $crawler->filter('#informacion > p')->eq(4)->each(function($node){
								return $node->filter('.ab > a')->each(function($node_a){
									return $node_a->text();
								});
							});

				$duracion = $crawler->filter('#informacion > p')->eq(5)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});

				$reparto = $crawler->filter('#informacion > p')->eq(10)->each(function($node){
								return $node->filter('.ab > a')->each(function($node_a){
									return $node_a->text();
								});
							});

				$imagen = $crawler->filter('.poster > img')->first()->attr('src');

				///////director
				$director = $crawler->filter('#informacion > p')->eq(9)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});

				if($director){
					$getDirector = Director::where('name', implode($director))->first();
					if($getDirector != null){
						$director_id = $getDirector->id;
					}else{
						$dire = Director::create(['name' => implode($director)]);
						$director_id = response($dire->id)->original;
					}
					
					$datos = [
						'title' => implode($titulo),
						'title_origin' => implode($titulo_origen),
						'description' => $descripcion,
						'ano' => implode($ano),
						'genre' => $genero,
						'duration' => implode($duracion),
						'director' => $director_id,
						'actor' => $reparto,
						'image' => $imagen,
						'url_origin' => implode($linkOrigen),
						'state' => '1'
						
					];
				}
				//////////////				

				//Armamos el array de datos

				
				if($datos != null){
					$movies = Movie::create($datos);
					$i = $i++;
					return 'Se an agregado '.$i.' peliculas';
				};
			};
		};
		//echo json_encode($datos);	

		//$movies = Movie::create($datos);
		//dd($datos);
    }
}
