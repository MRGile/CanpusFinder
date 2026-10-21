<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UniversityController extends Controller
{
    public function index(): View
    {
        return view('admin.universities.index')->with('campuses', Campus::query()->withCount('faculties')->ordered()->paginate(12));
    }

    public function create(): View
    {
        return view('admin.universities.form')->with('campus', new Campus());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('universities', 'public');
        }
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('universities/logos', 'public');
        }

        $campus = Campus::create($data);

        return redirect()->route('admin.universitas.fakultas.index', $campus)->with('status', 'Universitas berhasil ditambahkan.');
    }

    public function edit(Campus $campus): View
    {
        return view('admin.universities.form')->with('campus', $campus);
    }

    public function update(Request $request, Campus $campus): RedirectResponse
    {
        $data = $this->validated($request, $campus);
        if ($request->boolean('remove_image')) {
            if ($campus->image_path) {
                Storage::disk('public')->delete($campus->image_path);
            }
            $data['image_path'] = null;
        }
        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('universities', 'public');
            if ($campus->image_path) {
                Storage::disk('public')->delete($campus->image_path);
            }
            $data['image_path'] = $newImagePath;
        }
        if ($request->boolean('remove_logo')) {
            if ($campus->logo_path) {
                Storage::disk('public')->delete($campus->logo_path);
            }
            $data['logo_path'] = null;
        }
        if ($request->hasFile('logo')) {
            $newLogoPath = $request->file('logo')->store('universities/logos', 'public');
            if ($campus->logo_path) {
                Storage::disk('public')->delete($campus->logo_path);
            }
            $data['logo_path'] = $newLogoPath;
        }

        $campus->update($data);

        return redirect()->route('admin.universitas.index')->with('status', 'Data universitas berhasil diperbarui.');
    }

    public function destroy(Campus $campus): RedirectResponse
    {
        if ($campus->image_path) {
            Storage::disk('public')->delete($campus->image_path);
        }
        if ($campus->logo_path) {
            Storage::disk('public')->delete($campus->logo_path);
        }
        $campus->delete();

        return back()->with('status', 'Universitas berhasil dihapus.');
    }

    private function validated(Request $request, ?Campus $campus = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'abbreviation' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'founded_year' => ['nullable', 'integer', 'between:1800,'.now()->year],
            'description' => ['nullable', 'string', 'max:5000'],
            'program_count' => ['required', 'integer', 'min:0', 'max:10000'],
            'type' => ['required', Rule::in(['Negeri', 'Swasta', 'Vokasi', 'Kedinasan'])],
            'accreditation' => ['required', 'string', 'max:100'],
            'rank' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama universitas wajib diisi.',
            'abbreviation.required' => 'Singkatan universitas wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'type.required' => 'Jenis universitas wajib dipilih.',
        ]);

        $slug = Str::slug($data['name']);
        $slugQuery = Campus::query()->where('slug', $slug);
        if ($campus) {
            $slugQuery->where('id', '<>', $campus->getKey());
        }
        if ($slugQuery->exists()) {
            $slug .= '-'.Str::lower(Str::random(5));
        }

        return [...$data, 'slug' => $slug];
    }
}
