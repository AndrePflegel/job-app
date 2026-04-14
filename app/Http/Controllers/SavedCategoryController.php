<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SavedCategoryController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $this->authorize('save', $category);

        $request->user()->savedCategories()->syncWithoutDetaching([$category->id]);

        return redirect()->back()
            ->with('success', 'Kategorie wurde gespeichert.');
    }

    public function destroy(Request $request, Category $category)
    {
        $this->authorize('unsave', $category);

        $request->user()->savedCategories()->detach($category->id);

        return redirect()->back()
            ->with('success', 'Kategorie wurde aus deinen gemerkten Kategorien entfernt.');
    }
}
