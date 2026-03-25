@extends('layouts.app')

@section('content')
<h1 class="page-title">Jobanzeige bearbeiten</h1>

@if ($errors->any())
<div style="background: #ffe5e5; color: #8a1f1f; padding: 15px; margin-bottom: 20px; border: 1px solid #d99; border-radius: 8px;">
    <strong>Bitte prüfe deine Eingaben:</strong>
    <ul style="margin-top: 10px; padding-left: 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="job-card">
    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="return" value="{{ request('return', route('jobs.show', $job->id)) }}">

        <div style="margin-bottom: 15px;">
            <label for="title"><strong>Titel</strong></label><br>
            <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description"><strong>Beschreibung</strong></label><br>
            <textarea name="description" id="description" rows="6">{{ old('description', $job->description) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="location"><strong>Ort</strong></label><br>
            <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="salary"><strong>Gehalt</strong></label><br>
            <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary', $job->salary) }}">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="company_id"><strong>Firma</strong></label><br>
            <select name="company_id" id="company_id">
                @foreach ($companies as $company)
                <option value="{{ $company->id }}" @selected(old('company_id', $job->company_id) == $company->id)>
                {{ $company->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="category_id"><strong>Kategorie</strong></label><br>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id) == $category->id)>
                {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="action-row">
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a class="btn btn-secondary" href="{{ request('return', route('jobs.show', $job->id)) }}">Abbrechen</a>
        </div>
    </form>

    <div class="action-row">
        <a class="btn btn-secondary" href="{{ route('jobs.show', ['job' => $job->id, 'return' => request('return', route('jobs.index'))]) }}">Ansehen</a>

        @auth
        @if (auth()->user()->canManageJob($job))
        <form class="inline-form" action="{{ route('jobs.destroy', ['job' => $job->id]) }}" method="POST" onsubmit="return confirm('Möchtest du diese Jobanzeige wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
            <input type="hidden" name="return" value="{{ request('return', route('jobs.index')) }}">
        </form>
        @endif
        @endauth

        <a class="btn btn-secondary" href="{{ request('return', route('jobs.index')) }}">Zurück zur Liste</a>
    </div>
</div>
@endsection
