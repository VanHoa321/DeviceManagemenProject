<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceType;

class DeviceTypeController extends Controller
{
    public function index()
    {
        $deviceTypes = DeviceType::all();
        return view("admin.pages.device-type.list_dtypes", compact("deviceTypes"));
    }

    public function create()
    {
        return view("admin.pages.device-type.create_dtype");
    }

    public function store(Request $request)
    {
        $create = new DeviceType();
        $create->name = $request->name;
        $create->description = $request->description;
        $create->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới loại thiết bị thành công"]);
        return redirect()->route("dtype.index");
    }

    public function edit($id)
    {
        $edit = DeviceType::find($id);
        return view("admin.pages.device-type.edit_dtype", compact("edit"));
    }

    public function update(Request $request, $id)
    {
        $update = DeviceType::find($id );
        $update->name = $request->name;
        $update->description = $request->description;
        $update->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Chỉnh sửa loại thiết bị thành công"]);
        return redirect()->route("dtype.index");
    }

    public function destroy($id)
    {
        $destroy = DeviceType::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json(['success' => true, 'message' => 'Xóa loại thiết bị thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa loại thiết bị không thành công'], 404);
        }
    }
}
