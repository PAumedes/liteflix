<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use GuzzleHttp\Client;

class GenreController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->middleware('auth');

        $this->client = new Client([
            'base_uri' => config('moviedb.base_uri'),
            'timeout'  => 5.0,
        ]);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->response('', $validator->errors(), false, 400);
        }

        $apiResponse = $this->client->get('genre/movie/list', ['query' => 'api_key=' . config('moviedb.api_key')]);

        if ($apiResponse->getStatusCode() != 200) {
            return $this->response('', 'There was an error. Please try again', false, 400);
        }

        $response = json_decode($apiResponse->getBody());

        return $this->response($response);
    }
}
