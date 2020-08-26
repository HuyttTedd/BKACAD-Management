@extends('layouts.app')

@section('title')
    Xem Các Môn Đã Thêm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Mã Môn</th>
                    <th>Tên Môn</th>
                    <th>Thời Gian Học</th>
                    <th>Loại Kiểm Tra</th>
                </tr>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>{{ $subject->total_time }}</td>
                        <td>
                            @switch($subject->test_type)
                                @case(1)
                                    {{ 'Lý Thuyết' }}
                                @break
                                @case(2)
                                    {{ 'Thực Hành' }}
                                @break
                                @case(3)
                                    {{ 'Lý Thuyết + Thực Hành' }}
                                @break
                                @default

                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
