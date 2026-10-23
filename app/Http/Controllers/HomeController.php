<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Campus;
use App\Models\Scholarship;
use App\Models\CampusContent;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $campusTypes = Campus::query()->select('type')->selectRaw('COUNT(*) as total')->groupBy('type')->get();

        return view('welcome')
            ->with('campuses', Campus::query()->withAvg('reviews', 'rating')->withCount('reviews')->ordered()->limit(6)->get())
            ->with('programs', CampusContent::query()->where('kind', 'program')->whereNotNull('title')->selectRaw('title, COUNT(DISTINCT campus_id) as university_count')->groupBy('title')->orderBy('title')->limit(8)->get())
            ->with('scholarships', Scholarship::query()->notExpired()->ordered()->limit(3)->get())
            ->with('testimonials', Testimonial::query()->ordered()->limit(3)->get())
            ->with('articles', Article::query()->latest()->limit(3)->get())
            ->with('campusTypes', $campusTypes)
            ->with('totalCampuses', (int) $campusTypes->sum('total'))
            ->with('totalPrograms', (int) CampusContent::query()->where('kind', 'program')->distinct()->count('title'))
            ->with('registeredUsers', User::query()->count())
            ->with('totalScholarships', Scholarship::query()->notExpired()->count())
            ->with('scholarshipTypeCount', Scholarship::query()->notExpired()->distinct()->count('scholarship_type'))
            ->with('scholarshipProviderCount', Scholarship::query()->notExpired()->distinct()->count('provider'))
            ->with('scholarshipLevelCount', Scholarship::query()->notExpired()->distinct()->count('study_level'));
    }
}
