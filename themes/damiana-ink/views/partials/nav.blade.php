<!-- Navigation Header -->
<div x-data="{ menuOpen: false }">
    <nav class="absolute top-0 w-full flex items-center justify-between p-6 bg-black bg-opacity-75 z-30">
        <!-- Left Section for Hamburger Menu -->
        <div class="block flex-1">
            <button @click="menuOpen = !menuOpen" type="button" aria-label="Toggle navigation" class="flex items-center px-3 py-2 text-white hover:text-white focus:outline-none cursor-pointer">
                <svg class="fill-current h-6 w-6 visible hover:cursor-pointer" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0,3 L20,3 L20,4 L0,4 L0,3 Z M0,9 L20,9 L20,10 L0,10 L0,9 Z M0,15 L20,15 L20,16 L0,16 L0,15 Z"></path>
                </svg>
            </button>
        </div>
        <!-- Center Section for Logo -->
        <div class="flex-1 flex justify-center">
            <a href="/" class="flex items-center">
                <img
                    src="/logo.png"
                    alt="Damiana Ink Art Logo"
                    class="h-10 sm:h-12 md:h-16 w-auto object-contain transition-all duration-300"
                >
            </a>
        </div>
        <!-- Right Section as Spacer -->
        <div class="flex-1"></div>
    </nav>

    <!-- Menu Overlay -->
    <div x-show="menuOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black bg-opacity-100 flex flex-col items-center z-50"
         style="display: none;">
        <div class="text-white text-center transform translate-y-28">
            <div class="flex justify-center">
                <img
                    src="/logo.png"
                    class="h-24 sm:h-32 md:h-40 w-auto object-contain pb-8"
                    alt="Logo"
                >
            </div>
            <div>
                <button @click="menuOpen = false" type="button" aria-label="Close menu" class="mb-6 focus:outline-none cursor-pointer">
                    <svg class="h-8 w-8 text-white visible hover:cursor-pointer" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <title>Close menu</title>
                        <path d="M10 10 L30 30" stroke="currentColor" stroke-width="2"/>
                        <path d="M30 10 L10 30" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
            </div>
            <div>
                <ul class="font-heading text-4xl space-y-6">
                    <li><a href="/" @click="menuOpen = false" class="hover:text-gray-300">HOME</a></li>
                    <li><a href="/gallery" @click="menuOpen = false" class="hover:text-gray-300">GALLERY</a></li>
                    <li><a href="/faq" @click="menuOpen = false" class="hover:text-gray-300">FAQ</a></li>
                    <li><a href="/terms" @click="menuOpen = false" class="hover:text-gray-300">TERMS</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
