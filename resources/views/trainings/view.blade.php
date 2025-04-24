<x-app-layout>
    <section class="w-full flex justify-center my-10 px-4 sm:px-6">
        <section id="training-listings" class="w-full lg:w-[60%] mx-4 sm:mx-6 flex flex-col items-center gap-4">
            <section class="w-full bg-white transition rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
                <!-- Job Header -->
                <section class="flex w-full flex-shrink-0 p-6 border-b">
                    <img src="{{ asset('storage') . '/' . $training->company->logo }}" class="w-14 object-cover h-14 rounded-full border border-gray-300 p-1" alt="">
                    <section class="flex ms-6 flex-col justify-between w-full">
                        <h1 class="font-semibold text-lg">{{ $training->title }}</h1>
                        <section class="flex flex-wrap items-center text-gray-500 text-xs sm:text-sm gap-2 mt-1">
                            <span class="font-semibold flex items-center gap-1 break-words">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                </svg>
                                {{ $training->company->name }}
                            </span>
                            <span class="text-gray-500">·</span>
                            <p class="flex items-center gap-1 break-words">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 1 1.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                @foreach($training->location as $index => $location)
                                    {{ $location }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                            <span class="text-gray-500">·</span>
                            <p class="text-green-600 font-bold flex items-center gap-1 break-words">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{__('Published')}}: {{ $training->created_at->format('j M Y')}}</span>
                            </p>
                            <span class="text-gray-500">·</span>
                            <p class="text-red-600 flex font-bold items-center gap-1 break-words">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{__('Deadline')}}: {{ $training->deadline->format('j M Y')}}</span>
                            </p>
                        </section>
                        <section class="flex gap-2 mt-3 mb-6 flex-wrap">
                            @foreach($training->categories as $category)
                                <a href="{{ route('jobs.index', ['category' => $category->id]) }}">
            <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs break-words whitespace-normal">
                {{ $category->name }}
            </span>
                                </a>
                            @endforeach
                        </section>

                    </section>
                </section>

                <section class="text-white w-full text-xs mt-3">
                    <h1 class="p-2 text-xl w-full flex bg-gray-300">{{__('Job Description')}}</h1>
                    <section class="text-black text-sm p-6 leading-7">
                        {!! str($training->details)->sanitizeHtml() !!}
                    </section>
                </section>

                @if(now()->lte($training->deadline))
                    <section class="text-white w-full text-xs mt-3">
                        <h1 class="p-2 text-xl w-full flex bg-gray-300">{{__('How to Apply')}}</h1>
                        <section class="text-black text-sm p-6 leading-7">
                            <div class="break-words">
                                {!! $training->how_to_apply !!}
                            </div>
                        </section>
                    </section>
                @endif

            </section>
        </section>

        <!-- Filter Toggle Section for mobile view -->
        <section id="sidebar-section"
                 class="w-[80%] max-w-sm fixed top-0 right-0 h-full bg-white transform translate-x-full transition-transform duration-300 z-40 p-6 rounded-l-xl space-y-4 lg:relative lg:translate-x-0 lg:block hidden">
            @if(now()->lte($training->deadline))
                <section class="bg-white w-full shadow-sm border border-gray-200 rounded-lg p-4">
                    <a type="submit" href="{{$training->link}}" class="bg-secondary text-center cursor-pointer text-white block px-4 py-2 rounded-lg w-full">{{__('Apply Now')}}</a>
                </section>
            @endif

            <!-- Similar Jobs -->
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">{{__('Similar Jobs')}}</h1>

                @if(count($similar_jobs)>0)
                    @foreach($similar_jobs as $similarJob)
                        <a href="{{route('jobs.view',['slug'=>$similarJob->slug])}}" class="border-[#e3e3e0] border-b flex items-center pb-3 space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{asset('storage').'/'. $similarJob->company->logo }}" alt="{{ $similarJob->company_name }} Logo" class="w-12 h-12 rounded-full object-cover"/>
                            </div>
                            <div>
                                <h1 class="text-sm text-gray-900">{{ $similarJob->title }}</h1>
                            </div>
                        </a>
                    @endforeach
                @else
                    <h1>{{__('No Similar Jobs')}}</h1>
                @endif
            </section>

            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">{{__('Similar Trainings')}}</h1>
                @foreach($similar_trainings as $training)
                    <a href="{{route('trainings.view',['slug'=>$training->slug])}}" class="border-[#e3e3e0] border-b flex items-center pb-3 space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{asset('storage').'/'. $training->company->logo }}" alt="{{ $training->company_name }} Logo" class="w-12 h-12 rounded-full object-cover"/>
                        </div>
                        <div>
                            <h1 class="text-sm text-gray-900">{{ $training->title }}</h1>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('trainings.index') }}" class="text-sm text-blue-600 hover:underline block text-right font-medium">{{__('View all trainings')}}</a>
            </section>

            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">{{__('Share this Job')}}</h1>
                <section class="flex">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('jobs.view', ['slug' => $training->slug])) }}" target="_blank" class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                            <path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z"></path><path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"></path>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('jobs.view', ['slug' => $training->slug])) }}" target="_blank" class="text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
                            <path fill="#000000" d="M 5.9199219 6 L 20.582031 27.375 L 6.2304688 44 L 9.4101562 44 L 21.986328 29.421875 L 31.986328 44 L 44 44 L 28.681641 21.669922 L 42.199219 6 L 39.029297 6 L 27.275391 19.617188 L 17.933594 6 L 5.9199219 6 z M 9.7167969 8 L 16.880859 8 L 40.203125 42 L 33.039062 42 L 9.7167969 8 z"></path>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.view', ['slug' => $training->slug])) }}" target="_blank" class="text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                            <path fill="#0288D1" d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z"></path><path fill="#FFF" d="M12 19H17V36H12zM14.485 17h-.028C12.965 17 12 15.888 12 14.499 12 13.08 12.995 12 14.514 12c1.521 0 2.458 1.08 2.486 2.499C17 15.887 16.035 17 14.485 17zM36 36h-5v-9.099c0-2.198-1.225-3.698-3.192-3.698-1.501 0-2.313 1.012-2.707 1.99C24.957 25.543 25 26.511 25 27v9h-5V19h5v2.616C25.721 20.5 26.85 19 29.738 19c3.578 0 6.261 2.25 6.261 7.274L36 36 36 36z"></path>
                        </svg>
                    </a>
                </section>
            </section>
        </section>
        <div id="sidebar-overlay" class="fixed opacity-50 inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    </section>

    <!-- Filter Toggle Button -->
    <button id="sidebar-toggle" class="lg:hidden fixed bottom-6 right-6 z-50 p-3 bg-primary-100 text-white rounded-full shadow-lg">
        <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Enhanced Filter Toggle Script -->
    <script>
        const toggleButton = document.getElementById('sidebar-toggle');
        const filterSection = document.getElementById('sidebar-section');
        const overlay = document.getElementById('sidebar-overlay');

        toggleButton.addEventListener('click', function () {
            const isHidden = filterSection.classList.contains('translate-x-full');

            filterSection.classList.toggle('translate-x-full');
            filterSection.classList.remove('hidden');
            overlay.classList.toggle('hidden');

            // Allow closing by clicking the overlay
            overlay.addEventListener('click', () => {
                filterSection.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            });
        });
    </script>



</x-app-layout>
