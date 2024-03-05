<?php

namespace App\Providers;

use App\Services\Repositories\AuthenticateRepository\AuthAdminRepository;
use App\Services\Repositories\AuthenticateRepository\AuthCustomerRepository;

use App\Services\Interfaces\AuthInterface\AuthAdminInterface;
use App\Services\Interfaces\AuthInterface\AuthCustomerInterface;
use App\Services\Interfaces\ConceptInterface\AdminConceptInterface;
use App\Services\Interfaces\DistrictInterface\AdminDistrictInterface;
use App\Services\Interfaces\HotelInterface\AdminHotelInterface;
use App\Services\Interfaces\HotelInterface\CustomerHotelInterface;
use App\Services\Interfaces\ReservationInterface\AdminReservationInterface;
use App\Services\Interfaces\RoomInterface\AdminRoomInterface;
use App\Services\Repositories\ConceptRepository\AdminConceptRepository;
use App\Services\Repositories\DistrictRepository\AdminDistrictRepository;
use App\Services\Repositories\HotelRepository\AdminHotelRepository;
use App\Services\Repositories\HotelRepository\CustomerHotelRepository;
use App\Services\Repositories\ReservationRepository\AdminReservationRepository;
use App\Services\Repositories\RoomRepository\AdminRoomRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auth Admins
        $this->app->bind(AuthAdminInterface::class, AuthAdminRepository::class);
        // Auth Customers
        $this->app->bind(AuthCustomerInterface::class, AuthCustomerRepository::class);

        // Admin Districts
        $this->app->bind(AdminDistrictInterface::class, AdminDistrictRepository::class);

        // Admin Hotels
        $this->app->bind(AdminHotelInterface::class, AdminHotelRepository::class);
        // Customer Hotels
        $this->app->bind(CustomerHotelInterface::class, CustomerHotelRepository::class);

        // Admin Rooms
        $this->app->bind(AdminRoomInterface::class, AdminRoomRepository::class);

        // Admin Concepts
        $this->app->bind(AdminConceptInterface::class, AdminConceptRepository::class);

        // Admin Reservations
        $this->app->bind(AdminReservationInterface::class, AdminReservationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
