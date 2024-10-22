@extends('master_layout')
@section('title', 'Danh sách Menu')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Danh sách Menu</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý Menu</li>
                        <li class="breadcrumb-item active">Danh sách Menu</li>
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
                                 <a type="button" class="btn btn-success" href="{{route('menu.create')}}">
                                    <i class="fa-solid fa-plus" title="Thêm mới Menu"></i>
                                 </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên Menu</th>
                                        <th>Cấp</th>
                                        <th>Menu cha</th>
                                        <th>Vị trí</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody id="showdata">
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($menus as $menu)
                                     <tr id="menu-{{ $menu->menu_id }}">
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $menu->menu_name }}</td>
                                        <td>{{ $menu->item_level }}</t>        
                                        @if ($menu->parent_level != 0 && $menu->parent)
                                            <td>{{ $menu->parent->menu_name }}</td>
                                        @else
                                            <td>Không</td>
                                        @endif                                       
                                        <td>{{ $menu->item_order }}</td>
                                        <td>
                                            @if ($menu->is_active)
                                                <a href="#" class="IsActive" data-id="{{ $menu->menu_id }}">
                                                    <i class="bi bi-check2 text-success" style="font-size:20px"></i>
                                                </a>
                                            @else
                                                <a href="#" class="IsActive" data-id="{{ $menu->menu_id }}">
                                                    <i class="bi bi-x text-danger" style="font-size:20px"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('menu.edit', $menu->menu_id)}}" class="btn btn-info btn-sm" title="Sửa Menu">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $menu->menu_id }}" title="Xóa Menu">
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

        $('body').on('click', '.IsActive', function (e) {
            e.preventDefault();
            var check = $(this);
            const id = check.data("id");
            $.ajax({
                url: "/admin/menu/change/" + id,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        if (check.html().includes('bi-x')) {
                            $(check).html("<i class='bi bi-check2 text-success' style='font-size: 20px'></i>");
                        } else {
                            $(check).html("<i class='bi bi-x text-danger' style='font-size: 20px'></i>");
                        }
                        toastr.success(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Có lỗi xảy ra khi đổi trạng thái');
                }
            });
        })

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const menuId = $(this).data('id');
            Swal.fire({
                title: "Xác nhận xóa Menu?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/menu/destroy/" + menuId,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#menu-'+menuId).remove();                           
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi xóa Menu');
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


