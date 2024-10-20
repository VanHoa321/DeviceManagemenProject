<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];

    protected $primaryKey = 'position_id';
    protected $table = 'positions';
    public $timestamps = false;
}
