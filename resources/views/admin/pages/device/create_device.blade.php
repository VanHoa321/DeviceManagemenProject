@extends('master_layout')
@section('title', 'Thêm mới thiết bị')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Thêm mới thiết bị</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thiết bị</li>
                        <li class="breadcrumb-item active">Thêm mới thiết bị</li>
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
                        <form method="post" action="{{route("device.store")}}" id="quickForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                                        <div class="form-group text-center mt-2">
                                            <img id="holder" src="" 
                                                style="width:300px; height:300px; border:2px solid #ccc; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);" 
                                                class="mx-auto d-block mb-4" />
                                            <span class="input-group-btn mr-2">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-info">
                                                    <i class="fa-solid fa-image"></i> Chọn ảnh
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="hidden" name="image">                                                                             
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Tên thiết bị</label>
                                            <input type="text" name="name" class="form-control" placeholder="Nhập tên loại thiết bị">
                                        </div>  
                                        <div class="form-group">
                                            <label>Tên phân loại</label>
                                            <select name="type_id" class="form-control select2bs4">
                                                <option value="0">---Chọn phân loại---</option>
                                                @foreach($types as $item);
                                                <option value="{{$item->type_id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Thuộc phòng</label>
                                            <select name="room_id" class="form-control select2bs4">
                                                <option value="0">---Chọn phòng---</option>
                                                @foreach($rooms as $item);
                                                <option value="{{$item->room_id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Đơn vị quản lý</label>
                                            <select name="unit_id" class="form-control select2bs4">
                                                <option value="0">---Chọn đơn vị---</option>
                                                @foreach($units as $item);
                                                <option value="{{$item->unit_id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Số hiệu</label>
                                                    <input type="text" name="code" class="form-control" placeholder="Nhập số hiệu thiết bị">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Năm sử dụng</label>
                                                    <input type="date" name="years" class="form-control" placeholder="Nhập năm sử dụng thiết bị">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Trạng thái</label>
                                                    <select name="status" class="form-control select2bs4">
                                                        <option value="1">Đang hoạt động</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('device.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
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
                    name: {
                        required: true,
                        minlength: 2,
                    },
                    code: {
                        required: true,
                        minlength: 2,
                    },
                    years: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Tên thiết bị không được để trống",
                        minlength: "Tên thiết bị phải có ít nhất {0} ký tự!"
                    },
                    code: {
                        required: "Số hiệu thiết bị không được để trống",
                        minlength: "Số hiệu thiết bị phải có ít nhất {0} ký tự!"
                    },
                    years: {
                        required: "Năm sử dụng không được để trống"
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
