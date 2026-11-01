<?php

namespace App\Models;

use Awcodes\Curator\Facades\Curator;
use Celios\Core\Models\Media as CeliosMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Media extends CeliosMedia
{
    public function url(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (empty($this->path)) {
                    return '';
                }
                if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
                    return $this->path;
                }
                return Storage::disk($this->disk ?? 'public')->url($this->path);
            }
        );
    }

    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (empty($this->path)) {
                    return '';
                }
                if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
                    return $this->path;
                }

                // If pre-generated thumbnail exists in gallery/thumbs/
                $thumbPath = str_replace('gallery/', 'gallery/thumbs/', $this->path);
                if ($thumbPath !== $this->path && Storage::disk($this->disk ?? 'public')->exists($thumbPath)) {
                    return Storage::disk($this->disk ?? 'public')->url($thumbPath);
                }

                try {
                    return Curator::getUrlProvider()::getThumbnailUrl($this->path);
                } catch (\Throwable $e) {
                    return Storage::disk($this->disk ?? 'public')->url($this->path);
                }
            }
        );
    }

    public function mediumUrl(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (empty($this->path)) {
                    return '';
                }
                if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
                    return $this->path;
                }
                try {
                    return Curator::getUrlProvider()::getMediumUrl($this->path);
                } catch (\Throwable $e) {
                    return Storage::disk($this->disk ?? 'public')->url($this->path);
                }
            }
        );
    }

    public function largeUrl(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (empty($this->path)) {
                    return '';
                }
                if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
                    return $this->path;
                }
                try {
                    return Curator::getUrlProvider()::getLargeUrl($this->path);
                } catch (\Throwable $e) {
                    return Storage::disk($this->disk ?? 'public')->url($this->path);
                }
            }
        );
    }
}
