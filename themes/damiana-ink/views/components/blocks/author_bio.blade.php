@php
    $locale = app()->getLocale();

    $get = function($field, $default = '') use ($data, $locale) {
        if (!isset($data[$field])) return $default;
        if (is_array($data[$field])) {
            return $data[$field][$locale] 
                ?? $data[$field]['en'] 
                ?? $data[$field]['sr'] 
                ?? $default;
        }
        return $data[$field] ?: $default;
    };

    $circleImageUrl = $data['avatar_url'] ?? $data['circleImageUrl'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80';
@endphp

<section class="bg-black text-white py-12 sm:py-28" x-data="{ isExpanded: false }">
    <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center justify-center">
        <!-- Decorative circle -->
        <div
            class="rounded-full w-48 h-48 sm:w-64 sm:h-64 mb-8 lg:mb-0 lg:mr-20 shrink-0 bg-cover bg-center bg-white"
            style="background-image: url('{{ $circleImageUrl }}');"
        ></div>

        <div class="text-left flex flex-col lg:max-w-md">
            <div class="text-center lg:text-left">
                <h2 class="font-heading text-4xl mb-6">About me</h2>
            </div>

            <div>
                <p class="mb-4 font-body text-left">
                    Hey stranger, I'm Damiana - a painter, a tattoo artist and the hands behind CRUCIO studio!
                    I've been drawing literally my whole life, I went to college at the Academy of arts where I studied painting and shortly after that I realised that tattoos are my medium.
                    My mission is to create something  that was always meant to grow on your skin.
                </p>
            </div>

            <div>
                <div x-show="!isExpanded"
                     @click="isExpanded = true"
                     class="text-center sm:text-right py-8">
                    <p class="inline-block px-2 sm:px-6 py-1 border border-gray-100 text-gray-100 font-button uppercase tracking-wide hover:bg-gray-100 hover:text-black transition-colors duration-300 cursor-pointer">Read More &raquo;</p>
                </div>

                <div x-show="isExpanded"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     style="display: none;">
                    <h2 class="font-heading text-2xl mt-6">My story</h2>
                    <p class="mb-4 font-body text-left">
                        Art has always been my language.
                        Before tattooing, I painted - exploring dark textures, the emotional weight of organic forms, and energy of symmetry and patterns that create and unify all things, so  tattooing became the natural extension of that world.

                        My style is rooted in - dark organic forms and flowing compositions that move with the body, textures inspired by nature, dark ornaments that emphasize symmetry, geometry and flowing patterns that complement the anatomy of the body.
                        I'm drawn to pieces that are not just illustrations placed on the skin, but designs that grow with your anatomy.
                    </p>
                    <h2 class="font-heading text-2xl mt-6">My Process</h2>
                    <p class="font-body mt-4">
                        Consultations - everything begins with conversation.
                        You can come with a clear idea, or just a feeling. Understanding your energy and intention helps me design something that truly belongs to you.
                        If needed, I may suggest adjustments for better composition, and long term healing.
                    </p>
                    <p class="font-body mt-4">
                        Custom design or freehand - every design is created from scratch.
                        I study your anatomy, natural movement, and how the tattoo will interact with curves and joints.
                        I don't copy other artists work, I may reinterpret references that you bring to me through my style but the final piece is always original and designed specifically for you.
                        For larger projects, I sometimes build the composition directly on the body to ensure the perfect flow.
                    </p>
                    <p class="font-body mt-4">
                        Tattoo session - this is where the idea becomes permanent, and it's the most intimate part of the process.
                        Before we start - we check everything, adjust the size or make some small changes, we place the stencil or draw a freehand design directly on the skin, and then we are good to go when you are fully comfortable.
                        You can bring the music you love, we can work in silence or we can chat, every session is diferent depending on the person and moment. During the session you can always ask for a break!
                        When your new tattoo is done, we wrap it up properly, I walk you through the aftercare, and answer any final questions that you might have.
                        It is very welcome that you send me updates during your healing process, and of course - pictures of your fully healed tattoo!
                    </p>

                    <div @click="isExpanded = false" class="py-8 text-center sm:text-right">
                        <p class="inline-block px-2 sm:px-6 py-1 border border-gray-100 text-gray-100 font-button uppercase tracking-wide hover:bg-gray-100 hover:text-black transition-colors duration-300 cursor-pointer">
                            &laquo; Show Less
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
