<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/campaigns', [CampaignController::class, 'index']);

Route::get('/v1/organizers/{orgSlug}/campaigns/{campSlug}', [CampaignController::class, 'detail']);

Route::post('/v1/login', [AuthController::class, 'login']);

Route::post('/v1/logout', [AuthController::class, 'logout']);

Route::get('/v1/registrations', [CampaignController::class, 'showRegis']);

Route::post('/v1/organizers/{orgSlug}/campaigns/{campSlug}/registration', [CampaignController::class, 'doRegis']);
