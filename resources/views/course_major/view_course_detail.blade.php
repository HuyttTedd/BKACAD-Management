@extends('layouts.app')

@section('title')
    Xem Khóa - Ngành Chi Tiết
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Khóa</th>
                    <th>Ngành Đào Tạo</th>
                </tr>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->course_name }}</td>
                        <td>
                            @foreach ($course->majors as $major)
                                <span class="bagde badge-pill badge-primary">{{ $major->major_name }}</span>
                            @endforeach
                            <a href="{{ route('cap_nhap_nganh_cho_khoa', ['id'=>$course->id]) }}" class="badge badge-success"><i class="mdi mdi-plus"></i></a>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
