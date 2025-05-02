<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;

class AdminResearchController extends Controller
{
    public function index()
    {
        $researches = Research::with('researcher.user')->get();
        return view('admin.research', compact('researches'));
    }

    public function details($id)
    {
        $research = Research::with('researcher.user')->findOrFail($id);
        return view('admin.research_details', compact('research'));
    }

    public function updateStatus(Request $request)
    {
        $research = Research::find($request->research_id);
        if ($research) {
            $research->status = $request->status;
            $research->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Research not found'], 404);
    }
}
