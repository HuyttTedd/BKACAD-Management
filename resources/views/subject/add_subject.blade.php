@extends('layouts.app')

@section('title')
    Thêm Môn Học
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('xu_li_them_mon') }}" method="post">
                @csrf
                <div class="form-group row col-5 float-left">
                    <label for="" class="col-sm-3 col-form-label">Mã Môn</label>
                    <div class="col-sm-8">
                        <input class="form-control form-check-input @error('subject_id') is-invalid @enderror" type="text"
                            name="subject_id">
                        @error('subject_id')
                        <div class="alert alert-danger mt-2 mb-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row col-5 float-left">
                    <label for="" class="col-sm-4 col-form-label">Tên Môn</label>
                    <div class="col-sm-8">
                        <input class="form-control form-check-input @error('subject_name') is-invalid @enderror" type="text"
                            name="subject_name">
                        @error('subject_name')
                        <div class="alert alert-danger mt-2 mb-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row col-5 float-left">
                    <label for="" class="col-sm-3 col-form-label">Số Giờ Học</label>
                    <div class="col-sm-8">
                        <input class="form-control form-check-input @error('total_time') is-invalid @enderror" type="text"
                            name="total_time">
                        @error('total_time')
                        <div class="alert alert-danger mt-2 mb-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row col-5 float-left">
                    <label for="" class="col-sm-4 col-form-label">Loại Kiểm Tra</label>
                    <div class="col-sm-8">
                        <select name="test_type" id="" class="form-control">
                            <option value="1">Lý Thuyết</option>
                            <option value="2">Thực Hành</option>
                            <option value="3">Lý Thuyết + Thực Hành</option>
                        </select>
                        @error('test_type')
                        <div class="alert alert-danger mt-2 mb-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-2 mx-auto">
                    <button class="btn btn-primary" type="submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
