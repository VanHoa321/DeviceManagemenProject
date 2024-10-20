<?php

namespace App\View\Components;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminMenu extends Component
{
    public $menuItems;
    public function __construct()
    {
        $this -> menuItems = Menu::where("is_active", true)->orderBy("menu_id","asc")->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.admin-menu');
    }
}
