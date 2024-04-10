<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $search = $request->query('search');
        $users = User::where('role', 2)
            ->when($search, function ($query, $search) {
                $query
                    ->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
            ->paginate(15);

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
        // upload the file first
        $file = $request->file('id_verification_file');
        $fileExtension = $file->clientExtension();
        $fileName = time() . '_' . Str::random(10) . '.' . $fileExtension;

        // upload to storage
        $file->move(storage_path('app/public'), $fileName);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'id_verification_file' => $fileName,
            'dob' => $request->dob
        ]);

        return redirect()->back()->withSuccess('User created successfully');
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
