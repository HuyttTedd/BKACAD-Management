@extends('layouts.app')
@section('title')
    Điểm danh
@endsection

@section('content')
<form action="{{ route('process_diem_danh') }}" method="POST" onsubmit="return validate()">
    @csrf

<input type="hidden" name="id_user" id="id_user" value="">


@foreach ($last_att as $item)

@endforeach
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="class_id">Lớp học</label>
        <div class="col-sm-6">
                <input type="text" class="form-control" value="">
        </div>
    </div>
{{-- Submit --}}
    <div>
        <button type="submit" id="submit"  class="btn btn-primary mt-4" onclick="confirm('Xác nhận điểm danh?')">Xác nhận</button>
    </div>


</form>
@endsection
