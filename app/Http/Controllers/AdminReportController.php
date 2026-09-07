<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // Exclude announcement reports from admin management listing
        $query = Report::with('submitter')->where('report_type', '!=', 'Announcement');

        // search
        if ($q = $request->query('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('student_name', 'like', "%{$q}%");
            })->orWhereHas('submitter', function ($u) use ($q) {
                $u->where('name', 'like', "%{$q}%");
            });
        }

        // filter by type
        $type = $request->query('type');
        if ($type && in_array($type, ['Daily Report', 'Weekly Report'])) {
            $query->where('report_type', $type);
        }

        $isMobile = preg_match('/(android|iphone|ipad|mobile|blackberry|opera mini|iemobile)/i', (string) $request->header('User-Agent', ''));
        $perPage = $isMobile ? 5 : 10;

        $reports = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load('submitter');
        return view('admin.reports.show', compact('report'));
    }

    public function destroy(Report $report)
    {
        // soft delete
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Report moved to trash.');
    }
}
