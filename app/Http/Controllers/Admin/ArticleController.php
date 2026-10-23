<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.index', [
            'articles' => Article::query()->orderByDesc('published_at')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.form', ['article' => new Article()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $article = Article::create($this->validated($request));

        if ($request->hasFile('image')) {
            $article->update(['image_path' => $request->file('image')->store('articles', 'public')]);
        }

        return redirect()->route('admin.blog.index')->with('status', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $blog): View
    {
        return view('admin.blog.form', ['article' => $blog]);
    }

    public function update(Request $request, Article $blog): RedirectResponse
    {
        $blog->update($this->validated($request));

        if ($request->boolean('remove_image') && $blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
            $blog->image_path = null;
        }

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')->store('articles', 'public');
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $blog->image_path = $newImage;
        }

        $blog->save();

        return redirect()->route('admin.blog.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $blog): RedirectResponse
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }

        $blog->delete();

        return back()->with('status', 'Artikel berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'published_at' => ['required', 'date_format:Y-m-d'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category.required' => 'Kategori artikel wajib diisi.',
            'published_at.required' => 'Tanggal publikasi wajib diisi.',
        ]);

        unset($validated['image'], $validated['remove_image']);

        return $validated;
    }
}
