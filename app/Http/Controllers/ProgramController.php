<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Inertia\Inertia;

class ProgramController extends Controller
{
    //
    public function index()
    {
        $programs = Program::all();
        return Inertia::render('Programs/Index', ['programs' => $programs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:programs,name',
            'description' => 'nullable|string',
        ]);

        Program::create($request->all());

        return redirect('/programs')->with('success', 'Program created successfully.');
    }
}
