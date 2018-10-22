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


			
			$i=1;

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


				$duracion = $crawler->filter('#informacion > p')->eq(5)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});
				/////Reparto
				$reparto = $crawler->filter('#informacion > p')->eq(10)->each(function($node){
								return $node->filter('.ab > a')->each(function($node_a){

									$actor = Actor::firstOrCreate(['name' => $node_a->text()]);
									return $actor->id;
								});
							});
				/////////////
				/////Genre
				$generos = $crawler->filter('#informacion > p')->eq(4)->each(function($node){
								 return $node->filter('.ab > a')->each(function($node_a){
									
									 $genre = Genre::firstOrCreate(['name' => $node_a->text()]);
									 return $genre->id;
								});
							});
				// echo '<pre>';
				// 	var_dump($generos);
				// echo '<pre>';
				

				//echo json_encode($genero[0]);	
				
				////////////

				$imagen = $crawler->filter('.poster > img')->first()->attr('src');

				///////director
				$director = $crawler->filter('#informacion > p')->eq(9)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});

				if($director){
					$dire = Director::firstOrCreate(['name' => implode($director)]);
					$director_id = response($dire->id)->original;
				}else{
					$director_id = 1;
				}


				//echo $director_id.'<br>';
				//////////////				

				//Armamos el array de datos
				$datos = [
					'title' => implode($titulo),
					'title_origin' => implode($titulo_origen),
					'description' => $descripcion,
					'ano' => implode($ano),
					//'genre' => $genero,
					'duration' => implode($duracion),
					'image' => $imagen,
					//rating =>
					'url_origin' => implode($linkOrigen),
					'state' => 1,
					'director_id' => $director_id,
					//'actor' => $reparto,
					
				];
				
				$movies = Movie::create($datos);
				$movies->genres()->sync($generos[0]);
				$movies->actors()->sync($reparto[0]);
				
			};
		};
		//echo json_encode($datos);	
		//$movies = Movie::create($datos);
		//dd($datos);
		// foreach ($datos as $dato) {
		// };

    }
}
