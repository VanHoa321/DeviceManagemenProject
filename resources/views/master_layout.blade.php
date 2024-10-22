<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield(section: 'title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/jqvmap/jqvmap.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/dist/css/adminlte.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/daterangepicker/daterangepicker.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/summernote/summernote-bs4.min.css")}}">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("assets/plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/bs-stepper/css/bs-stepper.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/dropzone/min/dropzone.min.css")}}">
    <link href="{{asset("assets/plugins/toastr/toastr.min.css")}}" rel="stylesheet" />
    <link href="{{asset("assets/plugins/toastr/toastr.css")}}" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center" style="z-index: 9999;">
            <img class="animation__shake" src="{{asset("assets/dist/img/AdminLTELogo.png")}}" alt="AdminLTELogo" height="60" width="60">
        </div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">@yield(section: 'title')</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="{{Auth::user()->avatar}}" alt="User Avatar" class="img-size-50 mr-3 img-circle" style="margin-top:-8px; width:40px; height:40px">
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header text-success">{{Auth::user()->full_name}}</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-3"></i>{{Auth::user()->email}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-phone mr-3"></i>{{Auth::user()->phone}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-cake-candles mr-3"></i>{{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d/m/Y') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{route("profile")}}" class="dropdown-item dropdown-footer text-primary">Chi tiết</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{route("logout")}}" class="dropdown-item dropdown-footer text-danger">Đăng xuất</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link text-center">
                <span class="brand-text font-weight-light text-info font-weight-bold text-uppercase">{{Auth::user()->role->role_name}}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{Auth::user()->avatar}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{route("profile")}}" class="d-block">{{Auth::user()->full_name}}</a>
                    </div>
                </div>
                <x-admin-menu />
            </div>
        </aside>
        @yield('content')
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <script src="{{asset("assets/plugins/jquery/jquery.min.js")}}"></script>
    <script src="{{asset("assets/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("assets/plugins/chart.js/Chart.min.js")}}"></script>
    <script src="{{asset("assets/plugins/jqvmap/jquery.vmap.min.js")}}"></script>
    <script src="{{asset("assets/plugins/jqvmap/maps/jquery.vmap.usa.js")}}"></script>
    <script src="{{asset("assets/plugins/jquery-knob/jquery.knob.min.js")}}"></script>
    <script src="{{asset("assets/plugins/moment/moment.min.js")}}"></script>
    <script src="{{asset("assets/plugins/daterangepicker/daterangepicker.js")}}"></script>
    <script src="{{asset("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
    <script src="{{asset("assets/plugins/summernote/summernote-bs4.min.js")}}"></script>
    <script src="{{asset("assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
    <script src="{{asset("assets/dist/js/adminlte.js")}}"></script>
    <script src="{{asset("assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}"></script>
    <script src="{{asset("assets/plugins/bs-stepper/js/bs-stepper.min.js")}}"></script>
    <script src="{{asset("assets/plugins/dropzone/min/dropzone.min.js")}}"></script>
    <script src="{{asset("assets/dist/js/demo.js")}}"></script>
    <script src="{{asset("assets/dist/js/pages/dashboard.js")}}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset("assets/plugins/toastr/toastr.min.js")}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#example-table').DataTable({
                pageLength: 10,
                language: {
                    "lengthMenu": "Hiển thị _MENU_ mục",
                    "search": "Tìm kiếm:",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Hiển thị từ _START_ đến _END_ của _TOTAL_ mục",
                    "infoEmpty": "Hiển thị từ 0 đến 0 của 0 mục",
                    "infoFiltered": "(được lọc từ _MAX_ tổng số mục)",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Tiếp",
                        "previous": "Trước"
                    }
                },
            });
        });
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>       
        $('#lfm').filemanager('image', {prefix: '/files-manager'});
        $(document).ready(function(){
            var lfm = function(options, cb) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/files-manager';
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=700,height=400');
            window.SetUrl = cb;
            };

            var LFMButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="note-icon-picture"></i> ',
                tooltip: 'Insert image with filemanager',
                click: function() {

                lfm({type: 'image', prefix: '/files-manager'}, function(lfmItems, path) {
                    lfmItems.forEach(function (lfmItem) {
                    context.invoke('insertImage', lfmItem.url);
                    });
                });

                }
            });
            return button.render();
            };

            $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'height', 'table']],
                ['insert', ['link', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['misc', ['undo', 'redo', 'print', 'clear']],
                ['popovers', ['lfm']],
            ],
            buttons: {
                lfm: LFMButton
            }
            })
            var initialUrl = $('#thumbnail').val();
            if (initialUrl) {
                $('#holder').attr('src', initialUrl);
            } else {
                $('#holder').attr('src', '/storage/photos/Image/Device/no_photo.jpg');
            }
            $('#lfm').filemanager('image');
            $('#lfm').on('click', function() {
                var route_prefix = '/files-manager';
                window.open(route_prefix + '?type=image', 'FileManager', 'width=700,height=400');
                window.SetUrl = function (items) {
                    var url = items[0].url;
                    $('#holder').attr('src', url);
                    $('#thumbnail').val(url);
                };
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
