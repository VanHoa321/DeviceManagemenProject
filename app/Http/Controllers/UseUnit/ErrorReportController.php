<?php

namespace App\Http\Controllers\UseUnit;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Device;
use App\Models\Buildings;
use App\Models\Room;
use App\Models\MaintenanceReview;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ErrorReportController extends Controller
{
    public function index()
    {
        $branchs = Branch::all();
        return view("useunit.pages.error-report.index", compact("branchs"));
    }

    public function detail(){
        return view("useunit.pages.error-report.detail");
    }

    public function addtoReport($id)
    {
        $device = Device::with('type', 'room', 'unit')->where('device_id', $id)->first();
        if ($device == null) {
            return response()->json(['danger' => true, 'message' => 'Không tìm thấy thiết bị']);
        }
        $reports = session()->get('reports', []);
        if (isset($reports[$device->device_id])) {
            return response()->json(['warning' => true, 'message' => 'Thiết bị đã có trong phiếu bảo trì']);
        } else {
            $reports[$device->device_id] = [
                'image' => $device->image,
                'name' => $device->name,
                'type' => $device->type->name,
                'code' => $device->code,
                'unit' => $device->unit->name,
                'error' => ''
            ];
            $count = count($reports);
            session()->put('reports', $reports);
            return response()->json(['success' => true, 'message' => 'Thêm vào phiếu bảo trì thành công', 'count' => $count]);
        }
    }

    public function removeReport($id){
        if($id){
            $resports = session()->get('reports');
            if(isset($resports[$id])){
                unset($resports[$id]);
                session()->put('reports', $resports);
            }
            return response()->json(['success' => true, 'message' => 'Đã xóa thiết bị khỏi phiếu bảo trì']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy thiết bị']);
    }

    public function clearReport() {
        if (session()->has('reports')) {
            session()->forget('reports');
            return response()->json(['success' => true, 'message' => 'Đã xóa tất cả thiết bị khỏi phiếu bảo trì']);
        }
        return response()->json(['success' => false, 'message' => 'Không có thiết bị nào trong phiếu bảo trì để xóa']);
    }
    
    public function getErrorReport($id)
    {
        $reports = session()->get('reports', []);
        
        if (isset($reports[$id])) {
            return response()->json([
                'success' => true,
                'error' => $reports[$id]['error']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thiết bị trong phiếu bảo trì'
            ]);
        }
    }

    public function saveErrorReport(Request $request)
    {
        $id = $request->input('id');
        $error = $request->input('error');
        
        $reports = session()->get('reports', []);
        if (isset($reports[$id])) {
            $reports[$id]['error'] = $error;
            session()->put('reports', $reports);
            return response()->json(['success' => true, 'message' => 'Lưu mô tả lỗi thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thiết bị trong phiếu bảo trì']);
        }
    }

    public function saveMaintenance(Request $request){

        //Tạo 1 biên bản đánh giá 
        $review = new MaintenanceReview();
        $review->quality = 5;
        $review->attitude = 5;
        $review->response = 5;
        $review->description = null;
        $review->save();

        $review_id = $review->review_id;

        // 2. Tạo một phiếu bảo trì mới với review_id
        $maintenance = new Maintenance();
        $maintenance->user_id = Auth::user()->user_id;
        $maintenance->created_date = now();
        $maintenance->review_id = $review_id;
        $maintenance->status = 0;
        $maintenance->description = $request->has('description') ? $request->description : null;
        $maintenance->save();

        $maintenance_id = $maintenance->maintenance_id;

        // 3. Đọc session reports và lưu vào bảng bảo trì chi tiết
        $reports = session()->get('reports', []);


        foreach ($reports as $device_id => $report) {
            // Kiểm tra xem mô tả lỗi có trống không
            if (empty($report['error'])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Hãy nhập mô tả lỗi cho mọi thiết bị'
                ]);
            }
            $maintenanceDetail = new MaintenanceDetail();
            $maintenanceDetail->maintenance_id = $maintenance_id;
            $maintenanceDetail->user_id = Auth::user()->user_id;
            $maintenanceDetail->device_id = $device_id;
            $maintenanceDetail->status = 0;
            $maintenanceDetail->expense = 0;
            $maintenanceDetail->error_description = $report['error'];
            $maintenanceDetail->save();

            //Cập nhật trạng thái thiết bị
            $device = Device::find($device_id);
            if ($device) {
                $device->status = 0;
                $device->save();
            }
        }

        session()->forget('reports');
        return response()->json(['success' => true, 'message' => 'Tạo phiếu bảo trì thành công']);
    }

    public function getBuildingsByBranch($branch_id)
    {
        $buildings = Buildings::where('branch_id', $branch_id)->get();
        return response()->json($buildings);
    }

    public function getRoomsByBuilding($building_id)
    {
        $rooms = Room::where('building_id', $building_id)->get();
        return response()->json($rooms);
    }

    public function getDevicesByRoom($room_id)
    {
        $devices = Device::with('type', 'room', 'unit')->where('room_id', $room_id)->get();
        return response()->json($devices);
    }
}
