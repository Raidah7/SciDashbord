<?php
namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $researchCounts = Research::select('fields')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('fields')
            ->limit(20);
        $yearlyPublications = Research::selectRaw('YEAR(date_submitted) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $totalResearch = \App\Models\Research::count();
        $totalResearchers = \App\Models\Researcher::count();
        $totalComments = \App\Models\Comment::count();
        $totalRatings = \App\Models\Rating::count();

        $latest = Research::orderBy('date_submitted', 'desc')->take(5)->get();

        return view('front.dashboard', compact(
            'researchCounts', 'yearlyPublications',
            'totalResearch', 'totalResearchers', 'totalComments', 'totalRatings',
            'latest'
        ));
    }

}
