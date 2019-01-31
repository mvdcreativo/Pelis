@extends('layouts.app', [
  'meta_title' => $meta_title ,
  'meta_description'=> $meta_description,
  'meta_claves' => $meta_claves
  ])
@if (!isset($genre))
    <?php 
    $titulo_page = 'Listado de películas online más recientes en HD.';
    $meta_title = 'Listado de Películas online';
    $meta_description = 'Sin Publicidad molesta. Listados de películas Online en buena calidad HD o Full HD en idioma Español Latino, información sobre películas estreno o clasicos';
    $meta_claves = 'cine de calidad, full HD,HD, Latino,allPelis,gratis,online';
    ?>
@else
    <?php
    $titulo_page = 'Películas de '.$genre->name.' online más recientes en HD.';
    $meta_title = 'Peliculas de '.$genre->name;
    $meta_description = 'Peliculas de '.$genre->name.'. Listado de las mejores peliculas de '.$genre->name.' online Latino y gratis, buena calidad HD o Full HD en idioma Español Latino, información sobre películas estreno o clasicos';
    $meta_claves = 'pelicula, online, pelicula de '.$genre->name.', latino,idioma español, hd, full hd,buena calidad';
    ?>
@endif

@if (isset($search))
    <?php
        $titulo_page = 'Resultado de su busqueda';
    ?>
@endif

@section('content')
{{-- {!! dd($movies) !!} --}}
{{-- {!! $movies->render() !!} --}}
    <h1>{{ $titulo_page }}</h1>
    @if ($movies->total()==0)
        <h2>No se obtuvieron resultados. <strong>Intente ser menos específico</strong></h2>  
    @else
        @if ($movies->total()==1)
        <h2><strong>{{ $movies->total() }}</strong> película encontrada.</h2>
        @else
        <h2><strong>{{ $movies->total() }}</strong> películas encontradas.</h2>
        @endif
    @endif

    <div class="contenedor">
        
        @foreach ($movies as $movie)

            <div class="em-card-item">
            <a href="/peliculas/{{ $movie->slug }}" style ="background-image: url('https://image.tmdb.org/t/p/w342{!! $movie->poster_path !!}')">
                    <div class="em-card-header">
                    <div class="em-card-valoration">
                        <span>
                        <i class="material-icons yellow">star</i>
                        <strong>{{ $movie->vote_average }}</strong>
                        </span>
                    </div>
                    <div class="em-card-title">
                        <h1>{{ $movie->title }} - <span> {{ date('Y', strtotime($movie->release_date)) }}</span> </h1>
                    </div>
                    </div>
                </a>
                
                <div class="em-card-action">
                    <div>
                        <a href="/peliculas/{{ $movie->slug }}"  class="iz"><i class="material-icons">ondemand_video</i><span> Ver Online</span></a>
                    </div>
                    <div>
                        <a href="/peliculas/{{ $movie->slug }}" class="de"><span>Mas Info</span><i class="material-icons">more_horiz</i></a>
                    </div>
                </div>

            </div>
        @endforeach        
    </div>
    <div class="">
        {!! $movies->render() !!}
    </div>
    
    
@endsection