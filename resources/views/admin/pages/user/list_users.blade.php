@extends('admin.master_layout')
@section('title', 'Danh sách người dùng')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Danh sách người dùng</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý người dùng</li>
                        <li class="breadcrumb-item active">Danh sách người dùng</li>
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
                                 <a type="button" class="btn btn-success" href="{{route('user.create')}}">
                                    <i class="fa-solid fa-plus" title="Thêm mới người dùng"></i>
                                 </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hình ảnh</th>
                                        <th>Họ tên</th>
                                        <th>SĐT</th>  
                                        <th>Bộ phận</th>
                                        <th>Chức vụ</th>
                                        <th>Phân quyền</th>
                                        <th>Trạng thái</th>                                      
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($users as $items)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td><img src="{{ $items->avatar }}" alt="" style="width: 80px; height: 80px"></td>
                                        <td>{{ $items->full_name }}</td>
                                        <td>{{ $items->phone }}</td>
                                        <td>{{ $items->unit ? $items->unit->name : 'N/A' }}</td>
                                        <td>{{ $items->position ? $items->position->name : 'N/A' }}</td> 
                                        <td>{{ $items->role ? $items->role->role_name : 'N/A' }}</td>
                                        <td>
                                            @switch($items->status)
                                                @case(1)
                                                    <span class="btn btn-sm btn-success">Đang hoạt động</span>
                                                    @break
                                                @case(2)
                                                    <span class="btn btn-sm btn-warning">Đã bị khóa</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('device.edit', $items->user_id)}}" class="btn btn-info btn-sm" title="Xem thông tin người dùng">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if($items->role_id != 1)
                                                @if ($items->status)
                                                    <a class="btn btn-danger btn-sm btn-lock-acc" data-id="{{ $items->user_id }}" title="Khóa tài khoản người dùng">
                                                        <i class="fa-solid fa-lock"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-success btn-sm btn-unlock-acc" data-id="{{ $items->user_id }}" title="Mở khóa tài khoản">
                                                        <i class="fa-solid fa-lock-open"></i>
                                                    </a>
                                                @endif
                                            @endif
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

        $('body').on('click', '.btn-lock-acc', function (e) {
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

