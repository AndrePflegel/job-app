@extends('layouts.app')

@section('content')
<h1 class="page-title">Jobanzeigen</h1>

@forelse($jobs as $job)
<div class="job-card">
    <h2>
        <a href="{{ route('jobs.show', $job->id) }}">
            {{ $job->title }}
        </a>
    </h2>

    <p>{{ $job->description }}</p>

    <p><strong>Firma:</strong> {{ $job->company->name }}</p>
    <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
    <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>
</div>
@empty
<p>Keine Jobanzeigen gefunden.</p>
@endforelse

<div class="pagination">
    {{ $jobs->links() }}
</div>
@endsection
