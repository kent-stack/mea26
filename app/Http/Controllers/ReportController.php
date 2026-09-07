<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    /**
    * Store uploaded report media.
     */
    public function store(Request $request)
    {
        // Check if this is an admin review submission
        if ($request->has('is_admin_review') && $request->input('is_admin_review') == 1) {
            return $this->storeAdminReview($request);
        }
        
        // Regular student report submission
        $validated = $request->validate([
            'report_type' => 'required|in:Daily Report,Weekly Report',
            'nama_project' => 'required|string|max:255',
            'penjelasan_project' => 'required|string',
            'photos' => 'required|array|max:10',
            'photos.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,webm,mkv|max:2097152',
        ]);

        $paths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $paths[] = $file->store('reports', 'public');
            }
        }

        $report = Report::create([
            'report_type' => $validated['report_type'],
            'title' => $validated['nama_project'],
            'description' => $validated['penjelasan_project'],
            'photos' => $paths,
            'submitted_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }

    /**
     * Store admin review submission
     */
    private function storeAdminReview(Request $request)
    {
        $validated = $request->validate([
            'student_email' => 'required|email|string|max:255',
            'student_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'admin_notes' => 'required|string',
            'admin_docs' => 'nullable|array|max:5',
            'admin_docs.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $docPaths = [];
        if ($request->hasFile('admin_docs')) {
            foreach ($request->file('admin_docs') as $file) {
                $docPaths[] = $file->store('admin-reviews', 'public');
            }
        }

        // Create a new report entry for the admin review
        $report = Report::create([
            'report_type' => 'Admin Review',
            'title' => 'Review for ' . $validated['student_name'],
            'description' => $validated['admin_notes'],
            'student_name' => $validated['student_name'],
            'student_email' => $validated['student_email'],
            'rating' => $validated['rating'],
            'admin_id' => auth()->id(),
            'submitted_by' => auth()->id(),
            'photos' => $docPaths,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully for ' . $validated['student_name'] . '.');
    }
}
