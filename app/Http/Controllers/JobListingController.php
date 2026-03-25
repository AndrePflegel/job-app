<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
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

        $cacheKey = 'jobs_' . md5(json_encode($request->all()));

        $jobs = Cache::remember($cacheKey, 60, function () use ($request) {
            $query = JobListing::with('company', 'category', 'user');

            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            return $query->paginate(10)->withQueryString();
        });

        return view('jobs.index', compact('jobs', 'companies', 'categories'));
    }

    public function show($id)
    {
        $job = JobListing::with('company', 'category', 'user')->findOrFail($id);

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
        ]);

        $validated['user_id'] = auth()->id();

        $job = JobListing::create($validated);

        Cache::flush();

        return redirect($request->input('return', route('jobs.show', $job->id)))
            ->with('success', 'Jobanzeige erfolgreich erstellt.');
    }

    public function edit($id)
    {
        $job = JobListing::findOrFail($id);
        $this->authorize('update', $job);

        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('jobs.edit', compact('job', 'companies', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $job = JobListing::findOrFail($id);
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $job->update($validated);

        Cache::flush();

        return redirect($request->input('return', route('jobs.show', $job->id)))
            ->with('success', 'Jobanzeige erfolgreich aktualisiert.');
    }

    public function destroy(Request $request, $id)
    {
        $job = JobListing::findOrFail($id);
        $this->authorize('delete', $job);

        $job->delete();

        Cache::flush();

        return redirect($request->input('return', route('jobs.index')))
            ->with('success', 'Jobanzeige erfolgreich gelöscht.');
    }

    public function myJobs()
    {
        $jobs = JobListing::where('user_id', auth()->id())
            ->with('company', 'category')
            ->latest()
            ->get();

        return view('jobs.my-jobs', compact('jobs'));
    }

}
