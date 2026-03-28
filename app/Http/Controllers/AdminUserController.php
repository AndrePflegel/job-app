<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
    }

    public function index()
    {
        $this->ensureAdmin();

        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

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
        $this->ensureAdmin();

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->ensureAdmin();

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
            return redirect()->route('admin.users.edit', $user->id)
                ->with('error', 'Der letzte Admin kann nicht auf eine andere Rolle geändert werden.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.edit', $user->id)
            ->with('success', 'Benutzer erfolgreich aktualisiert.');
    }

    public function destroy(User $user)
    {
        $this->ensureAdmin();

        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Du kannst deinen eigenen Account nicht löschen.');
        }

        $lastAdmin = User::where('role', 'admin')->count() <= 1 && $user->role === 'admin';

        if ($lastAdmin) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Der letzte Admin kann nicht gelöscht werden.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}
