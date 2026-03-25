<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        $companies = Company::orderBy('name')->get();

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('companies.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        Company::create($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Firma erfolgreich erstellt.');
    }

    public function edit(Company $company)
    {
        $this->authorizeAdmin();

        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Firma erfolgreich aktualisiert.');
    }

    public function destroy(Company $company)
    {
        $this->authorizeAdmin();

        if ($company->jobListings()->exists()) {
            return redirect()->route('companies.index')
                ->with('error', 'Diese Firma kann nicht gelöscht werden, weil noch Jobs darauf verweisen.');
        }

        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Firma erfolgreich gelöscht.');
    }

    private function authorizeAdmin(): void
    {
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Nur Admins dürfen Firmen verwalten.');
        }
    }
}
