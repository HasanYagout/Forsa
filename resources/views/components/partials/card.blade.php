@php
    $route = match(true) {
        $record instanceof App\Models\Job => route('jobs.view', ['slug' => $record->slug]),
        $record instanceof App\Models\Training => route('trainings.view', ['slug' => $record->slug]),
        $record instanceof App\Models\Tender => route('tenders.view', ['slug' => $record->slug]),
        default => '#',
    };

    $baseRoute = $title === 'trainings' ? 'trainings.index' : 'jobs.index';
@endphp
<a href="{{ $route }}" target="_blank" class="w-full group" role="button" tabindex="0" aria-label="View {{ $record->title }} position at {{ $record->company->name }}">

    <!-- Header -->
    <div class="flex w-full gap-3 sm:gap-5">
        <!-- Logo -->
        <img
            src="{{ $record->company->logo ? asset('storage/' . $record->company->logo) : asset('images/default-company.png') }}"
            class="w-14 h-14 rounded-full border p-1 object-cover"
            alt="{{ $record->company->name }} logo"
            loading="lazy"
        >

        <!-- Job Info -->
        <div class="flex flex-col justify-between w-full">
            <h2 class="font-semibold text-black text-base sm:text-lg group-hover:text-primary transition-colors">
                {{ $record->title }}
            </h2>

            <div class="flex flex-wrap items-center text-xs sm:text-sm gap-x-2 gap-y-1 mt-1 text-black">
                <!-- Company -->
                <span class="font-semibold flex items-center gap-1 whitespace-nowrap hover:text-primary">
                    <x-icon name="heroicon-o-building-office" class="w-4 h-4 sm:w-5 sm:h-5"/>
                    {{ $record->company->name }}
                </span>

                <span class="hidden sm:inline">·</span>

                <!-- Location -->
                <div class="flex items-center gap-1 flex-wrap">
                    <x-icon name="heroicon-o-map-pin" class="w-4 h-4"/>
                    @foreach((array) $record->location as $city)
                        <span class="text-sm font-bold text-black hover:text-primary hover:underline whitespace-nowrap">
                            {{ $city }}
                        </span>
                        @if (!$loop->last)
                            <span class="text-gray-400">/</span>
                        @endif
                    @endforeach
                </div>

                <span class="hidden sm:inline">·</span>

                <!-- Deadline -->
                <span class="text-red-600 flex items-center gap-1 whitespace-nowrap">
                    <x-icon name="heroicon-o-clock" class="w-4 h-4 sm:w-5 sm:h-5"/>
                    {{$title=='trainings'?__('Closes'):__('Deadline')}}
                    <span class="ml-1">{{ $record->deadline->format('j M Y') }}</span>
                </span>

            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="mt-3">
        <p class="text-gray-700 text-xs sm:text-sm leading-relaxed line-clamp-3">
            {{ $record->description }}
        </p>

        <!-- Categories -->
        @if($title !== 'tenders' && !$record instanceof App\Models\Tender)
            <div class="flex flex-wrap gap-2 mt-3">
                @foreach($record->categories as $category)
                    <span class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs transition">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Footer -->
        <div class="flex justify-between items-center mt-4">
            <time datetime="{{ $record->created_at->toIso8601String() }}" class="text-xs text-gray-500">
                {{__('Posted')}} {{ $record->created_at->diffForHumans() }}
            </time>
            <span class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-xs sm:text-sm transition">
                {{__('More')}}
            </span>
        </div>
    </div>
</a>

