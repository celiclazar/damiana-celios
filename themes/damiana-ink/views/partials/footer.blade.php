<footer class="bg-black text-white py-12 border-t border-gray-900 font-body">
    <div class="container mx-auto px-4 text-center sm:px-16">

        <div class="mb-8">
            <a href="/">
                <img
                    src="/logo.png"
                    alt="Damiana Logo"
                    class="h-12 sm:h-16 mx-auto object-contain hover:opacity-80 transition-opacity"
                >
            </a>
        </div>

        <nav class="flex flex-col sm:flex-row justify-center items-center gap-y-4 sm:gap-x-8 mb-8 text-sm uppercase tracking-widest">
            <a href="/gallery" class="hover:text-gray-400 transition-colors">Gallery</a>
            <a href="/faq" class="hover:text-gray-400 transition-colors">FAQ</a>
            <a href="/terms" class="hover:text-gray-400 transition-colors">Terms</a>
        </nav>

        <div class="flex justify-center gap-x-8 mb-8 text-white">
            <a href="https://www.instagram.com/damiana.inkart/"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Follow us on Instagram"
               class="hover:text-gray-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                </svg>
            </a>
        </div>

        <div class="text-[10px] text-gray-300 uppercase tracking-widest">
            &copy; {{ date('Y') }} All rights reserved by Damiana InkArt
        </div>
    </div>
</footer>
