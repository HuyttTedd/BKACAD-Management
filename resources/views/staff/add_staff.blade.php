@extends('layouts.app')

@section('title')
    Thêm nhân viên
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card m-b-30">
                <div class="card-body">
                    <form action="{{ route('xu_li_them_nhan_vien') }}" method="post" class="">
                        @csrf
                        <div class="form-group">
                            <label>Họ Tên Nhân Viên</label>
                            <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                placeholder="Lê Văn A" />
                            @error('fullname')
                            <div class="alert alert-danger mt-2 mb-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Ngày Sinh</label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob"/>
                            @error('dob')
                            <div class="alert alert-danger mt-2 mb-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Giới Tính</label>
                            <div class="form-check form-check-inline ml-5">
                                <input type="radio" class="form-check-input @error('gender') is-invalid @enderror"
                                    name="gender" value="0" />
                                <label for="" class="form-check-label">Nữ</label>
                                <input type="radio" class="form-check-input ml-5" name="gender" value="1" />
                                <label for="" class="form-check-label">Nam</label>
                            </div>
                            @error('gender')
                            <div class="alert alert-danger mt-2 mb-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Số Điện Thoại</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" />
                            @error('phone')
                            <div class="alert alert-danger mt-2 mb-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                parsley-type="email" />
                            @error('email')
                            <div class="alert alert-danger mt-2 mb-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Mật Khẩu</label>
                            <div>
                                <input type="password" id="pass2"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    data-parsley-minlength="8" placeholder="Mật Khẩu" />
                                @error('password')
                                <div class="alert alert-danger mt-2 mb-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="m-t-10">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                                    data-parsley-equalto="#pass2" name="confirm_password" placeholder="Nhập Lại Mật Khẩu"
                                    data-parsley-minlength="8" />
                                @error('confirm_password')
                                <div class="alert alert-danger mt-2 mb-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Thêm Chức Vụ</label>
                            <select name="role" class="custom-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('plugins/parsleyjs/parsley.js') }}"></script>
        <script>
            $(document).ready(function() {
                $("form").parsley();
                $("input").prop('required', true);
            });

        </script>
    @endpush
@endsection
