@extends('master_layout')
@section('title', 'Chỉnh sửa loại thiết bị')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Chỉnh sửa loại thiết bị</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thiết bị</li>
                        <li class="breadcrumb-item active">Chỉnh sửa loại thiết bị</li>
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
                        <form method="post" action="{{route("dtype.update", $edit->type_id)}}" id="quickForm">
                            @csrf
                            <div class="card-body">                                
                                <div class="form-group">
                                    <label>Tên phân loại thiết bị</label>
                                    <input type="text" name="name" value="{{$edit->name}}" class="form-control" placeholder="Nhập tên loại thiết bị">
                                </div>                                      
                                <div class="form-group">
                                    <label asp-for="Description">Mô tả thêm</label>
                                    <textarea class="form-control mb-3" name="description" placeholder="Nhập mô tả thêm" style=" height: 100px">{{$edit->description}}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('dtype.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
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
                    }
                },
                messages: {
                    name: {
                        required: "Tên loại thiết bị không được để trống",
                        minlength: "Tên loại thiết bị phải có ít nhất {0} ký tự!"
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
