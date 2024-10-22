@extends('master_layout')
@section('title', 'Báo hỏng thiết bị')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Tạo phiếu báo hỏng</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thiết bị</li>
                        <li class="breadcrumb-item active">Báo hỏng thiết bị</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="branch_id">Cơ sở</label>
                                        <select id="branch_id" class="form-control select2bs4">
                                            <option value="0">---Chọn cơ sở---</option>
                                            @foreach($branchs as $item)
                                            <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="building_id">Tòa nhà</label>
                                        <select id="building_id" class="form-control select2bs4" disabled>
                                            <option value="0">---Chọn tòa nhà---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="room_id">Phòng</label>
                                        <select id="room_id" class="form-control select2bs4" disabled>
                                            <option value="0">---Chọn phòng---</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example-table" class="">
                                        <thead id="table-head"></thead>
                                        <tbody id="table-body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('report.detail')}}" class="btn btn-info"><i class="fa-solid fa-floppy-disk" style="color:white" title="Chi tiết phiếu lỗi"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{asset("assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script src="{{asset("assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js")}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Khi chọn cơ sở
        $('#branch_id').on('change', function() {
            var branch_id = $(this).val();
            $('#building_id').empty().append('<option value="0">---Chọn tòa nhà---</option>').prop('disabled', true);
            $('#room_id').empty().append('<option value="0">---Chọn phòng---</option>').prop('disabled', true);
            $('#table-head').empty();
            $('#table-body').empty();

            if (branch_id > 0) {
                $.ajax({
                    url: '/use-unit/get-buildings/' + branch_id,
                    method: 'GET',
                    success: function(data) {
                        $('#building_id').prop('disabled', false);
                        $.each(data, function(index, building) {
                            $('#building_id').append('<option value="' + building.building_id + '">' + building.name + '</option>');
                        });
                    }
                });
            }
        });

        // Khi chọn tòa nhà
        $('#building_id').on('change', function() {
            var building_id = $(this).val();
            $('#room_id').empty().append('<option value="0">---Chọn phòng---</option>').prop('disabled', true);
            $('#table-head').empty();
            $('#table-body').empty();

            if (building_id > 0) {
                $.ajax({
                    url: '/use-unit/get-rooms/' + building_id,
                    method: 'GET',
                    success: function(data) {
                        $('#room_id').prop('disabled', false);
                        $.each(data, function(index, room) {
                            $('#room_id').append('<option value="' + room.room_id + '">' + room.name + '</option>');
                        });
                    }
                });
            }
        });

        // Khi chọn phòng
        $('#room_id').on('change', function() {
            var room_id = $(this).val();
            $('#table-body').empty();
            $('#table-head').empty();

            if (room_id > 0) {
                $('#example-table').addClass('table table-bordered table-hover');
                $.ajax({
                    url: '/use-unit/get-devices/' + room_id,
                    method: 'GET',
                    success: function(data) {
                        $('#table-head').append(`
                            <tr>
                                <th>#</th>
                                <th>Hình ảnh</th>
                                <th>Tên thiết bị</th>
                                <th>Phân loại</th>
                                <th>Số hiệu</th>
                                <th>Thuộc bộ phận</th>
                                <th>Chức năng</th>
                            </tr>
                        `);

                        let counter = 1;
                        $.each(data, function(index, device) {
                            $('#table-body').append(`
                                <tr>
                                    <td>${counter++}</td>
                                    <td><img src="${device.image}" alt="" style="width: 80px; height: 80px"></td>
                                    <td>${device.name}</td>
                                    <td>${device.type ? device.type.name : 'N/A'}</td>
                                    <td>${device.code}</td>
                                    <td>${device.unit ? device.unit.name : 'N/A'}</td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm btn-add-report" data-id="${device.device_id}" title="Thêm vào phiếu báo hỏng">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            `);                           
                        });
                    }
                });
            }
            else{
                $('#example-table').removeClass('table table-bordered table-hover');
            }
        });
    });
</script>
<script>
    $(document).on('click', '.btn-add-report', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: '/use-unit/add-to-report/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else if (response.warning) {
                    toastr.warning(response.message);
                } else if (response.danger) {
                    toastr.danger(response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
    });
</script>
@endsection