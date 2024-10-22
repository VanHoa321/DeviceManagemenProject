<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\BuildingsController;
use App\Http\Controllers\Admin\DeviceTypeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UseUnit\HomeUserUnitController;
use App\Http\Controllers\UseUnit\ErrorReportController;

Route::get('/',[AccountController::class, "login"])->name("index");

Route::group(['prefix' => 'files-manager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//Account
Route::get('/dang-nhap', [AccountController::class, 'login'])->name('login');
Route::post('/login', [AccountController::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [AccountController::class, 'logout'])->name('logout');

//Profile
Route::get('/thong-tin-tai-khoan', [AccountController::class, 'profile']) ->name('profile');
Route::get('/cap-nhat-thong-tin', [AccountController::class, 'editProfile']) ->name('edit.profile');
Route::post('/profile/update', [AccountController::class, 'updateProfile']) -> name('updateProfile');
Route::get('/doi-mat-khau', [AccountController::class, 'editPassword']) ->name('editPassword');
Route::post('/update-password', [AccountController::class, 'updatePassword']) -> name('updatePassword');

//Admin
Route::prefix('admin')->middleware("admin")->group(function () {
    Route::get('/trang-chu', [HomeController::class, 'index']) ->name('home.index');   
    //CRUD Menu
    Route::get('/menu/index', [AdminMenuController::class, 'index']) ->name('menu.index');
    Route::get('/menu/create', [AdminMenuController::class, 'create']) -> name('menu.create');
    Route::post('/menu/store', [AdminMenuController::class, 'store']) -> name('menu.store');
    Route::get('/menu/edit/{id}', [AdminMenuController::class, 'edit']) -> name('menu.edit');
    Route::post('/menu/update/{id}', [AdminMenuController::class, 'update']) -> name('menu.update');
    Route::delete('/menu/destroy/{id}', [AdminMenuController::class, 'destroy']);
    Route::post('/menu/change/{id}', [AdminMenuController::class, 'changeActive']);

    //CRUD Buildings
    Route::get('/danh-sach-toa-nha', [BuildingsController::class, 'index']) ->name('buildings.index');
    Route::get('/them-moi-toa-nha', [BuildingsController::class, 'create']) -> name('buildings.create');
    Route::post('/buildings/store', [BuildingsController::class, 'store']) -> name('buildings.store');
    Route::get('/chinh-sua-toa-nha/{id}', [BuildingsController::class, 'edit']) -> name('buildings.edit');
    Route::post('/buildings/update/{id}', [BuildingsController::class, 'update']) -> name('buildings.update');
    Route::delete('/buildings/destroy/{id}', [BuildingsController::class, 'destroy']);

    //CRUD Rooms
    Route::get('/danh-sach-phong', [RoomController::class, 'index']) ->name('room.index');
    Route::get('/them-moi-phong', [RoomController::class, 'create']) -> name('room.create');
    Route::post('/room/store', [RoomController::class, 'store']) -> name('room.store');
    Route::get('/chinh-sua-phong/{id}', [RoomController::class, 'edit']) -> name('room.edit');
    Route::post('/room/update/{id}', [RoomController::class, 'update']) -> name('room.update');
    Route::delete('/room/destroy/{id}', [RoomController::class, 'destroy']);

    //CRUD Device Type
    Route::get('/danh-sach-phan-loai', [DeviceTypeController::class, 'index']) ->name('dtype.index');
    Route::get('/them-moi-phan-loai', [DeviceTypeController::class, 'create']) -> name('dtype.create');
    Route::post('/devicetype/store', [DeviceTypeController::class, 'store']) -> name('dtype.store');
    Route::get('/chinh-sua-phan-loai/{id}', [DeviceTypeController::class, 'edit']) -> name('dtype.edit');
    Route::post('/devicetype/update/{id}', [DeviceTypeController::class, 'update']) -> name('dtype.update');
    Route::delete('/dtype/destroy/{id}', [DeviceTypeController::class, 'destroy']);

    //CRUD Device
    Route::get('/danh-sach-thiet-bi', [DeviceController::class, 'index']) ->name('device.index');
    Route::get('/them-moi-thiet-bi', [DeviceController::class, 'create']) -> name('device.create');
    Route::post('/device/store', [DeviceController::class, 'store']) -> name('device.store');
    Route::get('/chinh-sua-thiet-bi/{id}', [DeviceController::class, 'edit']) -> name('device.edit');
    Route::post('/device/update/{id}', [DeviceController::class, 'update']) -> name('device.update');
    Route::delete('/device/destroy/{id}', [DeviceController::class, 'destroy']);

    //User
    Route::get('/danh-sach-nguoi-dung', [UserController::class, 'index']) ->name('user.index');
    Route::get('/them-moi-nguoi-dung', [UserController::class, 'create']) -> name('user.create');
    Route::post('/user/store', [UserController::class, 'store']) -> name('user.store');
    Route::get('/thong-tin-nguoi-dung/{id}', [UserController::class, 'show']) -> name('user.show');
    Route::post('/user/change-status/{id}', [UserController::class, 'changeStatus']);
});

Route::prefix('use-unit')->middleware("use-unit")->group(function () {
    Route::get('/trang-chu', [HomeUserUnitController::class, 'index']) ->name('homeU.index');

    //Error Report
    Route::get('/bao-loi-thiet-bi', [ErrorReportController::class, 'index']) ->name('report.index');
    Route::post('/add-to-report/{id}', [ErrorReportController::class, 'addtoReport']);
    Route::get('/get-buildings/{branch_id}', [ErrorReportController::class, 'getBuildingsByBranch']);
    Route::get('/get-rooms/{building_id}', [ErrorReportController::class, 'getRoomsByBuilding']);
    Route::get('/get-devices/{room_id}', [ErrorReportController::class, 'getDevicesByRoom']);
    Route::get('/chi-tiet-phieu-bao-tri', [ErrorReportController::class, 'detail'])->name('report.detail');
    Route::post('/remove-report/{id}', [ErrorReportController::class, 'removeReport']);
    Route::get('/clear-report', [ErrorReportController::class, 'clearReport']);
    Route::get('/get-error/{id}', [ErrorReportController::class, 'getErrorReport']);
    Route::post('/save-error', [ErrorReportController::class, 'saveErrorReport']);
    Route::post('/save-maintenance', [ErrorReportController::class, 'saveMaintenance']);
});

