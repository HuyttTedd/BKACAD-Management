@extends('layouts.app')

@section('title')
    Xem Các Khóa Đã Thêm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Tên Khóa</th>
                </tr>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->course_name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
