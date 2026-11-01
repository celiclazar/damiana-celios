<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="48x48" href="/logo.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $page->getTranslation('title', app()->getLocale()) }} | DamianaInkArt</title>
    <meta name="description" content="DamianaInkArt Studio. Explore custom tattoo designs, artistic portfolios, and professional ink services by Damiana.">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Gotu&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&display=swap" rel="stylesheet">

    <!-- GLightbox CSS za Galeriju -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    {{-- Tailwind & Alpine --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        heading: ['"Be Vietnam Pro"', 'sans-serif'],
                        about: ['Gotu', 'sans-serif'],
                        body: ['Montserrat', 'sans-serif'],
                        button: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        dimgray: '#696969',
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        html, body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
        }

        .font-heading {
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 500;
        }
        .font-body {
            font-family: 'Montserrat', sans-serif;
        }
        .font-about {
            font-family: 'Gotu', sans-serif;
        }
        .font-button {
            font-family: 'Montserrat', sans-serif;
        }

        /* 1. Default Mobile Styles (Whole, Fixed Image) */
        .hero-img {
            object-fit: contain; /* Shows the whole image without cropping */
            transform: scale(1) !important; /* Forces it to stay fixed/no zoom */
            animation: none !important;
        }

        /* 2. Desktop Styles (Zoomed/Cinematic Look) */
        @media (min-width: 1024px) {
            .hero-img {
                object-fit: cover; /* Fills the screen beautifully on desktop */
                animation: slowZoom 20s infinite alternate ease-in-out;
            }
        }

        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }

        .move-up {
            background-color: transparent;
        }

        @media only screen and (max-width: 768px) {
            .move-up {
                width: 100%;
                height: 100%;
                background-color: transparent;
                position: relative;
                margin: -80px 0 50px 0;
            }
        }

        @media only screen and (min-width: 768px) {
            .move-up {
                width: 100%;
                height: 100%;
                background-color: transparent;
                position: relative;
                margin: -180px 0 50px 0;
            }
        }

        input::placeholder, textarea::placeholder {
            color: #b3b3b3;
            font-family: Montserrat, sans-serif;
            font-size: 1rem;
            font-style: italic;
        }

        input:hover::placeholder, textarea:hover::placeholder {
            color: white;
        }

        .booking-input {
            background-color: transparent;
            border: 1px solid #767676;
            padding: 1rem;
            border-radius: 0.25rem;
            color: white;
            width: 100%;
        }

        .booking-input:focus {
            outline: none !important;
            background-color: transparent;
            border-radius: 10px;
            border-color: #767676;
            transition: all 0.4s ease 50ms;
            color: white;
        }

        .date-dark-input {
            padding: 10px;
            cursor: pointer;
            background: transparent;
            width: 200px;
            color: #cccccc;
        }

        .underline-input {
            border: none;
            border-bottom: 1px solid #767676;
            background: transparent;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .underline-input:hover {
            border-bottom-color: white;
            color: white;
        }

        /* Custom slim scrollbar from ImageModal */
        .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* GLightbox dark theme */
        .goverlay {
            background: rgba(0, 0, 0, 0.95) !important;
        }
    </style>
</head>
<body class="bg-black text-white antialiased min-h-screen selection:bg-white selection:text-black">

<div class="min-h-screen flex flex-col bg-black">
    <!-- Absolute navigation -->
    <div class="absolute w-full z-20">
        @include('partials.nav', ['currentPage' => $page])
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @if(!empty($content) && is_array($content))
            @foreach($content as $block)
                @includeIf('components.blocks.' . $block['type'], ['data' => $block['data'], 'page' => $page])
            @endforeach
        @endif
    </main>

    <!-- Footer -->
    @include('partials.footer')
</div>

<!-- GLightbox JS -->
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof GLightbox !== 'undefined') {
            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                zoomable: true
            });
        }
    });
</script>
</body>
</html>
