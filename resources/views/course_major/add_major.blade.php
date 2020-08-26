@extends('layouts.app')

@section('title')
    Thêm Ngành Mới
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('xu_li_them_nganh') }}" method="post">
                @csrf
                <div class="form-group row col-5 float-left">
                    <label for="" class="col-sm-3 col-form-label">Mã Ngành</label>
                    <div class="col-sm-8">
                        <input class="form-control form-check-input @error('major_id') is-invalid @enderror" type="text"
                            name="major_id">
                        @error('major_id')
                        <div class="alert alert-danger mt-2 mb-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row col-5 float-left">
                    <label for="" class="col-sm-3 col-form-label">Tên Ngành</label>
                    <div class="col-sm-8">
                        <input class="form-control form-check-input @error('major_id') is-invalid @enderror" type="text"
                            name="major_name">
                        @error('major_name')
                        <div class="alert alert-danger mt-2 mb-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
