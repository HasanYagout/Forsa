<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-[#EAEFF8] py-12 px-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">{{__('CHANCES')}}</h1>
            <p class="text-sm text-gray-500">{{__('Your Next Chance Starts Here')}}</p>
        </div>

        <div class="w-full max-w-md bg-white rounded-xl shadow-md p-10  transition-all">
            <!-- Tabs -->
            <div class="flex justify-center mb-8 space-x-6">
                <button id="tab-login-btn" class="pb-1 cursor-pointer text-lg font-medium text-indigo-600 border-b-2 border-indigo-500">{{__('Sign')}}</button>
                <button id="tab-register-btn" class="pb-1 cursor-pointer text-lg font-medium text-gray-500">{{__('Register')}}</button>
            </div>

            <!-- Login Form -->
            <div id="tab-login">
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <x-label for="email" value="{{__('Email Address')}}" />
                        <x-input id="email" class="block mt-1 p-2 w-full border rounded-md" type="email" name="email" :value="old('email')" placeholder="{{__('Email Address')}}" required autofocus />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="{{__('Password')}}" />
                        <x-input id="password" class="block mt-1 p-2 w-full border rounded-md" type="password" name="password" placeholder="{{__('Password')}}" required />
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{__('Remember me')}}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                                {{__('Forgot password?')}}
                            </a>
                        @endif
                    </div>

                    <x-button class="w-full justify-center  hover:bg-indigo-600 text-white py-2 rounded-md">
                        {{__('Submit')}}
                    </x-button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="tab-register" class="hidden">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-4">
                        <x-label for="first_name" value="{{__('First Name')}}" />
                        <x-input id="first_name" class="block mt-1 p-2 w-full border rounded-md" type="text" name="first_name" placeholder="{{__('First Name')}}" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="last_name" value="{{__('Last Name')}}" />
                        <x-input id="last_name" class="block mt-1 p-2 w-full border rounded-md" type="text" name="last_name" placeholder="{{__('Last Name')}}" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="email" value="{{__('Email Address')}}" />
                        <x-input id="email" class="block mt-1 p-2 w-full border rounded-md" type="email" name="email" placeholder="{{__('Email Address')}}" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="{{__('Password')}}" />
                        <x-input id="password" class="block mt-1 p-2 w-full border rounded-md" type="password" name="password" placeholder="{{__('Password')}}" required />
                    </div>

                    <div class="mb-6">
                        <x-label for="password_confirmation" value="{{__('Confirm Password')}}" />
                        <x-input id="password_confirmation" class="block mt-1 p-2 w-full border rounded-md" type="password" name="password_confirmation" placeholder="{{__('Confirm Password')}}" required />
                    </div>

                    <x-button class="w-full justify-center bg-indigo-500 hover:bg-indigo-600 text-white py-2 rounded-md">
                        {{__('Register')}}
                    </x-button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    @push('js')
        <script>
            $(function () {
                function switchTo(tab) {
                    if (tab === 'register') {
                        $('#tab-register').show();
                        $('#tab-login').hide();
                        $('#tab-register-btn').addClass('text-indigo-600 border-b-2 border-indigo-500').removeClass('text-gray-500');
                        $('#tab-login-btn').removeClass('text-indigo-600 border-b-2 border-indigo-500').addClass('text-gray-500');
                    } else {
                        $('#tab-login').show();
                        $('#tab-register').hide();
                        $('#tab-login-btn').addClass('text-indigo-600 border-b-2 border-indigo-500').removeClass('text-gray-500');
                        $('#tab-register-btn').removeClass('text-indigo-600 border-b-2 border-indigo-500').addClass('text-gray-500');
                    }
                }

                // Check tab from query string
                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab');
                switchTo(tab);

                // Button click handlers
                $('#tab-login-btn').on('click', function () {
                    switchTo('login');
                });

                $('#tab-register-btn').on('click', function () {
                    switchTo('register');
                });
            });
        </script>
    @endpush


</x-app-layout>
