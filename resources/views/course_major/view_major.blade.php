@extends('layouts.app')

@section('title')
    Xem Các Ngành Đã Thêm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Mã Ngành</th>
                    <th>Tên Ngành</th>
                </tr>
                @foreach ($majors as $major)
                    <tr>
                        <td>{{ $major->id }}</td>
                        <td>{{ $major->major_name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
