<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ShuttleCarController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\CustomerPlaceController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\PickupPlaceController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {

//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/edit/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/update', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::post('/schedule/delete', [ScheduleController::class, 'delete'])->name('schedule.delete');
    // Route::get('/schedule/get_create_data', [ScheduleController::class, 'get_create_data'])->name('schedule.get_create_data');/*ajax*/
    Route::get('/schedule/get_sche_stu_data', [ScheduleController::class, 'get_sche_stu_data'])->name('schedule.get_sche_stu_data');/*ajax*/
    Route::post('/schedule/sche_stu_update', [ScheduleController::class, 'sche_stu_update'])->name('schedule.sche_stu_update');
    Route::get('/pickup', [PickupController::class, 'index'])->name('pickup.index');
    Route::get('/pickup/edit/{id}', [PickupController::class, 'edit'])->name('pickup.edit');
    Route::post('/pickup/update', [PickupController::class, 'update'])->name('pickup.update');
    Route::get('/pickup_place', [PickupPlaceController::class, 'index'])->name('pickup.pickup_place_index');
    Route::get('/pickup_place/edit/{id}', [PickupPlaceController::class, 'edit'])->name('pickup.pickup_place_edit');
    Route::post('/pickup_place/update', [PickupPlaceController::class, 'update'])->name('pickup.pickup_place_update');
    Route::get('/mst/customer', [CustomerController::class, 'index'])->name('mst.index');
    Route::get('/mst/staff', [StaffController::class, 'index'])->name('mst.index');
    Route::get('/mst/shuttle_car', [ShuttleCarController::class, 'index'])->name('mst.index');
    Route::get('/mst/holiday', [HolidayController::class, 'index'])->name('mst.index');
    Route::get('/mst/customer_place', [CustomerPlaceController::class, 'index'])->name('mst.index');
});

require __DIR__.'/auth.php';
