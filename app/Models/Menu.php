<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        "menu_name",
        "item_level",
        "parent_level",
        "item_order",
        "icon",
        "route",
        "role_id",
        "is_active"
    ];
    protected $primaryKey = 'menu_id';
    protected $table = 'menus';
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_level');
    }
}
