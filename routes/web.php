<?php

Route::group(['prefix' => 'integrations'], function () {
    //Route::any('/', [\Mind4me\Bx24_integration\Controllers\IndexController::class, 'index'])->name('integrations.index');
    Route::any('index', [\Mind4me\Bx24_integration\Controllers\IndexController::class, 'auth'])->name('integrations.auth');
    Route::any('install', [\Mind4me\Bx24_integration\Controllers\IndexController::class, 'install'])->name('integrations.install');
});
