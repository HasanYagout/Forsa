<x-app-layout>

    <!-- Hero Section -->
    <section class="bg-blue-50 text-white py-20">
        <div class="container text-black mx-auto text-center">
            <h1 class="text-5xl font-bold">Get in Touch</h1>
            <p class="mt-4 text-lg">We're here to assist you. Reach out for any inquiries or support!</p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <div class="flex justify-center py-10">
        <form class="bg-blue-50 shadow-md rounded-lg p-8 max-w-3xl w-full" method="post" action="{{route('bug')}}">
            @csrf
            <h2 class="text-2xl font-semibold text-center text-black mb-6">Contact Us</h2>

            <div class="mb-4 flex space-x-4">
                <div class="flex-1">
                    <label for="first_name" class="block text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Your Name">
                </div>
                <div class="flex-1">
                    <label for="last_name" class="block text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Your Name">
                </div>
                <div class="flex-1">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Your Email">
                </div>
            </div>

            <div class="mb-4">
                <label for="bug_type" class="block text-gray-700">Type of Bug</label>
                <select id="type" name="type" required class="mt-1 p-2 border border-gray-300 rounded w-full">
                    <option value="" disabled selected>Select a bug type</option>
                    <option value="UI Bug">UI Bug</option>
                    <option value="Performance Bug">Performance Bug</option>
                    <option value="Functionality Bug">Functionality Bug</option>
                    <option value="Security Bug">Security Bug</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="message" class="block text-gray-700">Message</label>
                <textarea id="message" name="message" required class="mt-1 p-2 border border-gray-300 rounded w-full" rows="4" placeholder="Your Message"></textarea>
            </div>

            <button type="submit" class="bg-gray-300 cursor-pointer w-full text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                Send Message
            </button>
        </form>    </div>
</x-app-layout>
