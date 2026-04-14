<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $cacheKey = 'jobs_' . md5(json_encode([
                'filters' => $request->all(),
                'role' => auth()->check() ? auth()->user()->role : 'guest',
            ]));

        $jobs = Cache::remember($cacheKey, 60, function () use ($request) {
            $query = JobListing::with('company', 'category', 'user');

            if (!auth()->check() || auth()->user()->isVisitor()) {
                $query->where('is_active', true);
            }

            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            return $query->latest()->paginate(10)->withQueryString();
        });

        return view('jobs.index', compact('jobs', 'companies', 'categories'));
    }

    public function show(JobListing $job)
    {
        $job->load('company', 'category', 'user');

        $this->authorize('view', $job);

        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        $this->authorize('create', JobListing::class);

        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('jobs.create', compact('companies', 'categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', JobListing::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active');

        $job = JobListing::create($validated);

        Cache::flush();

        return redirect($request->input('return', route('jobs.show', $job)))
            ->with('success', 'Jobanzeige erfolgreich erstellt.');
    }

    public function edit(JobListing $job)
    {
        $this->authorize('update', $job);

        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('jobs.edit', compact('job', 'companies', 'categories'));
    }

    public function update(Request $request, JobListing $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $job->update($validated);

        Cache::flush();

        return redirect()
            ->route('jobs.edit', $job)
            ->with('success', 'Jobanzeige erfolgreich aktualisiert.');
    }

    public function destroy(Request $request, JobListing $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        Cache::flush();

        return redirect($request->input('return', route('jobs.index')))
            ->with('success', 'Jobanzeige erfolgreich gelöscht.');
    }

    public function myJobs()
    {
        $this->authorize('create', JobListing::class);

        $jobs = JobListing::where('user_id', auth()->id())
            ->with('company', 'category', 'user')
            ->latest()
            ->get();

        return view('jobs.my-jobs', compact('jobs'));
    }
}
