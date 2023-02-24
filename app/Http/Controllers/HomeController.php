<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Response;
use App\Weather;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lastRecord = Weather::get()->first()->created_at;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.weatherstack.com/current?access_key=dbedee80b221219fce09992491330325&query=Kathmandu',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if (!request()->page &&
            Carbon::parse($lastRecord)->addMinutes(60) <= Carbon::now()
        ) {
            $weather = new Weather();
            $weather->location = json_encode($response->location);
            $weather->local_time = $response->location->localtime;
            $weather->temperature = $response->current->temperature;
            $weather->save();
        }

        if (request('from') && request('to')) {
            $weatherData = Weather::whereDate('created_at', '>=',  request('from'))
            ->whereDate('created_at', '<=', request('to'))
            ->paginate(5);
        } else {
            $weatherData = Weather::paginate(5);
        }

        
        
        return view('home', ['responseData' => $weatherData, 'requestData' => request() ]);
    }
}
