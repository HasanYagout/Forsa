<footer class="bg-blue-900 px-20 text-white py-10">
    <div class="container mx-auto px-6">
        <!-- Grid Layout for Four Sections -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-10">
            <!-- Logo & Social Links -->
            <div class="flex flex-col items-center md:items-start space-y-3">
                <a href="{{route('dashboard')}}">
                    <img src="{{ asset('img/light_logo.png') }}" alt="Chances Platform" class="h-12">
                </a>
                <p class="text-sm text-white">Your Next Chance Starts Here</p>
                <div class="flex space-x-3">
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook size-5"></i></a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-linkedin size-5"></i></a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fas fa-x size-5"></i></a>
                </div>
            </div>

            <!-- For Employers -->
            <div>
                <h4 class="font-semibold text-white mb-3">Trainings</h4>
                <ul class="space-y-2 list-none pl-0 text-gray-300">
                    <li><a href="{{route('trainings.index')}}" class="hover:text-white">Home</a></li>
                </ul>
            </div>

            <!-- For Jobs -->
            <div>
                <h4 class="font-semibold text-white mb-3">Jobs</h4>
                <ul class="space-y-2 list-none pl-0 text-gray-300">
                    <li><a href="{{route('jobs.index')}}" class="hover:text-white">Home</a></li>
                </ul>
            </div>

            <!-- About Company -->
            <div>
                <h4 class="font-semibold text-white mb-3">About Chances Company</h4>
                <ul class="space-y-2 list-none pl-0 text-gray-300">
                    <li><a href="{{route('contact_us')}}" class="hover:text-white">Contact Us</a></li>
                    <li><a href="{{route('about_us')}}" class="hover:text-white">About Us</a></li>
                    <li><a href="#" class="hover:text-white">Privacy Commitment</a></li>
                    <li><a href="#" class="hover:text-white">Terms of Use</a></li>
                    <li><a href="{{route('contact_us')}}" class="hover:text-white">Report a Bug</a></li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-600 my-6"></div>

        <!-- Copyright -->
        <p class="text-center text-gray-300 text-sm">Copyright &copy; 2025</p>
    </div>
</footer>
