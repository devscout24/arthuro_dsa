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

// mission
Route::get('/admin/missions/index', [BannerApiController::class, 'missionindex']);

// career up
Route::get('/admin/career-ups/index', [BannerApiController::class, 'careerUp']);

// here
Route::get('/admin/heres/index', [BannerApiController::class, 'hereindex']);

// future
Route::get('/admin/futures/index', [BannerApiController::class, 'futureindex']);

// already
Route::get('/admin/alreadys/index', [BannerApiController::class, 'alreadyindex']);

// negotiable
Route::get('/admin/negotiables/index', [BannerApiController::class, 'negotiableindex']);

// Team paragraph
Route::get('/admin/teamParagraphs/index', [TeamController::class, 'teamParagraphindex']);

// navbar
Route::get('/admin/navbars/index', [BannerApiController::class, 'navbarindex']);

// building paragraph
Route::get('/admin/buildingParagraphs/index', [BannerApiController::class, 'buildingindex']);

// exception
Route::get('/admin/exceptions/index', [BannerApiController::class, 'exceptionindex']);

// social media
Route::get('/admin/socialMedias/index', [BannerApiController::class, 'socialMediaindex']);

// system setting
Route::get('/admin/systemSettings/index', [BannerApiController::class, 'systemSettingindex']);


// contact dynamic
Route::get('/admin/contact-dynamics/index', [BannerApiController::class, 'contactDynamicindex']);


// information
Route::get('/admin/informations/index', [BannerApiController::class, 'informationindex']);


// footer down
Route::get('/admin/footer-downs/index', [BannerApiController::class, 'footerDownindex']);