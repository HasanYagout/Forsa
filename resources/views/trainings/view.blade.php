<x-app-layout>
    <section class="w-full flex justify-center my-10 px-4">
        <!-- Main Content -->
        <section class="w-[60%] mx-10 flex flex-col items-center gap-4">
            <section class="bg-white transition w-full rounded-xl shadow-sm flex flex-col gap-4 mb-4 border border-gray-200">

                <!-- Header -->
                <section class="flex flex-col sm:flex-row w-full p-6 border-b gap-4 sm:gap-6">
                    <img src="{{ asset('storage/' . $training->company->logo) }}"
                         class="w-14 h-14 rounded-full object-cover border border-gray-300 p-1" alt="">
                    <section class="flex flex-col justify-between w-full">
                        <h1 class="font-semibold text-lg">{{ $training->title }}</h1>

                        <!-- Metadata -->
                        <section class="flex flex-wrap items-center text-gray-500 text-sm gap-2 mt-2">
                            <a href="{{ route('trainings.index', ['company' => $training->company->id]) }}"
                               class="font-semibold flex items-center gap-1 whitespace-nowrap hover:underline text-black">
                                <x-icon name="heroicon-o-building-office" class="w-4 h-4 sm:w-5 sm:h-5" />
                                {{ $training->company->name }}
                            </a>

                            <span class="hidden sm:inline">·</span>

                            <span class="flex items-center gap-1">
                                <x-icon name="heroicon-o-map-pin" class="w-5 text-black h-5" />
                                @foreach($training->location as $location)
                                    <a href="{{ route('trainings.index', ['location' => $location]) }}" class="hover:underline text-black">
                                        {{ $location }}
                                    </a>@if (!$loop->last), @endif
                                @endforeach
                            </span>

                            <span class="hidden sm:inline">·</span>

                            <span class="text-green-600 font-bold flex items-center gap-1">
                                <x-icon name="heroicon-o-clock" class="w-5 h-5" />
                                <span>{{ __('Published') }}: {{ $training->created_at->format('j M Y')}}</span>
                            </span>

                            <span class="text-red-600 font-bold flex items-center gap-1">
                                <x-icon name="heroicon-o-clock" class="w-5 h-5" />
                                <span>{{ __('Starting In') }}: {{ $training->deadline->format('j M Y') }}</span>
                            </span>
                        </section>

                        <!-- Categories -->
                        <section class="flex flex-wrap gap-2 mt-3 mb-4">
                            @foreach($training->categories as $category)
                                <a href="{{ route('trainings.index', ['category' => $category->id]) }}"
                                   class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </section>
                    </section>
                </section>

                <!-- Training Image -->
                @if($training->image)
                    <img src="{{ asset('storage/' . $training->image) }}"
                         alt="{{ __('Training Image') }}"
                         class="w-full h-auto rounded-lg object-cover max-w-full" />
                @endif

                <!-- Description -->
                <section class="text-white w-full text-xs mt-3">
                    <h1 class="p-2 text-xl bg-gray-300">{{ __('Training Description') }}</h1>
                    <section class="text-black text-sm p-6 leading-7">
                        {!! str($training->details)->sanitizeHtml() !!}
                    </section>
                </section>

                <!-- How to Apply -->
                <section class="text-white w-full text-xs mt-3">
                    <h1 class="p-2 text-xl bg-gray-300">{{ __('How to Apply') }}</h1>
                    <section class="text-black text-sm p-6 leading-7">
                        <p>{{ __('To apply click on the link below:') }}</p>
                        <a class="underline text-blue-600 break-all" href="{{ $training->link }}">{{ $training->link }}</a>
                    </section>
                </section>
            </section>
        </section>

        <!-- Sidebar -->
        <section class="w-[20%] px-6 rounded-xl h-fit hidden lg:block space-y-4">

            <!-- Apply Now -->
            <section class="bg-white shadow-sm border border-gray-200 rounded-lg p-4">
                @if($training->link)
                    <a href="{{ $training->link }}"
                       class="bg-secondary text-white block px-4 py-2 text-center rounded-lg w-full">
                        {{ __('Apply Now') }}
                    </a>
                @endif
            </section>

            <!-- Similar Trainings -->
            <section class="bg-white shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">{{ __('Similar Trainings') }}</h1>
                @foreach($similar_trainings as $similar)
                    <a href="{{ route('jobs.view', ['slug' => $similar->slug]) }}"
                       class="flex items-center gap-4 border-b border-gray-200 pb-3">
                        <img src="{{ asset('storage/' . $similar->company->logo) }}"
                             alt="{{ $similar->company->name }} Logo"
                             class="w-12 h-12 rounded-full object-cover">
                        <h2 class="text-sm font-semibold text-gray-900">{{ $similar->title }}</h2>
                    </a>
                @endforeach
                <a href="{{ route('jobs.index') }}" class="text-sm text-blue-600 hover:underline block text-right font-medium">{{__('View all jobs')}}</a>

            </section>

            <!-- Similar Jobs -->
            <section class="bg-white shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                <h1 class="text-lg font-semibold">{{ __('Similar Jobs') }}</h1>
                @foreach($similar_jobs as $job)
                    <a href="{{ route('jobs.view', ['slug' => $job->slug]) }}"
                       class="flex items-center gap-4 border-b border-gray-200 pb-3">
                        <img src="{{ asset('storage/' . $job->company->logo) }}"
                             alt="{{ $job->company->name }} Logo"
                             class="w-12 h-12 rounded-full object-cover">
                        <h2 class="text-sm font-semibold text-gray-900">{{ $job->title }}</h2>
                    </a>
                @endforeach
            </section>

        </section>

    </section>
</x-app-layout>
