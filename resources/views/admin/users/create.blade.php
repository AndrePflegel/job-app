@extends('layouts.app')

@section('content')
<h1>Benutzer anlegen</h1>

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

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    <div>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
        <label for="email">E-Mail:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
        <label for="role">Rolle:</label><br>
        <select id="role" name="role" required>
            <option value="visitor" {{ old('role') === 'visitor' ? 'selected' : '' }}>Visitor</option>
            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div>
        <label for="password">Passwort:</label><br>
        <input type="password" id="password" name="password" required>
    </div>

    <div>
        <label for="password_confirmation">Passwort bestätigen:</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>

    <div class="action-row">
        <button type="submit" class="btn btn-primary">Benutzer speichern</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Abbrechen</a>
    </div>
</form>
@endsection
