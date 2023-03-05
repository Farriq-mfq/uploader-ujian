<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttchRoom extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'size', 'room_id'];


    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
