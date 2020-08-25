<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('staff.add_staff', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => ['bail', 'required', 'unique:users,phone', 'regex: /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/'],
            'email' => 'bail|required|unique:users,email|email',
            'password' => 'bail|required|min:8',
            'confirm_password' => 'bail|required|same:password',
        ]);

        DB::beginTransaction();
        try {
            //code...

            $new_user = User::create([
                'fullname' => $request->fullname,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            DB::commit();
            alert()->success('Success!', 'Thêm Nhân Viên Thành Công');

        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..!', 'Có lỗi xảy ra. Vui lòng thử lại');
        }
        $role = Role::findById($request->role);
        $user = User::where('email', $request->email)->first();

        try {
            $user->assignRole($role->name);
            DB::commit();
            alert()->success('Success!', 'Thêm chức vụ cho người dùng thành công.');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..!', 'Đã có lỗi xảy ra khi thêm chức vụ. Vui lòng thêm lại sau');
        }

        return redirect()->route('them_nhan_vien');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
