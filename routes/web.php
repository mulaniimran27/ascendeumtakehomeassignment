<?php

use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampaignController::class, 'index'])->name('home');
Route::post('/campaigns/data', [CampaignController::class, 'getCampaigns'])->name('campaigns.data');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaign');
Route::get('/campaigns/{campaign}/publishers', [CampaignController::class, 'publishers'])->name('publishers');
