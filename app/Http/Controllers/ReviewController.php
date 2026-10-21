<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Campus $campus): RedirectResponse
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'body' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        $campus->reviews()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $data,
        );

        return redirect()->to('/kampus/'.$campus->slug.'#tab-ulasan')->with('status', 'Ulasan kamu berhasil disimpan.');
    }
}
