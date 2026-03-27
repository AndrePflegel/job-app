@extends('layouts.app')

@section('content')
<h1 style="margin-bottom: 24px;">Neue Jobanzeige erstellen</h1>

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

<form action="{{ route('jobs.store') }}" method="POST">
    @csrf
    <input type="hidden" name="return" value="{{ request('return', route('jobs.index')) }}">

    <div style="margin-bottom: 18px;">
        <label for="title" style="display: block; margin-bottom: 6px; color: #e5e7eb;">Titel:</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
    </div>

    <div style="margin-bottom: 18px;">
        <label for="description" style="display: block; margin-bottom: 6px; color: #e5e7eb;">Beschreibung:</label>
        <textarea id="description" name="description" required>{{ old('description') }}</textarea>
    </div>

    <div style="margin-bottom: 18px;">
        <label for="location" style="display: block; margin-bottom: 6px; color: #e5e7eb;">Ort:</label>
        <input type="text" id="location" name="location" value="{{ old('location') }}" required>
    </div>

    <div style="margin-bottom: 18px;">
        <label for="salary" style="display: block; margin-bottom: 6px; color: #e5e7eb;">Gehalt:</label>
        <input type="text" id="salary" name="salary" value="{{ old('salary') }}">
    </div>

    <div style="margin-bottom: 18px;">
        <label for="company_id" style="display: block; margin-bottom: 6px; color: #e5e7eb;">Firma:</label>
        <select name="company_id" id="company_id" required>
            @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
            {{ $company->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 22px;">
        <label for="category_id" style="display: block; margin-bottom: 6px; color: #e5e7eb;">Kategorie:</label>
        <select name="category_id" id="category_id" required>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 24px; color: #f3f4f6;">
        <label for="is_active" style="display: inline-flex; align-items: center; gap: 10px; cursor: pointer;">
            <input
                type="checkbox"
                name="is_active"
                id="is_active"
                value="1"
                style="width: 18px; height: 18px; margin: 0;"
                {{ old('is_active', true) ? 'checked' : '' }}
            >
            <span>Jobanzeige aktiv</span>
        </label>
    </div>

    <div class="action-row" style="margin-bottom: 18px;">
        <button type="submit" class="btn btn-primary">Jobanzeige speichern</button>
        <a class="btn btn-secondary" href="{{ request('return', route('jobs.index')) }}">Abbrechen</a>
    </div>
</form>
@endsection
