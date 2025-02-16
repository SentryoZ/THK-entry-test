<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;

/** user screen */
Route::get('/', [TopController::class, 'index'])->name('top');
Route::get('/{prefecture_name_alpha}/hotellist', [HotelController::class, 'showList'])->name('hotelList');
Route::get('/hotel/{hotel_id}', [HotelController::class, 'showDetail'])->name('hotelDetail');

/** admin screen */
Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/', [AdminTopController::class, 'index'])->name('adminTop');

    Route::group([
        'prefix' => 'hotel'
    ], function () {
        Route::get('/search', [AdminHotelController::class, 'showSearch'])->name('adminHotelSearchPage');
        Route::get('/edit', [AdminHotelController::class, 'showEdit'])->name('adminHotelEditPage');
        Route::get('/create', [AdminHotelController::class, 'showCreate'])->name('adminHotelCreatePage');
        Route::post('/search/result', [AdminHotelController::class, 'searchResult'])->name('adminHotelSearchResult');
        Route::post('/edit', [AdminHotelController::class, 'edit'])->name('adminHotelEditProcess');
        Route::post('/create', [AdminHotelController::class, 'create'])->name('adminHotelCreateProcess');
        Route::post('/confirm', [AdminHotelController::class, 'confirm'])->name('adminHotelConfirmProcess');
        Route::post('/confirmEdit', [AdminHotelController::class, 'confirmEdit'])->name('adminHotelConfirmEditProcess');
        Route::post('/delete', [AdminHotelController::class, 'delete'])->name('adminHotelDeleteProcess');

    });
});

