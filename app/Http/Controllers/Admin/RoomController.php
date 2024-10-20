<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buildings;
use App\Models\Room;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::with('building')->get();
        return view("admin.pages.room.list_rooms", compact("rooms"));
    }

    public function create()
    {
        $listBuildings = Buildings::orderBy('building_id', 'desc')->get();
        return view("admin.pages.room.create_room", compact("listBuildings"));
    }

    public function store(Request $request)
    {
        $create = new Room();
        $create->name = $request->name;
        $create->building_id = $request->building_id;
        $create->description = $request->description;
        $create->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới phòng thành công"]);
        return redirect()->route("room.index");
    }

    public function edit($id)
    {
        $listBuildings = Buildings::orderBy('building_id', 'desc')->get();
        $edit = Room::find($id);
        return view("admin.pages.room.edit_room", compact("edit", "listBuildings"));
    }

    public function update(Request $request, $id)
    {
        $update = Room::find($id );
        $update->name = $request->name;
        $update->building_id = $request->building_id;
        $update->description = $request->description;
        $update->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Chỉnh sửa phòng thành công"]);
        return redirect()->route("room.index");
    }

    public function destroy($id)
    {
        $destroy = Room::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json(['success' => true, 'message' => 'Xóa phòng thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa phòng không thành công'], 404);
        }
    }
}
