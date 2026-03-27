@extends('layouts.app')

@section('content')
<h1 class="page-title">Jobanzeigen</h1>

<div class="job-card" style="margin-bottom: 24px;">
    <form action="{{ route('jobs.index') }}" method="GET">
        <div style="display: flex; gap: 16px; flex-wrap: wrap; align-items: end;">
            <div style="flex: 1; min-width: 220px;">
                <label for="company_id"><strong>Firma</strong></label><br>
                <select name="company_id" id="company_id">
                    <option value="">Alle Firmen</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected(request('company_id') == $company->id)>
                    {{ $company->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 220px;">
                <label for="category_id"><strong>Kategorie</strong></label><br>
                <select name="category_id" id="category_id">
                    <option value="">Alle Kategorien</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="action-row" style="margin-top: 0;">
                <button type="submit" class="btn btn-primary">Filtern</button>
                <a class="btn btn-secondary" href="{{ route('jobs.index') }}">Zurücksetzen</a>
            </div>
        </div>
    </form>
</div>

@auth
@if (auth()->user()->canCreateJobs())
<p style="margin-bottom: 20px;">
    <a class="btn btn-primary" href="{{ route('jobs.create') }}">
        + Neue Jobanzeige erstellen
    </a>
</p>
@endif
@endauth

@if (session('success'))
<div style="background: #e6ffed; color: #1f6b3b; padding: 15px; margin-bottom: 20px; border: 1px solid #a6d8b8;">
    {{ session('success') }}
</div>
@endif

@forelse($jobs as $job)
<div class="job-card">
    <h2>
        <a href="{{ route('jobs.show', ['job' => $job->id, 'return' => request()->fullUrl()]) }}"
           onclick="sessionStorage.setItem('jobs_index_url', window.location.pathname + window.location.search); sessionStorage.setItem('jobs_index_scroll', window.scrollY);">
            {{ $job->title }}
        </a>
    </h2>

    <p>{{ $job->description }}</p>

    <p><strong>Firma:</strong> {{ $job->company->name }}</p>
    <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
    @auth
    @if (auth()->user()->canSeeInternalEditorInfo())
    <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>
    @endif
    @endauth

    <div class="action-row">
        <a class="btn btn-secondary"
           href="{{ route('jobs.show', ['job' => $job->id, 'return' => request()->fullUrl()]) }}"
           onclick="sessionStorage.setItem('jobs_index_url', window.location.pathname + window.location.search); sessionStorage.setItem('jobs_index_scroll', window.scrollY);">
            Ansehen
        </a>

        @auth
        @if (auth()->user()->canManageJob($job))
        <a class="btn btn-primary"
           href="{{ route('jobs.edit', ['job' => $job->id, 'return' => request()->fullUrl()]) }}"
           onclick="sessionStorage.setItem('jobs_index_url', window.location.pathname + window.location.search); sessionStorage.setItem('jobs_index_scroll', window.scrollY);">
            Bearbeiten
        </a>

        <form class="inline-form" action="{{ route('jobs.destroy', ['job' => $job->id]) }}" method="POST" onsubmit="return confirm('Möchtest du diese Jobanzeige wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
            <input type="hidden" name="return" value="{{ request()->fullUrl() }}">
        </form>
        @endif
        @endauth
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
