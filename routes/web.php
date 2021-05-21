<?php

use Illuminate\Support\Facades\Route;
use Mach3builders\PrivateLabel\Http\Controllers\PrivateLabelController;

// Private label
Route::prefix('app')->middleware('web')->group(function(){
    Route::get('private-label/{owner_id}', [PrivateLabelController::class, 'index'])->name('private-label.index');
    Route::patch('private-label/{owner_id}', [PrivateLabelController::class, 'update'])->name('private-label.update');

    Route::get('private-label/{owner_id}/poll', [PrivateLabelController::class, 'poll'])->name('private-label.check-status');
    Route::get('private-label/{owner_id}/delete-media/{media}', [PrivateLabelController::class, 'deleteMedia'])->name('private-label.delete-media');
});
