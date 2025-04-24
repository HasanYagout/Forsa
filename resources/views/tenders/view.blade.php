<x-app-layout>
    <section class="w-full flex justify-center my-10">

        <!-- Job Listings -->
        <section id="job-listings" class="w-[60%] mx-10 flex flex-col items-center gap-4">
            <section class="w-full bg-white  transition rounded-xl shadow-sm flex flex-col items-center gap-4 mb-4 border border-gray-200">
                <!-- Job Header -->
                <section class="flex w-full flex-shrink-0 p-6 border-b">
                    <img src="{{ asset('storage') . '/' . $tender->company->logo }}"
                         class="w-14 object-cover h-14 rounded-full border border-gray-300 p-1" alt="">
                    <section class="flex ms-6 flex-col justify-between w-full">
                        <h1 class="font-semibold text-lg">{{ $tender->title }}</h1>

                        <!-- Job Details with Icons -->
                        <section class="flex items-center text-gray-500 text-sm gap-2 mt-1">
                            <a href="{{ route('tenders.index', ['company' => $tender->company->id]) }}"
                               class="font-semibold flex items-center gap-1 whitespace-nowrap hover:underline text-black">
                                <x-icon name="heroicon-o-building-office" class="w-4 h-4 sm:w-5 sm:h-5" />
                                {{ $tender->company->name }}
                            </a>

                            <span>·</span>

                            <span class="flex items-center gap-1">
                                    <x-icon name="heroicon-o-map-pin" class="w-5 text-black h-5" />
                                    @foreach($tender->location as $location)
                                    <a href="{{ route('trainings.index', ['location' => $location]) }}" class="hover:underline text-black">
                                            {{ $location }}
                                        </a>@if (!$loop->last), @endif
                                @endforeach
                                </span>
                            <span>·</span>
                            <p class="text-green-600 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{__('Published')}}: {{ $tender->created_at->format('M j, Y')}}</span>

                            </p>

                            <p class="text-red-600 flex font-bold items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{__('Deadline')}}: {{ $tender->deadline->format('M j, Y')}}</span>

                            </p>
                        </section>

                    </section>
                </section>


                <section class="text-white w-full text-xs mt-3">
                    <h1 class="p-2 text-xl bg-gray-300">{{__('Tender Description')}}</h1>
                    <section class="text-black text-sm p-6 leading-7">
                        {!! str($tender->details)->sanitizeHtml() !!}
                    </section>
                </section>

                @if($processedFiles && $processedFiles->count())
                    <section class="w-full text-white mt-4">

                        <h2 class="bg-gray-300 px-4 py-2 rounded-t-md text-lg flex items-center justify-between">
                            {{__('Attachments')}}
                        </h2>
                        <ul class="bg-white border border-gray-200 rounded-b-md divide-y divide-gray-200">
                            @foreach($processedFiles as $file)
                                <li class="flex items-center justify-between px-4 py-3 hover:bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col text-sm">
                                            <a href="{{$file['url']}}">
                                                <span class="font-medium hover:underline text-gray-400 truncate">{{ $file['display'] }}</span>
                                            </a>
                                            @if($file['size'])
                                                <span class="text-gray-500 text-xs">{{ $file['size'] }} KB</span>
                                            @endif
                                        </div>
                                    </div>
                                    <a
                                        href="{{ $file['url'] }}"
                                        download
                                        target="_blank"
                                        class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md text-sm hover:bg-gray-300 hover:text-white transition"
                                    >
                                        {{__('Download')}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif


                @if(now()->lte($job->deadline))
                <section class=" text-white  w-full  text-xs mt-3">
                    <h1 class=" p-2 text-xl w-full flex bg-gray-300">{{__('How to Apply')}}</h1>
                  <section class="text-black text-sm p-6 leading-7">
                      <p >{{__('To apply click on the link below:')}}</p>
                      <a class="underline" href="{{$tender->link}}">{{$tender->link}}</a>
                  </section>
                </section>
            </section>
                @endif

        </section>

        <section class="w-[20%] p-6 rounded-xl h-fit hidden lg:block space-y-4">
            <!-- First Section -->
            @if(now()->lte($job->deadline))
            <section class="bg-white w-full shadow-sm border border-gray-200 rounded-lg p-4">
                <a type="submit" class="bg-secondary text-center cursor-pointer text-white block px-4 py-2 rounded-lg w-full">{{__('Apply Now')}}</a>
            </section>
            @endif

            <!-- Second Section -->


            <!-- Third Section -->
            <section class="bg-white w-full shadow-sm border border-blue-200 rounded-lg p-4 space-y-4">
                @foreach($similar_tenders as $tender)
                    <a href="{{route('jobs.view',['slug'=>$tender->slug])}}" class="flex items-center space-x-4">
                        <!-- Company Logo (Circular) -->
                        <div class="flex-shrink-0">
                            <img
                                src="{{asset('storage').'/'. $tender->company->logo }}"
                            alt="{{ $tender->company_name }} Logo"
                            class="w-12 h-12 rounded-full object-cover"
                            />
                        </div>

                        <!-- Job Title -->
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">{{ $tender->title }}</h1>
                        </div>
                    </a>
                @endforeach
            </section>

        </section>


    </section>
 </x-app-layout>
