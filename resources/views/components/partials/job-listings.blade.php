@foreach($jobs as $job)
    <section class="w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">
        <!-- Bookmark Button -->
        <div class="absolute top-3 right-3 sm:top-4 sm:right-4 z-10">
            <button class="bookmark-btn cursor-pointer"
                    data-id="{{ $job->id }}"
                    data-type="{{ $job instanceof App\Models\Job ? 'job' : 'tender' }}"
                    data-bookmarked="{{ auth()->check() && auth()->user()->hasBookmarkedJob($job) ? 'true' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="{{ auth()->check() && auth()->user()->hasBookmarkedJob($job) ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="w-5 h-5 sm:w-6 sm:h-6 text-blue-900 hover:text-blue-700 transition-colors bookmark-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                </svg>
            </button>
        </div>

        <!-- Clickable Area -->
        <div onclick="window.location='{{ route('jobs.view', ['slug' => $job->slug]) }}'"
             class="w-full cursor-pointer">

            <!-- Job Header -->
            <section class="flex w-full flex-shrink-0 gap-3 sm:gap-0">
                <!-- Company Logo -->
                <img src="{{ asset('storage') . '/' . $job->company->logo }}"
                     class="w-10 h-10 sm:w-14 sm:h-14 rounded-full p-1" alt="">

                <!-- Job Details -->
                <section class="flex ms-0 sm:ms-6 flex-col justify-between w-full">
                    <h1 class="font-semibold text-black text-base sm:text-lg">{{ $job->title }}</h1>

                    <!-- Job Details with Icons - Responsive Layout -->
                    <section class="flex flex-wrap items-center text-black text-xs sm:text-sm gap-x-2 gap-y-1 mt-1">
                        <!-- Company Name -->
                        <span class="font-semibold flex items-center gap-1 whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
        </svg>
        {{ $job->company->name }}
    </span>

                        <!-- Separator Dot (hidden on mobile) -->
                        <span class="hidden sm:inline whitespace-nowrap">·</span>

                        <!-- Location -->
                        <p class="flex font-bold items-center gap-1 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                            </svg>
                            @if(count($job->location) > 2)
                                <span class="text-xs sm:text-sm">Multiple Cities</span>
                            @else
                                @foreach($job->location as $index => $location)
                                    <span class="text-xs sm:text-sm">{{ $location }}@if(!$loop->last), @endif</span>
                                @endforeach
                            @endif
                        </p>

                        <!-- Separator Dot (hidden on mobile) -->
                        <span class="hidden sm:inline whitespace-nowrap">·</span>

                        <!-- Job Type -->
                        <p class="flex font-bold items-center gap-1 whitespace-nowrap">
                            @if($job->type == 'Full Time')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4 sm:w-6 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                </svg>
                            @elseif($job->type == 'Part Time')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4 sm:w-6 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            @elseif($job->type == 'Remote')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4 sm:w-6 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                                </svg>
                            @endif
                            <span class="text-xs sm:text-sm">{{ $job->type }}</span>
                        </p>

                        <!-- Separator Dot (hidden on mobile) -->
                        <span class="hidden sm:inline whitespace-nowrap">·</span>

                        <!-- Deadline -->
                        <p class="text-red-600 flex items-center gap-1 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <span class="text-xs sm:text-sm">Deadline: {{ $job->deadline }}</span>
                        </p>

                    </section>
                </section>
            </section>

            <!-- Job Description -->
            <section class="flex flex-col w-full mt-2 sm:mt-3">
                <section class="text-gray-700 text-xs sm:text-sm leading-relaxed">
                    {{ Str::limit($job->description, 150, '...') }}
                </section>
                <!--<section class="flex gap-2 mt-3">-->
                <!--    @foreach($job->categories as $category)-->
                <!--        <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">{{ $category->name }}</span>-->
                <!--    @endforeach-->
                <!--</section>-->
                <!-- Categories -->
                <section class="flex flex-wrap gap-1 sm:gap-2 mt-2 sm:mt-3">
                    @foreach($job->categories as $category)
                        <span class="bg-gray-200 text-gray-600 px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xxs sm:text-xs">{{ $category->name }}</span>
                    @endforeach
                </section>

                <!-- Footer with Date and Apply Button -->
                <section class="text-black flex justify-between items-center text-xxs sm:text-xs mt-2 sm:mt-3">
                    <p class="font-bold">{{ $job->created_at->diffForHumans() }}</p>
                    <a class="bg-secondary p-1.5 sm:p-2 text-white rounded-lg w-20 sm:w-24 md:w-32 text-center text-xs sm:text-sm"
                       href="{{ route('jobs.view', ['slug' => $job->slug]) }}">
                        Apply now
                    </a>
                </section>
            </section>
        </div>
    </section>
@endforeach

<!-- Responsive Pagination -->
@if($jobs->hasPages())
    <div class="mt-6">
        {{ $jobs->appends(request()->query())->links() }}
    </div>
@endif
