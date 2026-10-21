<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Campus;
use App\Models\Scholarship;
use App\Models\StudyProgram;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('welcome')
            ->with('campuses', Campus::query()->ordered()->limit(6)->get())
            ->with('programs', StudyProgram::query()->ordered()->limit(8)->get())
            ->with('scholarships', Scholarship::query()->ordered()->limit(3)->get())
            ->with('testimonials', Testimonial::query()->ordered()->limit(3)->get())
            ->with('articles', Article::query()->latest()->limit(3)->get())
            ->with('campusTypes', Campus::query()->select('type')->selectRaw('COUNT(*) as total')->groupBy('type')->get());
    }
}
