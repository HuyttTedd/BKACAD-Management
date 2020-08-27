@extends('layouts.app')

@section('title')
    Nhập Sinh Viên
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('xu_li_nhap_sinh_vien') }}" method="post" class="mx-auto" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Khóa</label>
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
                    <label for="" class="col-sm-2 col-form-label">Chọn Ngành</label>
                    <div class="col-sm-8">
                        <select name="major" id="" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Ngành--- </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nhập Sinh Viên</label>
                    <div class="col-sm-8 form-control-file">
                        <input type="file" name="file">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Xác Nhận</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script type="text/javascript">
            var url = "{{ route('show_course_major') }}";
            $("select[name='course']").change(function() {
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
                        $.each(data, function(key, value) {
                            $("select[name='major']").append(
                                "<option value=" + value.id + ">" + value.major_name +
                                "</option>"
                            );
                        });
                    }
                });
            });

        </script>
    @endpush
@endsection
