<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        $categories = Category::withCount('jobListings')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategorie erfolgreich erstellt.');
    }

    public function edit(Category $category)
    {
        $this->authorizeAdmin();

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategorie erfolgreich aktualisiert.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeAdmin();

        if ($category->jobListings()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Diese Kategorie wird noch verwendet und kann nicht gelöscht werden.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategorie gelöscht.');
    }

    private function authorizeAdmin(): void
    {
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            abort(403);
        }
    }
}
