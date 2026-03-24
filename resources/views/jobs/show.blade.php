@extends('layouts.app')

@section('content')
<div class="job-card">
    <h1>{{ $job->title }}</h1>

    <p><strong>Beschreibung:</strong></p>
    <p>{{ $job->description }}</p>

    <p><strong>Firma:</strong> {{ $job->company->name }}</p>
    <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
    <p><strong>Ort:</strong> {{ $job->location }}</p>
    <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
    <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>

    <a class="back-link" href="{{ route('jobs.index') }}">← Zurück zur Übersicht</a>
</div>
@endsection
