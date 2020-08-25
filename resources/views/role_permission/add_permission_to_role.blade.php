@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" class="mx-auto" action="{{ route('xu_li_them_quyen_cho_chuc_vu') }}">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chức Vụ</label>
                    <div class="col-sm-8">
                        <select name="role" id="" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Quyền</label>
                    <div class="col-sm-8">
                        @foreach ($permissions as $permission)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
                            <label class="form-check-label" for="">{{ $permission->name }}</label>
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
@endsection
