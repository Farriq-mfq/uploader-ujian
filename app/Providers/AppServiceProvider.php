<?php

namespace App\Providers;

use App\Http\Requests\RoomsRequest;
use App\Models\Room;
use App\Observers\RoomObserver;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Room::observe(RoomObserver::class);
    }
}
