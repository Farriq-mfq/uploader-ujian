<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'time_start', 'time_end', 'ip_start', 'ip_end', 'folder', 'status', "extensions", "mata_kuliah", "kelas"];
    protected $guarded = ['id'];

    public function scopeActive($query, $status, $id)
    {
        return $query->where('id', $id)->update(['status' => !$status]);
    }

    public function allowsIP(): HasMany
    {
        return $this->hasMany('allow_ips', 'room_id');
    }
}
