@extends('layouts.app')

@section('title', 'Participant Profile')

@section('content')
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <style>
            @media (max-width: 640px) {
                section {
                    padding-top: 5.75rem !important;
                }
            }
        </style>
        <div class="mb-6">
            <a href="{{ route('admin.participants.index') }}" class="font-semibold text-sky-700 hover:text-sky-900">&larr; Back to participants</a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-5 border-b border-slate-200 p-6 sm:flex-row sm:items-center">
                <div class="h-32 w-24 shrink-0 overflow-hidden rounded-xl bg-slate-100">
                    @if($participant->photo_3x4)
                        <img src="{{ route('users.photo', $participant) }}" alt="{{ $participant->full_name ?: $participant->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full items-center justify-center text-4xl font-bold text-sky-700">{{ strtoupper(substr($participant->full_name ?: $participant->name ?: 'P', 0, 1)) }}</div>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Participant Profile</p>
                    <h1 class="mt-1 text-3xl font-extrabold text-slate-800">{{ $participant->full_name ?: $participant->name }}</h1>
                    <p class="mt-1 text-slate-600">{{ $participant->email }}</p>
                </div>
            </div>

            <div class="grid gap-x-8 gap-y-5 p-6 sm:grid-cols-2">
                @foreach([
                    'School origin' => $participant->school_origin,
                    'Gender' => $participant->gender,
                    'Place of birth' => $participant->place_of_birth,
                    'Date of birth' => optional($participant->date_of_birth)->format('d M Y'),
                    'WhatsApp number' => $participant->whatsapp_number,
                    'Telegram number' => $participant->telegram_number,
                    'Province' => $participant->provinsi,
                    'City / Regency' => $participant->kabupaten_kota,
                    'District' => $participant->kecamatan,
                    'Sub-District' => $participant->kelurahan_desa,
                    'Postal code' => $participant->kode_pos,
                    'Complete address' => $participant->address,
                ] as $label => $value)
                    <div class="border-b border-slate-100 pb-3 {{ $label === 'Complete address' ? 'sm:col-span-2' : '' }}">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</dt>
                        <dd class="mt-1 whitespace-pre-line text-slate-800">{{ $value ?: 'Not provided' }}</dd>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection