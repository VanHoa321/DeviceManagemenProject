<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];

    protected $primaryKey = 'unit_id';
    protected $table = 'work_units';
    public $timestamps = false;
}
