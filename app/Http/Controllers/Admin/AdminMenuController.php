<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;

class AdminMenuController extends Controller
{

    public function index()
    {
        $menus = Menu::with('parent')->orderBy("menu_id", "desc")->get();
        return view("admin.pages.menu.list_menu", compact("menus"));
    }

    public function create()
    {
        $listMenu = Menu::where('is_active', true)
                    ->where('parent_level', 0)
                    ->orderBy('menu_id', 'desc')->get();
        $roles = Role::all();
        return view("admin.pages.menu.create_menu", compact("listMenu","roles"));
    }

    public function store(Request $request)
    {
        $create = new Menu();
        $create->menu_name = $request->menu_name;
        $create->item_level = $request->item_level;
        $create->parent_level = $request->parent_level;
        $create->item_order = $request->item_order;
        $create->icon = $request->icon;
        $create->route = $request->route;
        $create->role_id = $request->role_id;
        $create->is_active = $request->has('is_active') ? true : false;
        $create->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới Menu thành công"]);
        return redirect()->route("menu.index");
    }

    public function edit($id)
    {
        $listMenu = Menu::where('is_active', true)
                    ->where('parent_level', 0)
                    ->orderBy('menu_id', 'desc')->get();
        $edit = Menu::where("menu_id", $id)->first();
        $roles = Role::all();
        return view("admin.pages.menu.edit_menu", compact("edit", "listMenu", "roles"));
    }

    public function update(Request $request, $id)
    {
        $update = Menu::where("menu_id", $id)->first();
        $update->menu_name = $request->menu_name;
        $update->item_level = $request->item_level;
        $update->parent_level = $request->parent_level;
        $update->item_order = $request->item_order;
        $update->icon = $request->icon;
        $update->route = $request->route;
        $update->role_id = $request->role_id;
        $update->is_active = $request->has('is_active') ? true : false;
        $update->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Cập nhật Menu thành công"]);
        return redirect()->route("menu.index");
    }

    public function destroy($id)
    {
        $destroy = Menu::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json(['success' => true, 'message' => 'Xóa menu thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Menu không tồn tại'], 404);
        }
    }

    public function changeActive($id)
    {

        $change = Menu::find($id);    
        if ($change) {
            $change->is_active = !$change->is_active;
            $change->save();

            return response()->json(['success' => true, 'message' => 'Thay đổi trạng thái thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Thay đổi trạng thái không thành công'], 404);
        }
    }
}
