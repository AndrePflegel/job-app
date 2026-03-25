@extends('layouts.app')

@section('content')
<div class="job-card">
    <h1>{{ $job->title }}</h1>

    @if (session('success'))
    <div style="background: #e6ffed; color: #1f6b3b; padding: 15px; margin-bottom: 20px; border: 1px solid #a6d8b8;">
        {{ session('success') }}
    </div>
    @endif

    <p><strong>Beschreibung:</strong></p>
    <p>{{ $job->description }}</p>

    <p><strong>Firma:</strong> {{ $job->company->name }}</p>
    <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
    <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>

    <div class="action-row">
        @auth
        @if (auth()->user()->canManageJob($job))
        <a class="btn btn-primary" href="{{ route('jobs.edit', ['job' => $job->id, 'return' => request('return', request()->fullUrl())]) }}">Bearbeiten</a>

        <form class="inline-form" action="{{ route('jobs.destroy', ['job' => $job->id]) }}" method="POST" onsubmit="return confirm('Möchtest du diese Jobanzeige wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
            <input type="hidden" name="return" value="{{ request('return', request()->fullUrl()) }}">
        </form>
        @endif
        @endauth

        <a class="btn btn-secondary" href="{{ request('return', route('jobs.index')) }}">Zurück</a>
    </div>
</div>
@endsection
