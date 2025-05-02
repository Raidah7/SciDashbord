<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Research;
use App\Models\Comment;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // User Growth Chart Data
        $userGrowthData = User::selectRaw('DATE(date_created) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('total');
        $userGrowthLabels = User::selectRaw('DATE(date_created) as date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('date');

        // Research Status Distribution
        $researchStatusCounts = Research::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.reports', compact('userGrowthData', 'userGrowthLabels', 'researchStatusCounts'));
    }

    public function export($type)
    {
        switch ($type) {
            case 'users':
                $data = User::select('name', 'email', 'role', 'date_created')->get();
                $filename = "users_report.csv";
                break;

            case 'research':
                $data = Research::select('title', 'status', 'date_submitted')->get();
                $filename = "research_report.csv";
                break;

            case 'comments':
                $data = Comment::select('user_id', 'research_id', 'content', 'date')->get();
                $filename = "comments_report.csv";
                break;

            default:
                return back()->with('error', 'Invalid report type.');
        }

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array_keys($data->first()->toArray()));

        foreach ($data as $row) {
            fputcsv($handle, $row->toArray());
        }

        fclose($handle);

        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
