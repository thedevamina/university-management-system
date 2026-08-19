<?php

use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Admin\WebhookEventController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Student\DocumentController as StudentDocumentController;
use App\Http\Controllers\Faculty\DocumentController as FacultyDocumentController;

// ── Welcome ───────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Dashboard ─────────────────────────────────────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return view('dashboards.admin');
    } elseif ($user->isFaculty()) {
        return view('dashboards.faculty');
    } else {
        return view('dashboards.student');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Profile ───────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Stripe Webhook ────────────────────────────────────────────
Route::post('stripe/webhook', [StripeWebhookController::class, 'handle'])
    ->name('stripe.webhook');

// ── Admin Routes ──────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::resource('departments', DepartmentController::class);
    Route::resource('faculty', FacultyController::class);
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('timetables', TimetableController::class);

    Route::resource('fees', FeeController::class)
        ->only(['index', 'create', 'store', 'destroy']);
    Route::patch('fees/{fee}/mark-paid', [FeeController::class, 'markPaid'])
        ->name('fees.markPaid');

    // Webhook Events
    Route::get('webhook-events', [WebhookEventController::class, 'index'])
        ->name('webhook-events.index');
    Route::get('fees/{fee}/webhook-events', [WebhookEventController::class, 'forFee'])
        ->name('fees.webhook-events');
    Route::get('webhook-events/payment/{payment}', [WebhookEventController::class, 'showPayment'])
        ->name('webhook-events.payment');
    Route::get('webhook-events/subscription/{subscription}', [WebhookEventController::class, 'showSubscription'])
        ->name('webhook-events.subscription');
    Route::get('webhook-events/event/{webhookEvent}', [WebhookEventController::class, 'show'])
        ->name('webhook-events.show');

    // Subscriptions
    Route::get('subscriptions', [AdminSubscriptionController::class, 'index'])
        ->name('subscriptions.index');

    // ── Admin Documents ───────────────────────────────────────
    Route::get('students/{student}/documents',
        [AdminDocumentController::class, 'indexForStudent'])
        ->name('students.documents.index');

    Route::post('students/{student}/documents',
        [AdminDocumentController::class, 'storeForStudent'])
        ->name('students.documents.store');

    Route::delete('students/{student}/documents/{document}',
        [AdminDocumentController::class, 'destroy'])
        ->name('students.documents.destroy');

    Route::get('faculty/{faculty}/documents',
        [AdminDocumentController::class, 'indexForFaculty'])
        ->name('faculty.documents.index');

    Route::post('faculty/{faculty}/documents',
        [AdminDocumentController::class, 'storeForFaculty'])
        ->name('faculty.documents.store');

    Route::delete('faculty/{faculty}/documents/{document}',
        [AdminDocumentController::class, 'destroyFaculty'])
        ->name('faculty.documents.destroy');
});

// ── Student Routes ────────────────────────────────────────────
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

    Route::resource('enrollments', EnrollmentController::class)
        ->only(['index', 'store', 'destroy']);
    Route::get('results', [ResultController::class, 'myResults'])->name('results');
    Route::get('fees', [FeeController::class, 'myFees'])->name('fees');
    Route::get('payment/{fee}', [PaymentController::class, 'checkout'])
        ->name('payment.checkout');
    Route::get('subscription', [SubscriptionController::class, 'show'])
        ->name('subscription');
    Route::get('subscription/checkout/{fee}', [SubscriptionController::class, 'checkout'])
        ->name('subscription.checkout');

    // ── Student Documents ─────────────────────────────────────
    Route::get('documents', [StudentDocumentController::class, 'index'])
        ->name('documents.index');
    Route::post('documents', [StudentDocumentController::class, 'store'])
        ->name('documents.store');
    Route::delete('documents/{document}', [StudentDocumentController::class, 'destroy'])
        ->name('documents.destroy');
});

// ── Faculty Routes ────────────────────────────────────────────
Route::middleware(['auth', 'role:faculty'])
    ->prefix('faculty')
    ->name('faculty.')
    ->group(function () {

    Route::get('attendance', [AttendanceController::class, 'create'])
        ->name('attendance.create');
    Route::post('attendance', [AttendanceController::class, 'store'])
        ->name('attendance.store');
    Route::resource('exams', ExamController::class);
    Route::get('results/{exam}', [ResultController::class, 'create'])
        ->name('results.create');
    Route::post('results/{exam}', [ResultController::class, 'store'])
        ->name('results.store');

    // ── Faculty Documents ─────────────────────────────────────
    Route::get('documents', [FacultyDocumentController::class, 'index'])
        ->name('documents.index');
    Route::post('documents', [FacultyDocumentController::class, 'store'])
        ->name('documents.store');
    Route::delete('documents/{document}', [FacultyDocumentController::class, 'destroy'])
        ->name('documents.destroy');
});

// ── Payment & Subscription Callbacks ─────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('payment/success', [PaymentController::class, 'success'])
        ->name('payment.success');
    Route::get('payment/cancel', [PaymentController::class, 'cancel'])
        ->name('payment.cancel');
    Route::get('subscription/success', [SubscriptionController::class, 'success'])
        ->name('subscription.success');
    Route::get('subscription/cancel', [SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');
});

require __DIR__.'/auth.php';