<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];
    protected $primaryKey = 'type_id';
    protected $table = 'device_types';
    public $timestamps = false;
}
