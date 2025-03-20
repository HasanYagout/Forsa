@foreach($jobs as $job)
    <section class="w-full bg-white p-6 rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
        <!-- Job Header -->
        <section class="flex w-full flex-shrink-0">
            <img src="{{ asset('storage') . '/' . $job->company->logo }}" class="w-14 h-14 rounded-full bg-gray-100 p-1" alt="">
            <section class="flex ms-6 flex-col justify-between w-full">
                <h1 class="font-semibold text-lg">{{ $job->title }}</h1>
                <section class="flex items-center text-gray-500 text-sm gap-2 mt-1">
                    <span class="font-semibold">{{ $job->company->name }}</span>
                    <span>·</span>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</p>
                    <span>·</span>
                    <p><i class="fas fa-briefcase"></i> {{ $job->type }}</p>
                    <span>·</span>
                    <p class="text-red-600"><i class="fas fa-calendar-alt"></i> Deadline: {{ $job->deadline }}</p>
                </section>
            </section>
        </section>

        <!-- Job Description -->
        <section class="flex flex-col w-full">
            <section class="mt-3 text-gray-700 text-sm leading-relaxed">
                {{ Str::limit($job->description, 150, '...') }}
            </section>
            <section class="flex gap-2 mt-3">
                <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">Networking</span>
                <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">Telecommunication</span>
            </section>

            <!-- Apply Button -->
            <section class="text-gray-500 flex justify-between text-xs mt-3">
                <p class="content-center">{{ $job->created_at->diffForHumans() }}</p>
                <a class="bg-secondary-color p-2 text-white rounded-lg w-20 md:w-20 lg:w-32 text-center" href="">Apply now</a>
            </section>
        </section>
    </section>
@endforeach

<!-- Pagination -->
<div class="mt-6">
    {{ $jobs->links() }}
</div>
