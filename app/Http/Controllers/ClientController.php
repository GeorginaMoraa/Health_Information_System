<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Inertia\Inertia;

class ClientController extends Controller
{
    //
    public function index()
{
    $clients = Client::all();
    return Inertia::render('Clients/Index', compact('clients'));
}

public function create()
{
    return Inertia::render('Clients/Create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:clients',
        'phone' => 'required',
    ]);

    Client::create($request->all());

    return redirect()->route('clients.index');
}
public function searchForm()
{
    return Inertia::render('Clients/Search');
}
public function show(Client $client)
    {
        $client->load('programs');
        return Inertia::render('Clients/Show', ['client' => $client]);
    }

}
