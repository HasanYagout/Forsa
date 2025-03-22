@extends('layouts.app')
@section('content')
    <section class="w-full flex justify-center my-10">

        <!-- Job Listings -->
        <section id="job-listings" class="w-[60%] mx-10 flex flex-col items-center gap-4">
            @include('partials.tenders-listings', ['tenders' => $tenders])
        </section>

        <!-- Filter Section -->
        <section class="w-[20%] bg-lightBlue p-6 rounded-xl shadow-sm border border-gray-200 h-fit hidden lg:block">

            <h2 class="text-lg font-semibold mb-4">Filters</h2>
            <form id="filter-form">

                <!-- Search -->
                <div class="mb-4">
                    <label for="company" class="text-sm font-medium text-gray-600">Company</label>
                    <select id="company" name="company" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="category" class="text-sm font-medium text-gray-600">Category</label>
                    <select id="category" name="category" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>



                <!-- Location Filter -->
                <div class="mb-4">
                    <label for="location" class="text-sm font-medium text-gray-600">Location</label>
                    <select id="location" name="location" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-secondary">
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
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $('#filter-form').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Show the loading indicator (optional)
                $('#loading-indicator').removeClass('hidden');

                // Serialize form data
                let formData = $(this).serializeArray();

                // Ensure selectedCategories is always an array
                let selectedCategories = $('#category').val() || [];

                if (!Array.isArray(selectedCategories)) {
                    selectedCategories = [selectedCategories]; // Convert to array if it's a single value
                }

                selectedCategories.forEach(categoryId => {
                    formData.push({ name: "category[]", value: categoryId });
                });

                // Handle checkboxes (Job Type)
                $('input[name="type[]"]:checked').each(function () {
                    formData.push({ name: "type[]", value: $(this).val() });
                });

                // Send AJAX request
                $.ajax({
                    url: '{{ route("tenders.index") }}',
                    type: 'GET',
                    data: formData,
                    success: function (response) {
                        $('#job-listings').html(response.html);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    },
                    complete: function () {
                        $('#loading-indicator').addClass('hidden'); // Hide loading indicator
                    }
                });
            });
        });
    </script>
@endpush


