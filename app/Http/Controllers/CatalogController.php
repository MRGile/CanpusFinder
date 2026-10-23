<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Campus;
use App\Models\CampusContent;
use App\Models\Faculty;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function campuses(Request $request): View
    {
        $campuses = Campus::query()->withAvg('reviews', 'rating')->withCount('reviews')
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('fakultas'), fn ($query) => $query->whereHas('faculties', fn ($facultyQuery) => $facultyQuery->where('name', 'like', '%'.$request->string('fakultas').'%')))
            ->when($request->filled('kota'), fn ($query) => $query->where('city', 'like', '%'.$request->string('kota').'%'))
            ->when($request->filled('jenis'), fn ($query) => $query->where('type', ucfirst((string) $request->string('jenis'))))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

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
            ->with('similarCampuses', Campus::query()->withAvg('reviews', 'rating')->withCount('reviews')->where('id', '!=', $campus->id)->ordered()->limit(3)->get())
            ->with('faculties', $campus->faculties()->orderBy('name')->get())
            ->with('reviews', $campus->reviews()->with('user')->latest()->get())
            ->with('averageRating', $campus->reviews()->avg('rating'))
            ->with('reviewCount', $campus->reviews()->count())
            ->with('myReview', auth()->check() ? $campus->reviews()->where('user_id', auth()->id())->first() : null);
    }

    public function facultyDetail(Campus $campus, Faculty $faculty): View
    {
        return view('pages.fakultas-detail')
            ->with('campus', $campus)
            ->with('faculty', $faculty);
    }

    public function scholarships(Request $request): View
    {
        $studyLevels = collect(['SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'])
            ->merge(Scholarship::query()->notExpired()->select('study_level')->distinct()->orderBy('study_level')->pluck('study_level'))
            ->filter(fn ($level) => !in_array(mb_strtolower(trim((string) $level)), [mb_strtolower(Scholarship::ALL_STUDY_LEVEL), 'semua'], true))
            ->unique()->sort()->values();

        $scholarships = Scholarship::query()->notExpired()
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($search) => $search->where('name', 'like', '%'.$request->string('q').'%')->orWhere('provider', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('jenis'), fn ($query) => $query->where('scholarship_type', $request->string('jenis')))
            ->when($request->filled('jenjang'), fn ($query) => $query->where(function ($levels) use ($request) {
                $levels->where('study_level', $request->string('jenjang'))
                    ->orWhereRaw('LOWER(study_level) IN (?, ?)', [mb_strtolower(Scholarship::ALL_STUDY_LEVEL), 'semua']);
            }))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('pages.beasiswa')
            ->with('scholarships', $scholarships)
            ->with('scholarshipTypes', Scholarship::query()->notExpired()->select('scholarship_type')->distinct()->orderBy('scholarship_type')->pluck('scholarship_type'))
            ->with('studyLevels', $studyLevels);
    }

    public function scholarshipDetail(Scholarship $scholarship): View
    {
        $scholarship = Scholarship::query()->notExpired()->findOrFail($scholarship->id);

        return view('pages.beasiswa-detail')->with('scholarship', $scholarship);
    }

    public function programs(Request $request): View
    {
        $programs = CampusContent::query()->where('kind', 'program')->whereNotNull('title')
            ->when($request->filled('nama'), fn ($query) => $query->where('title', 'like', '%'.$request->string('nama').'%'))
            ->select('title')->distinct()->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        $names = $programs->getCollection()->pluck('title');
        $entriesByTitle = CampusContent::query()->where('kind', 'program')->whereIn('title', $names)->with(['campus', 'faculty'])->ordered()->get()->groupBy('title');
        $programs->setCollection($programs->getCollection()->map(function ($row) use ($entriesByTitle) {
            $entries = $entriesByTitle->get($row->title, collect());
            $row->name = $row->title;
            $row->slug = Str::slug($row->title);
            $classification = $entries->flatMap(fn (CampusContent $entry) => [$entry->study_level, $entry->faculty?->name])->filter()->unique();
            $row->category = ($classification->isNotEmpty() ? $classification : $entries->pluck('subtitle')->filter())->unique()->implode(' · ');
            $row->university_count = $entries->pluck('campus_id')->unique()->count();

            return $row;
        }));

        return view('pages.program-studi')->with('programs', $programs);
    }

    public function programDetail(string $slug): View
    {
        $entries = CampusContent::query()->where('kind', 'program')->whereNotNull('title')->with(['campus', 'faculty'])->ordered()->get()
            ->filter(fn (CampusContent $entry) => Str::slug($entry->title) === $slug)
            ->values();

        abort_if($entries->isEmpty(), 404);

        return view('pages.program-studi-detail', ['program' => $entries->first(), 'campusPrograms' => $entries]);
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
            ->with('campuses', Campus::query()->withAvg('reviews', 'rating')->withCount('reviews')->ordered()->get())
            ->with('selectedSlugs', $validated['kampus'] ?? [])
            ->with('selectedCampuses', Campus::query()->withAvg('reviews', 'rating')->withCount('reviews')->whereIn('slug', $validated['kampus'] ?? [])->ordered()->get());
    }
}
