<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\CampusContent;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CampusContentController extends Controller
{
    private const TYPES = [
        'program' => 'Program studi',
        'admission' => 'Jalur pendaftaran',
        'cost' => 'Biaya kuliah',
        'facility' => 'Fasilitas',
    ];

    public function index(Campus $campus): View
    {
        $content = $campus->contents()->whereIn('kind', array_keys(self::TYPES))->ordered()->get()->groupBy('kind');
        $programOptions = CampusContent::query()->where('kind', 'program')->whereNotNull('title')->select('title')->distinct()->orderBy('title')->pluck('title');
        $faculties = $campus->faculties()->orderBy('name')->get(['id', 'name']);

        return view('admin.campus-content.index', ['campus' => $campus, 'content' => $content, 'types' => self::TYPES, 'programOptions' => $programOptions, 'faculties' => $faculties]);
    }

    public function store(Request $request, Campus $campus): RedirectResponse
    {
        $data = $this->validated($request);
        $data['sort_order'] = ((int) $campus->contents()->where('kind', $data['kind'])->max('sort_order')) + 1;
        $campus->contents()->create($data);
        $this->syncProgramCount($campus);

        return back()->with('status', self::TYPES[$data['kind']].' berhasil ditambahkan.');
    }

    public function update(Request $request, Campus $campus, CampusContent $campusContent): RedirectResponse
    {
        $campusContent = $campus->contents()->findOrFail($campusContent->id);
        $data = $this->validated($request);
        $campusContent->update($data);
        $this->syncProgramCount($campus);

        return back()->with('status', self::TYPES[$data['kind']].' berhasil diperbarui.');
    }

    public function destroy(Campus $campus, CampusContent $campusContent): RedirectResponse
    {
        $campus->contents()->findOrFail($campusContent->id)->delete();
        $this->syncProgramCount($campus);

        return back()->with('status', 'Data berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        if ($request->input('kind') === 'program') {
            if ($request->input('title') === '__new') {
                $request->merge(['title' => $request->input('title_custom')]);
            }
        }

        $data = $request->validate([
            'kind' => ['required', 'string', 'in:'.implode(',', array_keys(self::TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'study_level' => ['nullable', 'string', 'max:50'],
            'faculty_id' => [
                'nullable',
                Rule::exists('faculties', 'id')->where(fn (QueryBuilder $query) => $query->where('campus_id', $request->route('campus')->id)),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'value' => ['nullable', 'string', 'max:255'],
        ]);

        if ($data['kind'] !== 'program') {
            unset($data['study_level'], $data['faculty_id']);
        }

        return $data;
    }

    private function syncProgramCount(Campus $campus): void
    {
        $campus->update(['program_count' => $campus->contents()->where('kind', 'program')->count()]);
    }
}
