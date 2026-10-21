<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Campus;
use App\Models\CampusContent;
use App\Models\Scholarship;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function campuses(Request $request): View
    {
        $campuses = Campus::query()
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('fakultas'), fn ($query) => $query->whereHas('faculties', fn ($facultyQuery) => $facultyQuery->where('name', 'like', '%'.$request->string('fakultas').'%')))
            ->when($request->filled('kota'), fn ($query) => $query->where('city', 'like', '%'.$request->string('kota').'%'))
            ->when($request->filled('jenis'), fn ($query) => $query->where('type', ucfirst((string) $request->string('jenis'))))
            ->ordered()
            ->get();

        return view('kampus.index')
            ->with('campuses', $campuses)
            ->with('filterCities', Campus::query()->select('city')->distinct()->orderBy('city')->pluck('city'))
            ->with('filterTypes', Campus::query()->select('type')->distinct()->orderBy('type')->pluck('type'));
    }

    public function campusDetail(string $slug): View
    {
        $campus = Campus::query()->where('slug', $slug)->firstOrFail();

        return view('kampus.detail')
            ->with('campus', $campus)
            ->with('campusContent', CampusContent::query()->where('campus_id', $campus->id)->ordered()->get()->groupBy('kind'))
            ->with('similarCampuses', Campus::query()->where('id', '!=', $campus->id)->ordered()->limit(3)->get())
            ->with('faculties', $campus->faculties()->orderBy('name')->get())
            ->with('reviews', $campus->reviews()->with('user')->latest()->get())
            ->with('averageRating', $campus->reviews()->avg('rating'))
            ->with('reviewCount', $campus->reviews()->count())
            ->with('myReview', auth()->check() ? $campus->reviews()->where('user_id', auth()->id())->first() : null);
    }

    public function scholarships(): View
    {
        return view('pages.beasiswa')->with('scholarships', Scholarship::query()->ordered()->get());
    }

    public function programs(Request $request): View
    {
        $programs = StudyProgram::query()
            ->when($request->filled('nama'), fn ($query) => $query->where('name', 'like', '%'.$request->string('nama').'%'))
            ->ordered()
            ->get();

        return view('pages.program-studi')->with('programs', $programs);
    }

    public function articles(): View
    {
        return view('pages.blog')->with('articles', Article::query()->latest()->get());
    }

    public function compare(Request $request): View
    {
        $requestedCampuses = $request->input('kampus', []);
        $selectedSlugs = is_array($requestedCampuses)
            ? array_values(array_filter($requestedCampuses, fn ($slug) => is_string($slug) && $slug !== ''))
            : [];

        $request->merge(['kampus' => $selectedSlugs]);
        $validated = $request->validate([
            'kampus' => ['nullable', 'array', 'max:3'],
            'kampus.*' => ['required', 'string', 'distinct', Rule::exists('campuses', 'slug')],
        ]);

        return view('pages.bandingkan')
            ->with('campuses', Campus::query()->ordered()->get())
            ->with('selectedSlugs', $validated['kampus'] ?? [])
            ->with('selectedCampuses', Campus::query()->whereIn('slug', $validated['kampus'] ?? [])->ordered()->get());
    }
}
