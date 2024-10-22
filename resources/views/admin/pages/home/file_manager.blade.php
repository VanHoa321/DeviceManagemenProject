@extends('master_layout')
@section('title', 'Trang chủ')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-btn mr-2">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fas fa-picture-o"></i> Choose
                    </a>
                </span>
                <input id="thumbnail" class="form-control" type="text" name="filepath">
            </div>
            <div id="holder" style="margin-top:15px;">
                <img src="{{old('thumbnail')}}" alt="" style="height:100px">
            </div>
            <textarea id="summernote"></textarea>
        </div>
    </section>
</div>
@endsection

@section('scripts')

@endsection
