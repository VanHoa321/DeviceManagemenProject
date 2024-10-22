@extends('master_layout')
@section('title', 'Thông tin người dùng')
@section('content')

<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Thông tin người dùng</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý người dùng</li>
                        <li class="breadcrumb-item active">Thông tin tài khoản</li>
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
                            <p class="text-muted text-center">{{$position->name}}</p>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label"><strong>Họ tên</strong></div>
                                <div class="col-lg-9 col-md-8">{{$user->full_name}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label"><strong>Địa chỉ</strong></div>
                                <div class="col-lg-9 col-md-8">{{$user->address? "$user->address":"Chưa cập nhật"}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label"><strong>Khoa/ Viện</strong></div>
                                <div class="col-lg-9 col-md-8">{{$unit->name? "$unit->name":"Chưa cập nhật"}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label"><strong>Trạng thái</strong></div>
                                <div class="col-lg-9 col-md-8">{{$user->status? "Hoạt động" : "Bị khóa"}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label"><strong>Phân quyền</strong></div>
                                <div class="col-lg-9 col-md-8">{{$role->role_name}}</div>
                            </div>
                            <hr>
                            <div class="text-left p-1">
                                <a href="{{route('user.index')}}" class="btn btn-warning"><i class="fa-solid fa-rotate-left" style="color:white" title="Quay lại"></i></a>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script>
    setTimeout(function() {
        $("#myAlert").fadeOut(500);
    },3500);
</script>

