<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientApiController extends Controller
{
    //
    public function show(Client $client)
    {
        return response()->json([
            'client' => $client->load('programs')
        ]);
    }
}
