@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'rounded-md bg-red-50 p-4']) }}>
        <div class="text-sm font-medium text-red-800">Please fix the following errors:</div>
        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
