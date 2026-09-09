<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function edit(User $participant)
    {
        abort_if($participant->is_admin, 404);

        return view('admin.participants.edit', compact('participant'));
    }

    public function update(Request $request, User $participant)
    {
        abort_if($participant->is_admin, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $participant->id],
            'school_origin' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'place_of_birth' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'telegram_number' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'photo_3x4' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,bmp,webp,avif', 'max:2048'],
        ]);

        $participant->fill($validated);

        if ($request->hasFile('photo_3x4')) {
            if ($participant->photo_3x4) {
                Storage::disk('public')->delete($participant->photo_3x4);
            }

            $participant->photo_3x4 = $request->file('photo_3x4')->store('profile-photos', 'public');
        }

        $participant->save();

        return redirect()
            ->route('admin.participants.show', $participant)
            ->with('success', 'Participant updated successfully.');
    }

    public function destroy(User $participant)
    {
        abort_if($participant->is_admin, 404);

        if ($participant->photo_3x4) {
            Storage::disk('public')->delete($participant->photo_3x4);
        }

        $participant->delete();

        return redirect()
            ->route('admin.participants.index')
            ->with('success', 'Participant deleted successfully.');
    }
}