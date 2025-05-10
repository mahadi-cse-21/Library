<?php

use App\Exports\OverdueBooksExport;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentProfileController;
use App\Mail\TestMail;
use App\Models\Reservation;
use App\Notifications\OverdueBooksNotification;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:librarian'])->group(function () {

    Route::get('/admin', [DashboardController::class, 'index'])->name('admin');


    Route::get('return/{borrow}', [BorrowController::class, 'update'])->name('borrow.return');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/students/export', [AdminStudentController::class, 'export'])->name('students.export');

    Route::resource('students', AdminStudentController::class)->names(['index' => 'students.index']);

    Route::get(
        'addnewstudent',
        [AdminStudentController::class, 'viewstudentform']
    )->name('addnewstudent');

    Route::get('/addnewbook', [BookController::class, 'addnewbook'])->name('addnewbook');

    Route::resource('books', BookController::class)->names(['index' => 'books.index']);
    // Route::resource('students', StudentController::class)->names(['index' => 'students.index']);
    Route::resource('borrows', BorrowController::class)->names(['index' => 'borrows.index']);
    Route::resource('reservations', ReservationController::class)->names(['index' => 'reservations.index']);


    Route::resource('settings', SettingController::class)->only(['index'])->names([
        'index' => 'settings.index'
    ]);


    Route::resource('fines', FineController::class)->names([
        'index' => 'fine.index',
    ]);

    Route::resource('reservations', ReservationController::class)->names([
        'index' => 'reservations.index',
    ]);
    Route::post('requests/{id}/approve', [RequestsController::class, 'approve'])->name('requests.approve');

    Route::post('requests/{id}/reject', [RequestsController::class, 'reject'])->name('requests.reject');

    Route::get('/overdue-books/pdf', function () {
        $export = new OverdueBooksExport();
        return $export->downloadPDF(); // triggers download to user's device
    })->name('overdue_books.pdf');

    // Route::get('/send-overdue-notifications', [App\Http\Controllers\NotificationController::class, 'sendOverdue'])->name('notifications.send');

    Route::get('/send-email', SendEmailController::class)->name('send.email');
    Route::get('/overdue_books/{id}/notify', SendEmailController::class, 'notify')->name('notify');
});





Route::resource('history', HistoryController::class)->names([
    'index' => 'student.history.index',
]);


// Student section routes - grouped with auth middleware
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {

    //(auth()->user()->role);

    Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');

    Route::get('/browse', [BrowseController::class, 'index'])->name('browse.index');
    Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile.index');

    Route::post('/borrows/{id}/{book_copy_id}', [BorrowController::class, 'store'])->name('borrows.store');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reserve');
    Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [StudentProfileController::class, 'update'])->name('profile.update');
});




require __DIR__ . '/auth.php';
