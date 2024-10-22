@extends('master_layout')
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
                                        <td class="status-column">
                                            @switch($items->status)
                                                @case(1)
                                                    <span class="btn btn-sm btn-success" style="width:120px">Đang hoạt động</span>
                                                    @break
                                                @case(0)
                                                    <span class="btn btn-sm btn-warning" style="width:120px">Đã bị khóa</span>
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>                                                                                                                    
                                        <td>
                                            <a href="{{route('user.show', $items->user_id)}}" class="btn btn-info btn-sm" title="Xem thông tin người dùng">
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
        $('body').on('click', '.btn-lock-acc, .btn-unlock-acc', function (e) {
            e.preventDefault();
            var button = $(this);
            const id = button.data('id');
            var statusColumn = button.closest('tr').find('.status-column');
            var actionTitle = button.hasClass('btn-lock-acc') ? "Xác nhận khóa tài khoản?" : "Xác nhận mở khóa tài khoản?";
            var actionConfirmText = button.hasClass('btn-lock-acc') ? "Khóa" : "Mở khóa";
            
            Swal.fire({
                title: actionTitle,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: actionConfirmText,
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/user/change-status/" + id,
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message);
                                if (response.status) {
                                    button
                                        .removeClass('btn-success btn-unlock-acc')
                                        .addClass('btn-danger btn-lock-acc')
                                        .attr('title', 'Khóa tài khoản')
                                        .html('<i class="fa-solid fa-lock"></i>');
                                    statusColumn.html('<span class="btn btn-sm btn-success" style="width:120px">Đang hoạt động</span>');
                                } else {
                                    button
                                        .removeClass('btn-danger btn-lock-acc')
                                        .addClass('btn-success btn-unlock-acc')
                                        .attr('title', 'Mở khóa tài khoản')
                                        .html('<i class="fa-solid fa-lock-open"></i>');
                                    statusColumn.html('<span class="btn btn-sm btn-warning" style="width:120px">Đã bị khóa</span>');
                                }
                            } else {
                                toastr.error('Có lỗi khi thay đổi trạng thái tài khoản');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr); // Ghi lại chi tiết lỗi vào console
                            toastr.error('Có lỗi khi thực hiện yêu cầu: ' + xhr.responseText);
                        }
                    });
                }
            });
        });

        setTimeout(function() {
            $("#myAlert").fadeOut(500);
        },3500);
    })
</script>                              
@endsection

