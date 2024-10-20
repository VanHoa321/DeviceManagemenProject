@extends('admin.master_layout')
@section('title', 'Danh sách thiết bị')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Danh sách thiết bị</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thiết bị</li>
                        <li class="breadcrumb-item active">Danh sách thiết bị</li>
                    </ol>
                </div>
            </div>
        </div>
        @if(Session::has('messenge') && is_array(Session::get('messenge')))
            @php
                $messenge = Session::get('messenge');
            @endphp
            @if(isset($messenge['style']) && isset($messenge['msg']))
                <div class="alert alert-{{ $messenge['style'] }}" role="alert" style="position: fixed; top: 70px; right: 16px; width: auto; z-index: 999" id="myAlert">
                    <i class="bi bi-check2 text-{{ $messenge['style'] }}"></i>{{ $messenge['msg'] }}
                </div>
                @php
                    Session::forget('messenge');
                @endphp
            @endif
        @endif
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                 <a type="button" class="btn btn-success" href="{{route('device.create')}}">
                                    <i class="fa-solid fa-plus" title="Thêm mới thiết bị"></i>
                                 </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên thiết bị</th>
                                        <th>Phân loại</th>
                                        <th>Thuộc phòng</th>     
                                        <th>Thuộc bộ phận</th>
                                        <th>Trạng thái</th>                                      
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($devices as $items)
                                    <tr id="device-{{ $items->device_id }}">
                                        <td>{{ $counter++ }}</td>
                                        <td><img src="{{ $items->image }}" alt="" style="width: 80px; height: 80px"></td>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->type ? $items->type->name : 'N/A' }}</td>
                                        <td>{{ $items->room ? $items->room->name : 'N/A' }}</td> 
                                        <td>{{ $items->unit ? $items->unit->name : 'N/A' }}</td>
                                        <td>
                                            @switch($items->status)
                                                @case(1)
                                                    <span class="btn btn-sm btn-success">Đang hoạt động</span>
                                                    @break
                                                @case(2)
                                                    <span class="btn btn-sm btn-warning">Đang bảo trì</span>
                                                    @break
                                                @case(3)
                                                    <span class="btn btn-sm btn-danger">Đang bị hỏng</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('device.edit', $items->device_id)}}" class="btn btn-info btn-sm" title="Sửa thông tin thiết bị">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $items->device_id}}" title="Xóa thiết bị">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>                              
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: "Xác nhận xóa thiết bị?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/device/destroy/" + id,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#device-'+id).remove();                           
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi xóa thiết bị');
                        }
                    });
                }
            });
        })

        setTimeout(function() {
            $("#myAlert").fadeOut(500);
        },3500);
    })
</script>                              
@endsection

