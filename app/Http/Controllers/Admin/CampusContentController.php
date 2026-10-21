<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\CampusContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return view('admin.campus-content.index', ['campus' => $campus, 'content' => $content, 'types' => self::TYPES]);
    }

    public function store(Request $request, Campus $campus): RedirectResponse
    {
        $data = $this->validated($request);
        $campus->contents()->create($data);

        return back()->with('status', self::TYPES[$data['kind']].' berhasil ditambahkan.');
    }

    public function update(Request $request, Campus $campus, CampusContent $campusContent): RedirectResponse
    {
        $campusContent = $campus->contents()->findOrFail($campusContent->id);
        $data = $this->validated($request);
        $campusContent->update($data);

        return back()->with('status', self::TYPES[$data['kind']].' berhasil diperbarui.');
    }

    public function destroy(Campus $campus, CampusContent $campusContent): RedirectResponse
    {
        $campus->contents()->findOrFail($campusContent->id)->delete();

        return back()->with('status', 'Data berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'kind' => ['required', 'string', 'in:'.implode(',', array_keys(self::TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'value' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:10000'],
        ]);

        $data['sort_order'] ??= 0;

        return $data;
    }
}
