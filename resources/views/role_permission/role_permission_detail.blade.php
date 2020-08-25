@extends('layouts.app')

@section('title')
    Quyền chức vụ chi tiết
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <table class="table tab-content">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Chức vụ</th>
                    <th scope="col">Quyền</th>
                </tr>
                @foreach ($roles as $item)
                    <tr>
                        <th></th>
                        <td>{{ $item->description }}</td>
                        <td>
                            {{ !$permissions = $item->permissions }}
                            @foreach ($permissions as $item)
                               <span class="bage badge-primary">{{ $item->description }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
