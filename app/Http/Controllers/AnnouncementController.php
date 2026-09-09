<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Report;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,webp,avif|max:5120',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcements/files', 'public');
        }

        $announcement = Announcement::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'file' => $filePath,
            'published_at' => now(),
            'user_id' => auth()->id(),
        ]);

        Report::create([
            'report_type' => 'Announcement',
            'title' => $announcement->title,
            'description' => $announcement->content ?? 'Announcement update',
            'photos' => $imagePath ? [$imagePath] : [],
            'submitted_by' => auth()->id(),
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Announcement posted successfully.');
    }
}
