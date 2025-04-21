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
                <form id="filter-form-mobile" class="p-6">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-lg font-semibold">Filters</h2>
                        <button id="clear-mobile" type="button" class="text-lg font-semibold cursor-pointer text-blue-600 hover:text-blue-800">Clear</button>
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

                    <div class="mb-4">
                        <label for="category" class="text-sm font-medium text-gray-600">Category</label>
                        <select id="category" name="category"
                                class="w-full rounded-md bg-white py-2 px-3 text-gray-900 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option {{(int)request()->query('category')==$category->id?'selected':''}}value="{{$category->id}}">{{$category->name}}</option>
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
                :records="$jobs"
                title="jobs"
            />
        </section>

        <!-- Filter Section -->
        <section class="w-[20%]   h-fit hidden lg:block">
            <form class="bg-white ms-6  p-6 rounded-xl shadow-sm border border-gray-200" id="filter-form-desktop">
                <div class="flex justify-between">
                    <h2 class="text-lg font-semibold mb-4">Filters</h2>
                    <button id="clear-desktop" class="text-lg font-semibold mb-4 cursor-pointer text-blue-600 hover:text-blue-800">Clear</button>
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
                <div class="mb-4">
                    <label for="category" class="text-sm font-medium text-gray-600">Category</label>

                    <select id="category" name="category"
                            class="w-full rounded-md bg-white py-2 px-3 text-gray-900 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option {{(int)request()->query('category')==$category->id?'selected':''}}value="{{$category->id}}">{{$category->name}}</option>
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
                <button type="submit" class="bg-secondary cursor-pointer text-white px-4 py-2 rounded-lg w-full">Apply
                    Filters
                </button>
            </form>
            <div class="bg-white ms-6 mt-3  p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Explore Trainings</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Enhance your skills with curated training opportunities from leading training institutions.
                </p>
                <a href="{{ route('trainings.index') }}" class="inline-block w-full text-center bg-gray-300 text-white text-sm font-medium py-2 rounded-lg hover:bg-primary-100 transition">
                    Go to Trainings
                </a>
            </div>
        </section>


    </section>
    @push('js')
        <script>
            $(document).ready(function () {
                // 🔁 FILTER TOGGLE
                const $toggleButton = $('#filter-toggle');
                const $filterContent = $('#filter-content');
                const $chevron = $('#filter-chevron');

                $toggleButton.on('click', function (e) {
                    e.stopPropagation();
                    $filterContent.toggleClass('max-h-0 max-h-[800px]');
                    $chevron.toggleClass('rotate-180');

                    if (!$filterContent.hasClass('max-h-0')) {
                        $(document).on('click.collapseFilters', function (e) {
                            if (
                                !$filterContent.is(e.target) &&
                                !$toggleButton.is(e.target) &&
                                $filterContent.has(e.target).length === 0
                            ) {
                                $filterContent.addClass('max-h-0').removeClass('max-h-[800px]');
                                $chevron.removeClass('rotate-180');
                                $(document).off('click.collapseFilters');
                            }
                        });
                    } else {
                        $(document).off('click.collapseFilters');
                    }
                });

                // 🔖 BOOKMARK TOGGLE
                $(document).on('click', '.bookmark-btn', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const button = $(this);
                    const itemId = button.data('id');
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
                            item_type: 'job',
                            action: isBookmarked ? 'remove' : 'add'
                        },
                        success: function (response) {
                            const newState = !isBookmarked;
                            button.data('bookmarked', newState ? 'true' : 'false');
                            icon.attr('fill', newState ? 'currentColor' : 'none');
                            toastr.success(newState ? 'Saved Successfully!' : 'Removed Successfully!');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            toastr.error('An error occurred. Please try again.');
                        },
                        complete: function () {
                            icon.removeClass('opacity-50');
                        }
                    });
                });

                // 🔍 FILTER FORM SUBMIT
                $('#filter-form-mobile, #filter-form-desktop').on('submit', function (e) {
                    e.preventDefault();
                    $('#filter-loader').removeClass('hidden');

                    let formData = $(this).serialize();

                    const urlParams = new URLSearchParams(window.location.search);
                    const page = urlParams.get('page');
                    if (page) {
                        formData += '&page=' + page;
                    }

                    $.ajax({
                        url: '{{ route("jobs.index") }}',
                        type: 'GET',
                        data: formData,
                        success: function (response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, '?' + $.param(response.queryParams));
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error applying filters');
                        },
                        complete: function () {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // 🧹 CLEAR FILTERS
                $('#clear-mobile').on('click', function (e) {
                    e.preventDefault();
                    $('#filter-loader').removeClass('hidden');

                    const $form = $('#filter-form-mobile');
                    $form[0].reset();
                    $form.find('select').val('').trigger('change');
                    $form.find('input[type="checkbox"]').prop('checked', false);

                    $.ajax({
                        url: '{{ route("jobs.index") }}', // ✅ Corrected
                        type: 'GET',
                        success: function (response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, '{{ route("jobs.index") }}');
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error clearing filters');
                        },
                        complete: function () {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // Clear filters (desktop)
                // 🧹 CLEAR FILTERS (DESKTOP)
                $('#clear-desktop').on('click', function (e) {
                    e.preventDefault();
                    $('#filter-loader').removeClass('hidden');

                    const $form = $('#filter-form-desktop');
                    $form[0].reset();
                    $form.find('select').val('').trigger('change');
                    $form.find('input[type="checkbox"]').prop('checked', false);

                    $.ajax({
                        url: '{{ route("jobs.index") }}', // ✅ Corrected
                        type: 'GET',
                        success: function (response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, '{{ route("jobs.index") }}');
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error clearing filters');
                        },
                        complete: function () {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // 🔄 PAGINATION AJAX
                $(document).on('click', '.pagination a', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    $('#filter-loader').removeClass('hidden');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (response) {
                            $('#job-listings').html(response.html);
                            history.pushState(null, null, url);
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            toastr.error('Error loading page');
                        },
                        complete: function () {
                            $('#filter-loader').addClass('hidden');
                        }
                    });
                });

                // 🔁 APPLY FILTERS FROM URL (on page load)
                const urlParams = new URLSearchParams(window.location.search);
                ['company', 'category', 'type', 'location'].forEach(param => {
                    if (urlParams.has(param)) {
                        $('[name="' + param + '"]').val(urlParams.get(param));
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>



