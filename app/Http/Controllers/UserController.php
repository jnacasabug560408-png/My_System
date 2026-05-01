<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('admin');
        $roles = ['admin', 'editor', 'author', 'creator', 'subscriber'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'username' => 'required|string|unique:users|min:3|max:20',
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,author,creator,subscriber',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);

        User::create($validated);
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        $this->authorize('admin');
        $user->load('contents', 'media', 'comments');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('admin');
        $roles = ['admin', 'editor', 'author', 'creator', 'subscriber'];
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id . '|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,editor,author,creator,subscriber',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'required|string|min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $this->authorize('admin');

        if (auth()->id() === $user->id) {
            return back()->with('error', 'Cannot delete your own account!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function activate(User $user)
    {
        $this->authorize('admin');
        $user->update(['is_active' => true]);
        return back()->with('success', 'User activated successfully!');
    }

    public function deactivate(User $user)
    {
        $this->authorize('admin');

        if (auth()->id() === $user->id) {
            return back()->with('error', 'Cannot deactivate your own account!');
        }

        $user->update(['is_active' => false]);
        return back()->with('success', 'User deactivated successfully!');
    }
}