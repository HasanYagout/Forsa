<x-app-layout>

    <!-- Hero Section -->
    <section class="bg-blue-50 text-white py-20 px-3">
        <div class="container text-black mx-auto text-center">
            <h1 class="text-5xl font-bold">{{ __('Get in Touch') }}</h1>
            <p class="mt-4 text-lg">{{ __('We\'re here to assist you. Reach out for any inquiries or support!') }}</p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <div class="flex justify-center py-10">
        <form class="bg-blue-50 shadow-md rounded-lg p-8 max-w-3xl w-full" method="post" action="{{ route('contact.store') }}">
            @csrf
            <h2 class="text-2xl font-semibold text-center text-black mb-6">{{ __('Contact Us') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-gray-700">{{ __('First Name') }}</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="{{ __('Your Name') }}">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-gray-700">{{ __('Last Name') }}</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="{{ __('Your Name') }}">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="{{ __('Your Email') }}">
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-gray-700">{{ __('Phone Number') }}</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="{{ __('Your Phone Number') }}">
                </div>

                <!-- Type (full width even on large screens) -->
                <div class="lg:col-span-2">
                    <label for="type" class="block text-gray-700">{{ __('Choose a Type') }}</label>
                    <select id="type" name="type" required class="mt-1 p-2 border border-gray-300 rounded w-full">
                        <option value="" disabled {{ old('type') ? '' : 'selected' }}>{{ __('Select a type') }}</option>
                        <option value="Job" {{ old('type') == 'Job' ? 'selected' : '' }}>{{ __('Post a Job') }}</option>
                        <option value="Internship" {{ old('type') == 'Internship' ? 'selected' : '' }}>{{ __('Post a Training') }}</option>
                        <option value="Advertising" {{ old('type') == 'Advertising' ? 'selected' : '' }}>{{ __('Post Advertising') }}</option>
                        <option value="Bug" {{ old('type') == 'Bug' ? 'selected' : '' }}>{{ __('Report a Bug') }}</option>
                        <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>{{ __('Others') }}</option>
                    </select>
                </div>

                <!-- Message (full width even on large screens) -->
                <div class="lg:col-span-2">
                    <label for="message" class="block text-gray-700">{{ __('Message') }}</label>
                    <textarea id="message" name="message" required class="mt-1 p-2 border border-gray-300 rounded w-full" rows="4" placeholder="{{ __('Your Message') }}">{{ old('message') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="bg-primary w-full text-white px-6 py-3 rounded-md hover:bg-primary-dark transition">
                    {{ __('Send Message') }}
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
