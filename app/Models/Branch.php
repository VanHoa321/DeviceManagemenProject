<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        "branch_name",
        "address",
        "description"
    ];
    protected $primaryKey = 'branch_id';
    protected $table = 'branchs';
    public $timestamps = false;
}
