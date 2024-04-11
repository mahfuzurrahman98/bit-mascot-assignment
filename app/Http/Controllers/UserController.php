<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View {
        // Get the search query parameter
        $search = $request->query('search');

        // Filter users based on role and search query
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
     *
     * @return View
     */
    public function create(): View {
        return view('users.create');
    }

    /**
     * Check if user exists.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUserExists(Request $request): JsonResponse {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['exists' => true]);
        }
        return response()->json(['exists' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return RedirectResponse
     */
    public function store(CreateUserRequest $request): RedirectResponse {
        // upload the file first
        $file = $request->file('id_verification_file');
        $fileExtension = $file->clientExtension();
        $fileName = time() . '_' . Str::random(10) . '.' . $fileExtension;

        // upload to storage
        $file->move(storage_path('app/public'), $fileName);

        // Create a new user with the provided data
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
