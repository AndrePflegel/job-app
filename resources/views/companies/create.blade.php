@extends('layouts.app')

@section('content')
<h1 class="page-title">Neue Firma anlegen</h1>

@if ($errors->any())
<div style="background: #ffe5e5; color: #8a1f1f; padding: 15px; margin-bottom: 20px; border: 1px solid #d99;">
    <strong>Bitte prüfe deine Eingaben:</strong>
    <ul style="margin-top: 10px; padding-left: 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="job-card">
    <form action="{{ route('companies.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name"><strong>Name</strong></label><br>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="location"><strong>Standort</strong></label><br>
            <input type="text" name="location" id="location" value="{{ old('location') }}">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description"><strong>Beschreibung</strong></label><br>
            <textarea name="description" id="description" rows="5">{{ old('description') }}</textarea>
        </div>

        <div class="action-row">
            <button type="submit" class="btn btn-primary">Firma speichern</button>
            <a class="btn btn-secondary" href="{{ route('companies.index') }}">Abbrechen</a>
        </div>
    </form>
</div>
@endsection
