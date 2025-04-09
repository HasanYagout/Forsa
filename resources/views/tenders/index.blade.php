<x-app-layout>

    <section class="w-full flex flex-col lg:flex-row justify-center my-10 px-4 sm:px-6 lg:px-8">
        <section class="w-full lg:hidden">
            <!-- Collapsible Trigger Button -->
            <button id="filter-toggle" class="w-full bg-blue-100 p-4 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Filters</h2>
                <svg id="filter-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transform transition-transform duration-200">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Collapsible Content -->
            <div id="filter-content" class="bg-blue-100 rounded-xl mb-6 shadow-sm border border-gray-200 h-fit mt-2 overflow-hidden transition-all duration-300 max-h-0">
                <form id="filter-form" class="p-6">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-lg font-semibold">Filters</h2>
                        <button id="clear" type="button" class="text-lg font-semibold cursor-pointer text-blue-600 hover:text-blue-800">Clear</button>
                    </div>

                    <!-- Search -->
                    <div class="mb-4">
                        <label for="company" class="text-sm font-medium text-gray-600">Company</label>
                        <select id="company" name="company"
                                class="w-full rounded-md bg-white py-2 px-3 text-gray-900 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option {{request()->query('company')==$company->id?'selected':''}} value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                    </div>



                    <!-- Location Filter -->
                    <div class="mb-4">
                        <label for="location" class="text-sm font-medium text-gray-600">Location</label>
                        <select id="location" name="location"
                                class="w-full rounded-md bg-white py-2 px-3 text-gray-900 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Locations</option>
                            @foreach(\App\Models\Job::LOCATIONS as $location)
                                <option {{request()->query('location')==$location?'selected':''}} value="{{$location}}">{{$location}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Apply Filters Button -->
                    <button type="submit" class="bg-secondary cursor-pointer text-white px-4 py-2 rounded-lg w-full">
                        Apply Filters
                    </button>
                </form>
            </div>
        </section>
        <!-- Job Listings -->
        <section id="job-listings" class="w-full lg:w-[60%] flex flex-col items-center gap-4 order-2 lg:order-none">
            <x-partials.listings
                :records="$tenders"
                title="tenders"
            />        </section>

        <!-- Filter Section -->
        <section class="w-[20%] ms-6 bg-blue-100 p-6 rounded-xl shadow-sm border border-gray-200 h-fit hidden lg:block">

            <h2 class="text-lg font-semibold mb-4">Filters</h2>
            <form id="filter-form">

                <div class="mb-4">
                    <label for="company" class="text-sm font-medium text-gray-600">Company</label>
                    <select id="company" name="company" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option {{request()->query('company')==$company->id? 'selected':''}} value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Filter -->
                <div class="mb-4">
                    <label for="location" class="text-sm font-medium text-gray-600">Location</label>
                    <select id="location" name="location" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="">All Locations</option>
                        @foreach(\App\Models\Job::LOCATIONS as $location)
                            <option value="{{$location}}">{{$location}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Apply Filters Button -->
                <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg w-full">Apply Filters</button>
            </form>
        </section>

    </section>
    @push('js')
        <script>
            $(document).ready(function() {
                const $toggleButton = $('#filter-toggle');
                const $filterContent = $('#filter-content');
                const $chevron = $('#filter-chevron');

                $toggleButton.on('click', function(e) {
                    e.stopPropagation(); // Prevent event from bubbling up

                    $filterContent.toggleClass('max-h-0 max-h-[800px]');
                    $chevron.toggleClass('rotate-180');

                    // Optional: Close when clicking outside
                    if (!$filterContent.hasClass('max-h-0')) {
                        $(document).on('click.collapseFilters', function(e) {
                            if (!$filterContent.is(e.target) && !$toggleButton.is(e.target) && $filterContent.has(e.target).length === 0) {
                                $filterContent.addClass('max-h-0').removeClass('max-h-[800px]');
                                $chevron.removeClass('rotate-180');
                                $(document).off('click.collapseFilters');
                            }
                        });
                    } else {
                        $(document).off('click.collapseFilters');
                    }
                });
            });

            $(document).ready(function() {
                // Ensure the click event is attached correctly
                $(document).on('click', '.bookmark-btn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const button = $(this);
                    const itemId = button.data('id');
                    const isBookmarked = button.data('bookmarked') === 'true';
                    const icon = button.find('.bookmark-icon');

                    // Check if user is authenticated
                    @if(!auth()->check())
                        window.location.href = '{{ route('login') }}';
                    return;
                    @endif

                    // Show loading effect
                    icon.addClass('opacity-50');

                    // AJAX request
                    $.ajax({
                        url: '{{ route("bookmarks.toggle") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            item_id: itemId,
                            item_type: 'tender',
                            action: isBookmarked ? 'remove' : 'add'
                        },
                        success: function(response) {
                            // Toggle bookmark state
                            const newState = !isBookmarked;
                            button.data('bookmarked', newState ? 'true' : 'false');
                            icon.attr('fill', newState ? 'currentColor' : 'none');

                            // Show toast notification
                            toastr.success(newState ? 'Bookmark added!' : 'Bookmark removed!');
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
            });
        </script>
        <script>
            $(document).ready(function() {
                // Submit form via AJAX
                $('form[id="filter-form"]').on('submit', function(e) {
                    e.preventDefault();

                    // Show loader
                    $('#filter-loader').removeClass('hidden');

                    // Get form data
                    let formData = $(this).serialize();

                    // Get current page if exists
                    const urlParams = new URLSearchParams(window.location.search);
                    const page = urlParams.get('page');
                    if (page) {
                        formData += '&page=' + page;
                    }

                    // AJAX request
                    $.ajax({
                        url: '{{ route("tenders.index") }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, '?' + $.param(response.queryParams));
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error applying filters');
                        },
                        complete: function() {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // Handle pagination clicks
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();

                    let url = $(this).attr('href');
                    $('#filter-loader').removeClass('hidden');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, url);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error loading page');
                        },
                        complete: function() {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // Clear filters
                $('#clear').on('click', function(e) {
                    e.preventDefault();
                    $('#filter-loader').removeClass('hidden');

                    $('form[id="filter-form"]')[0].reset();
                    $('#company, #location').val('').trigger('change');

                    $.ajax({
                        url: '{{ route("tenders.index") }}',
                        type: 'GET',
                        success: function(response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, '{{ route("tenders.index") }}');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error clearing filters');
                        },
                        complete: function() {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // Preserve filters on page load
                const urlParams = new URLSearchParams(window.location.search);
                ['company', 'location'].forEach(param => {
                    if (urlParams.has(param)) {
                        $('[name="' + param + '"]').val(urlParams.get(param));
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>



