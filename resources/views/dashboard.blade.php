<x-app-layout>
{{--        <x-slot name="header">--}}
{{--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--                {{ __('Dashboard') }}--}}
{{--            </h2>--}}
{{--        </x-slot>--}}

    <section class="relative flex flex-col bg-blue-50 items-center justify-center py-16 md:h-[30rem] text-white overflow-hidden px-4">
        <!-- Background Image -->
        <img
            src="{{asset('img/squares.svg')}}"
            alt="Background"
            class="absolute top-30 inset-0 w-full h-full object-cover md:object-contain object-center z-0"
        >
        <!-- Content Container -->
        <div class="relative z-10 text-center w-full max-w-7xl mx-auto">
            <!-- Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl leading-tight font-bold text-black mb-4">
                Step into Success with <br class="hidden sm:block">
                <span class="text-secondary">Chances Platform</span>
            </h1>

            <!-- Subheading -->

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
                            <option value="jobs">Search By: Jobs</option>
                            <option value="trainings">Search By: Trainings</option>
                        </select>
                        <div class="absolute  inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Search Inputs -->
                    <div class="flex flex-col justify-between sm:flex-row items-center w-full gap-3 sm:gap-4 bg-white p-1 rounded-2xl sm:rounded-3xl">
                        <input type="text" name="title"
                               class="bg-white text-gray-900 border-none focus:border-none focus-visible:border-none focus:outline-none focus-visible:outline-none text-sm rounded-lg w-full sm:w-60 p-3"
                               placeholder="البحث بواسطة كلمة مفتاحية ">
                        <input type="text" name="location" class="bg-white text-gray-900 border-none focus:border-none focus-visible:border-none focus:outline-none focus-visible:outline-none text-sm rounded-lg w-full sm:w-60 p-3" placeholder="Location">

                        <!-- Search Button -->
                        <button type="submit" class="text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full p-3 flex items-center justify-center w-12 h-12 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
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
    <section class="bg-primary-100' py-12">
        <div class="text-center mb-6">
            <span class="text-sm uppercase font-semibold border-2 rounded-sm rounded-lg border-blue-100 p-2 text-gray-600">Categories</span>
            <h2 class="text-4xl font-bold mt-3 text-gray-800 mt-2">We got you covered with <br><span>diverse opportunities</span></h2>
        </div>
        <div class="bg-secondary py-6">
            <div class="max-w-6xl mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{route('jobs.index',['category'=>$category->id])}}">
                        <div class="bg-blue-50 rounded-lg shadow-md flex justify-center items-center py-3 px-4">
                            <h3 class="text-md text-center font-semibold text-gray-900">{{ $category->name }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('jobs.index') }}" target="_blank"  class=" bg-gray-300 text-white px-6 py-2 rounded-lg font-semibold  transition">More</a>
        </div>
    </section>


    <div class="owl-carousel owl-theme my-20 px-28">
        @foreach($banners as $banner)
            <div class="item w-3/4">
                <img src="{{ asset('storage') . '/' . $banner->path }}" alt="{{ $banner->name }}" class="w-full h-auto">
            </div>
        @endforeach
    </div>
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
    <section class="bg-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Title Section -->
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-black">
               <span>We Work With</span>
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
                    navText: [
                        "<i class='fas fa-chevron-left'></i>", // Custom prev icon
                        "<i class='fas fa-chevron-right'></i>" // Custom next icon
                    ],
                    responsive: {
                        0: {
                            items: 4 // Number of items on small screens
                        },
                        600: {
                            items: 4 // Number of items on medium screens
                        },
                        1000: {
                            items: 4 // Number of items on large screens
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
