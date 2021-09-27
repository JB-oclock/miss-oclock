<?php

namespace App\Http\Controllers;

use App\Game;
use App\Question;
use App\Performance;
use GuzzleHttp\Client;

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
        // Check if the mercure instance is running
        $url = env('MERCURE_DOMAIN');
        $mercureRunning = (@get_headers(env('MERCURE_DOMAIN'))[0] == "HTTP/1.0 200 OK");

        $games = Game::orderBy('id', 'desc')->get();
        return view('home', compact('games', 'mercureRunning'));
    }
}
