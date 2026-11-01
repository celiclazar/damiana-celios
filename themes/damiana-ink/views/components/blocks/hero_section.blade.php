@php
    $slides = [];

    // Resolve selected image(s) from Curator (background_image_id or images)
    $rawIds = $data['background_image_id'] ?? $data['images'] ?? [];
    if (!empty($rawIds)) {
        $ids = (array) $rawIds;
        $mediaClass = config('curator.model', \App\Models\Media::class);
        $mediaRecords = $mediaClass::whereIn('id', $ids)->get();

        // Preserve exact selection order from Filament
        foreach ($ids as $id) {
            $m = $mediaRecords->firstWhere('id', $id);
            if ($m && ($m->url ?? $m->signedUrl)) {
                $slides[] = $m->url ?? $m->signedUrl;
            }
        }
    }
@endphp

<!-- Image Header Section -->
<section
    x-data="{
        currentIndex: 0,
        images: {{ json_encode(array_values($slides)) }},
        init() {
            if (this.images.length > 1) {
                setInterval(() => {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                }, 3500);
            }
        }
    }"
    class="relative w-full h-[50vh] lg:h-screen min-h-[300px] bg-black overflow-hidden"
>
    <template x-for="(image, index) in images" :key="index">
        <div
            x-show="index === currentIndex"
            x-transition:enter="transition-opacity duration-1000 ease-in-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-1000 ease-in-out"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full flex items-center justify-center"
        >
            <img
                :src="image"
                class="hero-img w-full h-full block"
                alt="Header"
            >
        </div>
    </template>

    <div class="absolute inset-0 bg-black/40 pointer-events-none"></div>
</section>

<!-- Main Header Section (Overlapping Move Up) -->
<div class="move-up">
    <div class="h-full flex flex-col justify-end items-center">
        <div class="font-heading text-center lg:mb-20">
            <div class="py-8">
                <a href="#booking" class="inline-block px-2 sm:px-6 py-1 border border-gray-100 text-gray-100 font-button uppercase tracking-wide hover:bg-gray-100 hover:text-black transition-colors duration-300">Book Now &raquo;</a>
            </div>
            <div class="pt-4 pb-">
                <img src="/icons/location.png" class="m-auto h-4" alt="Location Pin Icon">
                <p class="text-sm text-gray-400 mt-2">Novi Sad, Serbia</p>
            </div>
        </div>
    </div>
</div>
