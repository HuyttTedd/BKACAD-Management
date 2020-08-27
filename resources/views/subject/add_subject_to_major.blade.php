@extends('layouts.app')

@section('title')
    Thêm Môn Cho Ngành
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('xu_li_them_mon_cho_nganh') }}" method="post" class="mx-auto">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Ngành</label>
                    <div class="col-sm-8">
                        <select name="course" id="" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Ngành--- </option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}">{{ $major->major_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Môn</label>
                    <div class="col-sm-8">
                        @foreach ($subjects as $subject)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="subject[]" value="{{ $subject->id }}">
                            <label class="form-check-label" for="">{{ $subject->subject_name }}</label>
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
