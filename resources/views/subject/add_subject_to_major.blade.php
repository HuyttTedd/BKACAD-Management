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
                    <label for="" class="col-sm-2 col-form-label">Khóa</label>
                    <div class="col-sm-8">
                        <select name="course" id="" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Khóa--- </option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Ngành</label>
                    <div class="col-sm-8">
                        <select name="major" id="" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Ngành--- </option>
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

    {{-- @push('script')
    <script type="text/javascript">
        var url = "{{ route('show_course_major') }}";
        $("select[name='course']").change(function(){
            var course_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    course_id: course_id,
                    _token: token
                },
                success: function(data) {
                    $("select[name='major'").html('');
                    $.each(data, function(key, value){
                        $("select[name='major']").append(
                            "<option value=" + value.id + ">" + value.major_name + "</option>"
                        );
                    });
                }
            });
        });
    </script>
    @endpush --}}
@endsection
