<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Research;

class ResearchController extends Controller
{
    use UploadFile;

    public function index()
    {
        $researches = Research::where('submitted_by', Auth::id())->get();
        return view('researcher.research.index', compact('researches'));
    }

    public function create()
    {
        return view('researcher.research.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'nullable|string',
            'fields' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $documentPath = null;
                if ($request->hasFile('document')) {
                    $documentPath = $this->upload($request->file('document'));
                }
                Research::create([
                    'title' => $request->title,
                    'abstract' => $request->abstract,
                    'authors' => $request->authors,
                    'fields' => $request->fields,
                    'date_submitted' => now(),
                    'document' => $documentPath,
                    'submitted_by' => Auth::id(),
                    'approved' => false,
                    'status' => 'Submitted',
                ]);
            });

            return redirect()->route('researcher.research.index')->with('success', 'Research added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, please try again.')->withInput();
        }
    }

    public function edit(Research $research)
    {
        return view('researcher.research.edit', compact('research'));
    }

    public function update(Request $request, Research $research)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'nullable|string',
            'fields' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::transaction(function () use ($request, $research) {
                if ($request->hasFile('document')) {
                    if ($research->document) {
                        Storage::delete($research->document);
                    }
                    $documentPath = $this->upload($request->file('document'));
                }
                $research->update([
                    'title' => $request->title,
                    'abstract' => $request->abstract,
                    'authors' => $request->authors,
                    'fields' => $request->fields,
                ]);
            });
            return redirect()->route('researcher.research.index')->with('success', 'Research updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, please try again.')->withInput();
        }
    }

    public function destroy(Research $research)
    {
        try {
            if ($research->document) {
                Storage::delete($research->document);
            }
            $research->delete();
            return redirect()->route('researcher.research.index')->with('success', 'Research deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, please try again.');
        }
    }
}
