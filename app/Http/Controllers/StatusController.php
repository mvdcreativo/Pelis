<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

use App\Movie;

use App\Http\Resources\Movie as MovieResource;


class StatusController extends Controller
{
    	// Auth
        public function __construct()
        {
            $this->middleware('auth');
        }
        ////       



    public function getStatus()
    {
        // $status = Movie::where('id_upload', '130499700')->get();
        // return $status;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.openload.co/1/remotedl/status', [
            'query' => [
                // 'login' => '4c27f06e8bc67437',
                // 'key' => 'wIZfdNAC',
                'limit' => 100,
                
                'login' => '3c1cef2383ac50d1',
                'key' => 'mgatOun9',
                // 'url' => $urlOrigen,
                // 'folder' => 6162544
            ]
        ]);

        if($response->getStatusCode() == 200){
            $result = json_decode($response->getBody()->getContents(), true);

            $upload = [];
            $upload = $result['result'];

        };

        //ELIMINAMOS ARCHIVOS ERRONEOS DEL SERVIDOR
        // foreach($upload as $idFile){
        //     if($idFile['bytes_loaded'] === null ){
        //         $urlDwl = $idFile['url'];
        //         $extid = $idFile['extid'];         
        //         $this->deleteErrors($extid);
        //         //echo($idFile);
        //     }    
        // }

        ////


        $movies =  Movie::all();

        foreach ($movies as $movie) 
        {
            if($movie->id_upload)
            {
                $id_uplodBd= $movie->id_upload;
                
                $idBd =  $movie->id;
                
                if(isset($upload[$id_uplodBd]))
                {
                    $id_uploadServ = $upload[$id_uplodBd];

                    if($id_uploadServ['status'] == 'finished')
                    {
                        $urlDwl = $id_uploadServ['url'];
                        $extid = $id_uploadServ['extid'];
                        
                        $movieUpdate = Movie::find($idBd);
                        $movieUpdate->url_dwl = $urlDwl;
                        $movieUpdate->extid = $extid;
                        // $movieUpdate->state = 1;
                        $movieUpdate->save();

            
                        echo $urlDwl.' -- '.$extid.'<br>';
    
                    }
                };

            };
                //dd ($upload[$id_uplodBd]);
 
        };
    }


    // public function deleteErrors($extid)
    // {

    //     $client = new \GuzzleHttp\Client();
    //     $response = $client->request('GET', 'https://api.openload.co/1/file/delete', [
    //         'query' => [
    //             // 'login' => '4c27f06e8bc67437',
    //             // 'key' => 'wIZfdNAC',
    //             'file' => $extid,
                
    //             'login' => '3c1cef2383ac50d1',
    //             'key' => 'mgatOun9',
    //             // 'url' => $urlOrigen,
    //             // 'folder' => 6162544
    //         ]
    //     ]);

    //     if($response->getStatusCode() == 200){
    //         $result = json_decode($response->getBody()->getContents(), true);

    //         $resp = [];
    //         $resp = $result['result'];
    //         echo 'Delete -'.$extid.'<br>';

    //     };


    //     ///eliminamos de la BD
    //     $movie = Movie::where('extid', $extid)
    //                     ->orWhere('state', 0)
    //                     ->delete();
    //     if($movie)
    //     {
    //         echo 'Delete -'.$extid.'de la BD <br>';
    //     }
    //     //////
    // }

}
