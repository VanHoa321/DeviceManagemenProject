<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        "quality",
        "attitude",
        "response",
        "description",
    ];
    protected $primaryKey = 'review_id';
    protected $table = 'maintenance_reviews';
    public $timestamps = false;
}
