@extends('layouts.app')

@section('title')
    Xem Ngành - Môn Chi Tiết
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Ngành Đào Tạo</th>
                    <th>Môn</th>
                </tr>
                @foreach ($majors as $major)
                    <tr>
                        <td>{{ $major->major_name }}</td>
                        <td>
                            @foreach ($major->subjects as $subject)
                                <span class="bagde badge-pill badge-primary">{{ $subject->subject_name }}</span>
                            @endforeach
                            <a href="{{ route('cap_nhap_mon_cho_nganh', ['id'=>$major->id]) }}" class="badge badge-success"><i class="mdi mdi-plus"></i></a>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
