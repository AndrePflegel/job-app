@extends('layouts.app')

@section('content')
<h1 class="page-title">Kategorie bearbeiten</h1>

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
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="name"><strong>Name</strong></label><br>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="action-row">
            <button type="submit" class="btn btn-primary">Änderungen speichern</button>
            <a class="btn btn-secondary" href="{{ route('categories.index') }}">Zurück</a>
        </div>
    </form>
</div>
@endsection
