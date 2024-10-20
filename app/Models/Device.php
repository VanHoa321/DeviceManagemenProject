<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", 
        "type_id",
        "room_id",
        "unit_id",
        "code",
        "image",
        "years",
        "status"
    ];
    protected $primaryKey = 'device_id';
    protected $table = 'devices';
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(DeviceType::class, 'type_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function unit()
    {
        return $this->belongsTo(WorkUnit::class, 'unit_id');
    }
}
