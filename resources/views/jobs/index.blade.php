@extends('layouts.app')
@section('content')
    <section class="w-full flex justify-center my-10">

        <!-- Job Listings -->
        <section id="job-listings" class="w-[60%] mx-10 flex flex-col items-center gap-4">
            @include('partials.job-listings', ['jobs' => $jobs])
        </section>

        <!-- Filter Section -->
        <section class="w-[20%] bg-white p-6 rounded-xl shadow-sm border border-gray-200 h-fit hidden lg:block">
            <h2 class="text-lg font-semibold mb-4">Filters</h2>
            <form id="filter-form">
                <!-- Search -->
                <div class="mb-4">
                    <label for="category" class="text-sm font-medium text-gray-600">Category</label>
                    <select id="category" name="category" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Job Type Filter -->
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-600">Job Type</label>
                    <div class="flex flex-col space-y-2 mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" name="type[]" value="Full Time"> Full-time
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" name="type[]" value="Part Time"> Part-time
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" name="type[]" value="Remote"> Remote
                        </label>
                    </div>
                </div>

                <!-- Location Filter -->
                <div class="mb-4">
                    <label for="location" class="text-sm font-medium text-gray-600">Location</label>
                    <select id="location" name="location" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-secondary-color">
                        <option value="">All Locations</option>
                        <option value="Sana'a">Sana'a</option>
                        <option value="Taiz">Taiz</option>
                        <option value="Aden">Aden</option>
                    </select>
                </div>

                <!-- Apply Filters Button -->
                <button type="submit" class="bg-secondary-color text-white px-4 py-2 rounded-lg w-full">Apply Filters</button>
            </form>
        </section>

    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#filter-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show the loading indicator
                $('#loading-indicator').removeClass('hidden');

                // Get selected category IDs
                const selectedCategories = $('#category').val(); // Assuming category is a multi-select dropdown
                const formData = $(this).serializeArray();

                // Add category as a JSON array
                formData.push({
                    name: 'category',
                    value: JSON.stringify(selectedCategories)
                });

                // Send AJAX request
                $.ajax({
                    url: '{{ route("jobs.index") }}', // Use the same route as the form action
                    type: 'GET',
                    data: $.param(formData), // Serialize the form data
                    success: function(response) {
                        // Update the job listings section with the filtered results
                        $('#job-listings').html(response.html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                    complete: function() {
                        // Hide the loading indicator
                        $('#loading-indicator').addClass('hidden');
                    }
                });
            });
        });
    </script>
@endpush
