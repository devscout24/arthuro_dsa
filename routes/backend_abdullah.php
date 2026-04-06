<?php

use App\Http\Controllers\AnythingController;
use App\Http\Controllers\AlreadyController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CarrerController;
use App\Http\Controllers\CarrerUpController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FutureController;
use App\Http\Controllers\FounderController;
use App\Http\Controllers\HorizonController;
use App\Http\Controllers\HereController;
use App\Http\Controllers\MissonController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\NegotiableController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamParagraphController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserContactController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ContactDynamicController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FooterDownController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/admin/banner/index', [BannerController::class, 'index'])->name('admin.banner.index');
Route::get('/admin/banner/create', [BannerController::class, 'create'])->name('admin.banner.create');
Route::post('/admin/banner/store', [BannerController::class, 'store'])->name('admin.banner.store');
Route::get('/admin/banner/edit/{id}', [BannerController::class, 'edit'])->name('admin.banner.edit');
Route::put('/admin/banner/update/{id}', [BannerController::class, 'update'])->name('admin.banner.update');
Route::delete('/admin/banner/destroy/{id}', [BannerController::class, 'destroy'])->name('admin.banner.destroy');

// navbar
Route::get('/admin/navbar/index', [NavbarController::class, 'index'])->name('admin.navbar.index');
Route::get('/admin/navbar/create', [NavbarController::class, 'create'])->name('admin.navbar.create');
Route::post('/admin/navbar/store', [NavbarController::class, 'store'])->name('admin.navbar.store');
Route::get('/admin/navbar/edit/{id}', [NavbarController::class, 'edit'])->name('admin.navbar.edit');
Route::put('/admin/navbar/update/{id}', [NavbarController::class, 'update'])->name('admin.navbar.update');
Route::delete('/admin/navbar/destroy/{id}', [NavbarController::class, 'destroy'])->name('admin.navbar.destroy');

// future
Route::get('/admin/future/index', [FutureController::class, 'index'])->name('admin.future.index');
Route::get('/admin/future/create', [FutureController::class, 'create'])->name('admin.future.create');
Route::post('/admin/future/store', [FutureController::class, 'store'])->name('admin.future.store');
Route::get('/admin/future/edit/{id}', [FutureController::class, 'edit'])->name('admin.future.edit');
Route::put('/admin/future/update/{id}', [FutureController::class, 'update'])->name('admin.future.update');
Route::delete('/admin/future/destroy/{id}', [FutureController::class, 'destroy'])->name('admin.future.destroy');

// here
Route::get('/admin/here/index', [HereController::class, 'index'])->name('admin.here.index');
Route::get('/admin/here/create', [HereController::class, 'create'])->name('admin.here.create');
Route::post('/admin/here/store', [HereController::class, 'store'])->name('admin.here.store');
Route::get('/admin/here/edit/{id}', [HereController::class, 'edit'])->name('admin.here.edit');
Route::put('/admin/here/update/{id}', [HereController::class, 'update'])->name('admin.here.update');
Route::delete('/admin/here/destroy/{id}', [HereController::class, 'destroy'])->name('admin.here.destroy');

// already (single record)
Route::get('/admin/already/index', [AlreadyController::class, 'index'])->name('admin.already.index');
Route::get('/admin/already/create', [AlreadyController::class, 'create'])->name('admin.already.create');
Route::post('/admin/already/store', [AlreadyController::class, 'store'])->name('admin.already.store');
Route::get('/admin/already/edit/{id}', [AlreadyController::class, 'edit'])->name('admin.already.edit');
Route::put('/admin/already/update/{id}', [AlreadyController::class, 'update'])->name('admin.already.update');
Route::delete('/admin/already/destroy/{id}', [AlreadyController::class, 'destroy'])->name('admin.already.destroy');

// negotiable
Route::get('/admin/negotiable/index', [NegotiableController::class, 'index'])->name('admin.negotiable.index');
Route::get('/admin/negotiable/create', [NegotiableController::class, 'create'])->name('admin.negotiable.create');
Route::post('/admin/negotiable/store', [NegotiableController::class, 'store'])->name('admin.negotiable.store');
Route::get('/admin/negotiable/edit/{id}', [NegotiableController::class, 'edit'])->name('admin.negotiable.edit');
Route::put('/admin/negotiable/update/{id}', [NegotiableController::class, 'update'])->name('admin.negotiable.update');
Route::delete('/admin/negotiable/destroy/{id}', [NegotiableController::class, 'destroy'])->name('admin.negotiable.destroy');

// building
Route::get('/admin/building/index', [BuildingController::class, 'index'])->name('admin.building.index');
Route::get('/admin/building/create', [BuildingController::class, 'create'])->name('admin.building.create');
Route::post('/admin/building/store', [BuildingController::class, 'store'])->name('admin.building.store');
Route::get('/admin/building/edit/{id}', [BuildingController::class, 'edit'])->name('admin.building.edit');
Route::put('/admin/building/update/{id}', [BuildingController::class, 'update'])->name('admin.building.update');
Route::delete('/admin/building/destroy/{id}', [BuildingController::class, 'destroy'])->name('admin.building.destroy');

// exception
Route::get('/admin/exception/index', [ExceptionController::class, 'index'])->name('admin.exception.index');
Route::get('/admin/exception/create', [ExceptionController::class, 'create'])->name('admin.exception.create');
Route::post('/admin/exception/store', [ExceptionController::class, 'store'])->name('admin.exception.store');
Route::get('/admin/exception/edit/{id}', [ExceptionController::class, 'edit'])->name('admin.exception.edit');
Route::put('/admin/exception/update/{id}', [ExceptionController::class, 'update'])->name('admin.exception.update');
Route::delete('/admin/exception/destroy/{id}', [ExceptionController::class, 'destroy'])->name('admin.exception.destroy');

// carrer up
Route::get('/admin/carrer-up/index', [CarrerUpController::class, 'index'])->name('admin.carrer_up.index');
Route::get('/admin/carrer-up/create', [CarrerUpController::class, 'create'])->name('admin.carrer_up.create');
Route::post('/admin/carrer-up/store', [CarrerUpController::class, 'store'])->name('admin.carrer_up.store');
Route::get('/admin/carrer-up/edit/{id}', [CarrerUpController::class, 'edit'])->name('admin.carrer_up.edit');
Route::put('/admin/carrer-up/update/{id}', [CarrerUpController::class, 'update'])->name('admin.carrer_up.update');
Route::delete('/admin/carrer-up/destroy/{id}', [CarrerUpController::class, 'destroy'])->name('admin.carrer_up.destroy');

// carrer
Route::get('/admin/carrer/index', [CarrerController::class, 'index'])->name('admin.carrer.index');  
Route::get('/admin/carrer/create', [CarrerController::class, 'create'])->name('admin.carrer.create');
Route::post('/admin/carrer/store', [CarrerController::class, 'store'])->name('admin.carrer.store');
Route::get('/admin/carrer/edit/{id}', [CarrerController::class, 'edit'])->name('admin.carrer.edit');
Route::put('/admin/carrer/update/{id}', [CarrerController::class, 'update'])->name('admin.carrer.update');
Route::delete('/admin/carrer/destroy/{id}', [CarrerController::class, 'destroy'])->name('admin.carrer.destroy');

// family
Route::get('/admin/family/index', [FamilyController::class, 'index'])->name('admin.family.index');
Route::get('/admin/family/create', [FamilyController::class, 'create'])->name('admin.family.create');
Route::post('/admin/family/store', [FamilyController::class, 'store'])->name('admin.family.store');
Route::get('/admin/family/edit/{id}', [FamilyController::class, 'edit'])->name('admin.family.edit');
Route::put('/admin/family/update/{id}', [FamilyController::class, 'update'])->name('admin.family.update');
Route::delete('/admin/family/destroy/{id}', [FamilyController::class, 'destroy'])->name('admin.family.destroy');

// work
Route::get('/admin/work/index', [WorkController::class, 'index'])->name('admin.work.index');
Route::get('/admin/work/create', [WorkController::class, 'create'])->name('admin.work.create');
Route::post('/admin/work/store', [WorkController::class, 'store'])->name('admin.work.store');
Route::get('/admin/work/edit/{id}', [WorkController::class, 'edit'])->name('admin.work.edit');
Route::put('/admin/work/update/{id}', [WorkController::class, 'update'])->name('admin.work.update');
Route::delete('/admin/work/destroy/{id}', [WorkController::class, 'destroy'])->name('admin.work.destroy');


// partner
Route::get('/admin/partner/index', [PartnerController::class, 'index'])->name('admin.partner.index');   
Route::get('/admin/partner/create', [PartnerController::class, 'create'])->name('admin.partner.create');    
Route::post('/admin/partner/store', [PartnerController::class, 'store'])->name('admin.partner.store');
Route::get('/admin/partner/edit/{id}', [PartnerController::class, 'edit'])->name('admin.partner.edit');
Route::put('/admin/partner/update/{id}', [PartnerController::class, 'update'])->name('admin.partner.update');
Route::delete('/admin/partner/destroy/{id}', [PartnerController::class, 'destroy'])->name('admin.partner.destroy');



// horizon
Route::get('/admin/horizon/index', [HorizonController::class, 'index'])->name('admin.horizon.index');
Route::get('/admin/horizon/create', [HorizonController::class, 'create'])->name('admin.horizon.create');
Route::post('/admin/horizon/store', [HorizonController::class, 'store'])->name('admin.horizon.store');
Route::get('/admin/horizon/edit/{id}', [HorizonController::class, 'edit'])->name('admin.horizon.edit');
Route::put('/admin/horizon/update/{id}', [HorizonController::class, 'update'])->name('admin.horizon.update');
Route::delete('/admin/horizon/destroy/{id}', [HorizonController::class, 'destroy'])->name('admin.horizon.destroy');


// explore
Route::get('/admin/explore/index', [ExploreController::class, 'index'])->name('admin.explore.index');
Route::get('/admin/explore/create', [ExploreController::class, 'create'])->name('admin.explore.create');
Route::post('/admin/explore/store', [ExploreController::class, 'store'])->name('admin.explore.store');
Route::get('/admin/explore/edit/{id}', [ExploreController::class, 'edit'])->name('admin.explore.edit');
Route::put('/admin/explore/update/{id}', [ExploreController::class, 'update'])->name('admin.explore.update');
Route::delete('/admin/explore/destroy/{id}', [ExploreController::class, 'destroy'])->name('admin.explore.destroy');


// anything 
Route::get('/admin/anything/index', [AnythingController::class, 'index'])->name('admin.anything.index');
Route::get('/admin/anything/create', [AnythingController::class, 'create'])->name('admin.anything.create');
Route::post('/admin/anything/store', [AnythingController::class, 'store'])->name('admin.anything.store');
Route::get('/admin/anything/edit/{id}', [AnythingController::class, 'edit'])->name('admin.anything.edit');
Route::put('/admin/anything/update/{id}', [AnythingController::class, 'update'])->name('admin.anything.update');
Route::delete('/admin/anything/destroy/{id}', [AnythingController::class, 'destroy'])->name('admin.anything.destroy');


// misson
Route::get('/admin/misson/index', [MissonController::class, 'index'])->name('admin.misson.index');
Route::get('/admin/misson/create', [MissonController::class, 'create'])->name('admin.misson.create');
Route::post('/admin/misson/store', [MissonController::class, 'store'])->name('admin.misson.store');
Route::get('/admin/misson/edit/{id}', [MissonController::class, 'edit'])->name('admin.misson.edit');
Route::put('/admin/misson/update/{id}', [MissonController::class, 'update'])->name('admin.misson.update');
Route::delete('/admin/misson/destroy/{id}', [MissonController::class, 'destroy'])->name('admin.misson.destroy');


// founder
Route::get('/admin/founder/index', [FounderController::class, 'index'])->name('admin.founder.index');
Route::get('/admin/founder/create', [FounderController::class, 'create'])->name('admin.founder.create');
Route::post('/admin/founder/store', [FounderController::class, 'store'])->name('admin.founder.store');
Route::get('/admin/founder/edit/{id}', [FounderController::class, 'edit'])->name('admin.founder.edit');
Route::put('/admin/founder/update/{id}', [FounderController::class, 'update'])->name('admin.founder.update');
Route::delete('/admin/founder/destroy/{id}', [FounderController::class, 'destroy'])->name('admin.founder.destroy');


// team
Route::get('/admin/team/index', [TeamController::class, 'index'])->name('admin.team.index');
Route::get('/admin/team/create', [TeamController::class, 'create'])->name('admin.team.create');
Route::post('/admin/team/store', [TeamController::class, 'store'])->name('admin.team.store');
Route::get('/admin/team/edit/{id}', [TeamController::class, 'edit'])->name('admin.team.edit');
Route::put('/admin/team/update/{id}', [TeamController::class, 'update'])->name('admin.team.update');
Route::delete('/admin/team/destroy/{id}', [TeamController::class, 'destroy'])->name('admin.team.destroy');

// team paragraph
Route::get('/admin/team-paragraph/index', [TeamParagraphController::class, 'index'])->name('admin.team_paragraph.index');
Route::get('/admin/team-paragraph/create', [TeamParagraphController::class, 'create'])->name('admin.team_paragraph.create');
Route::post('/admin/team-paragraph/store', [TeamParagraphController::class, 'store'])->name('admin.team_paragraph.store');
Route::get('/admin/team-paragraph/edit/{id}', [TeamParagraphController::class, 'edit'])->name('admin.team_paragraph.edit');
Route::put('/admin/team-paragraph/update/{id}', [TeamParagraphController::class, 'update'])->name('admin.team_paragraph.update');
Route::delete('/admin/team-paragraph/destroy/{id}', [TeamParagraphController::class, 'destroy'])->name('admin.team_paragraph.destroy');


//all user 
Route::get('/admin/user/index', [UserController::class, 'index'])->name('admin.user.index');
Route::delete('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

// user contacts
Route::get('/admin/usercontact/index', [UserContactController::class, 'index'])->name('admin.usercontact.index');
Route::get('/admin/usercontact/create', [UserContactController::class, 'create'])->name('admin.usercontact.create');
Route::post('/admin/usercontact/store', [UserContactController::class, 'store'])->name('admin.usercontact.store');
Route::get('/admin/usercontact/edit/{id}', [UserContactController::class, 'edit'])->name('admin.usercontact.edit');
Route::put('/admin/usercontact/update/{id}', [UserContactController::class, 'update'])->name('admin.usercontact.update');
Route::delete('/admin/usercontact/destroy/{id}', [UserContactController::class, 'destroy'])->name('admin.usercontact.destroy');

// alias contact routes
Route::get('/admin/contact/index', [UserContactController::class, 'index'])->name('admin.contact.index');
Route::get('/admin/contact/create', [UserContactController::class, 'create'])->name('admin.contact.create');
Route::post('/admin/contact/store', [UserContactController::class, 'store'])->name('admin.contact.store');
Route::get('/admin/contact/edit/{id}', [UserContactController::class, 'edit'])->name('admin.contact.edit');
Route::put('/admin/contact/update/{id}', [UserContactController::class, 'update'])->name('admin.contact.update');
Route::delete('/admin/contact/destroy/{id}', [UserContactController::class, 'destroy'])->name('admin.contact.destroy');

// term
Route::get('/admin/term/index', [TermController::class, 'index'])->name('admin.term.index');
Route::get('/admin/term/create', [TermController::class, 'create'])->name('admin.term.create');
Route::post('/admin/term/store', [TermController::class, 'store'])->name('admin.term.store');
Route::get('/admin/term/edit/{id}', [TermController::class, 'edit'])->name('admin.term.edit');
Route::put('/admin/term/update/{id}', [TermController::class, 'update'])->name('admin.term.update');
Route::delete('/admin/term/destroy/{id}', [TermController::class, 'destroy'])->name('admin.term.destroy');

// privacy policy
Route::get('/admin/privacy-policy/index', [PrivacyPolicyController::class, 'index'])->name('admin.privacy-policy.index');
Route::get('/admin/privacy-policy/create', [PrivacyPolicyController::class, 'create'])->name('admin.privacy-policy.create');
Route::post('/admin/privacy-policy/store', [PrivacyPolicyController::class, 'store'])->name('admin.privacy-policy.store');
Route::get('/admin/privacy-policy/edit/{id}', [PrivacyPolicyController::class, 'edit'])->name('admin.privacy-policy.edit');
Route::put('/admin/privacy-policy/update/{id}', [PrivacyPolicyController::class, 'update'])->name('admin.privacy-policy.update');
Route::delete('/admin/privacy-policy/destroy/{id}', [PrivacyPolicyController::class, 'destroy'])->name('admin.privacy-policy.destroy');

// information
Route::get('/admin/information/index', [InformationController::class, 'index'])->name('admin.information.index');
Route::get('/admin/information/create', [InformationController::class, 'create'])->name('admin.information.create');
Route::post('/admin/information/store', [InformationController::class, 'store'])->name('admin.information.store');
Route::get('/admin/information/edit/{id}', [InformationController::class, 'edit'])->name('admin.information.edit');
Route::put('/admin/information/update/{id}', [InformationController::class, 'update'])->name('admin.information.update');
Route::delete('/admin/information/destroy/{id}', [InformationController::class, 'destroy'])->name('admin.information.destroy');

// contact dynamic
Route::get('/admin/contact-dynamic/index', [ContactDynamicController::class, 'index'])->name('admin.contact-dynamic.index');
Route::get('/admin/contact-dynamic/create', [ContactDynamicController::class, 'create'])->name('admin.contact-dynamic.create');
Route::post('/admin/contact-dynamic/store', [ContactDynamicController::class, 'store'])->name('admin.contact-dynamic.store');
Route::get('/admin/contact-dynamic/edit/{id}', [ContactDynamicController::class, 'edit'])->name('admin.contact-dynamic.edit');
Route::put('/admin/contact-dynamic/update/{id}', [ContactDynamicController::class, 'update'])->name('admin.contact-dynamic.update');
Route::delete('/admin/contact-dynamic/destroy/{id}', [ContactDynamicController::class, 'destroy'])->name('admin.contact-dynamic.destroy');

// cookie
Route::get('/admin/cookie/index', [CookieController::class, 'index'])->name('admin.cookie.index');
Route::get('/admin/cookie/create', [CookieController::class, 'create'])->name('admin.cookie.create');
Route::post('/admin/cookie/store', [CookieController::class, 'store'])->name('admin.cookie.store');
Route::get('/admin/cookie/edit/{id}', [CookieController::class, 'edit'])->name('admin.cookie.edit');
Route::put('/admin/cookie/update/{id}', [CookieController::class, 'update'])->name('admin.cookie.update');
Route::delete('/admin/cookie/destroy/{id}', [CookieController::class, 'destroy'])->name('admin.cookie.destroy');

// footer down
Route::get('/admin/footer-down/index', [FooterDownController::class, 'index'])->name('admin.footer-down.index');
Route::get('/admin/footer-down/create', [FooterDownController::class, 'create'])->name('admin.footer-down.create');
Route::post('/admin/footer-down/store', [FooterDownController::class, 'store'])->name('admin.footer-down.store');
Route::get('/admin/footer-down/edit/{id}', [FooterDownController::class, 'edit'])->name('admin.footer-down.edit');
Route::put('/admin/footer-down/update/{id}', [FooterDownController::class, 'update'])->name('admin.footer-down.update');
Route::delete('/admin/footer-down/destroy/{id}', [FooterDownController::class, 'destroy'])->name('admin.footer-down.destroy');

