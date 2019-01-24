@extends('layouts.app', [
  'meta_title' => $movie->title ,
  'meta_description'=> 'Titulo Original: '.$movie->original_title.' - '.$movie->overview,
  'meta_claves'=> $movie->original_title.','.$movie->original_title.', online,hd,español,latino,español latino, audio latino'
  ])

@section('content')
{{-- {!!dd($director)!!} --}}

<div class="contenedor-detail">
        <div class="acciones" style="background-image: url('https://image.tmdb.org/t/p/original/{!! $movie->backdrop_path !!}')">
          <div class="bg">
            <div class="img" >
              <img src="https://image.tmdb.org/t/p/w500/{!! $movie->poster_path !!}" alt="{{ $movie->title }}">
            </div>
            <div class="ver-online">
              <div class="header">
                  <div class="rating">
                      {{-- <span>
                        <bar-rating [(rate)]="value_display_rating" [max]="5" [theme]="'movie'" [showText]="true" [titles]="titles_rating"
                          [readOnly]="true">
                        </bar-rating>
                      </span>
                      <span class="count-votos">{{ pelicula.vote_count }} votos</span> --}}
                  </div>
                  <div class="titulo">
                        <h1>{{ $movie->title }}</h1>
                        <span><strong>Titulo Original:</strong>  {{ $movie->original_title }} ({{ date('Y', strtotime($movie->release_date)) }})</span>
                  </div>
              </div>
              <div class="video">
                                
                    <iframe class="play iframe" src="https://openload.co/embed/{{ $movie->extid }}"
                      style="background-image: url('')"
                      width="700"
                      height="430"
                      scrolling="no" 
                      frameborder="0" 
                      allowfullscreen="true" 
                      webkitallowfullscreen="true"
                      mozallowfullscreen="true">
                    </iframe>
                  
              </div>
      
            </div>
      
          </div>
        </div>
        <div class="info" >
          <div class="datos"> 
            
              <div class="sinopsis">
                <span>
                  <img src="{{ asset('images/sinopsis.png') }}" alt="">
                </span>
                <span class="atributo">
                  Sinopsis:
                </span>
                <span>
                  {{ $movie->overview }}
                </span>
              </div>
            
            
              <div class="genero">
                <span>
                  <img src="{{ asset('images/genre.png') }}" alt="">
                </span>
                <span class="atributo">
                  Genero:
                </span>
                <span>
                    @foreach ($movie->genres as $genre)                        
                        <span class="badge badge-pill badge-light">{{ $genre->name }}</span>
                    @endforeach      
                </span>
              </div>
            
            
              <div class="ano">
                <span>
                  <img src="{{ asset('images/lanzamiento.png') }}" alt="">
                </span>
                <span class="atributo">
                  Lanzamiento:
                </span>
                <span>
                    &nbsp;&nbsp;{{ date('d-m-Y', strtotime($movie->release_date)) }}
                </span>
              </div>
            
            
              <div class="duracion">
                <span>
                  <img src="{{ asset('images/duracion.png') }}" alt="">
                </span>
                <span class="atributo">
                  Duración:
                </span>
                <span>
                    &nbsp;&nbsp;{{ $movie->runtime }} min.
                </span>
              </div>
            
            
              <div class="director">
                <span>
                  <img src="{{ asset('images/director.png') }}" alt="">
                </span>
                <span class="atributo">
                  Director/es:
                </span>
                <span>
                    @foreach ($director as $director)
                        <span>
                            &nbsp;&nbsp;{{ $director->name }}
                        </span>                        
                    @endforeach

                </span>
              </div>
            
            
              <div class="actores">
                <span  class="atributo">Elenco Principal: </span>
                <div class="actores-cimg">
                    @foreach ($movie->casts as $actor)
                        @if ($actor->order <= 6)
                            <div class="dt-card-item">
                                <a href="#">
                                <div class="dt-card-header">
                                    <div class="dt-card-image">
                                        @if ($actor->profile_path != null)
                                            <img  src="https://image.tmdb.org/t/p/w154/{!! $actor->profile_path !!}" alt="{{ $actor->name }}">
                                        @else
                                            <img  src="{{ asset('images/desconocido.png') }}" alt="{{ $actor->name }}">
                                        @endif
                                    </div>
                    
                                    <div class="dt-card-title">
                                        <span><strong>{{ $actor->name }}</strong></span>
                                        <span>{{ $actor->character }}</span>
                                    </div>
                                </div>
                                </a>
                    
                            </div>                          
                        @endif
                     
                    @endforeach

                </div>
                {{-- <mat-accordion style=" width:100%">
          
                  <mat-expansion-panel >
                    <mat-expansion-panel-header>
                      <mat-panel-title>
                        Elenco Completo ...
                      </mat-panel-title>

                    </mat-expansion-panel-header>
          
                    <mat-list>
                      <mat-list-item *ngFor="let cast of pelicula.credits.casts">
                        <img matListAvatar src="https://img.icons8.com/ios/50/000000/user-male-circle-filled.png">
                        <img matListAvatar src="" alt="{{cast.name}}">
                        <h3 matLine> {{cast.name}} </h3>
                        <p matLine>
                          <span> {{cast.character}} </span>

                        </p>
                      </mat-list-item>
                    </mat-list>
          
                  </mat-expansion-panel>
                </mat-accordion> --}}
                    <p>
                        <a class="" data-toggle="collapse" href="#collapseElenco" aria-expanded="false" aria-controls="collapseElenco">
                          Ver Elenco Completo
                        </a>
                    </p>
                    <div class="collapse" id="collapseElenco">
                        <div class="actores-elenco">
                            @foreach ($movie->casts as $actor)
                                <div class="dt-card-item">
                                    <a href="#">
                                        <div class="dt-card-header">
                                            <div class="dt-card-image">
                                                @if ($actor->profile_path != null)
                                                    <img  src="https://image.tmdb.org/t/p/w154/{!! $actor->profile_path !!}" alt="{{ $actor->name }}">
                                                @else
                                                    <img  src="{{ asset('images/desconocido.png') }}" alt="{{ $actor->name }}">
                                                @endif
                                            </div>
                            
                                            <div class="dt-card-title">
                                                <span><strong>{{ $actor->name }}</strong></span>
                                                <span>{{ $actor->character }}</span>
                                            </div>
                                        </div>
                                    </a>
                            
                                </div>
                            @endforeach
                        </div>
                    </div>          
          
              </div>
            
          </div>
          </div>
      </div>
    @endsection