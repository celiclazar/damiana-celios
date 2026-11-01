<?php

namespace Database\Seeders;

use Celios\Core\Enums\PageType;
use Celios\Core\Models\Page;
use Illuminate\Database\Seeder;

class SystemPagesSeeder extends Seeder
{
    public function run(): void
    {
        $systemTypes = PageType::systemTypes();

        foreach ($systemTypes as $type) {
            $existing = Page::findByType($type);

            if (! $existing) {
                Page::create([
                    'type' => $type,
                    'title' => $type->defaultTitles(),
                    'slug' => $type->standardSlugs(),
                    'is_visible' => true,
                    'content' => [
                        [
                            'type' => 'text_block',
                            'data' => [
                                'body' => [
                                    'sr' => "<p>Sadržaj za {$type->defaultTitle('sr')} biće uskoro ažuriran.</p>",
                                    'en' => "<p>Content for {$type->defaultTitle('en')} will be updated soon.</p>",
                                    'it' => "<p>Il contenuto per {$type->defaultTitle('it')} sarà aggiornato a breve.</p>",
                                ],
                            ],
                        ],
                    ],
                ]);
            }
        }
    }
}
