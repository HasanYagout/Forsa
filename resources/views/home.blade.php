@extends('layouts.app')
@section('content')
    <section class="bg-primary">
        <section class="flex flex-col items-center justify-center h-[20rem] text-white">
            <h1 class="text-4xl font-bold ">Step into Success with Chances Platform</h1>
            <p class="mt-3">your gateway to endless opportunities</p>
            <section>
                <form class="flex justify-center mt-3 bg-white p-2 rounded-3xl">
                    <div class="w-60">
                        <input type="text" name="title" class="bg-gray-50  text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Job title, company or industry"  />
                    </div>
                    <div class="w-60">
                        <input type="text" name="location" class="bg-gray-50   text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Location" />
                    </div>

                    <button type="submit" class=" relative right-2 text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-3xl text-sm w-10 h-10 flex items-center justify-center  dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <!-- Search Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>                </form>
            </section>
        </section>

    </section>
    <div class="owl-carousel owl-theme">
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
        <div class="text-black"> Your Content </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function(){
                $('.owl-carousel').owlCarousel();
            });
        </script>
    @endpush
@endsection
