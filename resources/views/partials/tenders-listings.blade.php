@foreach($tenders as $tender)
    <section class="w-full bg-lightBlue p-6 rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
        <!-- Job Header -->
        <section class="flex w-full flex-shrink-0">
            <img src="{{ asset('storage') . '/' . $tender->company->logo }}" class="w-14 h-14 rounded-full bg-gray-100 p-1" alt="">
            <section class="flex ms-6 flex-col justify-between w-full">
                <h1 class="font-semibold text-darkBlue text-lg">{{ $tender->title }}</h1>

                <!-- Tender Details with Icons -->
                <section class="flex items-center text-gray-500 text-sm gap-2 mt-1">
                    <span class="font-semibold text-darkBlue flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                        {{ $tender->company->name }}
                    </span>
                    <span>·</span>

                    <p class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        {{ $tender->location }}
                    </p>
                    <span>·</span>

                    <p class="text-red-600 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Deadline: {{ $tender->deadline }}
                    </p>
                </section>
            </section>
        </section>

        <!-- Job Description -->
        <section class="flex flex-col w-full">
            <section class="mt-3 text-gray-700 text-sm leading-relaxed">
                {{ Str::limit($tender->description, 150, '...') }}
            </section>

            <!-- Apply Button -->
            <section class="text-gray-500 flex justify-between text-xs mt-3">
                <p class="content-center text-darkBlue">{{ $tender->created_at->diffForHumans() }}</p>
                <a class="bg-darkBlue p-2 text-white rounded-lg w-20 md:w-20 lg:w-32 text-center" href="">Apply now</a>
            </section>
        </section>
    </section>
@endforeach

<!-- Pagination -->
<div class="mt-6">
    {{ $tenders->links() }}
</div>
