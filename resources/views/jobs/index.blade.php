@extends('layouts.app')

@section('content')
<h1 class="page-title">Jobanzeigen</h1>

<p style="margin-bottom: 20px;">
    <a href="{{ route('jobs.create') }}">+ Neue Jobanzeige erstellen</a>
</p>

@if (session('success'))
<div style="background: #e6ffed; color: #1f6b3b; padding: 15px; margin-bottom: 20px; border: 1px solid #a6d8b8;">
    {{ session('success') }}
</div>
@endif

@forelse($jobs as $job)
<div class="job-card">
    <h2>
        <a href="{{ route('jobs.show', ['id' => $job->id, 'return' => request()->fullUrl()]) }}">
            {{ $job->title }}
        </a>
    </h2>

    <p>{{ $job->description }}</p>

    <p><strong>Firma:</strong> {{ $job->company->name }}</p>
    <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
    <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>
    <div class="action-row">
        <a class="btn btn-secondary" href="{{ route('jobs.show', ['id' => $job->id, 'return' => request()->fullUrl()]) }}">Ansehen</a>
        <a class="btn btn-primary" href="{{ route('jobs.edit', ['id' => $job->id, 'return' => request()->fullUrl()]) }}">Bearbeiten</a>
        <form class="inline-form" action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Möchtest du diese Jobanzeige wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
            <input type="hidden" name="return" value="{{ request('return', request()->fullUrl()) }}">
        </form>
    </div>
</div>
@empty
<p>Keine Jobanzeigen gefunden.</p>
@endforelse

<div class="pagination">
    <div class="pagination" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        @if ($jobs->onFirstPage())
        <span class="btn btn-secondary">←</span>
        @else
        <a class="btn btn-secondary" href="{{ $jobs->previousPageUrl() }}">←</a>
        @endif

        @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
        @if ($page == $jobs->currentPage())
        <span class="btn btn-primary">{{ $page }}</span>
        @else
        <a class="btn btn-secondary" href="{{ $url }}">{{ $page }}</a>
        @endif
        @endforeach

        @if ($jobs->hasMorePages())
        <a class="btn btn-secondary" href="{{ $jobs->nextPageUrl() }}">→</a>
        @else
        <span class="btn btn-secondary">→</span>
        @endif
    </div>
</div>
@endsection
