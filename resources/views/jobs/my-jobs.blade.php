@extends('layouts.app')

@section('content')
<h1 class="page-title">Meine Jobs</h1>

@if (session('success'))
<div style="background: #e6ffed; color: #1f6b3b; padding: 15px; margin-bottom: 20px; border: 1px solid #a6d8b8;">
    {{ session('success') }}
</div>
@endif

@forelse($jobs as $job)
<div class="job-card">
    <h2>
        <a href="{{ route('jobs.show', ['job' => $job->id, 'return' => request()->fullUrl()]) }}">
            {{ $job->title }}
        </a>
    </h2>

    <p>{{ $job->description }}</p>

    <p><strong>Firma:</strong> {{ optional($job->company)->name ?? 'Ohne Firma' }}</p>
    <p><strong>Kategorie:</strong> {{ optional($job->category)->name ?? 'Ohne Kategorie' }}</p>
    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
    @auth
    @if (auth()->user()->canSeeInternalEditorInfo())
    <p><strong>Erstellt von:</strong> {{ optional($job->user)->name ?? 'Unbekannt' }}</p>
    @endif
    @endauth

    <p>
        <strong>Status:</strong>
        <span style="color: {{ $job->is_active ? '#1f6b3b' : '#b91c1c' }}; font-weight: 600;">
        {{ $job->is_active ? 'Aktiv' : 'Inaktiv' }}
    </span>
    </p>

    <div class="action-row">
        <a class="btn btn-secondary"
           href="{{ route('jobs.show', ['job' => $job->id, 'return' => request()->fullUrl()]) }}">
            Ansehen
        </a>

        <a class="btn btn-primary"
           href="{{ route('jobs.edit', ['job' => $job->id, 'return' => request()->fullUrl()]) }}">
            Bearbeiten
        </a>

        <form class="inline-form" action="{{ route('jobs.destroy', ['job' => $job->id]) }}" method="POST" onsubmit="return confirm('Möchtest du diese Jobanzeige wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
            <input type="hidden" name="return" value="{{ request()->fullUrl() }}">
        </form>
    </div>
</div>
@empty
<p>Du hast noch keine eigenen Jobanzeigen erstellt.</p>
@endforelse
@endsection
