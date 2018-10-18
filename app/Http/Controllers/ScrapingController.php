<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Goutte\Client;
use Illuminate\Support\Collection as Collection;
use Symfony\Component\DomCrawler\Crawler;


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

				$director = $crawler->filter('#informacion > p')->eq(9)->each(function($node){
								return $node->filter('.ab')->first()->text();
							});

				$reparto = $crawler->filter('#informacion > p')->eq(10)->each(function($node){
								return $node->filter('.ab > a')->each(function($node_a){
									return $node_a->text();
								});
							});

				$imagen = $crawler->filter('.poster > img')->first()->attr('src');


				//Armamos el array de datos
				$datos[] = [
					'title' => implode($titulo),
					'title_origin' => implode($titulo_origen),
					'description' => $descripcion,
					'ano' => implode($ano),
					'genre' => $genero,
					'duration' => implode($duracion),
					'director' => implode($director),
					'actor' => $reparto,
					'image' => $imagen,
					'url_origin' => implode($linkOrigen),
					
				];
				
				
			};
		};
		echo json_encode($datos);	

 	//
		//$collection_peliculas = Collection::make($url_peliculas);
		//var_dump($url_peliculas);

		// foreach ($url_peliculas as $url_pelicula ) {
		// 	$crawler  = $cliente->request('GET', $url_pelicula);

		// 	$dato = [
		// 	  	'titulo' => $crawler->filter('.post_title')->first()->text(),
		// 		'descripcion' => $crawler->filter('.movie-info')->first()->text(),

		// 		// 'link' => $crawler->filter('#dlnmt > table > tbody > tr > td > a')->each(function($dl_node){
		// 		//     		$comienza = "https://openload.co/f/";
		// 		//     		$dl_link = $dl_node->attr('href');
		// 		//     		return $dl_link;
		// 		// 			// if(stristr($dl_link, $comienza) and stristr($dl_link, "Latino") == TRUE) {
		// 		// 			// 	return $dl_node->attr('href');
		// 		// 			// 	//echo $dl_linkOL;
		// 		// 			// };

		// 		//     	})
		//     ];
		//     echo "<pre>";
		//     var_dump($dato);
		//     echo ""
//var_dump($link);
			//echo $titulo."<br>".$descripcion."<br>".$link[1]."<br><br><br>";
		
		
		

// 		foreach ($url_peliculas as $url_pelicula ) {
		
// 			$crawler  = $cliente->request('GET', $url_pelicula[0]);

// 	    	$titulo = $crawler->filter('.todino > h1')->first()->text();
// 	    	$descripcion = $crawler->filter('.sinopsis')->first()->text();

// 	    	$link = $crawler->filter('#dlnmt > table > tbody > tr > td > a')->each(function($dl_node){
// 	    				$comienza = "https://openload.co/f/";
// 	    				$dl_link = $dl_node->attr('href');

// 						  if(stristr($dl_link, $comienza) and stristr($dl_link, "Latino") == TRUE) {
// 						    $dl_linkOL = $dl_link;
// 						    echo $dl_linkOL;
// 						  };

// 	    			});
// //var_dump($link);
// 			//echo $titulo."<br>".$descripcion."<br>".$link[1]."<br><br><br>";
// 		}




  //   	$link = $crawler->selectLink('Security Advisories')->link();
		// $crawler = $client->click($link);
  //   	dd($crawler->html());


    }
}
