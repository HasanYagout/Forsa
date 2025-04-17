@props(['records','title'])

@foreach($records as $record)
    <section class="w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">
        <!-- Bookmark Button - Visible to all users -->
        <div class="absolute top-3 right-3 sm:top-4 sm:right-4 z-10">
            <button class="bookmark-btn cursor-pointer {{ auth()->check() ? '' : 'guest-bookmark' }}"
                    data-id="{{ $record->id }}"
                    data-type="{{ auth()->check() ? auth()->user()->getBookmarkType($record) : '' }}"
                    data-bookmarked="{{ auth()->check() && auth()->user()->hasBookmarked($record) ? 'true' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="{{ auth()->check() && auth()->user()->hasBookmarked($record) ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="w-5 h-5 sm:w-6 sm:h-6 text-blue-900 hover:text-blue-700 transition-colors bookmark-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                </svg>
            </button>
        </div>

        <x-partials.card :record="$record" :title="$title" />
    </section>
@endforeach

<!-- Responsive Pagination -->
@if ($records->hasPages())
            {{ $records->appends(request()->query())->links() }}

@endif

