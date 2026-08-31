<?php

use Illuminate\Support\Facades\Route;
Route::get('/test-exception', fn() => throw new \Exception('Test error'));
Route::get('/test-404', fn() => \Domains\User\Models\Admin::findOrFail(9999));
