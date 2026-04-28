<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'author' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['author'] = $validated['author'] ?: 'Tim Mawkost';
        $validated['is_published'] = $request->input('is_published') === '1';
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'author' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
        ]);

        if ($request->title !== $article->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $validated['author'] = $validated['author'] ?: 'Tim Mawkost';

        $wasPublished = $article->is_published;
        $validated['is_published'] = $request->input('is_published') === '1';

        if (!$wasPublished && $validated['is_published']) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && Str::startsWith($article->thumbnail, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $article->thumbnail));
            }
            $path = $request->file('thumbnail')->store('articles', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        }

        if ($request->has('remove_thumbnail')) {
            if ($article->thumbnail && Str::startsWith($article->thumbnail, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $article->thumbnail));
            }
            $validated['thumbnail'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->thumbnail && Str::startsWith($article->thumbnail, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $article->thumbnail));
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
