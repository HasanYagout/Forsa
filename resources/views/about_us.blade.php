<x-app-layout>
    <div class="flex flex-col bg-blue-50 items-center justify-center py-6">
        <!-- Responsive Image -->
        <img src="{{asset('img/logo.png')}}" alt="Chances Platform Logo" class="w-auto h-24 sm:h-32 md:h-40">

        <div class="mt-10 w-full bg-secondary p-10">
            <h2 class="text-3xl font-semibold text-white text-center">{{ __('About Us') }}</h2>

            <p class="mt-4 text-white">
                {{ __('Chances Platform is an online recruitment and training portal in Yemen. It serves as the source of jobs and trainings for employers, training institutions, and job seekers.') }}
            </p>

            <p class="mt-4 text-white">
                {{ __('Founded in 2018, Chances Platform website is a part of the Future Chances Platform for Advertisement company. We make an innovative approach to help employers, training institutions, and employees with recruitment and skill development, driven by a relentless obsession with quality and excellence.') }}
            </p>

            <p class="mt-4 text-white">
                {{ __('Chances Platform is run by a seasoned team of young professionals with diverse backgrounds.') }}
            </p>
        </div>


        <div class="mt-10 w-full max-w-3xl px-4">
            <h2 class="text-3xl font-semibold text-center text-black">{{__('Our Services')}}</h2>
            <span class="mt-5">{{__('Posting jobs (jobs in more than 20 employers) - Posting training courses (training courses in the most important required fields and from leading training institutions)')}}</span>
        </div>
    </div>
</x-app-layout>
