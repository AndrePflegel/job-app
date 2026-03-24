<?php

namespace App\Http\Controllers;

use App\Models\JobListing;

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
}
