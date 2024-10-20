<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buildings;
use App\Models\Branch;

class BuildingsController extends Controller
{

    public function index()
    {
        $buildings = Buildings::with('branch')->get();
        return view("admin.pages.buildings.list_buildings", compact("buildings"));
    }

    public function create()
    {
        $listBranch = Branch::orderBy('branch_id', 'desc')->get();
        return view("admin.pages.buildings.create_buildings", compact("listBranch"));
    }

    public function store(Request $request)
    {
        $create = new Buildings();
        $create->name = $request->name;
        $create->branch_id = $request->branch_id;
        $create->description = $request->description;
        $create->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới tòa nhà thành công"]);
        return redirect()->route("buildings.index");
    }

    public function edit($id)
    {
        $listBranch = Branch::orderBy('branch_id', 'desc')->get();
        $edit = Buildings::find($id);
        return view("admin.pages.buildings.edit_buildings", compact("edit", "listBranch"));
    }

    public function update(Request $request, $id)
    {
        $update = Buildings::find($id );
        $update->name = $request->name;
        $update->branch_id = $request->branch_id;
        $update->description = $request->description;
        $update->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Cập nhật tòa nhà thành công"]);
        return redirect()->route("buildings.index");
    }

    public function destroy($id)
    {
        $destroy = Buildings::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json(['success' => true, 'message' => 'Xóa tòa nhà thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa tòa nhà không thành công'], 404);
        }
    }
}
