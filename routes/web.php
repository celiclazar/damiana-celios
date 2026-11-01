<?php

use Celios\Core\Enums\PageType;
use Celios\Core\Http\Controllers\CmsPageController;
use Celios\Core\Models\Page;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Direct aliases for Damiana's pages
Route::get('/gallery', [CmsPageController::class, 'fallback']);
Route::get('/faq', [CmsPageController::class, 'fallback']);

Route::get('/terms', function () {
    $page = Page::findByType(PageType::TERMS_AND_CONDITIONS);
    if (! $page) {
        abort(404);
    }

    return view('cms.render', [
        'page' => $page,
        'content' => $page->content,
        'activeRevision' => null,
    ]);
});

Route::get('/terms-and-conditions', function () {
    $page = Page::findByType(PageType::TERMS_AND_CONDITIONS);
    if (! $page) {
        abort(404);
    }

    return view('cms.render', [
        'page' => $page,
        'content' => $page->content,
        'activeRevision' => null,
    ]);
});
