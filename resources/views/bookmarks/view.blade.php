<x-app-layout>
    <section class="max-w-5xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">{{__('Saved')}}</h2>

        <!-- Tabs -->
        <div class="flex justify-center space-x-4 mb-6">
            <button onclick="showTab('jobs')" id="jobsTab" class="px-6 py-2 text-sm font-semibold rounded-full border border-primary text-primary bg-primary text-white transition cursor-pointer">{{__('Saved Jobs')}}</button>
{{--            <button onclick="showTab('tenders')" id="tendersTab" class="px-6 py-2 text-sm font-semibold rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition cursor-pointer">Saved Tenders</button>--}}
            <button onclick="showTab('trainings')" id="trainingsTab" class="px-6 py-2 text-sm font-semibold rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition cursor-pointer">{{__('Saved Trainings')}}</button>
        </div>

        <!-- Jobs Content -->
        <div id="jobsContent" class="space-y-4">

            <x-partials.listings :records="$jobBookmarks"
                                 title="saved" />

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
            <x-partials.listings :records="$trainingBookmarks"
                                 title="saved" />

        </div>
    </section>
@push('js')
        <script>
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
                        item_type: itemType, // Pass the dynamic type
                        action: isBookmarked ? 'remove' : 'add'
                    },
                    success: function(response) {
                        const newState = !isBookmarked;
                        button.data('bookmarked', newState ? 'true' : 'false');
                        icon.attr('fill', newState ? 'currentColor' : 'none');
                        toastr.success(response.message);
                        // Optional: Remove the item from DOM if unbookmarked

                        if (newState) {
                            button.closest('.bookmark-card').fadeOut(300, function() {
                                $(this).remove();
                            });
                        }

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
