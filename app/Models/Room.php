<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'time_start', 'time_end', 'ip_start', 'ip_end', 'folder', 'status', "extensions"];
    // protected $guarded = ['id'];

    public function scopeActive($query, $value)
    {
        return $query->update(['status' => $value], $value);
    }
}
