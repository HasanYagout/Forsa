<x-app-layout>
    <section class="max-w-5xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Saved</h2>

        <!-- Tabs -->
        <div class="flex justify-center space-x-4 mb-6">
            <button onclick="showTab('jobs')" id="jobsTab" class="px-6 py-2 text-sm font-semibold rounded-full border border-primary text-primary bg-primary text-white transition cursor-pointer">Saved Jobs</button>
{{--            <button onclick="showTab('tenders')" id="tendersTab" class="px-6 py-2 text-sm font-semibold rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition cursor-pointer">Saved Tenders</button>--}}
            <button onclick="showTab('trainings')" id="trainingsTab" class="px-6 py-2 text-sm font-semibold rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition cursor-pointer">Saved Trainings</button>
        </div>

        <!-- Jobs Content -->
        <div id="jobsContent" class="space-y-4">
            @forelse($jobBookmarks as $bookmark)
                <section class="w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">
                    <x-partials.card :record="$bookmark->bookmarkable" title="saved" />
                </section>
            @empty
                <div class="bg-white p-6 rounded-xl shadow-sm text-gray-600 text-center">No saved jobs yet.</div>
            @endforelse
        </div>

        <!-- Tenders Content -->
{{--        <div id="tendersContent" class="hidden space-y-4">--}}
{{--            --}}
{{--            @forelse($tenderBookmarks as $bookmark)--}}
{{--                <section class="w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">--}}
{{--                    <x-partials.card :record="$bookmark->bookmarkable" title="saved" />--}}
{{--                </section>--}}
{{--            @empty--}}
{{--         --}}
{{--                <div class="bg-white p-6 rounded-xl shadow-sm text-gray-600 text-center">No saved tenders yet.</div>--}}
{{--            @endforelse--}}
{{--        </div>--}}

        <!-- Trainings Content -->
        <div id="trainingsContent" class="hidden space-y-4">
            @forelse($trainingBookmarks as $bookmark)
                <section class="w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">
                    <x-partials.card :record="$bookmark->bookmarkable" title="saved" />
                </section>
            @empty
                <div class="bg-white p-6 rounded-xl shadow-sm text-gray-600 text-center">No saved trainings yet.</div>
            @endforelse
        </div>
    </section>
@push('js')
        <script>
            function showTab(tabName) {
                // Hide all content
                document.querySelectorAll('[id$="Content"]').forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected content
                document.getElementById(`${tabName}Content`).classList.remove('hidden');

                // Update active tab styling
                document.querySelectorAll('[id$="Tab"]').forEach(tab => {
                    if (tab.id === `${tabName}Tab`) {
                        tab.classList.add('bg-primary', 'text-white');
                        tab.classList.remove('hover:bg-primary', 'hover:text-white');
                    } else {
                        tab.classList.remove('bg-primary', 'text-white');
                        tab.classList.add('hover:bg-primary', 'hover:text-white');
                    }
                });
            }

            // Initialize with jobs tab active
            document.addEventListener('DOMContentLoaded', () => {
                showTab('jobs');
            });
        </script>
@endpush

</x-app-layout>
