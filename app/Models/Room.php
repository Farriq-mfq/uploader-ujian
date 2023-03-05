<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'time_start', 'time_end', 'folder', 'status', "extensions", "mata_kuliah", "kelas"];
    protected $guarded = ['id'];

    public function scopeActive($query, $status, $id)
    {
        return $query->where('id', $id)->update(['status' => !$status]);
    }

    public function allowsIP(): HasMany
    {
        return $this->hasMany(AllowIp::class, 'room_id');
    }
}
