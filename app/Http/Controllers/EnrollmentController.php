<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Program;
use Inertia\Inertia;

class EnrollmentController extends Controller
{
    //
    public function index()
    {
        $clients = Client::with('programs')->get();
        $programs = Program::all();
        return Inertia::render('Enrollments/Index', [
            'clients' => $clients,
            'programs' => $programs
        ]);
        return view('enrollment.index', compact('clients', 'programs'));
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'program_ids' => 'required|array',
            'program_ids.*' => 'exists:programs,id',
        ]);

        $client = Client::findOrFail($request->client_id);
        $client->programs()->syncWithoutDetaching($request->program_ids);

        return redirect('/enrollment')->with('success', 'Client enrolled successfully.');
    }
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        // Enrollment logic: associate the client with the program
        $client = Client::findOrFail($request->client_id);
        $program = Program::findOrFail($request->program_id);

        // Example: Enroll client in the program
        $client->programs()->attach($program); // Assuming a many-to-many relationship

        return response()->json([
            'message' => 'Client successfully enrolled in the program!',
        ], 200);
    }
}
