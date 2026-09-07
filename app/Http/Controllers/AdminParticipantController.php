<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminParticipantController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $participants = User::query()
            ->where('is_admin', false)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($participantQuery) use ($search) {
                    $participantQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('school_origin', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.participants.index', compact('participants', 'search'));
    }

    public function show(User $participant)
    {
        abort_if($participant->is_admin, 404);

        return view('admin.participants.show', compact('participant'));
    }
}