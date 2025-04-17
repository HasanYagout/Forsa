@props(['records','title'])

<section class="{{ $title == 'jobs' ? 'bg-gray-100' : 'bg-primary-100' }} py-12 px-4">
    <div class="text-center mb-6">
        <span class="text-sm uppercase font-semibold border-2 rounded-sm rounded-lg border-blue-100 p-2 {{ $title == 'jobs' ? 'text-gray-600' : 'text-white' }}">
            Latest {{ $title }}
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @foreach($records as $record)
            <a href="{{ route($title == 'jobs' ? 'jobs.view' : 'trainings.view', ['slug' => $record->slug]) }}"
               class="block transition-transform hover:scale-[1.02]">
                <div class="{{ $title == 'jobs' ? 'bg-white' : 'bg-primary' }} rounded-xl shadow-md p-5 flex flex-col gap-3 h-full">
                    <!-- Job Header -->
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/' . $record->company->logo) }}" class="w-10 h-10 rounded-full" alt="">
                        <h3 class="text-md font-semibold {{ $title == 'jobs' ? 'text-gray-900' : 'text-white' }}">
                            {{ $record->title }}
                        </h3>
                    </div>

                    <!-- Job Description -->
                    <p class="{{ $title == 'jobs' ? 'text-gray-600' : 'text-white' }} text-sm leading-relaxed">
                        {{ Str::limit($record->description, 100, '...') }}
                        <span class="{{ $title == 'jobs' ? 'text-black' : 'text-white' }} font-medium underline">More...</span>
                    </p>

                    <!-- Job Meta -->
                    <div class="flex justify-between {{ $title == 'jobs' ? 'text-black' : 'text-white' }} text-xs mt-auto">
                        <p>{{ $record->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @php
        $route = match($title) {
            'jobs' => route('jobs.index'),
            'tenders' => route('tenders.index'),
            'trainings' => route('trainings.index'),
            default => '#',
        };
    @endphp

    <div class="mt-8 text-center">
        <a href="{{ $route }}" target="_blank"
           class="bg-gray-300 hover:bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
            More
        </a>
    </div>
</section>
