<?php

use App\Enums\RoleType;

use App\Http\Controllers\API\V1\Admin\Auth\AdminAuthenticateController;
use App\Http\Controllers\API\V1\Admin\Concept\AdminConceptController;
use App\Http\Controllers\API\V1\Admin\District\AdminDistrictController;
use App\Http\Controllers\API\V1\Admin\Hotel\AdminHotelController;
use App\Http\Controllers\API\V1\Admin\Reservation\AdminReservationController;
use App\Http\Controllers\API\V1\Admin\Room\AdminRoomController;
use App\Http\Controllers\API\V1\Customer\Auth\CustomerAuthenticateController;
use App\Http\Controllers\API\V1\Customer\Hotel\CustomerHotelController;
use App\Http\Controllers\API\V1\Customer\Reservation\CustomerReservationController;
use Illuminate\Support\Facades\Route;



/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::prefix('v1')->name('v1.')->group(function () {

    // Customer
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::controller(CustomerAuthenticateController::class)->group(function () {
            // POST
            Route::post('/login', 'login')->middleware('not.login.page.show')->name('login');
            Route::post('/register', 'register')->middleware('not.login.page.show')->name('register');
            Route::post('/forgot-password', 'forgotPassword')->middleware(['not.login.page.show', 'throttle:api.v1.forgot.password.limit'])->name('forgot.password');
            Route::post('/reset-password', 'resetPassword')->middleware('not.login.page.show')->name('reset.password');

            // GET
            Route::get('/logout', 'logout')->middleware(['auth:api'])->name('logout');
        });

        Route::middleware(['auth:api', 'role:' . RoleType::getByUsersRole()])->group(function () {
            // GET
            Route::get('/home', function () {
                return response()->json(['success' => true, 'message' => 'Müşteri Olarak Giriş Yaptın ' . auth()->user()->name]);
            })->name('home');


            Route::controller(CustomerHotelController::class)->group(function () {
                // GET
                Route::get('/hotel/distric/{districId}/lists', 'districHotelList')->name('distric.hotel.lists');
                Route::get('/hotel', 'getAll')->name('hotel');
                Route::get('/hotel/{id}/detail', 'hotelDetail')->name('hotel.detail');
            });

            Route::controller(CustomerReservationController::class)->group(function () {
                // GET
                Route::get('/reservation', 'getAll')->name('reservation');
                Route::get('/reservation/{id}/detail', 'detail')->name('reservation.detail');
                Route::get('/reservation/{id}/delete', 'delete')->name('reservation.delete');

                // POST
                Route::post('/reservation/create', 'create')->name('reservation.create');
            });
        });
    });

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::controller(AdminAuthenticateController::class)->group(function () {
            Route::post('/login', 'login')->middleware('not.login.page.show')->name('login');

            Route::get('/logout', 'logout')->middleware(['auth:api'])->name('logout');
        });

        Route::middleware(['auth:api'])->group(function () {
            Route::get('/home', function () {
                return response()->json(['success' => true, 'message' => 'Yönetici Olarak Giriş Yaptın ' . auth()->user()->name]);
            })->name('home');


            Route::controller(AdminDistrictController::class)->group(function () {
                // GET
                Route::get('/district', 'getAll')->name('district');
                Route::get('/district/{id}/detail', 'detail')->name('district.detail');
                Route::get('/district/{id}/delete', 'delete')->name('district.delete');

                // POST
                Route::post('/district/create', 'create')->name('district.create');
                Route::post('/district/update', 'update')->name('district.update');
            });

            Route::controller(AdminHotelController::class)->group(function () {
                // GET
                Route::get('/hotel', 'getAll')->name('hotel');
                Route::get('/hotel/{id}/detail', 'detail')->name('hotel.detail');
                Route::get('/hotel/{id}/delete', 'delete')->name('hotel.delete');

                // POST
                Route::post('/hotel/create', 'create')->name('hotel.create');
                Route::post('/hotel/update', 'update')->name('hotel.update');
            });

            Route::controller(AdminRoomController::class)->group(function () {
                // GET
                Route::get('/room', 'getAll')->name('room');
                Route::get('/room/{id}/detail', 'detail')->name('room.detail');
                Route::get('/room/{id}/delete', 'delete')->name('room.delete');

                // POST
                Route::post('/room/create', 'create')->name('room.create');
                Route::post('/room/update', 'update')->name('room.update');
            });

            Route::controller(AdminConceptController::class)->group(function () {
                // GET
                Route::get('/concept', 'getAll')->name('concept');
                Route::get('/concept/{id}/detail', 'detail')->name('concept.detail');
                Route::get('/concept/{id}/delete', 'delete')->name('concept.delete');

                // POST
                Route::post('/concept/create', 'create')->name('concept.create');
                Route::post('/concept/update', 'update')->name('concept.update');
            });

            Route::controller(AdminReservationController::class)->group(function () {
                // GET
                Route::get('/reservation', 'getAll')->name('reservation');
                Route::get('/reservation/{id}/detail', 'detail')->name('reservation.detail');
                Route::get('/reservation/{id}/customer/detail', 'customerReservations')->name('reservation.customer');
                Route::get('/reservation/{id}/delete', 'delete')->name('reservation.delete');

                // POST
                Route::post('/reservation/create', 'create')->name('reservation.create');
            });
        });
    });
});
