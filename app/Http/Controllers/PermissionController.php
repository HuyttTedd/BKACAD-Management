<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function create(){
        $permission = Permission::paginate(5);
        return view('role_permission.add_permission', compact('permission'));
    }

    public function store(Request $request)
    {
        $permission = $request->permission;
        $description = $request->description;

        DB::beginTransaction();

        try {
            Permission::create(['name' => $permission, 'description' => $description]);

            DB::commit();
            alert()->success('Success!', 'Thêm Quyền Thành Công.');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Oops..!', 'Hình như đã có quyền đó rồi, xem lại nhé');
        }

        return redirect()->route('quyen');

    }
}
