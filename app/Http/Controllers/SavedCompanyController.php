<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class SavedCompanyController extends Controller
{
    public function store(Request $request, Company $company)
    {
        $this->authorize('save', $company);

        $request->user()->savedCompanies()->syncWithoutDetaching([$company->id]);

        return redirect()->back()
            ->with('success', 'Firma wurde gespeichert.');
    }

    public function destroy(Request $request, Company $company)
    {
        $this->authorize('unsave', $company);

        $request->user()->savedCompanies()->detach($company->id);

        return redirect()->back()
            ->with('success', 'Firma wurde aus deinen gemerkten Firmen entfernt.');
    }
}
