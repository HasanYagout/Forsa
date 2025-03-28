@extends('layouts.app')
@section('content')
    <section class="w-full flex justify-center my-10">

        <!-- Job Listings -->
        <section id="job-listings" class="w-[60%] mx-10 flex flex-col items-center gap-4">
            <section class="w-full bg-white  transition rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
                <!-- Job Header -->
                <section class="flex w-full flex-shrink-0 p-6 border-b">
                    <img src="{{ asset('storage') . '/' . $job->company->logo }}"
                         class="w-14 h-14 rounded-full bg-gray-100 p-1" alt="">
                    <section class="flex ms-6 flex-col justify-between w-full">
                        <h1 class="font-semibold text-lg">{{ $job->title }}</h1>

                        <!-- Job Details with Icons -->
                        <section class="flex items-center text-gray-500 text-sm gap-2 mt-1">
                    <span class="font-semibold flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                        {{ $job->company->name }}
                    </span>
                            <span>·</span>

                            <p class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                @foreach($job->location as $index => $location)
                                    {{ $location }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                            <span>·</span>

                            <p class="flex items-center gap-1">
                                @if($job->type == 'Full Time')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                    </svg>

                                @elseif($job->type == 'Part Time')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>

                                @elseif($job->type == 'Remote')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                                    </svg>

                                @endif
                                {{ $job->type }}
                            </p>
                            <span>·</span>
                            <p class="text-green-600 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                published: {{ $job->deadline }}
                            </p>

                            <p class="text-red-600 flex font-bold items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                Deadline: {{ $job->deadline }}
                            </p>
                        </section>
                        <section class="flex gap-2 mt-3 mb-6">
                            @foreach($job->categories as $category)
                                <span
                                    class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">{{ $category->name }}</span>
                            @endforeach
                        </section>

                    </section>
                </section>


                <section class="flex p-6 flex-col w-full">
                <h1 class="w-full font-bold text-left">Job Description</h1>
                    <section class="mt-3 text-gray-700 text-sm leading-relaxed prose">
                        {!! str($job->details)->sanitizeHtml() !!}
                    </section>
                </section>
                <section class=" text-white  w-full  text-xs mt-3">
                    <h1 class=" p-2 text-xl w-full flex bg-gray-300">How to Apply</h1>
                  <section class="text-black text-sm p-6 leading-7">
                      <p >To apply click on the link below:</p>
                      <a class="underline" href="{{$job->link}}">{{$job->link}}</a>
                  </section>
                </section>
            </section>
            <section class="w-full bg-white">
                <h1 class=" p-2 text-xl text-white w-full rounded-t-xl flex bg-gray-300">Report a bug</h1>

                <form action="{{route('jobs.bug',['slug'=>$job->slug])}}" method="POST" class="grid grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow-md">
                   @csrf
                    <div class="space-y-2">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            class="bg-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border border-gray-300"
                            placeholder="John"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            class="bg-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border border-gray-300"
                            placeholder="Doe"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="mobile" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input
                            type="number"
                            id="mobile"
                            name="mobile"
                            class="bg-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border border-gray-300"
                            placeholder="123-456-7890"
                        />
                    </div>

                    <!-- Second Row: Textarea (Spans All Columns) -->
                    <div class="col-span-3 space-y-2">
                        <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                        <textarea
                            id="message"
                            name="message"
                            class="bg-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border border-gray-300"
                            placeholder="Enter your message here..."
                            rows="4"
                        ></textarea>
                    <button type="submit" class="bg-gray-300 cursor-pointer text-white px-4 py-2 rounded-lg w-full">Submit</button>
                    </div>

                </form>
            </section>
        </section>

        <section class="w-[20%] p-6 rounded-xl h-fit hidden lg:block space-y-4">
            <!-- First Section -->
            <section class="bg-white w-full shadow-sm border border-gray-200 rounded-lg p-4">
                <a type="submit" class="bg-secondary text-center cursor-pointer text-white block px-4 py-2 rounded-lg w-full">Apply Now</a>
            </section>

            <!-- Second Section -->
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4">
                <h1 class="text-gray-700 text-sm">Share this Job</h1>
            </section>

            <!-- Third Section -->
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                @foreach($similar_jobs as $job)
                    <a href="{{route('jobs.view',['slug'=>$job->slug])}}" class="flex items-center space-x-4">
                        <!-- Company Logo (Circular) -->
                        <div class="flex-shrink-0">
                            <img
                                src="{{asset('storage').'/'. $job->company->logo }}"
                            alt="{{ $job->company_name }} Logo"
                            class="w-12 h-12 rounded-full object-cover"
                            />
                        </div>

                        <!-- Job Title -->
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">{{ $job->title }}</h1>
                        </div>
                    </a>
                @endforeach
            </section>

        </section>


    </section>
@endsection
