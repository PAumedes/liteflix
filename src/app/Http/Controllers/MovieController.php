<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Movie;

use GuzzleHttp\Client;

class MovieController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->middleware('auth');

        $this->client = new Client([
            'base_uri' => config('moviedb.base_uri_movie'),
            'timeout'  => 5.0,
        ]);
    }

    /**
     * Returns now playing movies
     *
     * @return void
     */
    public function nowPlaying(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $apiResponse = $this->client->get('now_playing', [
            'query' => [
                'api_key' =>config('moviedb.api_key'),
                'page' => $request->query('page'),
            ]
        ]);

        if ($apiResponse->getStatusCode() != 200) {
            return $this->response('', 'There was an error. Please try again', false, 400);
        }

        $response = json_decode($apiResponse->getBody());

        return $this->response($response->results);
    }

    /**
     * Returns upcoming movies
     *
     * @return void
     */
    public function upcoming(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $apiResponse = $this->client->get('upcoming', [
            'query' => [
                'api_key' =>config('moviedb.api_key'),
                'page' => $request->query('page'),
            ]
        ]);

        if ($apiResponse->getStatusCode() != 200) {
            return $this->response('', 'There was an error. Please try again', false, 400);
        }

        $response = json_decode($apiResponse->getBody());

        return $this->response($response->results);
    }

    /**
     * Returns popular movies
     *
     * @return void
     */
    public function popular(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $apiResponse = $this->client->get('popular', [
            'query' => [
                'api_key' =>config('moviedb.api_key'),
                'page' => $request->query('page'),
            ]
        ]);

        if ($apiResponse->getStatusCode() != 200) {
            return $this->response('', 'There was an error. Please try again', false, 400);
        }

        $response = json_decode($apiResponse->getBody());

        return $this->response($response->results);
    }

    /**
     * Returns popular movies
     *
     * @return void
     */
    public function highlight(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $apiResponse = $this->client->get('now_playing', [
            'query' => [
                'api_key' =>config('moviedb.api_key'),
                'page' => $request->query('page'),
            ]
        ]);

        if ($apiResponse->getStatusCode() != 200) {
            return $this->response('', 'There was an error. Please try again', false, 400);
        }

        $response = json_decode($apiResponse->getBody());
        $movies = collect($response->results);
        $movies->sortByDesc('release_date');

        return $this->response($movies->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPoster(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'poster' => 'required|file|max:300|mimes:jpeg,jpg,webp',
        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $path = $request->poster->store('posters');

        return $this->response($path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'genre_id' => 'required',
            'poster' => 'required|string'

        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $movie = Movie::create($request->all());

        return $this->response($movie);
    }

    /**
     * Returns my movies
     *
     * @return void
     */
    public function index()
    {
        return $this->response(Movie::all());
    }
}
