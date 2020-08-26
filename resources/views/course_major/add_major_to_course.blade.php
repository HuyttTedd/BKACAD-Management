@extends('layouts.app')

@section('title')
    Thêm Ngành Học Cho Khóa
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" class="mx-auto" action="{{ route('xu_li_them_nganh_cho_khoa') }}">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Khóa</label>
                    <div class="col-sm-8">
                        <select name="course" id="" class="form-control">
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Ngành</label>
                    <div class="col-sm-8">
                        @foreach ($majors as $major)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="major[]" value="{{ $major->id }}">
                                <label class="form-check-label" for="">{{ $major->major_name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="mx-auto">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
