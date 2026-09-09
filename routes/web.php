<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Report;
use Illuminate\Support\Facades\Schema;
use App\Models\Announcement;
use App\Http\Controllers\AdminReportController;

Route::get('/', function () {
    // fetch latest report to show on homepage
    $report = null;
    try {
        $report = Report::latest()->first();
    } catch (\Exception $e) {
        // ignore if reports table doesn't exist yet
        $report = null;
    }

    // only load announcements if table exists to avoid exceptions before migrations run
    $announcements = null;
    if (Schema::hasTable('announcements')) {
        try {
            $announcementTitles = Report::where('report_type', 'Announcement')
                ->whereNull('deleted_at')
                ->pluck('title');

            $announcements = Announcement::whereNotNull('file')
                ->whereIn('title', $announcementTitles)
                ->latest()
                ->get();
        } catch (\Exception $e) {
            $announcements = null;
        }
    }

    return view('home', compact('report', 'announcements'));
});

$reportsPage = function () {
    $report = Report::where('report_type', '!=', 'Announcement')->latest()->first();
    $previousReports = Report::where('report_type', '!=', 'Announcement')->latest()->offset(1)->limit(6)->get();
    $totalCount = Report::where('report_type', '!=', 'Announcement')->count();
    $hasMoreReports = $totalCount > 7; // 1 latest + 6 previous
    $showAllMode = false;
    return view('reports', compact('report', 'previousReports', 'hasMoreReports', 'showAllMode'));
};
Route::get('/reports', $reportsPage)->name('lapor');
Route::get('/lapor', $reportsPage);

$allReportsPage = function () {
    $report = null; // Don't show latest report on all reports page
    $previousReports = Report::where('report_type', '!=', 'Announcement')->latest()->paginate(4);
    $showAllMode = true;
    return view('reports', compact('report', 'previousReports', 'showAllMode'));
};
Route::get('/reports/all', $allReportsPage)->name('lapor.all');
Route::get('/lapor-all', $allReportsPage);

$reportDetailPage = function (Report $report) {
    abort_if($report->report_type === 'Announcement', 404);
    return view('report-detail', compact('report'));
};
Route::get('/reports/{report}', $reportDetailPage)->name('report.detail');
Route::get('/lapor/{report}', $reportDetailPage);

Route::get('/berita', function () {
    return view('news.index');
});

$modulePage = function () {
    $materials = \App\Models\Module::latest()->get()->map(function ($module) {
        return [
            'id' => $module->id,
            'title' => $module->title,
            'description' => $module->description ?? 'Module shared by admin.',
            'category' => ucfirst($module->module_category ?? 'materi'),
            'type' => strtoupper(pathinfo($module->file_name ?: $module->file_path, PATHINFO_EXTENSION) ?: 'FILE'),
            'file' => route('modules.view', $module->id),
            'created_at' => $module->created_at,
        ];
    });

    return view('module', compact('materials'));
};
Route::get('/module', $modulePage)->name('participants');
Route::get('/participants', $modulePage);

$moduleDownload = function (\App\Models\Module $module) {
    $storage = \Illuminate\Support\Facades\Storage::disk('public');

    abort_unless($module->file_path && $storage->exists($module->file_path), 404);

    return $storage->download(
        $module->file_path,
        $module->file_name ?: basename($module->file_path)
    );
};
Route::get('/module/{module}/view', function (\App\Models\Module $module) {
    $storage = \Illuminate\Support\Facades\Storage::disk('public');

    abort_unless($module->file_path && $storage->exists($module->file_path), 404);

    return response()->file($storage->path($module->file_path));
})->name('modules.view');
Route::get('/module/{module}/download', $moduleDownload)->name('modules.download');
Route::get('/participants/{module}/download', $moduleDownload);

Route::middleware('auth')->group(function () {
    Route::get('/wilayah/provinces', function () {
        return response()->json(
            \Laravolt\Indonesia\Models\Province::query()
                ->select(['code', 'name'])
                ->orderBy('name')
                ->get()
                ->map(fn ($province) => [
                    'code' => $province->code,
                    'name' => $province->name,
                ])
                ->values()
        );
    });

    Route::get('/wilayah/cities/{provinceCode}', function (string $provinceCode) {
        return response()->json(
            \Laravolt\Indonesia\Models\City::query()
                ->where('province_code', $provinceCode)
                ->select(['code', 'name'])
                ->orderBy('name')
                ->get()
                ->map(fn ($city) => [
                    'code' => $city->code,
                    'name' => $city->name,
                ])
                ->values()
        );
    });

    Route::get('/wilayah/districts/{cityCode}', function (string $cityCode) {
        return response()->json(
            \Laravolt\Indonesia\Models\District::query()
                ->where('city_code', $cityCode)
                ->select(['code', 'name'])
                ->orderBy('name')
                ->get()
                ->map(fn ($district) => [
                    'code' => $district->code,
                    'name' => $district->name,
                ])
                ->values()
        );
    });

    Route::get('/wilayah/villages/{districtCode}', function (string $districtCode) {
        return response()->json(
            \Laravolt\Indonesia\Models\Village::query()
                ->where('district_code', $districtCode)
                ->select(['code', 'name', 'meta'])
                ->orderBy('name')
                ->get()
                ->map(function ($village) {
                    $meta = is_array($village->meta)
                        ? $village->meta
                        : (is_string($village->meta) ? json_decode($village->meta, true) : []);

                    return [
                        'code' => $village->code,
                        'name' => $village->name,
                        'postal_code' => data_get($meta, 'pos') ?: null,
                    ];
                })
                ->values()
        );
    });

    Route::get('/profile', function () {
        return view('profile', ['user' => auth()->user()]);
    })->name('profile');

    Route::post('/profile', function (Request $request) {
        $user = auth()->user();

        if ($user->is_admin) {
            abort(403, 'Administrators do not need to complete participant details.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'school_origin' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'gender' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'jalan' => 'nullable|string|max:500',
            'dusun' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan_desa' => 'nullable|string|max:255',
            'rt' => ['nullable', 'regex:/^\d{1,3}$/'],
            'rw' => ['nullable', 'regex:/^\d{1,3}$/'],
            'kode_pos' => ['nullable', 'digits:5'],
            'address' => 'nullable|string|max:1000',
            'whatsapp_number' => 'required|string|max:20',
            'telegram_number' => 'nullable|string|max:30',
            'photo_3x4' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $addressValue = $validated['address'] ?? trim(
            ($validated['jalan'] ?? '') . ' ' .
            ($validated['dusun'] ?? '') . ' ' .
            ($validated['kecamatan'] ?? '') . ' ' .
            ($validated['kelurahan_desa'] ?? '') . ' ' .
            'RT ' . ($validated['rt'] ?? '') . ' / RW ' . ($validated['rw'] ?? '') . ' ' .
            ($validated['kode_pos'] ?? '')
        );

        $user->fill([
            'name' => $validated['full_name'],
            'full_name' => $validated['full_name'],
            'place_of_birth' => $validated['place_of_birth'],
            'date_of_birth' => $validated['date_of_birth'],
            'school_origin' => $validated['school_origin'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'agama' => $validated['agama'] ?? null,
            'kewarganegaraan' => $validated['kewarganegaraan'] ?? null,
            'status_pernikahan' => $validated['status_pernikahan'] ?? null,
            'provinsi' => $validated['provinsi'] ?? null,
            'kabupaten_kota' => $validated['kabupaten_kota'] ?? null,
            'jalan' => $validated['jalan'] ?? null,
            'dusun' => $validated['dusun'] ?? null,
            'kecamatan' => $validated['kecamatan'] ?? null,
            'kelurahan_desa' => $validated['kelurahan_desa'] ?? null,
            'rt' => $validated['rt'] ?? null,
            'rw' => $validated['rw'] ?? null,
            'kode_pos' => $validated['kode_pos'] ?? null,
            'address' => trim($addressValue),
            'whatsapp_number' => $validated['whatsapp_number'],
            'telegram_number' => $validated['telegram_number'] ?? null,
        ]);

        if ($request->hasFile('photo_3x4')) {
            if ($user->photo_3x4 && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo_3x4)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo_3x4);
            }

            $user->photo_3x4 = $request->file('photo_3x4')->store('profile-photos', 'public');
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Participant details saved successfully.');
    })->name('profile.store');

    Route::get('/submitted-reports', function () {
        $reports = \App\Models\Report::where('submitted_by', auth()->id())
            ->orWhere('admin_id', auth()->id())
            ->latest()
            ->get();

        return view('submitted-reports', compact('reports'));
    })->name('submitted.reports');

    Route::get('/reports/{report}/edit', function (\App\Models\Report $report) {
        if ($report->submitted_by != auth()->id()) {
            abort(403);
        }

        return view('report-edit', compact('report'));
    })->name('reports.edit');

    Route::put('/reports/{report}', function (Request $request, \App\Models\Report $report) {
        if ($report->submitted_by != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'report_type' => 'required|in:Daily Report,Weekly Report',
            'nama_project' => 'required|string|max:255',
            'penjelasan_project' => 'required|string',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'removed_photos' => 'nullable|array|max:10',
            'removed_photos.*' => 'string',
        ]);

        $photoPaths = $report->photos ?? [];
        $removedPhotos = $request->input('removed_photos', []);

        if (!empty($removedPhotos)) {
            $photoPaths = array_values(array_filter($photoPaths, function ($photo) use ($removedPhotos) {
                return !in_array($photo, $removedPhotos, true);
            }));
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photoPaths[] = $file->store('reports', 'public');
            }
        }

        $report->update([
            'report_type' => $validated['report_type'],
            'title' => $validated['nama_project'],
            'description' => $validated['penjelasan_project'],
            'photos' => $photoPaths,
        ]);

        return redirect()->route('submitted.reports')->with('success', 'Report updated successfully.');
    })->name('reports.update');

    Route::delete('/reports/{report}', function (\App\Models\Report $report) {
        if ($report->submitted_by != auth()->id()) {
            abort(403);
        }

        if ($report->report_type === 'Announcement') {
            $announcement = Announcement::where('title', $report->title)
                ->where('user_id', auth()->id())
                ->latest()
                ->first();

            if ($announcement) {
                $storage = \Illuminate\Support\Facades\Storage::disk('public');

                if ($announcement->image) {
                    $storage->delete($announcement->image);
                }

                if ($announcement->file) {
                    $storage->delete($announcement->file);
                }

                $announcement->delete();
            }
        }

        $report->delete();

        return redirect()->route('submitted.reports')->with('success', 'Report deleted successfully.');
    })->name('reports.destroy');
});

use App\Http\Controllers\ReportController;

Route::middleware('auth')->group(function () {
    // submit page
    Route::get('/submit', function () {
        $isAdmin = auth()->check() && auth()->user()->is_admin;
        return view('submit', compact('isAdmin'));
    });

    // upload handler
    Route::post('/upload', [ReportController::class, 'store'])->name('upload');

    Route::post('/submit/content', function (Request $request) {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $type = $request->input('content_type', 'module');

        if ($type === 'module') {
            $request->validate([
                'module_title' => 'required|string|max:255',
                'module_description' => 'nullable|string',
                'module_category' => 'required|in:tugas,materi',
                'module_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,mp4,mov,avi,webm,mkv|max:2097152',
            ]);

            $path = $request->file('module_file')->store('modules', 'public');

            \App\Models\Module::create([
                'title' => $request->input('module_title'),
                'description' => $request->input('module_description'),
                'module_category' => $request->input('module_category'),
                'file_path' => $path,
                'file_name' => $request->file('module_file')->getClientOriginalName(),
                'uploaded_by' => auth()->id(),
            ]);

            return redirect()->route('participants')->with('success', 'Module uploaded successfully.');
        }

        $request->validate([
            'announcement_title' => 'required|string|max:255',
            'announcement_content' => 'nullable|string',
            'announcement_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'announcement_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,mp4,mov,avi,webm,mkv|max:2097152',
        ]);

        $imagePath = null;
        if ($request->hasFile('announcement_image')) {
            $imagePath = $request->file('announcement_image')->store('announcements', 'public');
        }

        $filePath = null;
        if ($request->hasFile('announcement_file')) {
            $filePath = $request->file('announcement_file')->store('announcements/files', 'public');
        }

        $announcement = \App\Models\Announcement::create([
            'title' => $request->input('announcement_title'),
            'content' => $request->input('announcement_content'),
            'image' => $imagePath,
            'file' => $filePath,
            'published_at' => now(),
            'user_id' => auth()->id(),
        ]);

        \App\Models\Report::create([
            'report_type' => 'Announcement',
            'title' => $announcement->title,
            'description' => $announcement->content ?? 'Announcement update',
            'photos' => $imagePath ? [$imagePath] : [],
            'submitted_by' => auth()->id(),
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Announcement submitted successfully.');
    })->name('admin.content.store');

    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        $moduleEditPage = function (\App\Models\Module $module) {
            return view('module-edit', compact('module'));
        };
        Route::get('/module/{module}/edit', $moduleEditPage)->name('modules.edit');
        Route::get('/participants/{module}/edit', $moduleEditPage);

        $moduleUpdate = function (Request $request, \App\Models\Module $module) {
            $request->validate([
                'module_title' => 'required|string|max:255',
                'module_description' => 'nullable|string',
                'module_category' => 'required|in:tugas,materi',
                'module_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,mp4,mov,avi,webm,mkv|max:2097152',
            ]);

            $module->title = $request->input('module_title');
            $module->description = $request->input('module_description');
            $module->module_category = $request->input('module_category');

            if ($request->boolean('remove_module_file') && $module->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($module->file_path);
                $module->file_path = null;
                $module->file_name = null;
            }

            if ($request->hasFile('module_file')) {
                if ($module->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($module->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($module->file_path);
                }

                $module->file_path = $request->file('module_file')->store('modules', 'public');
                $module->file_name = $request->file('module_file')->getClientOriginalName();
            }

            $module->save();

            return redirect()->route('participants')->with('success', 'Module updated successfully.');
        };
        Route::put('/module/{module}', $moduleUpdate)->name('modules.update');
        Route::put('/participants/{module}', $moduleUpdate);

        Route::get('/announcements/{report}/edit', function (\App\Models\Report $report) {
            abort_unless($report->report_type === 'Announcement' && $report->admin_id === auth()->id(), 403);

            $announcement = Announcement::where('title', $report->title)
                ->where('user_id', auth()->id())
                ->latest()
                ->firstOrFail();

            return view('announcement-edit', compact('report', 'announcement'));
        })->name('announcements.edit');

        Route::put('/announcements/{report}', function (Request $request, \App\Models\Report $report) {
            abort_unless($report->report_type === 'Announcement' && $report->admin_id === auth()->id(), 403);

            $announcement = Announcement::where('title', $report->title)
                ->where('user_id', auth()->id())
                ->latest()
                ->firstOrFail();

            $validated = $request->validate([
                'announcement_title' => 'required|string|max:255',
                'announcement_content' => 'nullable|string',
                'announcement_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'announcement_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,mp4,mov,avi,webm,mkv|max:2097152',
            ]);

            if ($request->boolean('remove_announcement_image') && $announcement->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->image);
                $announcement->image = null;
            }

            if ($request->boolean('remove_announcement_file') && $announcement->file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->file);
                $announcement->file = null;
            }

            if ($request->hasFile('announcement_image')) {
                if ($announcement->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->image);
                }
                $announcement->image = $request->file('announcement_image')->store('announcements', 'public');
            }

            if ($request->hasFile('announcement_file')) {
                if ($announcement->file) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->file);
                }
                $announcement->file = $request->file('announcement_file')->store('announcements/files', 'public');
            }

            $announcement->title = $validated['announcement_title'];
            $announcement->content = $validated['announcement_content'];
            $announcement->save();

            $report->update([
                'title' => $announcement->title,
                'description' => $announcement->content ?? 'Announcement update',
                'photos' => $announcement->image ? [$announcement->image] : [],
            ]);

            return redirect()->route('submitted.reports')->with('success', 'Announcement updated successfully.');
        })->name('announcements.update');

        $moduleDelete = function (\App\Models\Module $module) {
            if ($module->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($module->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($module->file_path);
            }

            $module->delete();

            return redirect()->route('participants')->with('success', 'Module deleted successfully.');
        };
        Route::delete('/module/{module}', $moduleDelete)->name('modules.destroy');
        Route::delete('/participants/{module}', $moduleDelete);
    });

    // announcement handler
    Route::post('/announcement', function (Request $request) {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
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

        $announcement = \App\Models\Announcement::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'file' => $filePath,
            'published_at' => now(),
            'user_id' => auth()->id(),
        ]);

        \App\Models\Report::create([
            'report_type' => 'Announcement',
            'title' => $announcement->title,
            'description' => $announcement->content ?? 'Announcement update',
            'photos' => $imagePath ? [$imagePath] : [],
            'submitted_by' => auth()->id(),
            'admin_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Announcement submitted successfully.');
    })->name('announcement.store');
});

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;

Route::get('/admin/announcements/create', [AnnouncementController::class, 'create'])->middleware('auth');
Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->middleware('auth');

Route::get('/announcement/media/{id}', function ($id) {
    $announcement = \App\Models\Announcement::findOrFail($id);
    $mediaPath = $announcement->image ?: $announcement->file;
    abort_unless($mediaPath, 404);

    $storage = \Illuminate\Support\Facades\Storage::disk('public');
    abort_unless($storage->exists($mediaPath), 404);

    return response()->file($storage->path($mediaPath));
})->name('announcement.media');

// View announcement file or image
Route::get('/announcement/download/{id}', function ($id) {
    $announcement = \App\Models\Announcement::findOrFail($id);

    $mediaPath = $announcement->file ?: $announcement->image;
    abort_unless($mediaPath, 404);

    $storage = \Illuminate\Support\Facades\Storage::disk('public');
    abort_unless($storage->exists($mediaPath), 404);

    $filePath = $storage->path($mediaPath);
    
    $fileExt = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'txt' => 'text/plain',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    
    $mimeType = $mimeTypes[$fileExt] ?? 'application/octet-stream';
    
    // Return file inline instead of download
    return response()->file($filePath, ['Content-Type' => $mimeType]);
})->name('announcement.download');

// Authentication routes (simple login/logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// One-time browser setup for the first superadmin account.
Route::get('/setup', [App\Http\Controllers\AdminUserController::class, 'setup'])->name('setup');
Route::post('/setup', [App\Http\Controllers\AdminUserController::class, 'storeSetup'])->name('setup.store');

// Admin report management (requires auth + is_admin)
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/participants', [App\Http\Controllers\AdminParticipantController::class, 'index'])->name('admin.participants.index');
    Route::get('/participants/{participant}', [App\Http\Controllers\AdminParticipantController::class, 'show'])->name('admin.participants.show');
    Route::get('/reports', [App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/{report}', [App\Http\Controllers\AdminReportController::class, 'show'])->name('admin.reports.show');
    Route::delete('/reports/{report}', [App\Http\Controllers\AdminReportController::class, 'destroy'])->name('admin.reports.destroy');
});

Route::middleware(['auth', \App\Http\Middleware\IsSuperAdmin::class])->prefix('admin')->group(function () {
    Route::get('/users/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.users.store');
});
