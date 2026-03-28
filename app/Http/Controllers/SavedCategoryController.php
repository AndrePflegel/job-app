<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SavedCategoryController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $user = auth()->user();

        if (!$user || !$user->isVisitor()) {
            abort(403, 'Nur Visitor können Kategorien speichern.');
        }

        $user->savedCategories()->syncWithoutDetaching([$category->id]);

        return redirect()->back()->with('success', 'Kategorie wurde gespeichert.');
    }

    public function destroy(Request $request, Category $category)
    {
        $user = auth()->user();

        if (!$user || !$user->isVisitor()) {
            abort(403, 'Nur Visitor können gespeicherte Kategorien verwalten.');
        }

        $user->savedCategories()->detach($category->id);

        return redirect()->back()->with('success', 'Kategorie wurde aus deinen gemerkten Kategorien entfernt.');
    }
}
