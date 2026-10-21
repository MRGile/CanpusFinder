<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Faculty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(Campus $campus): View
    {
        return view('admin.faculties.index')
            ->with('campus', $campus)
            ->with('faculties', $campus->faculties()->orderBy('name')->paginate(12));
    }

    public function create(Campus $campus): View
    {
        return view('admin.faculties.form')->with('campus', $campus)->with('faculty', new Faculty());
    }

    public function store(Request $request, Campus $campus): RedirectResponse
    {
        $campus->faculties()->create($this->validated($request, $campus));

        return redirect()->route('admin.universitas.fakultas.index', $campus)->with('status', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Campus $campus, Faculty $faculty): View
    {
        return view('admin.faculties.form')->with('campus', $campus)->with('faculty', $faculty);
    }

    public function update(Request $request, Campus $campus, Faculty $faculty): RedirectResponse
    {
        $faculty->update($this->validated($request, $campus, $faculty));

        return redirect()->route('admin.universitas.fakultas.index', $campus)->with('status', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Campus $campus, Faculty $faculty): RedirectResponse
    {
        $faculty->delete();

        return back()->with('status', 'Fakultas berhasil dihapus.');
    }

    private function validated(Request $request, Campus $campus, ?Faculty $faculty = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('faculties', 'name')->where('campus_id', $campus->id)->ignore($faculty?->id)],
            'dean' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ], ['name.required' => 'Nama fakultas wajib diisi.']);
    }
}
