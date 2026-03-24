<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index()
    {
        $jobs = JobListing::with('company', 'category', 'user')->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = JobListing::with('company', 'category', 'user')->findOrFail($id);

        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('jobs.create', compact('companies', 'categories', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        JobListing::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Jobanzeige erfolgreich erstellt.');
    }

    public function edit($id)
    {
        $job = JobListing::findOrFail($id);

        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('jobs.edit', compact('job', 'companies', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $job = JobListing::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $job->update($validated);

        return redirect($request->input('return', route('jobs.show', $job->id)))
            ->with('success', 'Jobanzeige erfolgreich aktualisiert.');
    }

    public function destroy($id)
    {
        $job = JobListing::findOrFail($id);
        $job->delete();

        return redirect(request('return', route('jobs.index')))
            ->with('success', 'Jobanzeige erfolgreich gelöscht.');
    }
}
