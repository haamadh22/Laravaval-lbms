<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// require __DIR__ . '/auth.php';

/* ================= HOME ================= */
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/books/{id}', [HomeController::class, 'show'])->name('book.detail');

// Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
// });

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
/* ================= DASHBOARD REDIRECT ================= */
Route::get('/dashboard', function () {

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');


/* ================= ADMIN ================= */
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    /* ===== DASHBOARD ===== */
    Route::get('/dashboard', function () {

        $totalBooks = DB::table('books')->count();
        $totalMembers = DB::table('members')->count();
        $issued = DB::table('book_issues')->where('status', 'issued')->count();
        $returned = DB::table('book_issues')->where('status', 'returned')->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalMembers',
            'issued',
            'returned'
        ));
    })->name('admin.dashboard');


    /* ===== MEMBERS ===== */
    Route::post('/members/register', [MemberController::class, 'registerAndStore'])->name('members.register');
    Route::resource('members', MemberController::class);


    /* ===== BOOKS ===== */
    Route::resource('books', BookController::class)->except(['create', 'show']);


    /* ===== ISSUE ===== */
    Route::get('/book-issue', [IssueController::class, 'index'])->name('issue.book');
    Route::post('/book-issue', [IssueController::class, 'store'])->name('issue.store');

    Route::get('/return-book', [IssueController::class, 'returnIndex'])->name('return.book');
    Route::post('/return-book', [IssueController::class, 'returnStore'])->name('return.store');

    Route::get('/issued-books', [IssueController::class, 'issuedBooks'])->name('issued.books');
    Route::get('/borrow-history', [IssueController::class, 'history'])->name('borrow.history');


    /* ===== AUTHORS ===== */
    Route::get('/authors', [AuthorController::class, 'index'])->name('admin.authors');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::put('/authors/{id}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');


    /* ===== CATEGORIES ===== */
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


/* ================= MEMBER ================= */
Route::prefix('member')->middleware(['auth', 'user'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/my-books', [UserDashboardController::class, 'myBooks'])
        ->name('user.mybooks');

    Route::get('/profile', [UserDashboardController::class, 'profile'])
        ->name('user.profile');
});


/* ================= PROFILE (DEFAULT LARAVEL) ================= */
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
