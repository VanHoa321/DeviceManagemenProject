@extends('master_layout')
@section('title', 'Đổi mật khẩu')
@section('content')

<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Đổi mật khẩu</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thông tin cá nhân</li>
                        <li class="breadcrumb-item active">Đổi mật khẩu</li>
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
                <div class="col-md-4">
                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{$user->avatar}}"
                                    alt="User profile picture"
                                    style="width:150px; height:150px; object-fit:cover;">
                            </div>
                            <h3 class="profile-username text-center mt-2">{{$user->user_name}}</h3>
                            <p class="text-muted text-center">Developer</p>
                            <ul class="list-group list-group-unbordered mb-2">
                                <li class="list-group-item">
                                    <b><i class="fas fa-envelope ml-2 mr-5"></i></b> {{$user->email}}
                                </li>
                                <li class="list-group-item">
                                    <b><i class="fas fa-phone ml-2 mr-5"></i></b> {{$user->phone}}
                                </li>
                                <li class="list-group-item">
                                    <b><i class="fa-solid fa-cake-candles ml-2 mr-5"></i></b> {{ \Carbon\Carbon::parse($user->dob)->format('d/m/Y') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header p-3 text-center">
                            <h4>Thông tin tài khoản</h4>
                        </div>
                        <form method="post" action="{{route("updatePassword")}}" id="quickForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Mật khẩu cũ</label>
                                    <input type="password" name="old_password" class="form-control" placeholder="Nhập mật khẩu cũ">
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu mới</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nhập mật khẩu mới">
                                </div>
                                <div class="form-group">
                                    <label>Xác nhận mật khẩu mới</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Nhập xác nhận mật khẩu mới">
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
                old_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                old_password: {
                    required: "Vui lòng nhập mật khẩu cũ!",
                    minlength: "Mật khẩu phải có ít nhất {0} ký tự!"
                },
                new_password: {
                    required: "Vui lòng nhập mật khẩu mới!",
                    minlength: "Mật khẩu phải có ít nhất {0} ký tự!"
                },
                confirm_password: {
                    required: "Vui lòng nhập lại mật khẩu mới!",
                    equalTo: "Mật khẩu xác nhận không khớp!"
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