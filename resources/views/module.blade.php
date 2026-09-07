@extends('layouts.app')

@section('title', 'Module')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between gap-4">
            <h1 class="text-3xl font-extrabold text-slate-800">Module</h1>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="/submit" class="rounded-full bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">+ New Module</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if($materials->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
                No modules have been submitted by the admin yet.
            </div>
        @else
            <div class="space-y-4">
                @foreach($materials as $module)
                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <p class="text-sm text-sky-600 font-semibold uppercase">{{ $module['category'] ?? 'Materi' }} · {{ $module['type'] ?? 'MODULE' }}</p>
                                <h2 class="text-xl font-bold text-slate-800">{{ $module['title'] }}</h2>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ $module['file'] }}" target="_blank" class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700 hover:bg-sky-100">Open</a>
                                <a href="{{ route('modules.download', $module['id']) }}" class="rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">Download</a>
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('modules.edit', $module['id']) }}" class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700 hover:bg-sky-100">Edit</a>
                                        <form action="{{ route('modules.destroy', $module['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this module?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <p class="mt-3 text-slate-600">{{ Str::limit($module['description'], 180) }}</p>
                        <div class="mt-4 text-sm text-slate-500">{{ $module['created_at']?->format('d M Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    @media (max-width: 767px) {
        section {
            padding-top: 5.5rem !important;
        }

        .mb-8 {
            margin-top: 0.25rem !important;
            margin-bottom: 1rem !important;
        }

        .mb-8 .flex {
            align-items: flex-start !important;
        }
    }
</style>

@endsection
