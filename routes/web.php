<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AppointmentBookingController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorDashboardController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\WebsiteSettings\AppointmentSettingController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorSpecializationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\WebsiteSettings\SliderController;
use App\Http\Controllers\Admin\WebsiteSettings\HeaderSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\FooterSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\AboutSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\GlobalAboutSettingController;
use App\Http\Controllers\Admin\WebsiteSettings\WhyChooseUsSettingController;
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
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AgentWithdrawalController;
use App\Http\Controllers\Admin\MedicalTestCategoryController;
use App\Http\Controllers\Admin\MedicalTestController;
use App\Http\Controllers\Admin\MedicalTestBookingController;
use App\Http\Controllers\Admin\WebsiteSettings\VideoGalleryController;
use App\Http\Controllers\Admin\WebsiteSettings\SmsSettingController;
use App\Http\Controllers\Agent\AgentAuthController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentDoctorBookingController;
use App\Http\Controllers\Agent\AgentMedicalTestBookingController;
use App\Http\Controllers\Agent\AgentBookingsController;
use App\Http\Controllers\Agent\AgentWalletController;
use App\Http\Controllers\Agent\AgentProfileController;
use App\Http\Controllers\Agent\AgentReportController;
use App\Http\Controllers\Admin\WebsiteSettings\LanguageController;
use App\Http\Controllers\Admin\WebsiteSettings\PaymentGatewaySettingController;
use App\Http\Controllers\PaymentController;

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
Route::post('/appointment',         [AppointmentBookingController::class, 'store'])->name('appointment.submit');
Route::get('/appointment/availability', [AppointmentBookingController::class, 'availability'])->name('appointment.availability');
Route::get('/appointment/slots',        [AppointmentBookingController::class, 'slots'])->name('appointment.slots');
Route::get('/blog',                 [FrontendController::class, 'blogList'])->name('blog-list');
Route::get('/blog/{slug}',          [FrontendController::class, 'blogDetails'])->name('blog-details');
Route::post('/blog/{blog}/comments', [FrontendController::class, 'submitBlogComment'])->name('blog-comments.store');
Route::get('/contact',              [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact',             [FrontendController::class, 'submitContact'])->name('contact.submit');
Route::get('/doctors',              [FrontendController::class, 'doctors'])->name('doctors');
Route::get('/doctors/{slug}',       [FrontendController::class, 'doctorDetails'])->name('doctor-details');
Route::get('/faq',                  [FrontendController::class, 'faq'])->name('faq');
Route::get('/gallery',              [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/video-gallery',        [FrontendController::class, 'videoGallery'])->name('video-gallery');
Route::get('/history',              [FrontendController::class, 'history'])->name('history');
Route::get('/management',           [FrontendController::class, 'management'])->name('management');
Route::get('/md-message',           [FrontendController::class, 'mdMessage'])->name('md-message');
Route::get('/packages',             [FrontendController::class, 'packages'])->name('packages');
Route::get('/packages/{slug}',      [FrontendController::class, 'packageDetails'])->name('package-details');
Route::get('/services',             [FrontendController::class, 'services'])->name('services');
Route::get('/services/{slug}',      [FrontendController::class, 'serviceDetails'])->name('service-details');
Route::get('/search',               [FrontendController::class, 'search'])->name('search');
Route::get('/language/{code}',      [LocaleController::class, 'update'])->name('language.switch');

// Agent Public Registration & Login Helper
Route::get('/agent/register',  [AgentAuthController::class, 'showRegister'])->name('agent.register');
Route::post('/agent/register', [AgentAuthController::class, 'register'])->name('agent.register.submit');

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    $user = $request->user();
    if ($user->isAgent()) {
        return redirect()->route('agent.dashboard');
    }
    if ($user->isDoctor()) {
        return redirect()->route('admin.doctor-dashboard.index');
    }
    if ($user->isOperator()) {
        return redirect()->route('admin.operator.dashboard');
    }
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Agent Portal Routes (For logged in agents)
Route::prefix('agent')->name('agent.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard',                  [AgentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/book-doctor',                [AgentDoctorBookingController::class, 'create'])->name('doctor.create');
    Route::post('/book-doctor',               [AgentDoctorBookingController::class, 'store'])->name('doctor.store');
    Route::get('/book-test',                  [AgentMedicalTestBookingController::class, 'create'])->name('test.create');
    Route::post('/book-test',                 [AgentMedicalTestBookingController::class, 'store'])->name('test.store');
    Route::get('/bookings',                   [AgentBookingsController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/tests',             [AgentBookingsController::class, 'tests'])->name('bookings.tests');
    Route::get('/wallet',                     [AgentWalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/withdraw',           [AgentWalletController::class, 'requestWithdrawal'])->name('wallet.withdraw');
    Route::get('/profile',                    [AgentProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile',                   [AgentProfileController::class, 'update'])->name('profile.update');
    Route::get('/reports',                    [AgentReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf',                [AgentReportController::class, 'printPdf'])->name('reports.pdf');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'module.permission'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // In-app notification bell
    Route::get('/notifications',               [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::patch('/notifications/read-all',     [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Inquiries
    Route::get('/inquiries',                         [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}',               [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}/status',      [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');
    Route::delete('/inquiries/{inquiry}',            [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Appointments
    Route::get('/appointments',                         [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create',                  [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',                        [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status',  [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    Route::patch('/appointments/{appointment}/payment', [AppointmentController::class, 'updatePayment'])->name('appointments.update-payment');
    Route::delete('/appointments/{appointment}',        [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Medical Tests & Diagnostic Management
    Route::get('/medical-test-categories',                     [MedicalTestCategoryController::class, 'index'])->name('medical-test-categories.index');
    Route::post('/medical-test-categories',                    [MedicalTestCategoryController::class, 'store'])->name('medical-test-categories.store');
    Route::put('/medical-test-categories/{category}',          [MedicalTestCategoryController::class, 'update'])->name('medical-test-categories.update');
    Route::delete('/medical-test-categories/{category}',       [MedicalTestCategoryController::class, 'destroy'])->name('medical-test-categories.destroy');

    Route::get('/medical-tests',                               [MedicalTestController::class, 'index'])->name('medical-tests.index');
    Route::get('/medical-tests/create',                        [MedicalTestController::class, 'create'])->name('medical-tests.create');
    Route::post('/medical-tests',                              [MedicalTestController::class, 'store'])->name('medical-tests.store');
    Route::get('/medical-tests/{medicalTest}/edit',            [MedicalTestController::class, 'edit'])->name('medical-tests.edit');
    Route::put('/medical-tests/{medicalTest}',                 [MedicalTestController::class, 'update'])->name('medical-tests.update');
    Route::delete('/medical-tests/{medicalTest}',              [MedicalTestController::class, 'destroy'])->name('medical-tests.destroy');

    Route::get('/medical-test-bookings',                       [MedicalTestBookingController::class, 'index'])->name('medical-test-bookings.index');
    Route::get('/medical-test-bookings/create',                [MedicalTestBookingController::class, 'create'])->name('medical-test-bookings.create');
    Route::post('/medical-test-bookings',                      [MedicalTestBookingController::class, 'store'])->name('medical-test-bookings.store');
    Route::get('/medical-test-bookings/{medicalTestBooking}',  [MedicalTestBookingController::class, 'show'])->name('medical-test-bookings.show');
    Route::patch('/medical-test-bookings/{medicalTestBooking}/status',  [MedicalTestBookingController::class, 'updateStatus'])->name('medical-test-bookings.update-status');
    Route::patch('/medical-test-bookings/{medicalTestBooking}/payment', [MedicalTestBookingController::class, 'updatePayment'])->name('medical-test-bookings.update-payment');
    Route::post('/medical-test-bookings/items/{item}/upload-report',   [MedicalTestBookingController::class, 'uploadReport'])->name('medical-test-bookings.upload-report');

    // Agent Management (Admin)
    Route::get('/agents',                        [AgentController::class, 'index'])->name('agents.index');
    Route::get('/agents/create',                 [AgentController::class, 'create'])->name('agents.create');
    Route::post('/agents',                       [AgentController::class, 'store'])->name('agents.store');
    Route::get('/agents/{agent}',                [AgentController::class, 'show'])->name('agents.show');
    Route::get('/agents/{agent}/edit',           [AgentController::class, 'edit'])->name('agents.edit');
    Route::put('/agents/{agent}',                [AgentController::class, 'update'])->name('agents.update');
    Route::delete('/agents/{agent}',             [AgentController::class, 'destroy'])->name('agents.destroy');
    Route::post('/agents/{agent}/adjust-balance',[AgentController::class, 'adjustBalance'])->name('agents.adjust-balance');

    // Cash Out / Withdrawals
    Route::get('/withdrawals',                       [AgentWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [AgentWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject',  [AgentWithdrawalController::class, 'reject'])->name('withdrawals.reject');

    // Patients — directory + full per-patient appointment history
    Route::get('/patients',              [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}',    [PatientController::class, 'show'])->name('patients.show');

    // Doctor dashboard (Doctor role)
    Route::get('/doctor-dashboard',                          [DoctorDashboardController::class, 'index'])->name('doctor-dashboard.index');
    Route::patch('/doctor-dashboard/{appointment}/status',    [DoctorDashboardController::class, 'updateStatus'])->name('doctor-dashboard.update-status');

    // Operator dashboard + manual booking (Operator role)
    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('/',                [OperatorController::class, 'dashboard'])->name('dashboard');
        Route::get('/book',            [OperatorController::class, 'book'])->name('book');
        Route::post('/book',           [OperatorController::class, 'store'])->name('book.store');
        Route::get('/patients/search', [OperatorController::class, 'searchPatients'])->name('patients.search');
        Route::get('/doctors',         [OperatorController::class, 'doctorsByDepartment'])->name('doctors');
        Route::get('/slots',           [OperatorController::class, 'slots'])->name('slots');
    });

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

    // Doctor Specializations CRUD
    Route::get('/doctor-specializations',                          [DoctorSpecializationController::class, 'index'])->name('doctor-specializations.index');
    Route::post('/doctor-specializations',                         [DoctorSpecializationController::class, 'store'])->name('doctor-specializations.store');
    Route::put('/doctor-specializations/{doctorSpecialization}',    [DoctorSpecializationController::class, 'update'])->name('doctor-specializations.update');
    Route::delete('/doctor-specializations/{doctorSpecialization}', [DoctorSpecializationController::class, 'destroy'])->name('doctor-specializations.destroy');
    Route::patch('/doctor-specializations/{doctorSpecialization}/toggle', [DoctorSpecializationController::class, 'toggleStatus'])->name('doctor-specializations.toggle');

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

        // Languages CRUD
        Route::get('/languages',                      [LanguageController::class, 'index'])->name('languages.index');
        Route::post('/languages',                     [LanguageController::class, 'store'])->name('languages.store');
        Route::put('/languages/{language}',           [LanguageController::class, 'update'])->name('languages.update');
        Route::delete('/languages/{language}',        [LanguageController::class, 'destroy'])->name('languages.destroy');
        Route::patch('/languages/{language}/toggle',  [LanguageController::class, 'toggleStatus'])->name('languages.toggle');
        Route::patch('/languages/{language}/default', [LanguageController::class, 'setDefault'])->name('languages.set-default');

        // Header Settings
        Route::get('/header',  [HeaderSettingController::class, 'edit'])->name('header.edit');
        Route::post('/header', [HeaderSettingController::class, 'update'])->name('header.update');

        // Footer Settings
        Route::get('/footer',  [FooterSettingController::class, 'edit'])->name('footer.edit');
        Route::post('/footer', [FooterSettingController::class, 'update'])->name('footer.update');

        // About Section (Global — shown on Home page and About page)
        Route::get('/global-about',  [GlobalAboutSettingController::class, 'edit'])->name('global-about.edit');
        Route::post('/global-about', [GlobalAboutSettingController::class, 'update'])->name('global-about.update');

        // Why Choose Us Section (Global — shown on Home page)
        Route::get('/why-choose-us',  [WhyChooseUsSettingController::class, 'edit'])->name('why-choose-us.edit');
        Route::post('/why-choose-us', [WhyChooseUsSettingController::class, 'update'])->name('why-choose-us.update');

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
        // Video Gallery CMS
        Route::get('/video-gallery',                           [VideoGalleryController::class, 'index'])->name('video-gallery.index');
        Route::post('/video-gallery',                          [VideoGalleryController::class, 'store'])->name('video-gallery.store');
        Route::put('/video-gallery/{videoGallery}',            [VideoGalleryController::class, 'update'])->name('video-gallery.update');
        Route::delete('/video-gallery/{videoGallery}',         [VideoGalleryController::class, 'destroy'])->name('video-gallery.destroy');
        Route::post('/video-gallery/reorder',                  [VideoGalleryController::class, 'reorder'])->name('video-gallery.reorder');
        Route::post('/video-gallery/settings',                 [VideoGalleryController::class, 'updateSettings'])->name('video-gallery.settings');

        // SMS Gateway Configuration & Template Editor
        Route::get('/sms',        [SmsSettingController::class, 'edit'])->name('sms.edit');
        Route::post('/sms',       [SmsSettingController::class, 'update'])->name('sms.update');
        Route::post('/sms/test',  [SmsSettingController::class, 'testSms'])->name('sms.test');
        Route::get('/sms/logs',   [SmsSettingController::class, 'logs'])->name('sms.logs');

        // Payment Gateways Settings (SSLCommerz & bKash)
        Route::get('/payment-gateways',  [PaymentGatewaySettingController::class, 'edit'])->name('payment-gateways.edit');
        Route::post('/payment-gateways', [PaymentGatewaySettingController::class, 'update'])->name('payment-gateways.update');
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

// Payment Processing Endpoints (Public & Webhooks)
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/initiate',                  [PaymentController::class, 'initiate'])->name('initiate');
    Route::get('/checkout/{payment}',         [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/sandbox/process/{payment}', [PaymentController::class, 'processSandbox'])->name('sandbox.process');
    Route::match(['get', 'post'], '/sslcommerz/success', [PaymentController::class, 'sslSuccess'])->name('sslcommerz.success');
    Route::match(['get', 'post'], '/sslcommerz/fail',    [PaymentController::class, 'sslFail'])->name('sslcommerz.fail');
    Route::match(['get', 'post'], '/sslcommerz/cancel',  [PaymentController::class, 'sslCancel'])->name('sslcommerz.cancel');
    Route::post('/sslcommerz/ipn',                       [PaymentController::class, 'sslIpn'])->name('sslcommerz.ipn');
    Route::match(['get', 'post'], '/bkash/callback',     [PaymentController::class, 'bkashCallback'])->name('bkash.callback');
    Route::get('/receipt/{payment}',          [PaymentController::class, 'receipt'])->name('receipt');
    Route::get('/failed/{payment?}',          [PaymentController::class, 'failed'])->name('failed');
    Route::get('/cancelled/{payment?}',       [PaymentController::class, 'cancelled'])->name('cancelled');
});

require __DIR__.'/auth.php';

// CMS Pages catch-all — MUST stay the last route in the file so it never
// shadows any of the specific/admin routes registered above it (including
// the auth routes required just above: /login, /register, etc.). Resolves
// nested paths (e.g. /parent-slug/child-slug) against Page::fullPath();
// falls through to the themed 404 view (resources/views/errors/404.blade.php)
// when nothing matches.
Route::get('/{path}', [FrontendController::class, 'showPage'])->where('path', '.*')->name('page.show');
