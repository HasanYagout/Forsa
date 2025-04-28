<x-app-layout>
    @section('title', 'Job View')
    <section class="w-full flex justify-center my-10 px-4 sm:px-6">
        <section id="job-listings" class="w-full lg:w-[60%] mx-4 sm:mx-6 flex flex-col items-center gap-4">
            <section class="w-full bg-white relative transition rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
                <!-- Job Header -->
                <section class="flex flex-col sm:flex-row w-full flex-shrink-0 p-4 sm:p-6 border-b">
                    <!-- Company Logo -->
                    <div class="flex-shrink-0 mb-4 sm:mb-0">
                        <img src="{{ asset('storage') . '/' . $job->company->logo }}"
                             class="w-12 h-12 sm:w-14 sm:h-14 object-cover rounded-full border border-gray-300 p-1"
                             alt="{{ $job->company->name }} logo">
                    </div>
                    @php
                        $isRtl = app()->getLocale() === 'ar';
                    @endphp

                    <div class="absolute top-2 {{ $isRtl ? 'left-2 sm:left-4' : 'right-2 sm:right-4' }} z-10">
                        <button class="bookmark-btn cursor-pointer flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white shadow-sm border border-gray-200
                                     {{ auth()->check() ? '' : 'guest-bookmark' }}"
                                data-id="{{ $job->id }}"
                                data-type="{{ auth()->check() ? auth()->user()->getBookmarkType($job) : '' }}"
                                data-bookmarked="{{ auth()->check() && auth()->user()->hasBookmarked($job) ? 'true' : 'false' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="{{ auth()->check() && auth()->user()->hasBookmarked($job) ? 'currentColor' : 'none' }}"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-5 h-5 sm:w-6 sm:h-6 text-blue-900 hover:text-blue-700 transition-colors bookmark-icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Job Details -->
                    <section class="flex flex-col justify-between w-full ms-0 sm:ms-6">
                        <!-- Job Title -->
                        <h1 class="font-semibold text-lg mb-2">{{ $job->title }}</h1>

                        <!-- Meta Information -->
                        <section class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center text-gray-500 text-xs sm:text-sm gap-1 sm:gap-2 mb-3">
                            <!-- Company -->
                            <span class="font-semibold flex items-center gap-1">
                <a target="_blank" href="{{ route('jobs.index', ['company' => $job->company->id]) }}"
                   class="font-semibold flex items-center gap-1 hover:underline hover:text-primary">
                    <x-icon name="heroicon-o-building-office" class="w-4 h-4 flex-shrink-0"/>
                    <span class="truncate max-w-[120px] sm:max-w-none">{{ $job->company->name }}</span>
                </a>
            </span>

                            <span class="hidden sm:inline text-gray-500">·</span>

                            <!-- Location -->
                            @php
                                $cities = is_array($job->location) ? $job->location : (array)$job->location;
                                $showMultiple = count($cities) > 3;
                            @endphp

                            @if($showMultiple)
                                <span class="text-sm font-bold text-black hover:text-primary hover:underline whitespace-nowrap">
        {{ __('Multiple Cities') }}
    </span>
                            @else
                                @foreach($cities as $city)
                                    <a href="{{ route('jobs.index', ['location' => $city]) }}" class="text-sm font-bold text-black hover:text-primary hover:underline whitespace-nowrap">
                                        {{ __($city) }}
                                    </a>
                                    @if(!$loop->last)
                                        <span class="text-gray-400">/</span>
                                    @endif
                                @endforeach
                            @endif

                            <span class="hidden sm:inline text-gray-500">·</span>

                            <!-- Published Date -->
                            <div class="text-green-600 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{__('Published')}}: {{ $job->created_at->format('j M Y')}}</span>
                            </div>

                            <span class="hidden sm:inline text-gray-500">·</span>

                            <!-- Deadline -->
                            <div class="text-red-600 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{__('Closes')}}: {{ $job->deadline->format('j M Y')}}</span>
                            </div>
                        </section>

                        <!-- Categories -->
                        <section class="flex gap-2 mb-4 flex-wrap">
                            @foreach($job->categories as $category)
                                <a href="{{ route('jobs.index', ['category' => $category->id]) }}">
                    <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-xs">
                        {{ $category->name }}
                    </span>
                                </a>
                            @endforeach
                        </section>
                    </section>

                    <!-- Social Media Icons -->
                    <section class="flex gap-2 sm:gap-3 mt-3 sm:mt-0 {{ app()->getLocale() === 'ar' ? 'justify-start' : 'justify-end' }} w-full sm:w-auto">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('jobs.view', ['slug' => $job->slug])) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                            </a>

                            <!-- Twitter -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('jobs.view', ['slug' => $job->slug])) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                <svg  xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" fill="currentColor" viewBox="0 0 50 50">
                                    <path  d="M 5.9199219 6 L 20.582031 27.375 L 6.2304688 44 L 9.4101562 44 L 21.986328 29.421875 L 31.986328 44 L 44 44 L 28.681641 21.669922 L 42.199219 6 L 39.029297 6 L 27.275391 19.617188 L 17.933594 6 L 5.9199219 6 z M 9.7167969 8 L 16.880859 8 L 40.203125 42 L 33.039062 42 L 9.7167969 8 z"></path>
                                </svg>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.view', ['slug' => $job->slug])) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-blue-700 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </a>
                        </div>
                    </section>
                </section>
                <section>
                    @if($job->updated_link == 1)
                        <div class="p-4 bg-blue-100 text-blue-800 rounded-md text-sm">
                            {{ __('The job link has been updated.') }}
                        </div>
                    @endif
                </section>

                <!-- Rest of your job view content remains exactly the same -->
                <section class="text-white w-full text-xs mt-3">
                    <h1 class="p-2 text-xl w-full flex bg-gray-300">{{__('Job Description')}}</h1>
                    <section class="text-black text-sm p-6 leading-7">
                        {!! str($job->details)->sanitizeHtml() !!}
                    </section>
                </section>

                @if(now()->lte($job->deadline))
                    <section class="text-white w-full text-xs mt-3">
                        <h1 class="p-2 text-xl w-full flex bg-gray-300">{{__('How to Apply')}}</h1>
                        <section class="text-black text-sm p-6 leading-7">
                            <div class="break-words">
                                {!! $job->how_to_apply !!}
                            </div>
                        </section>
                    </section>
                @endif

            </section>
        </section>

        <!-- Filter Toggle Section for mobile view -->
        <section id="sidebar-section"
                 class="w-[80%] max-w-sm fixed top-0 right-0 h-full overflow-y-auto bg-white transform translate-x-full transition-transform duration-300 z-40 p-6 rounded-l-xl space-y-4 lg:relative lg:translate-x-0 lg:block hidden">
            @if(now()->lte($job->deadline))
                <section class="bg-white w-full shadow-sm border border-gray-200 rounded-lg p-4">
                    <a type="submit" target="_blank" href="{{$job->link}}"
                       class="bg-secondary text-center cursor-pointer text-white block px-4 py-2 rounded-lg w-full">{{__('Apply Now')}}</a>
                </section>
            @endif

            <!-- Similar Jobs -->
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">{{__('Similar Jobs')}}</h1>

                @if(count($similar_jobs)>0)
                    @foreach($similar_jobs as $similarJob)
                        <a href="{{route('jobs.view',['slug'=>$similarJob->slug])}}"
                           class="border-[#e3e3e0] border-b flex items-center pb-3 space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{asset('storage').'/'. $similarJob->company->logo }}"
                                     alt="{{ $similarJob->company_name }} Logo"
                                     class="w-12 h-12 border-gray-300 border rounded-full object-cover"/>
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
                @if(count($similar_trainings)>0)
                    @foreach($similar_trainings as $training)
                        <a href="{{route('trainings.view',['slug'=>$training->slug])}}"
                           class="border-[#e3e3e0] border-b flex items-center pb-3 space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{asset('storage').'/'. $training->company->logo }}"
                                     alt="{{ $training->company_name }} Logo" class="w-12 h-12 rounded-full object-cover"/>
                            </div>
                            <div>
                                <h1 class="text-sm text-gray-900">{{ $training->title }}</h1>
                            </div>
                        </a>
                    @endforeach
                @else
                    <h1>{{__('No Similar Trainings')}}</h1>
                @endif
                <a href="{{ route('trainings.index') }}"
                   class="text-sm text-blue-600 hover:underline block text-right font-medium">{{__('View all trainings')}}</a>
            </section>

        </section>
        <div id="sidebar-overlay" class="fixed opacity-50 inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    </section>

    <!-- Filter Toggle Button -->
    <button id="sidebar-toggle"
            class="lg:hidden fixed bottom-6 right-6 z-50 p-3 bg-primary-100 text-white rounded-full shadow-lg">
        <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
