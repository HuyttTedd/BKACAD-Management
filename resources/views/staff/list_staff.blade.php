@extends('layouts.app')

@section('title')
    Danh sách nhân viên
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Họ Tên Nhân Viên</th>
                    <th scope="col">Chức Vụ</th>
                    <th scope="col">Quyền</th>
                </tr>
                @foreach ($users as $key => $user)
                    <tr>
                        <td></td>
                        <td>{{ $user->fullname }}</td>
                        <td>
                            {{! $roles = $user->roles }}
                            @foreach ($roles as $role)
                                <span class="bagde badge-primary">{{ $role->description }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{! $permissions = $user->getAllPermissions() }}
                            @foreach ($permissions as $permission)
                                <span class="badge badge-primary">{{ $permission->description }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
