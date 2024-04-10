<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $search = $request->query('search');
        $users = User::where('role', 2)
            ->where('first_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('users.create');
    }

    /**
     * Check if user exists.
     */
    public function checkUserExists(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['exists' => true]);
        }
        return response()->json(['exists' => false]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
