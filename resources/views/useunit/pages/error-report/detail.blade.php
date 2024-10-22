@extends('master_layout')
@section('title', 'Chi tiết phiếu bảo trì')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Quản lý thiết bị</li>
                        <li class="breadcrumb-item active">Chi tiết phiếu bảo trì</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Danh sách thiết bị lỗi</h4>
                                </div>
                                <div class="col-md-6">
                                    @if (session('reports'))
                                        <div class="float-sm-right">
                                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modal-default2" title="Tạo phiếu bảo trì">
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-clear-all" title="Xóa tất cả">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    @endif                                
                                </div>
                            </div>                            
                        </div>
                        <div class="card-body">
                            <table id="example-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên thiết bị</th>
                                        <th>Phân loại</th>
                                        <th>Số hiệu</th>
                                        <th>Thuộc bộ phận</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @if (session('reports'))
                                        @foreach (session('reports') as $id => $items)
                                            <tr id="detail-{{ $id }}">
                                                <td>{{ $counter++ }}</td>
                                                <td><img src="{{ $items['image'] }}" alt="" style="width: 80px; height: 80px"></td>
                                                <td>{{ $items['name'] }}</td>
                                                <td>{{ $items['type'] }}</td>
                                                <td>{{ $items['code'] }}</td>
                                                <td>{{ $items['unit'] }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm btn-error-detail" data-id="{{ $id }}" data-toggle="modal" data-target="#modal-default" title="Mô tả lỗi">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm btn-delete-report" data-id="{{ $id }}" title="Xóa thiết bị">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Mô tả lỗi</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mô tả lỗi gặp phải</label>
                                    <textarea id="error-description" class="form-control mb-3" placeholder="Nhập mô tả lỗi" style=" height: 100px"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-success btn-save-error">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->

                <div class="modal fade" id="modal-default2">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Nhập ghi chú phiếu bảo trì</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mô tả thêm</label>
                                    <textarea id="main-description" class="form-control mb-3" placeholder="Nhập mô tả phiếu bảo trì" style=" height: 100px"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-success btn-save-main">Tạo phiếu</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        $('body').on('click', '.btn-delete-report', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: "Xác nhận xóa khỏi phiếu bảo trì?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/use-unit/remove-report/" + id,
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            $('#detail-' + id).remove();
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi xóa thiết bị');
                        }
                    });
                }
            });
        })

        $('body').on('click', '.btn-clear-all', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Xác nhận xóa phiếu này?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/use-unit/clear-report',
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#example-table tbody').empty();
                            } else {
                                toastr.danger(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi khi xóa thiết bị');
                        }
                    });
                }
            });            
        });

        var id;
        $('body').on('click', '.btn-error-detail', function(e) {
            e.preventDefault();
            id = $(this).data('id');
            $.ajax({
                url: '/use-unit/get-error/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#error-description').val(response.error);
                        $('#modal-default').modal('show');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Có lỗi xảy ra khi lấy mô tả lỗi');
                }
            });
        });

        $('.btn-save-error').click(function() {
            var errorDescription = $('#error-description').val();
            if (errorDescription.trim() === '') {
                toastr.warning('Vui lòng nhập mô tả lỗi.');
                return;
            }

            $.ajax({
                url: '/use-unit/save-error',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    error: errorDescription
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#modal-default').modal('hide');
                        $('#error-description').val('');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Có lỗi xảy ra khi lưu mô tả lỗi');
                }
            });
        });

        $('body').on('click', '.btn-save-main', function(e) {
            let mainDescription = $('#main-description').val();
            $.ajax({
                url: '/use-unit/save-maintenance',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    description: mainDescription
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Tạo phiếu bảo trì thành công!');
                        $('#modal-default2').modal('hide');
                        $('#main-description').val('');
                        $('#example-table tbody').empty();
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);  // In ra console để kiểm tra chi tiết lỗi
                    alert('Có lỗi xảy ra: ' + xhr.responseText);  // Hiển thị lỗi trong alert
                }
            });
        });

        setTimeout(function() {
            $("#myAlert").fadeOut(500);
        }, 3500);
    })
</script>
@endsection