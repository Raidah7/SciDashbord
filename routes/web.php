<?php

use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminResearchController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Researcher\ResearchController;
use App\Http\Controllers\ResearchInteractionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Researcher\NotificationController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('test',function() {
    $filePath = public_path('re3.xls');
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    for ($i = 1; $i < count($rows); $i++) {
        $row = $rows[$i];

        $addresses = $row[22];
        $affiliations = $row[23];
        $college = null;
        $department = null;

        if (preg_match('/Coll\s+([a-zA-Z\s]+)/i', $addresses, $match)) {
            $college = trim($match[1]);
        }
        if (preg_match('/Dept\s+([a-zA-Z\s]+)/i', $addresses, $match)) {
            $department = trim($match[1]);
        }
        DB::table('research')->insert([
            'title' => $row[8],
            'abstract' => $row[21],
            'authors' => $row[1],
            'fields' => $row[63],
//            'approved_by' => 8,
            'submitted_by' => in_array($i, [1]) ? 1 : 6,
            'status' => 'Approved',
            'approved' => 1,
            'college' => $college,
            'department' => $department,
        ]);
    }

    return 'Import completed successfully.';
});
Route::view('/', 'front.home')->name('home');
Route::post('/chat/gemini', [AIController::class, 'chatWithOpenAI'])->name('chat.gemini');


Route::get('/research', [FrontController::class, 'researchList'])->name('research.list');
Route::get('/research/{id}', [FrontController::class, 'researchDetails'])->name('research.details');
Route::middleware('auth')->group(function ($user) {
    Route::post('/research/{id}/comment', [ResearchInteractionController::class, 'storeComment'])->name('research.comment.store');
    Route::post('/research/{id}/rating', [ResearchInteractionController::class, 'storeRating'])->name('research.rating.store');
    Route::post('/research/{id}/feedback', [ResearchInteractionController::class, 'storeFeedback'])->name('research.feedback.store');
});
Route::view('/explore', 'front.explore')->name('explore');
Route::view('/contact', 'front.contact')->name('contact');
Route::view('/admin/dashboard', 'admin.dashboard')->middleware('auth', 'admin')->name('admin.dashboard');
Route::view('/profile', 'user.profile')->middleware('auth')->name('profile');
Route::view('/submissions', 'researcher.submissions')->middleware('auth', 'researcher')->name('submissions');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/researcher-profile', 'front.researcher-profile')->name('researcher.profile');


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
use App\Http\Controllers\Researcher\ResearcherController;

Route::prefix('researcher')->name('researcher.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [ResearcherController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ResearcherController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ResearcherController::class, 'updateProfile'])->name('profile.update');
    Route::resource('research', ResearchController::class);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/delete/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::post('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
    Route::get('/comments', [ResearcherController::class, 'listComments'])->name('comments');
    Route::get('/ratings', [ResearcherController::class, 'listRatings'])->name('ratings');
});
use App\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::post('/users/delete', [AdminUserController::class, 'delete'])->name('users.delete');

    Route::get('/research', [AdminResearchController::class, 'index'])->name('research.index');
    Route::get('/research/{id}', [AdminResearchController::class, 'details'])->name('research.details');
    Route::post('/research/update-status', [AdminResearchController::class, 'updateStatus'])->name('research.updateStatus');

    Route::get('/comments', [AdminUserController::class, 'comments'])->name('comments.index');
    Route::post('/comments/delete', [AdminUserController::class, 'deleteComment'])->name('comments.delete');
    Route::get('/ratings', [AdminUserController::class, 'ratings'])->name('ratings.index');
    Route::post('/ratings/delete', [AdminUserController::class, 'deleteRate'])->name('ratings.delete');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');

    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [AdminNotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/delete', [AdminNotificationController::class, 'delete'])->name('notifications.delete');
    Route::post('/notifications/readAll', [AdminNotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::post('/notifications/deleteAll', [AdminNotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
});


Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/comments-ratings', [UserController::class, 'commentsRatings'])->name('commentsRatings');
    Route::post('comment/delete', [UserController::class, 'deleteComment'])->name('comment.delete');
    Route::post('rating/delete', [UserController::class, 'deleteRating'])->name('rating.delete');
});
