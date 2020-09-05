@extends('layouts.app')
@section('title')
    Lịch sử điểm danh
@endsection


@section('content')
<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="subject_id">Chọn môn học</label>
    <div class="col-sm-6">
        <select name="subject_id" id="subject_id" class="form-control">
            <option value="" disabled selected> ---Chọn môn học--- </option>
                @foreach ($arr as $item)
                    <option value="{{ $item[0] }}">{{ $item[1] }}</option>
                @endforeach
        </select>
    </div>
</div>
@endsection
