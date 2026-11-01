@php
    $locale = app()->getLocale();
    $body = $data['body'][$locale] 
        ?? $data['body']['en'] 
        ?? $data['body']['sr'] 
        ?? (is_string($data['body'] ?? null) ? $data['body'] : null);
@endphp

<section class="bg-black text-white py-24 mt-6 min-h-screen">
    <div class="container mx-auto px-4 max-w-3xl">

        <header class="mb-16">
            <h1 class="text-4xl font-heading text-center tracking-widest">
                Terms & Privacy
            </h1>
            <div class="w-24 h-1 bg-white mx-auto mt-4"></div>
        </header>

        @if(!empty($body) && !str_contains($body, 'Studio Policies'))
            <div class="space-y-8 font-body text-gray-400 leading-relaxed text-lg prose prose-invert max-w-none">
                {!! $body !!}
            </div>
        @else
            <div class="space-y-12 font-body text-gray-400 leading-relaxed text-lg">

                <section>
                    <p class="text-white italic">
                        Welcome to DamianaInkArt. This site serves as an online gallery and a point of contact for our studio. By browsing this site, you agree to the following terms:
                    </p>
                </section>

                <section>
                    <h2 class="font-heading text-2xl text-white mb-4 tracking-wider">
                        1. Website Content (Gallery)
                    </h2>
                    <p>
                        All images and tattoo designs displayed in the gallery are the intellectual property of
                        <span class="text-white font-bold">DamianaInkArt</span>. These images are for viewing purposes only and may not be copied, redistributed, or used for commercial purposes without our explicit permission.
                    </p>
                </section>

                <section class="bg-gray-900/30 p-8 rounded-2xl border border-gray-800">
                    <h2 class="font-heading text-2xl text-white mb-6 tracking-wider">
                        2. Contact Form & Your Data (GDPR)
                    </h2>
                    <p class="mb-6 text-white font-medium">
                        We respect your privacy. Here is how we handle the information you provide:
                    </p>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <span class="text-white">●</span>
                            <span><strong class="text-white">No Data Storage:</strong> We do not store your personal information in a database on this website.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-white">●</span>
                            <span><strong class="text-white">Email Transmission:</strong> Data is sent directly via encrypted email so we can respond to your inquiry.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-white">●</span>
                            <span><strong class="text-white">Confirmation:</strong> A copy is sent to you as a record of your message.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-white">●</span>
                            <span><strong class="text-white">Usage:</strong> We never share your data with third parties or use it for marketing.</span>
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-heading text-2xl text-white mb-4 tracking-wider">
                        3. Informational Purpose
                    </h2>
                    <p>
                        The content on this website is for general information only. While we showcase our work, all final consultations regarding tattoos and designs happen <span class="text-white underline decoration-gray-600 underline-offset-4">directly with the artist</span>.
                    </p>
                </section>

                <section>
                    <h2 class="font-heading text-2xl text-white mb-4 tracking-wider">
                        4. Cookies
                    </h2>
                    <p>
                        This website uses minimal cookies necessary for its basic functionality and to ensure the contact form works correctly.
                    </p>
                </section>

            </div>
        @endif

        <footer class="mt-20 pt-8 border-t border-gray-900 text-center text-sm text-gray-600">
            Last updated: {{ date('d/m/Y') }}
        </footer>
    </div>
</section>
