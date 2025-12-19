<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'nullable|integer|exists:roles,role_id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'NIP' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'User berhasil ditambahkan!']);
        }
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'role_id' => 'nullable|integer|exists:roles,role_id',
            'name' => 'required|string|max:255',
            'NIP' => 'required|string|max:20|unique:users,NIP,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        User::where('id', $id)->update($validatedData);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'User berhasil diperbarui!']);
        }
        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }
}
