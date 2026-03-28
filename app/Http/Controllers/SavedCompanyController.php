<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class SavedCompanyController extends Controller
{
    public function store(Request $request, Company $company)
    {
        $user = auth()->user();

        if (!$user || !$user->isVisitor()) {
            abort(403, 'Nur Visitor können Firmen speichern.');
        }

        $user->savedCompanies()->syncWithoutDetaching([$company->id]);

        return redirect()->back()->with('success', 'Firma wurde gespeichert.');
    }

    public function destroy(Request $request, Company $company)
    {
        $user = auth()->user();

        if (!$user || !$user->isVisitor()) {
            abort(403, 'Nur Visitor können gespeicherte Firmen verwalten.');
        }

        $user->savedCompanies()->detach($company->id);

        return redirect()->back()->with('success', 'Firma wurde aus deinen gemerkten Firmen entfernt.');
    }
}
