<?php

use App\Http\Controllers\BannerApiController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// banner
Route::get('/admin/banners/index', [BannerApiController::class, 'bannerindex']);

// team
Route::get('/admin/teams/index', [BannerApiController::class, 'index']);


// anything
Route::get('/admin/anythings/index', [BannerApiController::class, 'anythingindex']);

// carrer
Route::get('/admin/carrers/index', [BannerApiController::class, 'carrerindex']);

// family
Route::get('/admin/families/index', [BannerApiController::class, 'familyindex']);

// partner
Route::get('/admin/partners/index', [BannerApiController::class, 'partnerindex']);

// work
Route::get('/admin/works/index', [BannerApiController::class, 'workindex']);

// horizon
Route::get('/admin/horizons/index', [BannerApiController::class, 'horizonindex']);

// explore
Route::get('/admin/explores/index', [BannerApiController::class, 'exploreindex']);


// Founder
Route::get('/admin/founders/index', [BannerApiController::class, 'founderindex']);

// all user
Route::post('/admin/allUser/store', [BannerApiController::class, 'allUserStore']);


// all contact
Route::post('/admin/userContact/store', [BannerApiController::class, 'userContactStore']);

// term
Route::get('/admin/terms/index', [BannerApiController::class, 'termindex']);


// privacy policy
Route::get('/admin/privacy-policies/index', [BannerApiController::class, 'privacypolicyindex']);

