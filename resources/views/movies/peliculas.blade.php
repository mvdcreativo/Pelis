@extends('layouts.app')

@section('content')
    <div class="listado">
        @foreach ($movies as $movie)

            <div class="em-card-item">
                <a style ="background-image: url('https://image.tmdb.org/t/p/w342{!! $movie->poster_path !!}')">
                    <div class="em-card-header">
                    <div class="em-card-valoration">
                        <span>
                        <i class="material-icons yellow">star</i>
                        <strong>{{ $movie->vote_average }}</strong>
                        </span>
                    </div>
                    <div class="em-card-title">
                        <h1>{{ $movie->title }} - <span>{{ $movie->release_date }}</span> </h1>
                    </div>
                    </div>
                </a>
                
                <div class="em-card-action">
                    <div>
                        <a   class="iz"><i class="material-icons">ondemand_video</i><span> Ver Online</span></a>
                    </div>
                    <div>
                        <a  class="de"><span>Mas Info</span><i class="material-icons">more_horiz</i></a>
                    </div>
                </div>

            </div>
        @endforeach        
    </div>
    


        {{-- <ul>
            @foreach ($movies as $movie)
              <li>{{ $movie->title }}</li>  
            @endforeach
            
        </ul>
        {!! $movies->render() !!} --}}
    
@endsection