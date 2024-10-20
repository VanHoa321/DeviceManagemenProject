@extends('admin.master_layout')
@section('title', 'Cập nhật thông tin')
@section('content')

<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Cập nhật thông tin</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thông tin cá nhân</li>
                        <li class="breadcrumb-item active">Cập nhật thông tin</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img id="holder" class="profile-user-img img-fluid img-circle"
                                    src=""
                                    alt="User profile picture"
                                    style="width:250px; height:250px; object-fit:cover;">
                                <div class="mt-3">
                                    <span class="input-group-btn mr-2">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-info">
                                            <i class="fa-solid fa-image"></i> Chọn ảnh
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header p-3 text-center">
                            <h4>Thông tin tài khoản</h4>
                        </div>
                        <form method="post" action="{{route("updateProfile")}}" id="quickForm">
                            @csrf
                            <div class="card-body">
                                <input id="thumbnail" class="form-control" type="hidden" value="{{$user->avatar}}" name="avatar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Họ tên</label>
                                            <input type="text" name="full_name" value="{{$user->full_name}}" class="form-control" placeholder="Nhập họ tên người dùng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" value="{{$user->email}}" class="form-control" placeholder="Nhập email người dùng">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Nhập số điện thoại người dùng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="address" value="{{$user->address}}" class="form-control" placeholder="Nhập địa chỉ người dùng">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Năm sinh</label>
                                            <input type="date" name="dob" value="{{$user->dob}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phân quyền</label>
                                            @php
                                            $role = '';
                                            switch($user->role_id) {
                                            case 1:
                                            $role = 'Quản trị viên';
                                            break;
                                            case 2:
                                            $role = 'Bộ phận phụ trách';
                                            break;
                                            case 3:
                                            $role = 'Kỹ thuật viên';
                                            break;
                                            default:
                                            $role = 'Vai trò không xác định';
                                            break;
                                            }
                                            @endphp
                                            <input type="text" value="{{ $role }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chức vụ</label>
                                            <input type="text" value="{{$position->name}}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Đơn vị</label>
                                            <input type="text" value="{{$unit->name}}" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route("profile")}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
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
    $(function() {
        $('#quickForm').validate({
            rules: {
                full_name: {
                    required: true,
                    minlength: 2,
                },
                email: {
                    required: true,
                    minlength: 2,
                },
                phone: {
                    required: true,
                },
                address: {
                    required: true,
                },
                dob: {
                    required: true,
                }
            },
            messages: {
                full_name: {
                    required: "Tên người dùng không được để trống",
                    minlength: "Tên người dùng phải có ít nhất {0} ký tự!"
                },
                email: {
                    required: "Số hiệu thiết bị không được để trống",
                    minlength: "Số hiệu thiết bị phải có ít nhất {0} ký tự!"
                },
                years: {
                    required: "Năm sử dụng không được để trống"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function() {
        var initialUrl = $('#thumbnail').val();
        if (initialUrl) {
            $('#holder').attr('src', initialUrl);
        } else {
            $('#holder').attr('src', 'http://127.0.0.1:8000/storage/photos/2/Image/img/avatar4.png');
        }
    });
</script>
@endsection