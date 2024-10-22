@extends('master_layout')
@section('title', 'Chỉnh sửa Menu')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Chỉnh sửa Menu</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý Menu</li>
                        <li class="breadcrumb-item active">Chỉnh sửa Menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{route("menu.update", $edit->menu_id)}}" id="quickForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tên Menu</label>
                                            <input type="text" name="menu_name" class="form-control" value="{{$edit->menu_name}}" placeholder="Nhập tên Menu">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cấp Menu</label>
                                            <select name="item_level" class="form-control select2bs4" style="width: 100%">
                                                <option value="1" {{ $edit->item_level == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $edit->item_level == 2 ? 'selected' : '' }}>2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Menu cha</label>
                                    <select name="parent_level" class="form-control select2bs4">
                                        <option value="0">---Chọn Menu cha---</option>
                                        @foreach($listMenu as $item)
                                            <option value="{{ $item->menu_id }}" {{ $item->menu_id == $edit->parent_level ? 'selected' : '' }}>{{ $item->menu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vị trí hiển thị</label>
                                            <input type="number" name="item_order" value="{{ $edit->item_order }}" class="form-control" placeholder="Nhập vị trí hiển thị">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" name="icon" value="{{ $edit->icon }}" class="form-control" placeholder="Nhập Icon Menu">
                                        </div>
                                    </div>
                                </div>                               
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Route</label>
                                            <input type="text" name="route" value="{{$edit->route}}" class="form-control" placeholder="Nhập Route menu">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phân quyền</label>
                                            <select name="role_id" class="form-control select2bs4">
                                                <option value="0">--Tất cả--</option>
                                                @foreach($roles as $item);
                                                <option value="{{$item->role_id}}" {{ $item->role_id == $edit->role_id ? 'selected' : '' }}>{{$item->role_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pt-2">
                                    <label for="is_active">Trạng thái</label>
                                    <div class="icheck-success d-inline" style="margin-left:10px">
                                        <input type="checkbox" name="is_active" id="checkboxSuccess1" value="1" {{ old('is_active', $edit->is_active) ? 'checked' : '' }}>
                                        <label for="checkboxSuccess1"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('menu.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk" title="Lưu"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script src="{{asset("assets/plugins/jquery-validation/jquery.validate.min.js")}}"></script>
    <script src="{{asset("assets/plugins/jquery-validation/additional-methods.min.js")}}"></script>
    <script src="{{asset("assets/plugins/select2/js/select2.full.min.js")}}"></script>
    <script src="{{asset("assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js")}}"></script>

    <script>
        $(function () {
            $('#quickForm').validate({
                rules: {
                    menu_name: {
                        required: true,
                        minlength: 2,
                    },
                    item_order: {
                        required: true,
                        min: 1
                    },
                    icon: {
                        required: true,
                        minlength: 2,
                    },                  
                    route: {
                        required: true
                    }
                },
                messages: {
                    menu_name: {
                        required: "Tên Menu không được để trống",
                        minlength: "Tên Menu phải có ít nhất {0} ký tự!"
                    },
                    item_order: {
                        required: "Vị trí hiển thị không được để trống",
                        min: "Vị trí hiển thị phải lớn hơn {0}!"
                    },
                    icon: {
                        required: "Icon Menu không được để trống",
                        minlength: "Icon Menu phải có ít nhất {0} ký tự!"
                    },                
                    route: {
                        required: "Tên Route không được để trống"
                    }                   
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
