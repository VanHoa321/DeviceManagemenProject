<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Models\Room;
use App\Models\WorkUnit;
class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('type', 'room', 'unit')->orderBy('device_id', 'desc')->get();
        return view("admin.pages.device.list_devices", compact("devices"));
    }

    public function create()
    {
        $types = DeviceType::orderBy('type_id', 'desc')->get();
        $rooms = Room::orderBy('room_id', 'desc')->get();
        $units = WorkUnit::orderBy('unit_id', 'desc')->get();
        return view('admin.pages.device.create_device', compact('types','rooms','units'));
    }

    public function store(Request $request)
    {
        $create = new Device();
        $create->name = $request->name;
        $create->type_id = $request->type_id;
        $create->room_id = $request->room_id;
        $create->unit_id = $request->unit_id;
        $create->code = $request->code;
        $create->image = $request->image;
        $create->years = $request->years;
        $create->status = $request->status;
        $create->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới thiết bị thành công"]);
        return redirect()->route("device.index");
    }

    public function edit($id)
    {
        $device = Device::find($id);
        $types = DeviceType::orderBy('type_id', 'desc')->get();
        $rooms = Room::orderBy('room_id', 'desc')->get();
        $units = WorkUnit::orderBy('unit_id', 'desc')->get();
        return view('admin.pages.device.edit_device', compact('device', 'types','rooms','units'));
    }

    public function update(Request $request, $id)
    {
        $update = Device::find($id);
        $update->name = $request->name;
        $update->type_id = $request->type_id;
        $update->room_id = $request->room_id;
        $update->unit_id = $request->unit_id;
        $update->code = $request->code;
        $update->image = $request->image;
        $update->years = $request->years;
        $update->status = $request->status;
        $update->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Chỉnh sửa thiết bị thành công"]);
        return redirect()->route("device.index");
    }

    public function destroy(string $id)
    {
        $destroy = Device::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json(['success' => true, 'message' => 'Xóa thiết bị thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa thiết bị không thành công'], 404);
        }
    }
}
