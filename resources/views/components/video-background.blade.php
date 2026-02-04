@props(['source'])

<div class="fixed inset-0 z-0 h-screen w-screen overflow-hidden">
    <video class="absolute inset-0 w-full h-full object-cover blur-md scale-105" autoplay muted loop playsinline>
        <source src="{{ asset($source) }}" type="video/mp4">
    </video>
    <!-- Overlay for readability -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
</div>