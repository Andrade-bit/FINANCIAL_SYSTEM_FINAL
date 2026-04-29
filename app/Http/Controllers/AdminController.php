<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role', '!=', 'admin')->get()->map(fn($u) => [
            'id'         => $u->usersID,
            'firstName'  => $u->firstName,
            'middleName' => $u->middleName ?? '',
            'lastName'   => $u->lastName,
            'username'   => $u->username,
            'role'       => ucfirst($u->role),
            'status'     => $u->status,
        ])->values();

        return view('Admin', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName'  => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName'   => 'required|string|max:255',
            'username'   => 'required|string|unique:users,username',
            'password'   => 'required|string|min:6',
            'role'       => 'required|in:treasurer,encoder',
            'status'     => 'required|in:Active,Inactive',
        ]);

        $user = User::create([
            'firstName'  => $validated['firstName'],
            'middleName' => $validated['middleName'] ?? null,
            'lastName'   => $validated['lastName'],
            'username'   => $validated['username'],
            'password'   => Hash::make($validated['password']),
            'role'       => $validated['role'],
            'status'     => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Account created successfully.',
            'id'      => $user->usersID,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('usersID', $id)->firstOrFail();

        $validated = $request->validate([
            'firstName'  => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName'   => 'required|string|max:255',
            'username'   => 'required|string|unique:users,username,' . $id . ',usersID',
            'role'       => 'required|in:treasurer,encoder',
            'status'     => 'required|in:Active,Inactive',
        ]);

        $data = [
            'firstName'  => $validated['firstName'],
            'middleName' => $validated['middleName'] ?? null,
            'lastName'   => $validated['lastName'],
            'username'   => $validated['username'],
            'role'       => $validated['role'],
            'status'     => $validated['status'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'Account updated successfully.']);
    }

    public function destroy($id)
    {
        User::where('usersID', $id)->firstOrFail()->delete();
        return response()->json(['message' => 'Account deleted successfully.']);
    }
}