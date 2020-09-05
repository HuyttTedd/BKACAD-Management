@extends('layouts.app')
@section('title')
    Điểm danh đang hoạt động
@endsection

@section('content')
<form action="{{ route('process_update_diem_danh') }}" method="POST" onsubmit="return confirm('Xác nhận cập nhật?')">
    @csrf

<input type="hidden" name="id_user" id="id_user" value="">


@foreach ($last_att as $item)

@endforeach
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Ngày</label>
        <div class="col-sm-3">
                <input type="text" class="form-control" value="{{ $last_att->date }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Thời gian bắt đầu</label>
        <div class="col-sm-3">
                <input type="text" class="form-control" value="{{ $last_att->time_start }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Thời gian kết thúc</label>
        <div class="col-sm-3">
                <input type="text" class="form-control" value="{{ $last_att->time_end }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Môn học</label>
        <div class="col-sm-3">
                <input type="text" class="form-control" value="{{ $sub->subject_name }}" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Danh sách lớp học</label>
        <div class="col-sm-3">
            <select class="form-control" multiple disabled>
                    @foreach ($arr_class as $item => $value)
                        <option value="{{ $item }}">{{ $value }}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <table class="table table-sm mt-5" id="student">
        @foreach ($arr_update as $item)
            <tr>
                <td style="color: {{ $item['color'] }}">{{ $item['name'] }} ({{ round($item['sum'], 1) }}/{{ (int)$sub->total_time/4 }})</td>
                <th>Đi học <input type="radio" name="{{ $item['id'] }}" {{ $item['last_status'] == 0 ? 'checked' : '' }} value="0"></th>
                <th>Muộn <input type="radio" name="{{ $item['id'] }}" {{ $item['last_status'] == 1 ? 'checked' : '' }} value="1"></th>
                <th>Nghỉ <input type="radio" name="{{ $item['id'] }}" {{ $item['last_status'] == 2 ? 'checked' : '' }} value="2"></th>
                <th>Có phép <input type="radio" name="{{ $item['id'] }}" {{ $item['last_status'] == 3 ? 'checked' : '' }} value="3"></th>
            </tr>
        @endforeach

        </table>
{{-- Submit --}}
    <div>
        <button type="submit" id="submit"  class="btn btn-primary mt-4">Cập nhật điểm danh</button>
    </div>


</form>
@endsection
