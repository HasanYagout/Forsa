@php
    $route = match(true) {
        $record instanceof App\Models\Job => route('jobs.view', ['slug' => $record->slug]),
//        $record instanceof App\Models\Tender => route('tenders.view', ['slug' => $record->slug]),
        $record instanceof App\Models\Training => route('trainings.view', ['slug' => $record->slug]),
        default => '#'
    };
@endphp
<div
    onclick="window.location='{{ $route }}'"
    class="w-full cursor-pointer group"
    role="button"
    tabindex="0"
    aria-label="View {{ $record->title }} position at {{ $record->company->name }}"
>

    <!-- Job Header -->
    <div class="flex w-full flex-shrink-0 gap-3 sm:gap-0">
        <!-- Company Logo with fallback -->
        <img
            src="{{ $record->company->logo ? asset('storage/' . $record->company->logo) : asset('images/default-company.png') }}"
            class="w-10 h-10 sm:w-14 sm:h-14 rounded-full p-1 border border-gray-200 object-cover"
            alt="{{ $record->company->name }} logo"
            loading="lazy"
        >

        <!-- Job Details -->
        <div class="flex ms-0 sm:ms-6 flex-col justify-between w-full">
            <h2 class="font-semibold text-black text-base sm:text-lg group-hover:text-primary transition-colors">
                {{ $record->title }}
            </h2>

            <!-- Job Metadata -->
            <div class="flex flex-wrap items-center text-black text-xs sm:text-sm gap-x-2 gap-y-1 mt-1">
                <!-- Company Name -->
                <span class="font-semibold flex items-center gap-1 whitespace-nowrap">
                    <x-icon name="heroicon-o-building-office" class="w-4 h-4 sm:w-5 sm:h-5" />
                    {{ $record->company->name }}
                </span>

                <span class="hidden sm:inline whitespace-nowrap">·</span>

                <!-- Location -->
                <span class="flex font-bold items-center gap-1 whitespace-nowrap">
<x-icon name="heroicon-o-map-pin" class="w-4 h-4" />
                    @if(count($record->location) > 2)
                        <span>Multiple Cities</span>
                    @else
                        {{ implode(', ', $record->location) }}
                    @endif
                </span>

                <span class="hidden sm:inline whitespace-nowrap">·</span>

                <!-- Deadline -->
                <span class="text-red-600 flex items-center gap-1 whitespace-nowrap">
                    <x-icon name="heroicon-o-clock" class="w-4 h-4 sm:w-5 sm:h-5" />

                    <span>Closes: {{ $record->deadline->format('M j, Y')}}</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Job Description -->
    <div class="mt-2 sm:mt-3">
        <p class="text-gray-700 text-xs sm:text-sm leading-relaxed line-clamp-3">
            {{ $record->description }}
        </p>

        <!-- Categories -->
        @if($title != 'tenders' && !$record instanceof App\Models\Tender)
            <div class="flex flex-wrap gap-1 sm:gap-2 mt-2 sm:mt-3">
                @foreach($record->categories as $category)
                    <span class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xxs sm:text-xs transition-colors">
                {{ $category->name }}
            </span>
                @endforeach
            </div>
        @endif


        <!-- Footer -->
        <div class="flex justify-between items-center mt-2 sm:mt-3">
            <time datetime="{{ $record->created_at->toIso8601String() }}" class="text-xs text-gray-500">
                Posted {{ $record->created_at->diffForHumans() }}
            </time>
            <a
                href="{{$route}}"
                class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-xs sm:text-sm transition-colors"
                aria-label="Apply for {{ $record->title }} position"
            >
                Apply Now
            </a>
        </div>
    </div>
</div>
