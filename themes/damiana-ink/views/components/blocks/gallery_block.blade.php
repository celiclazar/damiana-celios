@php
    $isHomePage = (isset($page) && $page->type === \Celios\Core\Enums\PageType::HOME->value) 
        || request()->is('/') 
        || request()->is('sr') 
        || request()->is('en')
        || !empty($data['is_preview']);

    // Fetch images from Curator if media IDs are provided
    $allImages = [];
    $rawImages = $data['images'] ?? [];

    if (!empty($rawImages)) {
        $mediaClass = config('curator.model', \App\Models\Media::class);
        $mediaRecords = $mediaClass::whereIn('id', (array)$rawImages)->get();
        
        // Preserve order if IDs were ordered
        foreach ((array)$rawImages as $imgId) {
            $m = $mediaRecords->firstWhere('id', $imgId);
            if ($m) {
                $allImages[] = [
                    'id' => $m->id,
                    'url' => $m->url,
                    'title' => $m->title ?: 'Tattoo Artwork',
                    'alt' => $m->alt ?: 'Tattoo artwork by Damiana',
                    'description' => $m->description ?: $m->alt ?: '',
                    'type' => $m->caption ?: 'tattoo',
                ];
            }
        }
    }

    $tattoosOnly = array_values(array_filter($allImages, fn($i) => ($i['type'] ?? 'tattoo') === 'tattoo'));
    $sketchesOnly = array_values(array_filter($allImages, fn($i) => ($i['type'] ?? '') === 'sketch'));
@endphp

<div x-data="{
    modalOpen: false,
    currentFilter: 'tattoo',
    currentIndex: 0,
    allImages: {{ json_encode($allImages) }},
    get currentList() {
        if (this.currentFilter === 'tattoo') {
            return this.allImages.filter(img => (img.type || 'tattoo') === 'tattoo');
        }
        if (this.currentFilter === 'sketch') {
            return this.allImages.filter(img => img.type === 'sketch');
        }
        return this.allImages;
    },
    get activeImage() {
        return this.currentList[this.currentIndex] || this.currentList[0] || null;
    },
    openModal(index, filter = null) {
        if (filter) this.currentFilter = filter;
        this.currentIndex = index;
        this.modalOpen = true;
    },
    next() {
        this.currentIndex = (this.currentIndex + 1) % this.currentList.length;
    },
    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.currentList.length) % this.currentList.length;
    }
}" @keydown.right.window="if (modalOpen) next()" @keydown.left.window="if (modalOpen) prev()">

@if($isHomePage)
    <!-- HOMEPAGE GALLERY PREVIEW -->
    <div class="bg-black text-white py-12">
        <div class="container mx-auto px-4" style="max-width: 1200px;">
            <h2 class="font-heading text-4xl mb-6 text-center">Gallery</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                @foreach(array_slice($tattoosOnly, 0, 6) as $index => $image)
                    <div class="overflow-hidden rounded-2xl cursor-pointer"
                         @click="openModal({{ $index }}, 'tattoo')">
                        <img src="{{ $image['url'] }}" 
                             alt="{{ $image['alt'] ?? 'Gallery preview' }}" 
                             loading="lazy"
                             class="w-full h-auto transform transition duration-500 hover:scale-110 rounded-2xl grayscale">
                    </div>
                @endforeach
            </div>
            <div class="text-center pt-4">
                <a href="/gallery" class="inline-block right-0 px-6 py-1 border border-gray-100 text-gray-100 font-button uppercase tracking-wide hover:bg-gray-100 hover:text-black transition-colors duration-300">View More &raquo;</a>
            </div>
        </div>
    </div>
@else
    <!-- GALLERY FULL PAGE -->
    <section class="bg-black text-white py-24 mt-6">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-heading text-center mb-12">Gallery</h2>
            
            <!-- Category Filter Tabs -->
            <div class="flex justify-center mb-8">
                <button @click="currentFilter = 'tattoo'; currentIndex = 0" 
                        type="button"
                        class="bg-transparent font-body border-none text-white mr-2 p-2 hover:underline cursor-pointer"
                        :class="{ 'underline font-bold': currentFilter === 'tattoo' }">
                    Tattoos
                </button>
                <button @click="currentFilter = 'sketch'; currentIndex = 0" 
                        type="button"
                        class="bg-transparent font-body border-none text-white p-2 hover:underline cursor-pointer"
                        :class="{ 'underline font-bold': currentFilter === 'sketch' }">
                    Available sketches
                </button>
            </div>

            <!-- Image Grid -->
            <div class="sm:w-2/3 mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    <template x-for="(image, index) in currentList" :key="image.id || index">
                        <div class="overflow-hidden rounded-xl">
                            <img
                                :src="image.url"
                                :alt="image.alt"
                                :title="image.title"
                                loading="lazy"
                                class="w-full h-48 md:h-64 object-cover mx-auto rounded-xl cursor-pointer hover:scale-105 transition-transform duration-500"
                                @click="openModal(index)"
                            >
                            <span class="sr-only" x-text="image.description"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
@endif

    <!-- CUSTOM STUDIO IMAGE MODAL (Exact match with ImageModal.vue) -->
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-md p-2 md:p-6"
         @keydown.escape.window="modalOpen = false"
         @click.self="modalOpen = false"
         style="display: none;">
        
        <div class="relative w-full max-w-7xl h-[95vh] md:h-[80vh] border border-white/10 bg-black shadow-2xl overflow-hidden rounded-md flex flex-col justify-between">

            <!-- Split Content -->
            <div class="flex flex-col md:flex-row h-full w-full p-4 md:p-8 gap-4 md:gap-10 items-stretch relative min-h-0">
                
                <!-- Left: Full Image (object-contain in centered box) -->
                <div class="w-full h-[55%] md:h-auto md:flex-[1.8] flex items-center justify-center min-h-0 bg-zinc-900/20 rounded overflow-hidden relative">
                    <img :src="activeImage ? activeImage.url : ''" 
                         :alt="activeImage ? activeImage.alt : ''" 
                         class="w-full h-full object-contain transition-opacity duration-300">
                    
                    <!-- Prev / Next arrows over image -->
                    <button @click="prev()" 
                            type="button" 
                            aria-label="Previous artwork"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-white/60 hover:text-white p-2.5 bg-black/50 hover:bg-black/80 rounded-full transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="next()" 
                            type="button" 
                            aria-label="Next artwork"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-white/60 hover:text-white p-2.5 bg-black/50 hover:bg-black/80 rounded-full transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <!-- Right: Information & Description -->
                <div class="w-full h-[45%] md:h-auto md:flex-1 flex flex-col justify-start md:justify-center text-white min-h-0 py-2">
                    <h2 class="text-xl md:text-3xl font-heading font-bold mb-2 md:mb-4 flex-shrink-0 border-b border-white/10 pb-2"
                        x-text="activeImage ? activeImage.title : ''">
                    </h2>

                    <div class="overflow-y-auto pr-2 custom-scrollbar flex-grow">
                        <p class="text-sm md:text-base opacity-90 font-body leading-relaxed text-gray-300"
                           x-text="activeImage ? (activeImage.description || activeImage.alt) : ''">
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bottom Pagination Indicators -->
            <div class="flex justify-center items-center gap-1.5 pb-3 z-10">
                <template x-for="(img, idx) in currentList" :key="img.id || idx">
                    <button @click="currentIndex = idx" 
                            type="button"
                            :aria-label="'Go to image ' + (idx + 1)"
                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                            :class="currentIndex === idx ? 'w-5 bg-white' : 'w-1.5 bg-white/30 hover:bg-white/60'">
                    </button>
                </template>
            </div>

            <!-- Close Button (X) in Top-Right Corner -->
            <button
                @click="modalOpen = false"
                type="button"
                aria-label="Close modal"
                class="absolute top-2 right-2 z-20 text-white/40 hover:text-white transition-colors p-2 bg-black/50 rounded-full cursor-pointer"
            >
                <span class="text-xl leading-none">✕</span>
            </button>
        </div>
    </div>

</div>
