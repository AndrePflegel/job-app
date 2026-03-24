<?php

namespace App\Http\Controllers;

use App\Models\JobListing;

class JobListingController extends Controller
{
    public function index()
    {
        $jobs = JobListing::with('company', 'category', 'user')->get();

        return view('jobs.index', compact('jobs'));
    }
}
