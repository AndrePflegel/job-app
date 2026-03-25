@extends('layouts.app')

@section('content')
<h1 class="page-title">Kategorien verwalten</h1>

@if (session('success'))
<div style="background: #e6ffed; color: #1f6b3b; padding: 15px; margin-bottom: 20px; border: 1px solid #a6d8b8;">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div style="background: #ffe5e5; color: #8a1f1f; padding: 15px; margin-bottom: 20px; border: 1px solid #d99;">
    {{ session('error') }}
</div>
@endif

<p style="margin-bottom: 20px;">
    <a class="btn btn-primary" href="{{ route('categories.create') }}">+ Neue Kategorie anlegen</a>
</p>

@forelse($categories as $category)
<div class="job-card">
    <h2>{{ $category->name }}</h2>

    <p><strong>Zugeordnete Jobs:</strong> {{ $category->jobListings()->count() }}</p>

    <div class="action-row">
        <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">Bearbeiten</a>

        <form class="inline-form" action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Möchtest du diese Kategorie wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
        </form>
    </div>
</div>
@empty
<p>Keine Kategorien vorhanden.</p>
@endforelse
@endsection
