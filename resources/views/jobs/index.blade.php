@extends('layouts.app')

@section('content')

<h1>Jobanzeigen</h1>

@foreach($jobs as $job)
    <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc;">
        <h2>{{ $job->title }}</h2>

        <p>{{ $job->description }}</p>

        <p><strong>Firma:</strong> {{ $job->company->name }}</p>
        <p><strong>Kategorie:</strong> {{ $job->category->name }}</p>
        <p><strong>Ort:</strong> {{ $job->location }}</p>
        <p><strong>Gehalt:</strong> {{ $job->salary }}</p>
        <p><strong>Erstellt von:</strong> {{ $job->user->name }}</p>
    </div>
@endforeach

@endsection
