@extends('layouts.app')
@section('title')
    Điểm danh
@endsection

@section('content')
<form action="{{ route('process_diem_danh') }}" method="POST" onsubmit="return validate()">
    @csrf

<input type="hidden" name="id_user" id="id_user" value="{{ $id }}">


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

    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="class_id">Chọn lớp học (giữ Ctr để chọn)</label>
        <div class="col-sm-6">
            <select name="class_id[]" id="class_id" class="form-control" multiple>

            </select>
        </div>
    </div>

    {{-- <div id="aaa">asdasdsa</div> --}}
    <div class="btn btn-primary" id="choose_class" onclick="show()">Xác nhận chọn môn và lớp</div>
    <div class="h6 mt-3 mb-3" id="session"></div>
    {{-- Hiện sinh viên --}}
    <table class="table table-sm mt-5" id="student">
    {{-- @foreach ($student as $item)
        <tr>
            <td>{{ $item->name }} ({{ round($arr[$item->id]['sum'], 1) }}/{{ (int)$subject->time_total/4 }})</td>
            <th>Đi học <input type="radio" name="{{ $item->id }}" {{ old($item->id) == 0 ? 'checked' : '' }} value="0"></th>
            <th>Muộn <input type="radio" name="{{ $item->id }}" {{ old($item->id) == 1 ? 'checked' : '' }} value="1"></th>
            <th>Nghỉ <input type="radio" name="{{ $item->id }}" {{ old($item->id) == 2 ? 'checked' : '' }} value="2"></th>
            <th>Có phép <input type="radio" name="{{ $item->id }}" {{ old($item->id) == 3 ? 'checked' : '' }} value="3"></th>
        </tr>
    @endforeach --}}

    </table>
    <div class="form-group row col-sm-6 text-danger" id="format">
        Nhập giờ theo format giờ:phút. Ví dụ: 8:00, 01:30, 20:10
    </div>

    <div class="form-group row" id="time-start">
        <label class="col-sm-2 col-form-label" for="start">Thời gian bắt đầu:</label>
        <input class="" id="start" type="text" name="start">
    </div>

    <div class="form-group row" id="time-end">
        <label class="col-sm-2 col-form-label" for="end">Thời gian kết thúc:</label>
        <input class="" id="end" type="text" name="end">
    </div>

    <div class="form-group row col-sm-6 text-danger" id="error"></div>
{{-- Submit --}}
    <div>
        <button type="submit" id="submit"  class="btn btn-primary mt-4" onclick="confirm('Xác nhận điểm danh?')">Xác nhận</button>
    </div>


</form>


<script>
// function a() {
//     var a = [];
//     let selectElement = document.getElementById('class_id');
//     let selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
//     alert(selectedValues);
// }

function validate() {
    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;
    let arr_start = start.split(':');
    let arr_end = end.split(':');
    //Từ 0h-23h
    if(Number(arr_start[0]) == Number(arr_end[0]) && Number(arr_start[1]) >= Number(arr_end[1])) {
        document.getElementById('error').innerHTML = "Bạn nhập thời gian sai!";
        return false;
    }else if(Number(arr_start[0]) > Number(arr_end[0])) {
        document.getElementById('error').innerHTML = "Bạn nhập thời gian sai!";
        return false;
    }
    let regex = /^([0-9]|[0-1][0-9]|[2][0-3]):([0-5][0-9]|[0-9])$/m;
    if(regex.test(start) == false || regex.test(end) == false) {
        document.getElementById('error').innerHTML = "Bạn nhập thời gian sai!";
        return false;
    }
     else {
        document.getElementById('error').innerHTML = "";
    }

}

function show() {
    let selectElement = document.getElementById('class_id');
    let selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
    if(selectedValues.length != 0) {
        document.getElementById('submit').style.display = 'block';
        document.getElementById('time-start').style.display = 'block';
        document.getElementById('time-end').style.display = 'block';
        document.getElementById('format').style.display = 'block';

    } else {
        alert('Bạn chưa chọn!')
    }

}


$('#choose_class').click(function(){
var subject_id =$('#subject_id').val();
var class_id =$('#class_id').val();
var token = $("input[name='_token']").val();

    $.ajax({
    url:'{{ route('ajax_diem_danh2') }}',
    type:'POST',
    data:{
        class_id: class_id,
        subject_id: subject_id,
        _token: token
    },
    success:function(data){
        let aa = Object.keys(data).slice(1).reduce((result, key) => {
                    result[key] = data[key];

                    return result;
                }, {});
        $('#student').html('');
        $('#student').append(
            "<tr class='bg-primary'>"+
            "<th class='h5 font-weight-bold text-center'>TÊN SINH VIÊN</th>"+
            "<th colspan='4' class='h5 font-weight-bold text-center'>TÌNH TRẠNG ĐI HỌC</th>"+
        "</tr>"
                        );
        $('#session').html(
            "Tổng số giờ học: "+data.time_total+" giờ."
        );
        $.each(aa, function(key, value) {
                        $('#student').append(
                        "<tr>"+
            "<td class='font-weight-bold' style=color:"+value.color+">"+value.name+" ("+Math.round(value.sum * 10)/10+"/"+value.session+")</td>"+
            "<th>Đi học <input type='radio' name="+value.id+" {{ old("+value.id+") == 0 ? 'checked' : '' }} value='0'></th>"+
            "<th>Muộn <input type='radio' name="+value.id+" {{ old("+value.id+") == 1 ? 'checked' : '' }} value='1'></th>"+
            "<th>Nghỉ <input type='radio' name="+value.id+" {{ old("+value.id+") == 2 ? 'checked' : '' }} value='2'></th>"+
            "<th>Có phép <input type='radio' name="+value.id+" {{ old("+value.id+") == 3 ? 'checked' : '' }} value='3'></th></tr>"
                        );
                    });
    }
});
});


$('#subject_id').change(function(){

var subject_id =$('#subject_id').val();
var id_user =$('#id_user').val();

var token = $("input[name='_token']").val();

    $.ajax({
    url:'{{ route('ajax_diem_danh') }}',
    type:'POST',
    data:{
        id_user: id_user,
        subject_id: subject_id,
        _token: token
    },
    success:function(data){
        $('#class_id').html('');
        $('#class_id').append(
                            "<option disabled>" + "Chọn lớp" +
                            "</option>"
                        );
        $.each(data, function(key, value) {
                        $('#class_id').append(
                            "<option value="+value[0]+">" + value[1] +
                            "</option>"
                        );
                    });
    }
});
});
</script>

<style>
    #submit, #time-start, #time-end, #format {
        display: none;
    }
</style>
@endsection

{{-- $('#choose_classs').click(function(){

    var class_id =$('#class_id').val();
    var token = $("input[name='_token']").val();

        $.ajax({
        url:'{{ route('ajax_diem_danh2') }}',
        type:'POST',
        data:{
            class_id: class_id,
            _token: token
        },
        success:function(data){
            $('#subject_id').html('');
            $.each(data, function(key, value) {
                            $('#subject_id').append(
                                "<option value=" + value.id + ">" + value.major_name +
                                "</option>"
                            );
                        });
        }
    });
    }); --}}
