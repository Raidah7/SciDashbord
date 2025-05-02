<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;

class FrontController extends Controller
{
    public function researchList(Request $request)
    {
//        $query = Research::where('approved', true);

        $query = Research::query();
        if ($request->has('college') && !empty($request->college)) {
            $query->where('college', 'LIKE', "%{$request->college}%");
        }

        if ($request->has('department') && !empty($request->department)) {
            $query->where('department', 'LIKE', "%{$request->department}%");
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('fields', 'LIKE', "%{$request->category}%");
        }
        if ($request->has('author') && !empty($request->author)) {
            $query->where('authors', 'LIKE', "%{$request->author}%");
        }
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('date_submitted', '>=', $request->date);
        }
        if ($request->has('citations') && !empty($request->citations)) {
            $query->whereHas('ratings', function ($q) use ($request) {
                $q->havingRaw('COUNT(*) >= ?', [$request->citations]);
            });
        }
        $researches = $query->orderBy('date_submitted', 'desc')->paginate(12);
        return view('front.research', compact('researches'));
    }

    public function researchDetails($id)
    {
        $research = Research::with('ratings', 'comments')->findOrFail($id);
        return view('front.research_details', compact('research'));
    }
}
