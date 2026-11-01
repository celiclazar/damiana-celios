<?php

namespace App\Console\Commands;

use App\Models\Media;
use Celios\Core\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportDamianaImages extends Command
{
    protected $signature = 'damiana:import-images';
    protected $description = 'Import Damiana images from staging json and files into Curator and connect to pages';

    public function handle(): int
    {
        $jsonPath = storage_path('app/import/damiana-images.json');
        if (! File::exists($jsonPath)) {
            $this->error("JSON file not found at: {$jsonPath}");
            return 1;
        }

        $items = json_decode(File::get($jsonPath), true);
        if (! is_array($items)) {
            $this->error("Failed to decode JSON from: {$jsonPath}");
            return 1;
        }

        $this->info("Found " . count($items) . " gallery items in JSON.");

        // Clear existing dummy Unsplash media
        $deleted = Media::where('path', 'like', 'http%unsplash%')->delete();
        $this->info("Removed {$deleted} legacy placeholder media records.");

        $galleryUuids = [];
        $previewTattooUuids = [];

        // Sort items: tattoos first by order, then sketches by order
        usort($items, function ($a, $b) {
            $typeComp = strcmp($a['type'] ?? '', $b['type'] ?? '');
            if ($typeComp !== 0) {
                // 'tattoo' before 'sketch'
                return ($a['type'] === 'tattoo') ? -1 : 1;
            }
            return (int)($a['order'] ?? 0) <=> (int)($b['order'] ?? 0);
        });

        foreach ($items as $item) {
            $filePath = $item['file_path']; // e.g. "gallery/MjyT90mp4v7LiLXUwkET.webp"
            $fullPath = storage_path("app/public/{$filePath}");

            $width = 1400;
            $height = 1050;
            $size = 100 * 1024;

            if (File::exists($fullPath)) {
                $imageSize = @getimagesize($fullPath);
                if ($imageSize) {
                    $width = $imageSize[0];
                    $height = $imageSize[1];
                }
                $size = File::size($fullPath);
            } else {
                $this->warn("File missing on disk: {$fullPath}");
            }

            $name = Str::slug($item['title'] ?: basename($filePath, '.webp'));
            $title = $item['title'] ?: 'Tattoo Artwork';
            $alt = $item['alt'] ?: $title;
            $type = $item['type'] ?: 'tattoo';

            // Find or create Media
            $media = Media::updateOrCreate(
                ['path' => $filePath],
                [
                    'disk' => 'public',
                    'directory' => 'gallery',
                    'visibility' => 'public',
                    'name' => $name,
                    'width' => $width,
                    'height' => $height,
                    'size' => $size,
                    'type' => 'image/webp',
                    'ext' => 'webp',
                    'alt' => $alt,
                    'title' => $title,
                    'description' => $item['description'] ?? '',
                    'caption' => $type, // tattoo or sketch
                ]
            );

            $this->line("<fg=green>Imported media:</> [{$type}] {$title} ({$media->id})");
            $galleryUuids[] = (string) $media->id;

            if ($type === 'tattoo' && ! empty($item['is_preview'])) {
                $previewTattooUuids[] = (string) $media->id;
            }
        }

        // Import author bio avatar
        $aboutPath = 'background/aboutCircle_oWy7g.webp';
        $fullAboutPath = storage_path("app/public/{$aboutPath}");
        if (File::exists($fullAboutPath)) {
            $aboutSize = @getimagesize($fullAboutPath);
            Media::updateOrCreate(
                ['path' => $aboutPath],
                [
                    'disk' => 'public',
                    'directory' => 'background',
                    'visibility' => 'public',
                    'name' => 'damiana-portrait',
                    'width' => $aboutSize ? $aboutSize[0] : 600,
                    'height' => $aboutSize ? $aboutSize[1] : 600,
                    'size' => File::size($fullAboutPath),
                    'type' => 'image/webp',
                    'ext' => 'webp',
                    'alt' => 'Damiana — Painter & Tattoo Artist',
                    'title' => 'Damiana Portrait',
                    'description' => 'Damiana founder and artist behind DamianaInkArt Studio.',
                    'caption' => 'about',
                ]
            );
            $this->info("Imported author portrait media: {$aboutPath}");
        }

        // Import Hero header slides
        $heroSlides = [
            '/storage/background/image_header_section/6ZOxmIHhCLIfXfaRyxd4.webp',
            '/storage/background/image_header_section/PJ6JWWcUh3X7Vk0ueIwZ.webp',
            '/storage/background/image_header_section/Yhq7HKyaMgA35UQWWmin.webp',
            '/storage/background/image_header_section/aO1mPG8RFA8zL2Q6zO3w.webp',
            '/storage/background/image_header_section/home_background.jpg',
        ];

        // -------------------------------------------------------------
        // Update Page #5 (Gallery Full Page)
        // -------------------------------------------------------------
        $galleryPage = Page::find(5);
        if ($galleryPage) {
            $content = $galleryPage->content ?: [];
            foreach ($content as &$block) {
                if ($block['type'] === 'gallery_block') {
                    $block['data']['images'] = $galleryUuids;
                }
            }
            $galleryPage->content = $content;
            $galleryPage->save();
            $this->info("Updated Page #5 (Gallery) with " . count($galleryUuids) . " media items.");
        }

        // -------------------------------------------------------------
        // Update Page #1 (Home Page)
        // -------------------------------------------------------------
        $homePage = Page::find(1);
        if ($homePage) {
            $content = $homePage->content ?: [];
            foreach ($content as &$block) {
                if ($block['type'] === 'hero_section') {
                    $block['data']['slides'] = $heroSlides;
                }
                if ($block['type'] === 'author_bio') {
                    $block['data']['avatar_url'] = '/storage/background/aboutCircle_oWy7g.webp';
                }
                if ($block['type'] === 'gallery_block') {
                    // Preview top 6 tattoos
                    $block['data']['images'] = array_slice($previewTattooUuids, 0, 6);
                }
            }
            $homePage->content = $content;
            $homePage->save();
            $this->info("Updated Page #1 (Home) with real hero slides, avatar, and top 6 preview tattoos.");
        }

        $this->info("Migration completed successfully!");
        return 0;
    }
}
