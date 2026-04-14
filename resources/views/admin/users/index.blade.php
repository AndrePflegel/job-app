@extends('layouts.app')

@section('content')
@can('viewAny', App\Models\User::class)
<h1>Benutzerverwaltung</h1>

@if (session('success'))
<div style="background: #e6ffed; color: #176b3a; padding: 15px; margin-bottom: 20px; border: 1px solid #b7ebc6; border-radius: 8px;">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div style="background: #ffe5e5; color: #8a1f1f; padding: 15px; margin-bottom: 20px; border: 1px solid #d99; border-radius: 8px;">
    {{ session('error') }}
</div>
@endif

@can('create', App\Models\User::class)
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Neuen Benutzer anlegen</a>
</div>
@endcan

@forelse ($users as $user)
<div class="job-card">
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>E-Mail:</strong> {{ $user->email }}</p>
    <p><strong>Rolle:</strong> {{ $user->role }}</p>
    <p><strong>Erstellt:</strong> {{ $user->created_at?->format('d.m.Y H:i') }}</p>

    <div class="action-row">
        @can('update', $user)
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Bearbeiten</a>
        @endcan

        @can('delete', $user)
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Willst du diesen Benutzer wirklich löschen?')">
                Löschen
            </button>
        </form>
        @endcan
    </div>
</div>
@empty
<p>Es sind noch keine Benutzer vorhanden.</p>
@endforelse
@endcan
@endsection
