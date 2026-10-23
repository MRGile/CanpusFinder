<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Scholarship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScholarshipController extends Controller
{
    public function index(): View
    {
        return view('admin.scholarships.index')->with('scholarships', Scholarship::query()->ordered()->paginate(12));
    }

    public function create(): View
    {
        return view('admin.scholarships.form', $this->formData(new Scholarship()));
    }

    public function store(Request $request): RedirectResponse
    {
        Scholarship::create($this->validated($request));

        return redirect()->route('admin.beasiswa.index')->with('status', 'Beasiswa berhasil ditambahkan.');
    }

    public function edit(Scholarship $beasiswa): View
    {
        return view('admin.scholarships.form', $this->formData($beasiswa));
    }

    public function update(Request $request, Scholarship $beasiswa): RedirectResponse
    {
        $beasiswa->update($this->validated($request, $beasiswa));

        return redirect()->route('admin.beasiswa.index')->with('status', 'Data beasiswa berhasil diperbarui.');
    }

    public function destroy(Scholarship $beasiswa): RedirectResponse
    {
        $beasiswa->delete();

        return back()->with('status', 'Beasiswa berhasil dihapus.');
    }

    private function validated(Request $request, ?Scholarship $scholarship = null): array
    {
        foreach (['scholarship_type', 'study_level'] as $field) {
            if ($request->input($field) === '__new') {
                $request->merge([$field => $request->input($field.'_custom')]);
            }
        }

        $eligibleCampusOptions = Campus::query()->orderBy('name')->pluck('name')->all();
        $eligibleCampusOptions[] = Scholarship::ALL_CAMPUSES;
        if ($scholarship?->eligible_universities && !in_array($scholarship->eligible_universities, $eligibleCampusOptions, true)) {
            $eligibleCampusOptions[] = $scholarship->eligible_universities;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:255'],
            'scholarship_type' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date_format:Y-m-d'],
            'study_level' => ['required', 'string', 'max:255'],
            'recipient_count' => ['nullable', 'string', 'max:255'],
            'eligible_universities' => ['required', 'string', 'max:5000', Rule::in($eligibleCampusOptions)],
            'requirements' => ['nullable', 'string', 'max:10000'],
            'benefits' => ['nullable', 'string', 'max:10000'],
            'required_documents' => ['nullable', 'string', 'max:10000'],
            'description' => ['nullable', 'string', 'max:5000'],
            'application_url' => ['nullable', 'url', 'max:255'],
        ], [
            'name.required' => 'Nama beasiswa wajib diisi.',
            'provider.required' => 'Penyelenggara beasiswa wajib diisi.',
        ]);

        $validated['deadline_label'] = $validated['deadline'];

        return $validated;
    }

    private function formData(Scholarship $scholarship): array
    {
        $campuses = Campus::query()->ordered()->get(['id', 'name', 'abbreviation']);
        $legacyEligibleUniversity = $scholarship->eligible_universities
            && $scholarship->eligible_universities !== Scholarship::ALL_CAMPUSES
            && !$campuses->contains('name', $scholarship->eligible_universities)
                ? $scholarship->eligible_universities
                : null;
        $scholarshipTypes = collect(['Pemerintah', 'Swasta', 'Kedinasan', 'Luar Negeri', 'Kampus'])
            ->merge(Scholarship::query()->select('scholarship_type')->distinct()->orderBy('scholarship_type')->pluck('scholarship_type'))
            ->filter()->unique()->sort()->values();
        $studyLevels = collect([Scholarship::ALL_STUDY_LEVEL, 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'])
            ->merge(Scholarship::query()->select('study_level')->distinct()->orderBy('study_level')->pluck('study_level'))
            ->filter()->unique()->sort()->values();
        $oldType = old('scholarship_type');
        $oldLevel = old('study_level');
        $customTypeSelected = $oldType === '__new' || ($oldType && !$scholarshipTypes->contains($oldType));
        $customLevelSelected = $oldLevel === '__new' || ($oldLevel && !$studyLevels->contains($oldLevel));

        return compact('scholarship', 'campuses', 'legacyEligibleUniversity', 'scholarshipTypes', 'studyLevels', 'customTypeSelected', 'customLevelSelected');
    }
}
