@php
    $route = match(true) {
        $record instanceof App\Models\Job => route('jobs.view', ['slug' => $record->slug]),
        $record instanceof App\Models\Training => route('trainings.view', ['slug' => $record->slug]),
        $record instanceof App\Models\Tender => route('tenders.view', ['slug' => $record->slug]),
        default => '#',
    };

    $locationRoute = $title === 'trainings' ? 'trainings.index' : 'jobs.index';

    $cities = is_array($record->location) ? $record->location : (array)$record->location;
    $showMultiple = count($cities) > 3;
@endphp

<div class="w-full group">
    <!-- Header -->
    <div class="flex w-full gap-3 sm:gap-5">
        <!-- Logo -->
        <img
            src="{{ $record->company->logo ? asset('storage/' . $record->company->logo) : asset('images/default-company.png') }}"
            class="w-14 h-14 rounded-full border-gray-300 border p-1 object-cover"
            alt="{{ $record->company->name }} logo"
            loading="lazy"
        >

        <!-- Job Info -->
        <div class="flex flex-col justify-between w-full">
            <a href="{{ $route }}" target="_blank" class="block hover:underline" aria-label="View {{ $record->title }} position">
                <h2 class="font-semibold text-black text-base sm:text-lg hover:text-primary transition-colors">
                    {{ $record->title }}
                </h2>
            </a>

            <div class="flex flex-wrap items-center text-xs sm:text-sm gap-x-2 gap-y-1 mt-1 text-black">
                <!-- Company -->
                <a href="{{route($locationRoute,['company'=>$record->company->id])}}" class="font-semibold hover:underline flex items-center gap-1 whitespace-nowrap">
                    <x-icon name="heroicon-o-building-office" class="w-4 h-4 sm:w-5 sm:h-5"/>
                    {{ $record->company->name }}
                </a>

                <span class="hidden sm:inline">·</span>

                <!-- Location -->
                @if($showMultiple)
                    <span  class="text-sm flex font-bold text-black hover:text-primary hover:underline whitespace-nowrap">
                        <x-icon name="heroicon-o-map-pin" class="w-4 h-4"/>
                        {{ __('Multiple Cities') }}
                    </span>
                @else
                    <x-icon name="heroicon-o-map-pin" class="w-4 h-4"/>
                @foreach($cities as $city)
                        <a href="{{ route($locationRoute, ['location' => $city]) }}" class="text-sm font-bold text-black hover:text-primary hover:underline whitespace-nowrap">
                            {{ $city }}
                        </a>
                        @if(!$loop->last)
                            <span class="text-gray-400">/</span>
                        @endif
                    @endforeach
                @endif

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
                    <a href="{{route($locationRoute,['category'=>$category->id])}}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs transition">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Footer -->
        <div class="flex justify-between items-center mt-4">
            <time datetime="{{ $record->created_at->toIso8601String() }}" class="text-xs text-gray-500">
                {{__('Posted')}} {{ $record->created_at->diffForHumans() }}
            </time>
            <a href="{{ $route }}" target="_blank" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-xs sm:text-sm transition">
                {{__('More')}}
            </a>
        </div>
    </div>
</div>
