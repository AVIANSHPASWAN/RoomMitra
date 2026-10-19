
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public homepage
Route::get('/', [RoomController::class, 'index'])
    ->name('rooms.index');

// Login and registration
Route::middleware('guest:web,owner,admin')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

// Routes available to authenticated accounts
Route::middleware('auth:web,owner,admin')->group(function () {
    Route::get('/dashboard', [RoomController::class, 'dashboard'])
        ->name('dashboard');

    // Room management: controller must check Owner/Admin permissions
    Route::get('/my-rooms', [RoomController::class, 'myRooms'])
        ->name('rooms.manage');

    Route::get('/rooms/create', [RoomController::class, 'create'])
        ->name('rooms.create');

    Route::post('/rooms', [RoomController::class, 'store'])
        ->name('rooms.store');

    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])
        ->name('rooms.edit');

    Route::put('/rooms/{room}', [RoomController::class, 'update'])
        ->name('rooms.update');

    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
        ->name('rooms.destroy');

    // Admin management: UserController must enforce Admin permissions
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users');

    Route::patch('/admin/users/{id}/role', [UserController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/rooms/{room}', [RoomController::class, 'show'])
        ->name('rooms.show');
});
