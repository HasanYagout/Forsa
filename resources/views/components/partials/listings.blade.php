@props(['records','title'])
@if($records->count())
    @foreach($records as $record)

        <section class="bookmark-card w-full bg-white relative p-4 sm:p-6 hover:shadow-md transition rounded-xl shadow-sm flex flex-col items-center gap-3 sm:gap-4 mb-4 border border-gray-200">
            <!-- Bookmark Button - Visible to all users -->
            @php
                $isRtl = app()->getLocale() === 'ar';
                $actualRecord = $title == 'saved' ? $record->bookmarkable : $record;
            @endphp

            <div class="absolute top-2 {{ $isRtl ? 'left-2 sm:left-4' : 'right-2 sm:right-4' }} z-10">
                <button class="bookmark-btn cursor-pointer flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white shadow-sm border border-gray-200
                    {{ auth()->check() ? '' : 'guest-bookmark' }}"
                        data-id="{{ $actualRecord->id }}"
                        data-type="{{ auth()->check() ? auth()->user()->getBookmarkType($actualRecord) : '' }}"
                        data-bookmarked="{{ auth()->check() && auth()->user()->hasBookmarked($actualRecord) ? 'true' : 'false' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="{{ auth()->check() && auth()->user()->hasBookmarked($actualRecord) ? 'currentColor' : 'none' }}"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="w-5 h-5 sm:w-6 sm:h-6 text-blue-900 hover:text-blue-700 transition-colors bookmark-icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                </button>
            </div>


            @if($title=='saved')
                <x-partials.card :record="$record->bookmarkable" :title="$title" />
            @else
                <x-partials.card :record="$record" :title="$title" />
            @endif
        </section>
    @endforeach
@else
    <div class="text-center text-3xl text-primary-200 p-6">
        @if($title === 'jobs')
            {{ __('No Jobs available at the moment. Please visit us later') }}
        @elseif($title === 'trainings')
            {{ __('No trainings available at the moment. Please visit us later') }}
        @elseif($title === 'tenders')
            {{ __('No tenders available at the moment. Please visit us later') }}
        @endif
    </div>
@endif


<!-- Responsive Pagination -->
@if ($records->hasPages())
            {{ $records->appends(request()->query())->links() }}
@endif

