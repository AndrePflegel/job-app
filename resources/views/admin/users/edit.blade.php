@extends('layouts.app')

@section('content')
<h1>Benutzer bearbeiten</h1>

@if (session('success'))
<div style="background: #e6ffed; color: #176b3a; padding: 15px; margin-bottom: 20px; border: 1px solid #b7ebc6; border-radius: 8px;">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div style="background: #ffe5e5; color: #8a1f1f; padding: 15px; margin-bottom: 20px; border: 1px solid #d99; border-radius: 8px;">
    <strong>Bitte prüfe deine Eingaben:</strong>
    <ul style="margin-top: 10px; padding-left: 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div>
        <label for="email">E-Mail:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div>
        <label for="role">Rolle:</label><br>
        <select id="role" name="role" required>
            <option value="visitor" {{ old('role', $user->role) === 'visitor' ? 'selected' : '' }}>Visitor</option>
            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div>
        <label for="password">Neues Passwort (optional):</label><br>
        <input type="password" id="password" name="password">
    </div>

    <div>
        <label for="password_confirmation">Neues Passwort bestätigen:</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <div class="action-row">
        <button type="submit" class="btn btn-primary">Speichern</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Zurück</a>
    </div>
</form>
@endsection
