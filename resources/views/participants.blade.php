@extends('layouts.app')

@section('title', 'Participants')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-slate-800">Participants</h1>
            <p class="mt-2 text-slate-600">Total participants: {{ count($participants) }}</p>
        </div>

        @if(count($participants) === 0)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
                No participants found yet.
            </div>
        @else
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5">
                @foreach($participants as $participant)
                    <div class="mx-auto w-full max-w-[210px] overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-md shadow-slate-200/70">
                        <div class="aspect-[3/4] w-full overflow-hidden bg-slate-100">
                            <img src="{{ $participant['photo'] }}" alt="{{ $participant['name'] }}" class="h-full w-full object-cover" />
                        </div>
                        <div class="p-4 text-center">
                            <h2 class="text-base font-bold text-slate-800 line-clamp-2">{{ $participant['name'] }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ $participant['school'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
