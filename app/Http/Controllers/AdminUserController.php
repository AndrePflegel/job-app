<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:visitor,user,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Benutzer erfolgreich erstellt.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:visitor,user,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if (
            $user->role === 'admin' &&
            $validated['role'] !== 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return redirect()->route('admin.users.edit', $user)
                ->with('error', 'Der letzte Admin kann nicht auf eine andere Rolle geändert werden.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Benutzer erfolgreich aktualisiert.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Du kannst deinen eigenen Account nicht löschen.');
        }

        $lastAdmin = $user->role === 'admin' && User::where('role', 'admin')->count() <= 1;

        if ($lastAdmin) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Der letzte Admin kann nicht gelöscht werden.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}
