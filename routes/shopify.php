<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\FakeDataController;

Route::get('/', function (Request $request) {
    return Inertia::render('Welcome', [
        'hasApiKey' => config()->has('shopify-app.api_key'),
        'hasPremium' => $request->user()->plan?->price > 0,
    ]);
})->name('home');

Route::apiResource('/fake-data', FakeDataController::class)->only(['store', 'destroy']);

Route::apiResource('/premium', PremiumController::class)->only(['index', 'store', 'destroy']);
