<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "maintenance_id",
        "user_id",
        "device_id",
        "status",
        "expense",
        "error_description"
    ];
    protected $primaryKey = 'detail_id';
    protected $table = 'maintenance_details';
    public $timestamps = false;
}
