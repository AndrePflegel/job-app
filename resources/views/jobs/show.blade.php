@extends('layouts.app')

@section('content')
    <h1>{{ $job->title }}</h1>

    <div style="padding: 20px; border: 1px solid #ccc; margin-top: 20px;">
        <p><strong>Beschreibung:</strong></p>
        <p>{{ $job->description }}</p>

        <p><strong>Firma:</strong> {{ $job->company->name }}</p>
        <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
        <p><strong>Ort:</strong> {{ $job->location }}</p>
        <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
        <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>
    </div>

    <p style="margin-top: 20px;">
        <a href="/jobs">← Zurück zur Übersicht</a>
    </p>
@endsection
