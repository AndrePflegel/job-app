<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $query = JobListing::with('company', 'category', 'user');

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $jobs = $query->paginate(10)->withQueryString();

        return view('jobs.index', compact('jobs', 'companies', 'categories'));
    }

    public function show($id)
    {
        $job = JobListing::with('company', 'category', 'user')->findOrFail($id);

        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user || !$user->canCreateJobs()) {
            abort(403, 'Du hast keine Berechtigung, Jobs zu erstellen.');
        }

        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('jobs.create', compact('companies', 'categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->canCreateJobs()) {
            abort(403, 'Du hast keine Berechtigung, Jobs zu erstellen.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = $user->id;

        $job = JobListing::create($validated);

        return redirect($request->input('return', route('jobs.show', $job->id)))
            ->with('success', 'Jobanzeige erfolgreich erstellt.');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $job = JobListing::findOrFail($id);

        if (!$user || !$user->canManageJob($job)) {
            abort(403, 'Du darfst diese Jobanzeige nicht bearbeiten.');
        }

        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('jobs.edit', compact('job', 'companies', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $job = JobListing::findOrFail($id);

        if (!$user || !$user->canManageJob($job)) {
            abort(403, 'Du darfst diese Jobanzeige nicht bearbeiten.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $job->update($validated);

        return redirect($request->input('return', route('jobs.show', $job->id)))
            ->with('success', 'Jobanzeige erfolgreich aktualisiert.');
    }

    public function destroy(Request $request, $id)
    {
        $user = auth()->user();
        $job = JobListing::findOrFail($id);

        if (!$user || !$user->canManageJob($job)) {
            abort(403, 'Du darfst diese Jobanzeige nicht löschen.');
        }

        $job->delete();

        return redirect($request->input('return', route('jobs.index')))
            ->with('success', 'Jobanzeige erfolgreich gelöscht.');
    }
}
