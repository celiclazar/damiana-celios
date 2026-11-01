@php
    $locale = app()->getLocale();
    $items = $data['items'] ?? [];
@endphp

<section class="bg-black text-white py-24 mt-6">
    <div class="container mx-auto px-4 max-w-3xl">
        <h1 class="text-4xl font-heading text-center mb-12 uppercase tracking-wider">
            FAQ
        </h1>

        <div class="divide-y divide-gray-800" x-data="{ activeIndex: null }">
            @foreach($items as $index => $item)
                @php
                    $q = is_array($item['question'] ?? null) 
                        ? ($item['question'][$locale] ?? $item['question']['en'] ?? $item['question']['sr'] ?? '') 
                        : ($item['question'] ?? '');
                    $a = is_array($item['answer'] ?? null) 
                        ? ($item['answer'][$locale] ?? $item['answer']['en'] ?? $item['answer']['sr'] ?? '') 
                        : ($item['answer'] ?? '');
                @endphp
                <div class="py-2">
                    <button
                        @click="activeIndex = activeIndex === {{ $index }} ? null : {{ $index }}"
                        type="button"
                        class="w-full flex justify-between items-center py-6 text-left group focus:outline-none cursor-pointer"
                    >
                        <h2 class="font-heading text-lg md:text-xl uppercase transition-colors duration-300"
                            :class="activeIndex === {{ $index }} ? 'text-white' : 'text-gray-400 group-hover:text-white'">
                            {{ $q }}
                        </h2>
                        <span class="ml-4 text-2xl transition-transform duration-500 ease-in-out"
                              :class="{ 'rotate-45 text-white': activeIndex === {{ $index }}, 'text-gray-500': activeIndex !== {{ $index }} }">
                            +
                        </span>
                    </button>

                    <div x-show="activeIndex === {{ $index }}"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-[500px]"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-[500px]"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden"
                         style="display: none;">
                        <p class="pb-8 font-body text-gray-400 leading-relaxed text-left max-w-2xl">
                            {!! nl2br(e($a)) !!}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@php
    $schemaFaq = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($items)->map(function ($item) use ($locale) {
            $q = is_array($item['question'] ?? null) 
                ? ($item['question'][$locale] ?? $item['question']['en'] ?? $item['question']['sr'] ?? '') 
                : ($item['question'] ?? '');
            $a = is_array($item['answer'] ?? null) 
                ? ($item['answer'][$locale] ?? $item['answer']['en'] ?? $item['answer']['sr'] ?? '') 
                : ($item['answer'] ?? '');
            return [
                '@type' => 'Question',
                'name' => trim(strip_tags((string) $q)),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => trim(strip_tags((string) $a)),
                ],
            ];
        })->filter(fn ($item) => !empty($item['name']) && !empty($item['acceptedAnswer']['text']))->values()->all(),
    ];
@endphp

@if(!empty($schemaFaq['mainEntity']))
<script type="application/ld+json">
{!! json_encode($schemaFaq, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
