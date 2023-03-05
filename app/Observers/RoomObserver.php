<?php

namespace App\Observers;

use App\Http\Requests\RoomsRequest;
use App\Models\Room;

class RoomObserver
{
    /**
     * Handle the Room "created" event.
     */
    public function created(Room $room): void
    {
        $data = [];
        foreach (request('ip') as $key => $ip) {
            $data[] =  ['ip' => $ip];
        }
        $room->allowsIP()->createMany($data);
    }

    /**
     * Handle the Room "updated" event.
     */
    public function updated(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "deleted" event.
     */
    public function deleted(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "restored" event.
     */
    public function restored(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "force deleted" event.
     */
    public function forceDeleted(Room $room): void
    {
        //
    }
}
