    <x-app-layout>
        @section('title', 'Training View')
        <section class="w-full flex justify-center my-10 px-4 sm:px-6">
            <section id="training-listings" class="w-full lg:w-[60%] mx-4 sm:mx-6 flex flex-col items-center gap-4">
                <section class="w-full relative bg-white transition rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
                    <!-- Job Header -->

                    <section class="flex flex-col sm:flex-row w-full flex-shrink-0 p-4 sm:p-6 border-b">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0 mb-4 sm:mb-0">
                            <img src="{{ asset('storage') . '/' . $training->company->logo }}"
                                 class="w-12 h-12 sm:w-14 sm:h-14 object-cover rounded-full border border-gray-300 p-1"
                                 alt="{{ $training->company->name }} logo">
                        </div>
                        @php
                            $isRtl = app()->getLocale() === 'ar';
                        @endphp

                        <div class="absolute top-2 {{ $isRtl ? 'left-2 sm:left-4' : 'right-2 sm:right-4' }} z-10">
                            <button class="bookmark-btn cursor-pointer flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white shadow-sm border border-gray-200
        {{ auth()->check() ? '' : 'guest-bookmark' }}"
                                    data-id="{{ $training->id }}"
                                    data-type="{{ auth()->check() ? auth()->user()->getBookmarkType($training) : '' }}"
                                    data-bookmarked="{{ auth()->check() && auth()->user()->hasBookmarked($training) ? 'true' : 'false' }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="{{ auth()->check() && auth()->user()->hasBookmarked($training) ? 'currentColor' : 'none' }}"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="w-5 h-5 sm:w-6 sm:h-6 text-blue-900 hover:text-blue-700 transition-colors bookmark-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Training Details -->
                        <section class="flex flex-col justify-between w-full ms-0 sm:ms-6">
                            <!-- Training Title -->
                            <h1 class="font-semibold text-lg mb-2">{{ $training->title }}</h1>

                            <!-- Meta Information -->
                            <section class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center text-gray-500 text-xs sm:text-sm gap-1 sm:gap-2 mb-3">
                                <!-- Company -->
                                <span class="font-semibold flex items-center gap-1">
                <a target="_blank" href="{{ route('trainings.index', ['company' => $training->company->id]) }}"
                   class="font-semibold flex items-center gap-1 hover:underline hover:text-primary">
                    <x-icon name="heroicon-o-building-office" class="w-4 h-4 flex-shrink-0"/>
                    <span class="truncate max-w-[120px] sm:max-w-none">{{ $training->company->name }}</span>
                </a>
            </span>


                                <span class="hidden sm:inline text-gray-500">·</span>

                                <!-- Location -->
                                <div class="flex items-center gap-1 flex-wrap">
                                    <x-icon name="heroicon-o-map-pin" class="w-4 h-4 flex-shrink-0"/>
                                    @foreach((array) $training->location as $city)
                                        <a target="_blank" href="{{ route('jobs.index', ['location' => $city]) }}"
                                           class="text-sm font-bold text-black hover:text-primary hover:underline">
                                            {{ $city }}
                                        </a>
                                        @if (!$loop->last)
                                            <span class="text-gray-400">/</span>
                                        @endif
                                    @endforeach
                                </div>

                                <span class="hidden sm:inline text-gray-500">·</span>

                                <!-- Published Date -->
                                <div class="text-green-600 font-bold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <span>{{__('Published')}}: {{ $training->created_at->format('j M Y')}}</span>
                                </div>

                                <span class="hidden sm:inline text-gray-500">·</span>

                                <!-- Deadline -->
                                <div class="text-red-600 font-bold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <span>{{__('Closes')}}: {{ $training->deadline->format('j M Y')}}</span>
                                </div>
                            </section>

                            <!-- Categories -->
                            <section class="flex gap-2 mb-4 flex-wrap">
                                @foreach($training->categories as $category)
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
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('jobs.view', ['slug' => $training->slug])) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                            </a>

                            <!-- Twitter -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('jobs.view', ['slug' => $training->slug])) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.view', ['slug' => $training->slug])) }}"
                               target="_blank"
                               class="text-gray-400 hover:text-blue-700 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </a>
                            </div>
                        </section>
                    </section>
                    <section class="text-white w-full text-xs mt-3">
                        <h1 class="p-2 text-xl w-full flex bg-gray-300">{{__('Training Description')}}</h1>
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
                     class="w-[80%] max-w-sm fixed top-0 right-0 h-full overflow-y-auto bg-white transform translate-x-full transition-transform duration-300 z-40 p-6 rounded-l-xl space-y-4 lg:relative lg:translate-x-0 lg:block hidden">

            @if(now()->lte($training->deadline))
                    <section class="bg-white w-full shadow-sm border border-gray-200 rounded-lg p-4">
                        <a type="submit" href="{{$training->link}}" class="bg-secondary text-center cursor-pointer text-white block px-4 py-2 rounded-lg w-full">{{__('Apply Now')}}</a>
                    </section>
                @endif
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
                </section>
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
                            <a href="{{ route('jobs.index') }}" class="text-sm text-blue-600 hover:underline block text-right font-medium">{{__('View all jobs')}}</a>

                    @else
                        <h1>{{__('No Similar Jobs')}}</h1>
                    @endif
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

            $(document).on('click', '.bookmark-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const button = $(this);
                const itemId = button.data('id');
                const itemType = button.data('type'); // Get the type from data attribute
                const isBookmarked = button.data('bookmarked') === 'true';
                const icon = button.find('.bookmark-icon');

                @if(!auth()->check())
                    window.location.href = '{{ route('login') }}';
                return;
                @endif

                icon.addClass('opacity-50');
                $.ajax({
                    url: '{{ route("bookmarks.toggle") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        item_id: itemId,
                        item_type: itemType,
                        action: isBookmarked ? 'remove' : 'add'
                    },
                    success: function(response) {
                        const newState = !isBookmarked;
                        button.data('bookmarked', newState ? 'true' : 'false');
                        icon.attr('fill', newState ? 'currentColor' : 'none');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('An error occurred. Please try again.');
                    },
                    complete: function() {
                        icon.removeClass('opacity-50');
                    }
                });
            });

        </script>



    </x-app-layout>
