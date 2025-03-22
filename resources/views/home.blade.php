@extends('layouts.app')
@section('content')
    <section class="bg-blue-50">
        <section class="relative flex flex-col items-center justify-center h-[30rem] text-white overflow-hidden">
            <!-- Background Image -->
            <img src="{{asset('img/squares.svg')}}" alt="Background" class="absolute inset-0 w-full h-full object-fit z-0">

            <!-- Content -->
            <div class="relative z-10 text-center">
                <h1 class="text-6xl leading-[5rem] font-bold text-black">
                    Step into Success with <br>
                    <span class="text-6xl text-secondary">Chances Platform</span>
                </h1>
                <p class="mt-3 text-black">your gateway to endless opportunities</p>

                <!-- Search Form -->
                <section>
                    <form class="flex justify-center mt-3 bg-white p-2 rounded-3xl">
                        <div class="w-60">
                            <input type="text" name="title" class="bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Job title, company or industry" />
                        </div>
                        <div class="w-60">
                            <input type="text" name="location" class="bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Location" />
                        </div>

                        <button type="submit" class="relative right-2 text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-3xl text-sm w-10 h-10 flex items-center justify-center dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <!-- Search Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </form>
                </section>
            </div>
        </section>
        <section class="bg-secondary flex justify-between text-white px-[10rem] py-10">
            <section class="flex flex-col text-center">
                <span class="text-6xl mb-2">200</span> <!-- Added margin-bottom -->
                <h1 class="text-sm">Jobs</h1>
            </section>
            <section class="flex flex-col text-center">
                <span class="text-6xl mb-2">93</span> <!-- Added margin-bottom -->
                <h1 class="text-sm">tenders</h1>
            </section>
            <section class="flex flex-col text-center">
                <span class="text-6xl mb-2">40+</span> <!-- Added margin-bottom -->
                <h1 class="text-sm">companies</h1>
            </section>
            <section class="flex flex-col text-center">
                <span class="text-6xl mb-2">500+</span> <!-- Added margin-bottom -->
                <h1 class="text-sm">applicants</h1>
            </section>
        </section>    </section>
    <div class="owl-carousel owl-theme">
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
    </div>

    <section class="bg-gray-100 py-12 px-4">
        <!-- Title Section -->
        <div class="text-center mb-6">
            <span class="text-sm uppercase font-semibold border-2 rounded rounded-lg border-blue-100 p-2 text-gray-600">Latest Jobs</span>
            <h2 class="text-4xl font-bold mt-3 text-gray-800 mt-2">Collaborating with <br><span>many companies</span></h2>
        </div>

        <!-- Job Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($jobs as $job)
                    <div class="bg-white rounded-xl shadow-md p-5 flex flex-col gap-3 border border-gray-200">
                        <!-- Job Header -->
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('storage/' . $job->company->logo) }}" class="w-10 h-10 rounded-full bg-gray-200 p-1" alt="">
                            <h3 class="text-md font-semibold text-gray-900">{{ $job->title }}</h3>
                        </div>

                        <!-- Job Description -->
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ Str::limit($job->description, 100, '...') }}
                            <a href="{{ route('jobs.view', ['slug' => $job->slug]) }}" class="text-blue-500 font-medium">more</a>
                        </p>

                        <!-- Job Meta -->
                        <div class="flex justify-between text-gray-500 text-xs">
                            <p>{{ $job->created_at->diffForHumans() }}</p>
                <a href="{{ route('jobs.view', ['slug' => $job->slug]) }}" class="block">
                            <p class="flex items-center gap-1">Details <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></p>
                </a>
                        </div>
                    </div>
            @endforeach
        </div>

        <!-- More Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('jobs.index') }}" class=" bg-gray-300 text-white px-6 py-2 rounded-lg font-semibold  transition">More</a>
        </div>
    </section>

    @push('js')
        <script>
            $(document).ready(function(){
                $('.owl-carousel').owlCarousel();
            });
        </script>
    @endpush
@endsection
