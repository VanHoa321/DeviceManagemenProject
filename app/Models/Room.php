<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "building_id",
        "description"
    ];
    protected $primaryKey = 'room_id';
    protected $table = 'rooms';
    public $timestamps = false;

    public function building()
    {
        return $this->belongsTo(Buildings::class, 'building_id');
    }
}
