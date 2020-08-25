<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function create()
    {
        $role = Role::paginate(5);
        return view('role_permission.add_role', compact('role'));
    }

    public function store(Request $request)
    {
        $role = $request->role;
        $description = $request->description;

        DB::beginTransaction();

        try {
            Role::create(['name' => $role, 'description' => $description]);

            DB::commit();
            alert()->success('Success!', 'Thêm Chức Vụ Thành Công.');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Oops..!', 'Hình như đã có chức vụ đó rồi, xem lại nhé');
        }

        return redirect()->route('chuc_vu');

    }

    public function viewAddPermissionToRole()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('role_permission.add_permission_to_role', compact(['roles', 'permissions']));
    }

    public function addPermissionToRole(Request $request)
    {
        $role = Role::findById($request->role);

        $permission = $request->permission;
        $permissions = array();

        for ($i = 0; $i < count($permission); $i++) {
            $arrs = Permission::findById($permission[$i]);
            array_push($permissions, $arrs);
        }

        if ($role->syncPermissions($permissions)) {
            alert()->success('Success!', 'Cập nhật quyền cho chức vụ thành công');
        } else {
            alert()->error('Oops..!', 'Đã có lỗi xảy ra, vui lòng thử lại');
        }

        return redirect()->route('them_quyen_cho_chuc_vu');
    }

    public function index()
    {
        $roles = Role::all();
        return view('role_permission.role_permission_detail', compact('roles'));
    }

}
