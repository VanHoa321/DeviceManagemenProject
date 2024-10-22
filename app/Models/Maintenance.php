<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "created_date",
        "review_id",
        "status",
        "description"
    ];
    protected $primaryKey = 'maintenance_id';
    protected $table = 'maintenances';
    public $timestamps = false;
}
