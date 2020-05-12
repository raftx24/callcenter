<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('calls.')->group(function () {
    Route::post('/call/start', 'CallController@start')
        ->name('start');

    Route::put('/call/{call}/end', 'CallController@end')
        ->name('end');

    Route::put('/call/{support}/answer', 'CallController@answer')
        ->name('answer');
});
