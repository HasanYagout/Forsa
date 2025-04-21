<x-app-layout>
    <section class="w-full flex justify-center my-10">

        <!-- Job Listings -->
        <section id="job-listings" class="w-[60%] mx-10 flex flex-col items-center gap-4">
            <section class="w-full bg-white  transition rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
                <!-- Job Header -->
                <section class="flex w-full flex-shrink-0 p-6 border-b">
                    <img src="{{ asset('storage') . '/' . $job->company->logo }}"
                         class="w-14 object-cover h-14 rounded-full border border-gray-300 p-1" alt="">
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
                            <p class="text-green-600 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>Published: {{ $job->created_at->format('M j, Y')}}</span>

                            </p>

                            <p class="text-red-600 flex font-bold items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>Deadline: {{ $job->deadline->format('M j, Y')}}</span>

                            </p>
                        </section>
                        <section class="flex gap-2 mt-3 mb-6">
                            @foreach($job->categories as $category)
                                <a href="{{route('jobs.index',['category'=>$category->id])}}">
                                <span
                                    class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </section>

                    </section>
                </section>


                <section class=" text-white  w-full  text-xs mt-3">
                    <h1 class=" p-2 text-xl w-full flex bg-gray-300">Job Description</h1>
                    <section class="text-black text-sm p-6 leading-7">
                        {!! str($job->details)->sanitizeHtml() !!}
                    </section>
                </section>
                <section class=" text-white  w-full  text-xs mt-3">
                    <h1 class=" p-2 text-xl w-full flex bg-gray-300">How to Apply</h1>
                  <section class="text-black text-sm p-6 leading-7">
                     {!! $job->how_to_apply !!}
                  </section>
                </section>
            </section>

        </section>

        <section class="w-[20%] p-6 rounded-xl h-fit hidden lg:block space-y-4">
            <!-- First Section -->
            <section class="bg-white  w-full  shadow-sm border border-gray-200 rounded-lg p-4">
                <a type="submit"
                href="{{$job->link}}"
                class="bg-secondary text-center cursor-pointer text-white block px-4 py-2 rounded-lg w-full">Apply Now</a>
            </section>

            <!-- Second Section -->
            <!--<section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4">-->
            <!--    <h1 class="text-gray-700 text-sm">Share this Job</h1>-->
            <!--</section>-->

            <!-- Third Section -->
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">Similar Jobs</h1>
                @foreach($similar_jobs as $job)
                    <a href="{{route('jobs.view',['slug'=>$job->slug])}}" class="border-[#e3e3e0] border-b flex items-center pb-3 space-x-4">
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
                            <h1 class="text-sm text-gray-900">{{ $job->title }}</h1>
                        </div>
                    </a>
                @endforeach
            </section>
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">Similar Trainings</h1>
                @foreach($similar_trainings as $training)
                    <a href="{{route('trainings.view',['slug'=>$training->slug])}}" class="border-[#e3e3e0] border-b flex items-center pb-3 space-x-4">
                        <!-- Company Logo (Circular) -->
                        <div class="flex-shrink-0">
                            <img
                                src="{{asset('storage').'/'. $training->company->logo }}"
                                alt="{{ $training->company_name }} Logo"
                                class="w-12 h-12 rounded-full object-cover"
                            />
                        </div>

                        <!-- Job Title -->
                        <div>
                            <h1 class="text-sm text-gray-900">{{ $training->title }}</h1>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('trainings.index') }}"
                   class="text-sm text-blue-600 hover:underline block text-right font-medium">
                    View all trainings
                </a>
            </section>

        </section>


    </section>
 </x-app-layout>
