<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Campus;
use App\Models\Scholarship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        return view('pages.dashboard')
            ->with('favoriteCampuses', $user->favoriteCampuses()->orderByPivot('created_at', 'desc')->limit(3)->get())
            ->with('favoriteCount', $user->favoriteCampuses()->count())
            ->with('campusCount', Campus::query()->count())
            ->with('scholarshipCount', Scholarship::query()->count())
            ->with('scholarships', Scholarship::query()->ordered()->limit(3)->get());
    }

    public function favorites(Request $request): View
    {
        return view('pages.favorit')
            ->with('campuses', $request->user()->favoriteCampuses()->ordered()->get());
    }

    public function notifications(): View
    {
        return view('pages.notifikasi')->with('notifications', AppNotification::query()->latest()->get());
    }

    public function toggleFavorite(Request $request, string $slug): RedirectResponse
    {
        $campus = Campus::query()->where('slug', $slug)->firstOrFail();
        $favorites = $request->user()->favoriteCampuses();

        if ($favorites->whereKey($campus->id)->exists()) {
            $favorites->detach($campus->id);
        } else {
            $favorites->attach($campus->id);
        }

        return back();
    }
}
