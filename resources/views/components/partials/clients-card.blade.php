@props(['path']) <!-- Note the square brackets indicating an array -->

<div class="flex items-center justify-center p-2 md:p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
    <img class="h-auto max-h-12 md:max-h-16 grayscale min:h-12 hover:grayscale-0 transition duration-300"
         src="{{ $path }}"
         alt="Company logo">
</div>
