@extends('layouts.app')

@section('content')
<h1 class="page-title">Neue Jobanzeige erstellen</h1>

@if ($errors->any())
<div style="background: #ffe5e5; color: #8a1f1f; padding: 15px; margin-bottom: 20px; border: 1px solid #d99;">
    <strong>Bitte prüfe deine Eingaben:</strong>
    <ul style="margin-top: 10px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="job-card">
    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="return" value="{{ request('return', route('jobs.index')) }}">

        <div style="margin-bottom: 15px;">
            <label for="title"><strong>Titel</strong></label><br>
            <input type="text" name="title" id="title" value="{{ old('title') }}" style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description"><strong>Beschreibung</strong></label><br>
            <textarea name="description" id="description" rows="6" style="width: 100%; padding: 10px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="location"><strong>Ort</strong></label><br>
            <input type="text" name="location" id="location" value="{{ old('location') }}" style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="salary"><strong>Gehalt</strong></label><br>
            <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary') }}" style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="company_id"><strong>Firma</strong></label><br>
            <select name="company_id" id="company_id" style="width: 100%; padding: 10px;">
                <option value="">Bitte auswählen</option>
                @foreach ($companies as $company)
                <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                {{ $company->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="category_id"><strong>Kategorie</strong></label><br>
            <select name="category_id" id="category_id" style="width: 100%; padding: 10px;">
                <option value="">Bitte auswählen</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="user_id"><strong>Erstellt von</strong></label><br>
            <select name="user_id" id="user_id" style="width: 100%; padding: 10px;">
                <option value="">Bitte auswählen</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="action-row">
            <button type="submit" class="btn btn-primary">Jobanzeige speichern</button>
            <a class="btn btn-secondary" href="{{ request('return', route('jobs.index')) }}">Abbrechen</a>
        </div>
    </form>
</div>
@endsection
