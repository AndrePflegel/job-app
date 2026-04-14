@extends('layouts.app')

@section('content')
<h1 class="page-title">Firmen verwalten</h1>

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

@can('create', App\Models\Company::class)
<p style="margin-bottom: 20px;">
    <a class="btn btn-primary" href="{{ route('companies.create') }}">+ Neue Firma anlegen</a>
</p>
@endcan

@forelse($companies as $company)
<div class="job-card">
    <h2>{{ $company->name }}</h2>

    <p><strong>Standort:</strong> {{ $company->location ?: '—' }}</p>
    <p><strong>Beschreibung:</strong> {{ $company->description ?: '—' }}</p>
    <p><strong>Zugeordnete Jobs:</strong> {{ $company->job_listings_count }}</p>

    <div class="action-row">
        @can('update', $company)
        <a class="btn btn-primary" href="{{ route('companies.edit', $company->id) }}">Bearbeiten</a>
        @endcan

        @can('delete', $company)
        <form class="inline-form" action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Möchtest du diese Firma wirklich löschen?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Löschen</button>
        </form>
        @endcan
    </div>
</div>
@empty
<p>Keine Firmen vorhanden.</p>
@endforelse
@endsection
