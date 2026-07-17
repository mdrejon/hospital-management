<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PackageBookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\WebsiteSettings\SliderController;
use App\Http\Controllers\Admin\WebsiteSettings\HeaderSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\FooterSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\AboutSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\GalleryController;
use App\Http\Controllers\Admin\WebsiteSettings\ContactSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\ServiceSettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\WebsiteSettings\HistorySettingController;
use App\Http\Controllers\Admin\WebsiteSettings\FaqPageSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\BlogSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\EmailSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\MailSettingController;

use App\Http\Controllers\Admin\BackupController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Frontend / Public Routes
Route::get('/',                    [FrontendController::class, 'home'])->name('home');
Route::get('/about',                [FrontendController::class, 'about'])->name('about');
Route::get('/achievements',        [FrontendController::class, 'achievements'])->name('achievements');
Route::get('/appointment',          [FrontendController::class, 'appointment'])->name('appointment');
Route::get('/blog',                 [FrontendController::class, 'blogList'])->name('blog-list');
Route::get('/blog/{slug?}',         [FrontendController::class, 'blogDetails'])->name('blog-details');
Route::get('/contact',              [FrontendController::class, 'contact'])->name('contact');
Route::get('/doctors',              [FrontendController::class, 'doctors'])->name('doctors');
Route::get('/doctors/{slug?}',      [FrontendController::class, 'doctorDetails'])->name('doctor-details');
Route::get('/faq',                  [FrontendController::class, 'faq'])->name('faq');
Route::get('/gallery',              [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/history',              [FrontendController::class, 'history'])->name('history');
Route::get('/management',           [FrontendController::class, 'management'])->name('management');
Route::get('/md-message',           [FrontendController::class, 'mdMessage'])->name('md-message');
Route::get('/privacy-policy',       [FrontendController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/services',             [FrontendController::class, 'services'])->name('services');
Route::get('/services/{slug?}',     [FrontendController::class, 'serviceDetails'])->name('service-details');
Route::get('/terms-conditions',    [FrontendController::class, 'termsConditions'])->name('terms-conditions');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'module.permission'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inquiries
    Route::get('/inquiries',                         [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}',               [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}/status',      [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');
    Route::delete('/inquiries/{inquiry}',            [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Packages Management
    Route::get('/packages',           [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create',    [PackageController::class, 'create'])->name('packages.create');
    Route::get('/packages/{id}/edit', [PackageController::class, 'edit'])->name('packages.edit');

    // Package Bookings
    Route::get('/package-bookings',      [PackageBookingController::class, 'index'])->name('package-bookings.index');
    Route::get('/package-bookings/{id}', [PackageBookingController::class, 'show'])->name('package-bookings.show');

    // Users Management (full CRUD)
    Route::get('/users',                [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create',         [UserController::class, 'create'])->name('users.create');
    Route::post('/users',               [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',    [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',         [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',      [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle',[UserController::class, 'toggleStatus'])->name('users.toggle');

    // Roles Management
    Route::get('/roles',                [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create',         [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles',               [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit',    [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}',         [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}',      [RoleController::class, 'destroy'])->name('roles.destroy');

    // FAQ Management
    Route::get('/faqs',                [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create',         [FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs',               [FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{faq}/edit',     [FaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{faq}',          [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}',       [FaqController::class, 'destroy'])->name('faqs.destroy');
    Route::patch('/faqs/{faq}/toggle', [FaqController::class, 'toggleStatus'])->name('faqs.toggle');

    // Services CRUD
    Route::get('/services',                [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create',         [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services',               [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}',      [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}',   [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/services/{service}/toggle', [ServiceController::class, 'toggleStatus'])->name('services.toggle');

    // Facilities CRUD
    Route::get('/facilities',                         [FacilityController::class, 'index'])->name('facilities.index');
    Route::post('/facilities',                        [FacilityController::class, 'store'])->name('facilities.store');
    Route::put('/facilities/{facility}',              [FacilityController::class, 'update'])->name('facilities.update');
    Route::delete('/facilities/{facility}',           [FacilityController::class, 'destroy'])->name('facilities.destroy');
    Route::patch('/facilities/{facility}/toggle',     [FacilityController::class, 'toggleStatus'])->name('facilities.toggle');
    Route::post('/facilities/settings',               [FacilityController::class, 'updateSettings'])->name('facilities.settings');

    // Blog Posts CRUD
    Route::get('/blog',                        [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create',                 [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog',                       [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{blog}/edit',            [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog/{blog}',                [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{blog}',              [BlogController::class, 'destroy'])->name('blog.destroy');
    Route::patch('/blog/{blog}/toggle',        [BlogController::class, 'toggleStatus'])->name('blog.toggle');
    Route::get('/blog/{blog}/comments',        [BlogController::class, 'comments'])->name('blog.comments');
    Route::patch('/blog-comments/{comment}/approve', [BlogController::class, 'approveComment'])->name('blog-comments.approve');
    Route::delete('/blog-comments/{comment}',  [BlogController::class, 'deleteComment'])->name('blog-comments.destroy');

    // Blog Comments
    Route::get('/blog-comments',                              [BlogController::class, 'allComments'])->name('blog-comments.index');

    // Blog Categories CRUD
    Route::get('/blog-categories',                        [BlogCategoryController::class, 'index'])->name('blog-categories.index');
    Route::post('/blog-categories',                       [BlogCategoryController::class, 'store'])->name('blog-categories.store');
    Route::put('/blog-categories/{blogCategory}',         [BlogCategoryController::class, 'update'])->name('blog-categories.update');
    Route::delete('/blog-categories/{blogCategory}',      [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
    Route::patch('/blog-categories/{blogCategory}/toggle',[BlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle');

    // Testimonials CRUD
    Route::get('/testimonials',                       [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials',                      [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}',         [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}',      [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::patch('/testimonials/{testimonial}/toggle',[TestimonialController::class, 'toggleStatus'])->name('testimonials.toggle');
    Route::post('/testimonials/settings',             [TestimonialController::class, 'updateSettings'])->name('testimonials.settings');

    // Website Settings
    Route::prefix('website-settings')->name('website-settings.')->group(function () {
        // Hero Slider CRUD
        Route::get('/sliders',                  [SliderController::class, 'index'])->name('sliders.index');
        Route::get('/sliders/create',           [SliderController::class, 'create'])->name('sliders.create');
        Route::post('/sliders',                 [SliderController::class, 'store'])->name('sliders.store');
        Route::get('/sliders/{slider}/edit',    [SliderController::class, 'edit'])->name('sliders.edit');
        Route::post('/sliders/{slider}',        [SliderController::class, 'update'])->name('sliders.update');
        Route::delete('/sliders/{slider}',      [SliderController::class, 'destroy'])->name('sliders.destroy');
        Route::patch('/sliders/{slider}/toggle',[SliderController::class, 'toggleStatus'])->name('sliders.toggle');

        // Header Settings
        Route::get('/header',  [HeaderSettingController::class, 'edit'])->name('header.edit');
        Route::post('/header', [HeaderSettingController::class, 'update'])->name('header.update');

        // Footer Settings
        Route::get('/footer',  [FooterSettingController::class, 'edit'])->name('footer.edit');
        Route::post('/footer', [FooterSettingController::class, 'update'])->name('footer.update');

        // About Section Settings
        Route::get('/about',  [AboutSettingController::class, 'edit'])->name('about.edit');
        Route::post('/about', [AboutSettingController::class, 'update'])->name('about.update');

        // History Page Settings
        Route::get('/history',  [HistorySettingController::class, 'edit'])->name('history.edit');
        Route::put('/history',  [HistorySettingController::class, 'update'])->name('history.update');

        // FAQ Page Settings
        Route::get('/faq-page',  [FaqPageSettingController::class, 'edit'])->name('faq-page.edit');
        Route::put('/faq-page',  [FaqPageSettingController::class, 'update'])->name('faq-page.update');

        // Blog Page Settings
        Route::get('/blog-page',  [BlogSettingController::class, 'edit'])->name('blog-page.edit');
        Route::put('/blog-page',  [BlogSettingController::class, 'update'])->name('blog-page.update');

        // Contact Settings
        Route::get('/contact',  [ContactSettingController::class, 'edit'])->name('contact.edit');
        Route::post('/contact', [ContactSettingController::class, 'update'])->name('contact.update');

        // Services Section Settings
        Route::get('/services',  [ServiceSettingController::class, 'edit'])->name('services.edit');
        Route::post('/services', [ServiceSettingController::class, 'update'])->name('services.update');

        // Mail / SMTP Settings
        Route::get('/mail',       [MailSettingController::class, 'edit'])->name('mail.edit');
        Route::post('/mail',      [MailSettingController::class, 'update'])->name('mail.update');
        Route::post('/mail/test', [MailSettingController::class, 'sendTest'])->name('mail.test');

        // Email Notification Settings (per-status toggles + editable template copy)
        Route::get('/email-notifications',  [EmailSettingController::class, 'edit'])->name('email-notifications.edit');
        Route::put('/email-notifications',  [EmailSettingController::class, 'update'])->name('email-notifications.update');

        // Gallery CRUD
        Route::get('/gallery',                           [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/gallery',                          [GalleryController::class, 'store'])->name('gallery.store');
        Route::patch('/gallery/{gallery}',               [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{gallery}',              [GalleryController::class, 'destroy'])->name('gallery.destroy');
        Route::patch('/gallery/{gallery}/toggle',        [GalleryController::class, 'toggleStatus'])->name('gallery.toggle');
        Route::post('/gallery/reorder',                  [GalleryController::class, 'reorder'])->name('gallery.reorder');
        Route::post('/gallery/settings',                 [GalleryController::class, 'updateSettings'])->name('gallery.settings');
    });

    // Database Backup
    Route::prefix('backups')->name('backups.')->group(function () {
        Route::get('/',                    [BackupController::class, 'index'])->name('index');
        Route::post('/',                   [BackupController::class, 'store'])->name('store');
        Route::post('/restore-upload',     [BackupController::class, 'restoreUpload'])->name('restore-upload');
        Route::get('/{backup}/download',   [BackupController::class, 'download'])->name('download');
        Route::post('/{backup}/restore',   [BackupController::class, 'restore'])->name('restore');
        Route::delete('/{backup}',         [BackupController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
