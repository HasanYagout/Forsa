@foreach($trainings as $training)
    <!-- Main Card Container -->
    <section
        class="w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">
        <div class="absolute top-3 right-3 sm:top-4 sm:right-4 z-10">
            <button class="bookmark-btn cursor-pointer"
                    data-id="{{ $training->id }}"
                    data-type="{{ $training instanceof App\Models\Training ? 'job' : 'tender' }}"
                    data-bookmarked="{{ auth()->check() && auth()->user()->hasBookmarkedTraining($training) ? 'true' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="{{ auth()->check() && auth()->user()->hasBookmarkedTraining($training) ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="w-5 h-5 sm:w-6 sm:h-6 text-blue-900 hover:text-blue-700 transition-colors bookmark-icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
                </svg>
            </button>
        </div>


        <!-- Clickable Card Content -->
        <div onclick="window.location='{{ route('tenders.view', ['slug' => $training->slug]) }}'"
             class="w-full cursor-pointer">

            <!-- Job Header -->
            <section class="flex w-full flex-shrink-0 gap-3 sm:gap-0">
            <img src="{{ asset('storage') . '/' . $training->company->logo }}"
                 class="w-10 h-10 sm:w-14 sm:h-14 rounded-full p-1" alt="">
            <section class="flex ms-0 sm:ms-6 flex-col justify-between w-full">
                <h1 class="font-semibold text-black text-base sm:text-lg">{{ $training->title }}</h1>

                <!-- Tender Details with Icons -->
                <section class="flex flex-wrap items-center text-black text-xs sm:text-sm gap-x-2 gap-y-1 mt-1">
                        <span class="font-semibold flex items-center gap-1 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                            </svg>
                            {{ $training->company->name }}
                        </span>
                    <span class="hidden sm:inline whitespace-nowrap">·</span>

                    <p class="flex font-bold items-center gap-1 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        @if(count($training->location) > 2)
                            <span class="text-xs sm:text-sm">Multiple Cities</span>
                        @else
                            @foreach($training->location as $index => $location)
                                <span class="text-xs sm:text-sm">{{ $location }}@if(!$loop->last)
                                        ,
                                    @endif</span>
                            @endforeach
                        @endif
                    </p>

                    <p class="text-red-600 flex items-center gap-1 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <span class="text-xs sm:text-sm">Deadline: {{ $training->deadline }}</span>
                    </p>
                </section>
            </section>
    </section>

    <!-- Job Description -->
    <section class="flex flex-col w-full mt-2 sm:mt-3">
        <section class="text-gray-700 text-xs sm:text-sm leading-relaxed">
            {{ Str::limit($training->description, 150, '...') }}
        </section>

        <section class="flex gap-2 mt-3">
            @foreach($training->categories as $category)
                <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">{{ $category->name }}</span>
            @endforeach
        </section>

        <!-- Apply Button -->
        <section class="text-gray-500 flex justify-between text-xs mt-3">
            <p class="content-center font-bold text-blue-900">{{ $training->created_at->diffForHumans() }}</p>
            <a class="bg-blue-900 p-2 text-white rounded-lg w-20 md:w-20 lg:w-32 text-center" href="">Apply now</a>
        </section>
    </section>
    </div>
    </section>
@endforeach

<!-- Pagination -->
<div class="mt-6">
    {{ $trainings->links() }}
</div>
