<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role', 'position', 'unit')->orderBy('user_id','desc')->get();
        return view("admin.pages.user.list_users", compact("users"));
    }

    public function create()
    {
        $positions = Position::orderBy('position_id','desc')->get();
        $units = WorkUnit::orderBy('unit_id','desc')->get();
        $roles = Role::orderBy('role_id','desc')->get();
        return view('admin.pages.user.create_user', compact('positions','units','roles'));
    }

    public function store(Request $request)
    {
        if (User::where('user_name', $request->user_name)->exists()) {
            $request->session()->put("messenge", ["style" => "danger", "msg" => "Tên người dùng đã tồn tại!"]);
            return redirect()->back()->withInput();
        }
    
        if (User::where('phone', $request->phone)->exists()) {
            $request->session()->put("messenge", ["style" => "danger", "msg" => "Số điện thoại đã tồn tại!"]);
            return redirect()->back()->withInput();
        }
    
        if (User::where('email', $request->email)->exists()) {
            $request->session()->put("messenge", ["style" => "danger", "msg" => "Email đã tồn tại!"]);
            return redirect()->back()->withInput();
        }

        $create = new User();
        $create->user_name = $request->user_name;
        $create->password = Hash::make($request->password);
        $create->full_name = $request->full_name;
        $create->email = $request->email;
        $create->phone = $request->phone;
        $create->dob = Carbon::now();
        $create->avatar = "http://127.0.0.1:8000/storage/photos/2/Image/img/avatar4.png";
        $create->status = 1;
        $create->position_id = $request->position_id;
        $create->unit_id = $request->unit_id;
        $create->role_id = $request->role_id;
        $create->save();
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới người dùng thành công"]);
        return redirect()->route("user.index");

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    public function changeStatus($id)
    {
        $user = User::find($id);
        if($user){
            $user->status = !$user->status;
            $user->save();
            return response()->json(['success' => true, 'status' => $user->status]);
        }
        else{
            return response()->json(['success'=> false, 'message'=> 'Không tìm thấy người dùng']);
        }
    }
}
