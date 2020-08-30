@extends('layouts.app')
@section('title')
    Phân Công Dạy Học
@endsection

@section('content')
    <form action="{{ route('xu_ly_phan_cong') }}" method="POST">
        @csrf
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">Chọn khóa học</label>
            <div class="col-sm-6">
                <select name="course_id" id="course" class="form-control @error('course_id') is-invalid @enderror">
                    <option value="" disabled selected hidden> ---Chọn Khóa--- </option>
                    @foreach ($khoa_hoc as $item)

                        <option value="{{ $item->id }}">--{{ strtoupper($item->course_name) }}--</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">Chọn ngành học</label>
            <div class="col-sm-6">
                <select name="major_id" id="major" class="form-control @error('major_id') is-invalid @enderror">
                    <option value="" disabled selected hidden> ---Chọn ngành học--- </option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">Chọn môn học</label>
            <div class="col-sm-6">
                <select name="subject_id" id="subject" class="form-control @error('subject_id') is-invalid @enderror">
                    <option value="" disabled selected hidden> ---Chọn môn học--- </option>
                </select>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">Chọn giảng viên</label>
            <div class="col-sm-6">
                <select name="lecturer_id" id="lecturer" class="form-control @error('lecturer_id') is-invalid @enderror">
                    <option value="" disabled selected hidden> ---Chọn giảng viên--- </option>
                    @foreach ($user as $item)

                        <option value="{{ $item->id }}">--{{ $item->fullname }}--</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">Chọn lớp học</label>
            <div class="form-check col-sm-6" id="classes">
                {{-- <div>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> --}}
                {{-- <div>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> --}}

            </div>
        </div>

        <input type="checkbox" onclick="toggle(this);" />Chọn tất cả<br />


        <button type="submit" class="btn btn-primary mt-4">Xác nhận</button>

    </form>


<script type="text/javascript">
     $('#course').change(function(){

        var course_id =$('#course').val();
        var token = $("input[name='_token']").val();

            $.ajax({
            url:'{{ route('ajax_phan_cong') }}',
            type:'POST',
            data:{
                course_id: course_id,
                _token: token
            },
            success:function(data){
                $('#major').html('');
                $("#major").append(
                    "<option>" + "--Chọn ngành--" +
                            "</option>"
                );
                $.each(data, function(key, value) {
                                $('#major').append(
                                    "<option value=" + value.id + ">" + value.major_name +
                                    "</option>"
                                );
                            });
            }
        });
});



$('#major').change(function(){

var major_id =$('#major').val();
var token = $("input[name='_token']").val();

    $.ajax({
    url:'{{ route('ajax_phan_cong') }}',
    type:'POST',
    data:{
        major_id: major_id,
        _token: token
    },
    success:function(data){
        $('#classes').html('');
        $.each(data, function(key, value) {
                        $('#classes').append(
                        "<div><input type='checkbox' name='class[]' id="+value.class_name+" class='form-check-input' value="+value.id+"><label class='form-check-label' for="+value.class_name+">"+value.class_name+"</label>"
                +"</div>"
                        );
                    });
    }
});
});



$('#major').change(function(){

var major_id =$('#major').val();
var token = $("input[name='_token']").val();

    $.ajax({
    url:'{{ route('ajax_phan_cong1') }}',
    type:'POST',
    data:{
        major_id: major_id,
        _token: token
    },
    success:function(data){
        $('#subject').html('');
        $.each(data, function(key, value) {
                        $('#subject').append(
                            "<option value=" + value.id + ">" + value.subject_name +
                                    "</option>"
                        );
                    });
    }
});
});






function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
</script>


@endsection


