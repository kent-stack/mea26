@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Module</h1>
        @auth
            @if(auth()->user()->is_admin)
                <a href="#" class="bg-blue-600 text-white px-3 py-2 rounded">Add Module</a>
            @endif
        @endauth
    </div>

    @if($materials->isEmpty())
        <div class="bg-white rounded shadow p-8 text-center">
            <p class="text-lg font-medium text-slate-700">No modules have been submitted by the admin yet.</p>
            <p class="text-sm text-slate-500 mt-2">Modules will appear here after the admin uploads the material.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materials as $mat)
                <div class="bg-white rounded shadow p-4 flex flex-col">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ $mat['title'] }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ $mat['description'] }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 text-xs rounded bg-slate-100 text-slate-700">{{ $mat['type'] }}</span>
                        </div>
                    </div>

                    <div class="mt-4 mt-auto flex items-center justify-between">
                        <a href="{{ $mat['file'] }}" class="text-blue-600 hover:underline">View / Download</a>
                        <span class="text-xs text-slate-400">Submitted by admin</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
