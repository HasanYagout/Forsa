<x-app-layout>
{{--        <x-slot name="header">--}}
{{--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--                {{ __('Dashboard') }}--}}
{{--            </h2>--}}
{{--        </x-slot>--}}
    <section>

        <div class="owl-carousel owl-theme px-4 my-4 md:px-28">
            @foreach($trainings as $training)
                <a target="_blank" href="{{route('trainings.view',['slug'=>$training->slug])}}">
                    <div class="item w-full">
                        <div class="relative rounded-2xl overflow-hidden shadow-md h-80 flex flex-col justify-end text-black">
                            <!-- Blurred Background Image -->
                            <div class="absolute inset-0">
                                <img src="{{ asset('storage/' . $training->company->logo) }}"
                                     alt="Background"
                                     class="w-full h-full object-cover blur-sm scale-110" />
                                <div class="absolute inset-0 bg-black/20"></div> <!-- Optional overlay -->
                            </div>

                            <!-- White Title Box -->
                            <div class="absolute bottom-32 left-1/2 transform -translate-x-1/2 w-[95%] sm:w-[80%] md:w-[80%] lg:w-[80%] z-10 bg-white bg-opacity-90 px-6 py-6 text-center rounded-xl shadow-md">
                                <p class="text-sm sm:text-base font-medium break-words">
                                    {{ Str::limit($training->title, 40) }}
                                </p>
                            </div>






                            <!-- Bottom Info -->
                            <div class="relative z-10 bg-white p-4 flex items-center justify-between">
                                <div class="flex w-full px-3 justify-between items-center gap-3">
                                    <!-- Company Logo -->
                                    <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('storage/' . $training->company->logo) }}"
                                             alt="Company Logo"
                                             class="w-10 h-10 rounded-full  object-contain" />
                                    </div>

                                    <div class="text-sm text-gray-800 font-semibold">
                                        <div class="flex items-center gap-1">
                                            <x-icon name="heroicon-o-building-office" class="w-4 h-4 sm:w-5 sm:h-5" />
                                            {{ $training->company->name ?? 'Company' }}
                                        </div>

                                        <div class="flex items-center gap-1">
                                            <x-icon name="heroicon-o-map-pin" class="w-4 h-4" />
                                            <span class="text-gray-700 text-sm">
                                        @php
                                            $locations = is_string($training->location) ? json_decode($training->location, true) : $training->location;
                                        @endphp
                                                @if(is_array($locations))
                                                    @if(count($locations) === 1)
                                                        {{ $locations[0] }}
                                                    @elseif(count($locations) === 2)
                                                        {{ $locations[0] }}, {{ $locations[1] }}
                                                    @else
                                                        Many locations
                                                    @endif
                                                @else
                                                    {{ $training->location ?? 'Sana’a' }}
                                                @endif
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>

            @endforeach
        </div>
    </section>

    <section class="relative flex flex-col items-center justify-center py-16 md:h-[40rem] text-white overflow-hidden px-4">
        <!-- Background Image -->
        <img
            src="{{ asset('img/background.svg') }}"
            alt="Background"
            class="absolute bg-blue-50 inset-0 w-full h-full object-cover z-0"
        >

        <!-- Content Container -->
        <div class="relative z-10 text-center w-full max-w-7xl mx-auto">
            <!-- Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl leading-tight font-bold text-white mb-4">
               {{__('Step into Success with')}} <br class="hidden sm:block">
                <span class="text-white">{{__('Chances Platform')}}</span>
            </h1>

            <!-- Search Form -->
            <div class="w-full max-w-4xl mx-auto">
                <form id="searchForm" class="flex flex-col md:flex-row items-center gap-3 sm:gap-4">
                    <!-- Search Type Dropdown -->
                    <div class="md:self-auto md:w-auto w-full relative">
                        <select
                            name="search_type"
                            id="searchType"
                            class="appearance-none bg-primary-100 border-none h-full md:w-auto p-3 pr-8 rounded-lg text-sm text-white w-full"
                        >
                            <option value="jobs">{{__('Search By: Jobs')}}</option>
                            <option value="trainings">{{__('Search By: Trainings')}}</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Search Inputs -->
                    <div
                        class="flex flex-col justify-between sm:flex-row items-center w-full gap-3 sm:gap-4 bg-white p-1 rounded-2xl sm:rounded-3xl">
                        <input type="text" name="title"
                               class="bg-white text-gray-900 border-none focus:outline-none text-sm rounded-lg w-full sm:w-60 p-3"
                               placeholder="{{__('search')}}">

                        <div class="relative w-full sm:w-60">
                            <input type="text" id="location-input"
                                   class="bg-white text-gray-900 focus:outline-none text-sm rounded-lg w-full p-3"
                                   placeholder="{{__('Location')}}" autocomplete="off">

                            <ul id="location-suggestions"
                                class="absolute top-full left-0 list-none bg-white rounded-lg mt-1 max-h-60 overflow-y-auto hidden w-full z-10">
                            </ul>
                        </div>


                        <!-- Search Button -->
                        <button type="submit"
                                class="text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full p-3 flex items-center justify-center w-12 h-12 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <x-partials.home-card
        title="jobs"
        :records="$jobs"
    />


    @if($banner)

        <div class="mb-6 px-4 sm:px-6 md:px-16 lg:px-28">
            <a target="_blank" href="{{ $banner->url }}">
                <img src="{{ asset('storage') . '/' . $banner->image }}" alt="{{ $banner->name }}" class="w-full h-auto rounded-md shadow-md">
            </a>
        </div>

    @endif
    <x-partials.home-card
        title="trainings"
        :records="$trainings"
    />
{{--    <x-partials.home-card--}}
{{--        title="tenders"--}}
{{--        first_title="Be a part of making"--}}
{{--        second_title="new opportunities"--}}
{{--        :records="$tenders"--}}
{{--    />--}}

    <section class="mt-4">
        <div class="text-center">
            <span class="text-sm uppercase  font-semibold border-2 rounded-sm rounded-lg border-blue-100 p-2 text-gray-600">{{__('Categories')}}</span>
        </div>
        <section class="px-6 py-10 bg-gray-100 dark:bg-secondary-100">
            <h2 class="text-center text-2xl font-bold mb-6">Categories</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a target="_blank" href="{{ route('jobs.index', ['category' => $category->id]) }}">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition text-center flex flex-col justify-between min-h-[12rem] sm:min-h-[14rem] w-full h-full">
                            <div class="text-indigo-500 mb-3 flex justify-center">
                                @php
                                    // Ensure the icon exists and is not empty
                                    $iconPath = ltrim(str_replace('\\', '/', $category->icon), '/');
                                    $fullIconPath = public_path('storage/' . $iconPath);
                                @endphp

                                @if($category->icon && file_exists($fullIconPath))
                                    {!! file_get_contents($fullIconPath) !!}
                                @else
                                    <span class="text-red-500">[SVG not found]</span>
                                @endif
                            </div>

                            <h3 class="font-semibold text-gray-800 dark:text-white break-words text-wrap text-sm sm:text-base leading-snug whitespace-pre-line">
                                {!! nl2br(e(str_replace('/', "\n", $category->name))) !!}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-2">
                                {{ count($category->jobs) }} Posted Jobs
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

    </section>
    <section class="bg-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Title Section -->
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-black">
               <span>{{__('We Work With')}}</span>
            </h2>
        </div>

        <!-- Logos Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4 md:gap-6">
            <!-- Logo 1 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 6.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 2 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 7.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 3 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 9.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 4 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 10.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 5 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 11.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 6 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 12.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 7 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 13.png') }}"
                     alt="Company logo">
            </div>

            <!-- Logo 8 -->
            <div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                <img class=" h-auto max-h-12 md:max-h-16 grayscale hover:grayscale-0 transition duration-300"
                     src="{{ asset('img/image 14.png') }}"
                     alt="Company logo">
            </div>
        </div>
    </section>
    @push('js')
        <script>
            $(document).ready(function () {
                const $input = $('#location-input');
                const $suggestions = $('#location-suggestions');
                const allLocations = @json($availableLocations);

                $input.on('input', function () {
                    const query = $(this).val().toLowerCase();
                    $suggestions.empty();

                    if (query.length === 0) {
                        $suggestions.addClass('hidden');
                        return;
                    }
                    console.log(allLocations);
                    const filtered = allLocations.filter(location => location.toLowerCase().includes(query));

                    if (filtered.length) {
                        filtered.slice(0, 10).forEach(location => {
                            $suggestions.append(`<li class="p-2 hover:bg-gray-100 text-black cursor-pointer">${location}</li>`);
                        });
                        $suggestions.removeClass('hidden');
                    } else {
                        $suggestions.addClass('hidden');
                    }
                });

                // Handle suggestion click
                $suggestions.on('click', 'li', function () {
                    $input.val($(this).text());
                    $suggestions.addClass('hidden');
                });

                // Hide on outside click
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('#location-input, #location-suggestions').length) {
                        $suggestions.addClass('hidden');
                    }
                });
            });

            document.getElementById('searchForm').addEventListener('submit', function(e) {
                const searchType = document.getElementById('searchType').value;

                if (searchType === 'jobs') {
                    this.action = "{{ route('jobs.index') }}";
                } else if (searchType === 'trainings') {
                    this.action = "{{ route('trainings.index') }}";
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                $('.owl-carousel').owlCarousel({
                    loop: true, // Infinite loop
                    margin: 10, // Space between items
                    nav: true, // Show navigation arrows
                    rtl: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
                    navText: [
                        "<i class='fas fa-chevron-left'></i>", // Custom prev icon
                        "<i class='fas fa-chevron-right'></i>" // Custom next icon
                    ],
                    responsive: {
                        0: {
                            items: 1 // Number of items on small screens
                        },
                        600: {
                            items: 2 // Number of items on medium screens
                        },
                        1000: {
                            items: 3 // Number of items on large screens
                        }
                    }
                });
            });
        </script>

    @endpush
</x-app-layout>
