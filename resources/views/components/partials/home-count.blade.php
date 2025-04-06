@props(['count', 'title'])

<section {{ $attributes->merge(['class' => 'flex flex-col text-center']) }}>
    <span class="text-4xl sm:text-5xl md:text-6xl font-bold mb-1 sm:mb-2">{{ $count }}</span>
    <h2 class="text-xs sm:text-sm md:text-base font-medium tracking-wide">{{ $title }}</h2>
</section>
