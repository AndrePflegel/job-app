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

    <p><strong>Firma:</strong> {{ optional($job->company)->name ?? 'Ohne Firma' }}</p>

    @can('save', $job->company)
    @if ($job->company)
    <div style="margin: 10px 0 14px 0;">
        @if (auth()->user()->hasSavedCompany($job->company))
        <form class="inline-form" action="{{ route('saved-companies.destroy', $job->company->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Firma nicht mehr merken</button>
        </form>
        @else
        <form class="inline-form" action="{{ route('saved-companies.store', $job->company->id) }}" method="POST">
            @csrf
            <button class="btn btn-secondary" type="submit">Firma merken</button>
        </form>
        @endif
    </div>
    @endif
    @endcan

    <p><strong>Kategorie:</strong> {{ optional($job->category)->name ?? 'Ohne Kategorie' }}</p>

    @can('save', $job->category)
    @if ($job->category)
    <div style="margin: 10px 0 14px 0;">
        @if (auth()->user()->hasSavedCategory($job->category))
        <form class="inline-form" action="{{ route('saved-categories.destroy', $job->category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Kategorie nicht mehr merken</button>
        </form>
        @else
        <form class="inline-form" action="{{ route('saved-categories.store', $job->category->id) }}" method="POST">
            @csrf
            <button class="btn btn-secondary" type="submit">Kategorie merken</button>
        </form>
        @endif
    </div>
    @endif
    @endcan

    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>

    @can('viewInternalFields', $job)
    <p><strong>Erstellt von:</strong> {{ optional($job->user)->name ?? 'Unbekannt' }}</p>
    @endcan

    @can('viewInternalFields', $job)
    <p>
        <strong>Status:</strong>
        <span style="color: {{ $job->is_active ? '#1f6b3b' : '#b91c1c' }}; font-weight: 600;">
                {{ $job->is_active ? 'Aktiv' : 'Inaktiv' }}
            </span>
    </p>
    @endcan

    <div class="action-row">
        @can('update', $job)
        <a class="btn btn-primary" href="{{ route('jobs.edit', ['job' => $job->id, 'return' => request('return', request()->fullUrl())]) }}">
            Bearbeiten
        </a>
        @endcan

        @can('delete', $job)
        <form class="inline-form" action="{{ route('jobs.destroy', ['job' => $job->id]) }}" method="POST" onsubmit="return confirm('Möchtest du diese Jobanzeige wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
            <input type="hidden" name="return" value="{{ request('return', request()->fullUrl()) }}">
        </form>
        @endcan

        <a class="btn btn-secondary" href="{{ request('return', route('jobs.index')) }}">Zurück</a>
    </div>
</div>
@endsection
