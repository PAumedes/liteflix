<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response($payload, $message = '', $success = true, $code = 200)
    {
        return response()->json(
            [
                'payload' => $payload,
                'message' => $message,
                'success' => $success,
            ],
            $code,
        );
    }
}
