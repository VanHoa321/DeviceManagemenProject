@extends('master_layout')
@section('title', 'Thêm mới người dùng')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Thêm mới người dùng</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý người dùng</li>
                        <li class="breadcrumb-item active">Thêm mới người dùng</li>
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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{route("user.store")}}" id="quickForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Họ tên</label>
                                            <input type="text" name="full_name" class="form-control" placeholder="Nhập họ tên người dùng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại người dùng">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" class="form-control" placeholder="Nhập email người dùng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chức vụ</label>
                                            <select name="position_id" class="form-control select2bs4">
                                                <option value="0">---Chọn chức vụ---</option>
                                                @foreach($positions as $item);
                                                <option value="{{$item->position_id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label>Đơn vị</label>
                                            <select name="unit_id" class="form-control select2bs4">
                                                <option value="0">---Chọn đơn vị---</option>
                                                @foreach($units as $item);
                                                <option value="{{$item->unit_id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>                                                                        
                                    </div>
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label>Phân quyền</label>
                                            <select name="role_id" class="form-control select2bs4">
                                                <option value="0">---Chọn phân quyền---</option>
                                                @foreach($roles as $item);
                                                <option value="{{$item->role_id}}">{{$item->role_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>                                                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Tên tài khoản</label>
                                            <input type="text" name="user_name" class="form-control" placeholder="Nhập tên đăng nhập hệ thống">
                                        </div>                                                                        
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Mật khẩu</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu đăng nhập hệ thống">
                                        </div>                                                                        
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Xác nhận mật khẩu</label>
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu đăng nhập">
                                        </div>                                                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('user.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>
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
                phone: {
                    required: true,
                    minlength: 2,
                },
                email: {
                    required: true,
                    email: true
                },
                user_name: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                full_name: {
                    required: "Họ tên người dùng không được để trống",
                    minlength: "Họ tên người dùng phải có ít nhất {0} ký tự!"
                },
                phone: {
                    required: "Số điện thoại không được để trống",
                    minlength: "Số điện thoại phải có ít nhất {0} ký tự!"
                },
                email: {
                    required: "Email không được để trống",
                    email: "Vui lòng nhập đúng định dạng email"
                },
                user_name: {
                    required: "Tên tài khoản không được để trống",
                    minlength: "Tên tài khoản phải có ít nhất {0} ký tự"
                },
                password: {
                    required: "Mật khẩu không được để trống",
                    minlength: "Mật khẩu phải có ít nhất {0} ký tự"
                },
                confirm_password: {
                    required: "Xác nhận mật khẩu không được để trống",
                    equalTo: "Mật khẩu xác nhận không khớp"
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
</script>
@endsection