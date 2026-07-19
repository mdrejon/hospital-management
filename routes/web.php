<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\WebsiteSettings\AppointmentSettingController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\WebsiteSettings\SliderController;
use App\Http\Controllers\Admin\WebsiteSettings\HeaderSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\FooterSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\AboutSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\GalleryController;
use App\Http\Controllers\Admin\WebsiteSettings\ContactSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\ServiceSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\DoctorSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\PackageSettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\WebsiteSettings\HistorySettingController;
use App\Http\Controllers\Admin\WebsiteSettings\AchievementsSettingController;
use App\Http\Controllers\Admin\ManagementMemberController;
use App\Http\Controllers\Admin\WebsiteSettings\ManagementSettingController;
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
Route::post('/appointment',         [FrontendController::class, 'submitAppointment'])->name('appointment.submit');
Route::get('/blog',                 [FrontendController::class, 'blogList'])->name('blog-list');
Route::get('/blog/{slug}',          [FrontendController::class, 'blogDetails'])->name('blog-details');
Route::post('/blog/{blog}/comments', [FrontendController::class, 'submitBlogComment'])->name('blog-comments.store');
Route::get('/contact',              [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact',             [FrontendController::class, 'submitContact'])->name('contact.submit');
Route::get('/doctors',              [FrontendController::class, 'doctors'])->name('doctors');
Route::get('/doctors/{slug}',       [FrontendController::class, 'doctorDetails'])->name('doctor-details');
Route::get('/faq',                  [FrontendController::class, 'faq'])->name('faq');
Route::get('/gallery',              [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/history',              [FrontendController::class, 'history'])->name('history');
Route::get('/management',           [FrontendController::class, 'management'])->name('management');
Route::get('/md-message',           [FrontendController::class, 'mdMessage'])->name('md-message');
Route::get('/packages',             [FrontendController::class, 'packages'])->name('packages');
Route::get('/packages/{slug}',      [FrontendController::class, 'packageDetails'])->name('package-details');
Route::get('/services',             [FrontendController::class, 'services'])->name('services');
Route::get('/services/{slug}',      [FrontendController::class, 'serviceDetails'])->name('service-details');
Route::get('/search',               [FrontendController::class, 'search'])->name('search');

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

    // Appointments
    Route::get('/appointments',                       [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create',                [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',                      [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    Route::delete('/appointments/{appointment}',      [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Packages Management
    Route::get('/packages',                [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create',         [PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages',               [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}',      [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}',   [PackageController::class, 'destroy'])->name('packages.destroy');
    Route::patch('/packages/{package}/toggle', [PackageController::class, 'toggleStatus'])->name('packages.toggle');

    // Pages CMS (common content pages: Privacy Policy, Terms & Conditions, etc.)
    Route::get('/pages',                [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create',         [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages',               [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}/edit',    [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}',         [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}',      [PageController::class, 'destroy'])->name('pages.destroy');
    Route::patch('/pages/{page}/toggle', [PageController::class, 'toggleStatus'])->name('pages.toggle');

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

    // Doctors CRUD
    Route::get('/doctors',                [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/create',         [DoctorController::class, 'create'])->name('doctors.create');
    Route::post('/doctors',               [DoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit',  [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}',       [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}',    [DoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::patch('/doctors/{doctor}/toggle', [DoctorController::class, 'toggleStatus'])->name('doctors.toggle');

    // Management Team CRUD
    Route::get('/management-members',                       [ManagementMemberController::class, 'index'])->name('management-members.index');
    Route::get('/management-members/create',                [ManagementMemberController::class, 'create'])->name('management-members.create');
    Route::post('/management-members',                      [ManagementMemberController::class, 'store'])->name('management-members.store');
    Route::get('/management-members/{managementMember}/edit', [ManagementMemberController::class, 'edit'])->name('management-members.edit');
    Route::put('/management-members/{managementMember}',     [ManagementMemberController::class, 'update'])->name('management-members.update');
    Route::delete('/management-members/{managementMember}',  [ManagementMemberController::class, 'destroy'])->name('management-members.destroy');
    Route::patch('/management-members/{managementMember}/toggle', [ManagementMemberController::class, 'toggleStatus'])->name('management-members.toggle');

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

    // Awards CRUD
    Route::get('/awards',                       [AwardController::class, 'index'])->name('awards.index');
    Route::post('/awards',                      [AwardController::class, 'store'])->name('awards.store');
    Route::put('/awards/{award}',               [AwardController::class, 'update'])->name('awards.update');
    Route::delete('/awards/{award}',            [AwardController::class, 'destroy'])->name('awards.destroy');
    Route::patch('/awards/{award}/toggle',      [AwardController::class, 'toggleStatus'])->name('awards.toggle');
    Route::post('/awards/settings',             [AwardController::class, 'updateSettings'])->name('awards.settings');

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

        // Achievements Page Settings
        Route::get('/achievements',  [AchievementsSettingController::class, 'edit'])->name('achievements.edit');
        Route::post('/achievements', [AchievementsSettingController::class, 'update'])->name('achievements.update');

        // FAQ Page Settings
        Route::get('/faq-page',  [FaqPageSettingController::class, 'edit'])->name('faq-page.edit');
        Route::put('/faq-page',  [FaqPageSettingController::class, 'update'])->name('faq-page.update');

        // Contact Settings
        Route::get('/contact',  [ContactSettingController::class, 'edit'])->name('contact.edit');
        Route::post('/contact', [ContactSettingController::class, 'update'])->name('contact.update');

        // Services Section Settings (form lives as a tab on the Services list page)
        Route::post('/services', [ServiceSettingController::class, 'update'])->name('services.update');

        // Doctors Section Settings (form lives as a tab on the Doctors list page)
        Route::post('/doctors', [DoctorSettingController::class, 'update'])->name('doctors.update');

        // Packages Section Settings (form lives as a tab on the Packages list page)
        Route::post('/packages', [PackageSettingController::class, 'update'])->name('packages.update');

        // Blog Page Settings (form lives as a tab on the Blog Posts list page)
        Route::post('/blog-page', [BlogSettingController::class, 'update'])->name('blog-page.update');

        // Management Team Settings (form lives as a tab on the Management list page)
        Route::post('/management', [ManagementSettingController::class, 'update'])->name('management.update');

        // Appointment Settings (form lives as a tab on the Appointments list page)
        Route::post('/appointment', [AppointmentSettingController::class, 'update'])->name('appointment.update');

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

// CMS Pages catch-all — MUST stay the last route in the file so it never
// shadows any of the specific/admin routes registered above it (including
// the auth routes required just above: /login, /register, etc.). Resolves
// nested paths (e.g. /parent-slug/child-slug) against Page::fullPath();
// falls through to the themed 404 view (resources/views/errors/404.blade.php)
// when nothing matches.
Route::get('/{path}', [FrontendController::class, 'showPage'])->where('path', '.*')->name('page.show');
