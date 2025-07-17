<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
use App\Helpers\PermissionHelper;
use App\Traits\CrudTrait;

class RoleController extends Controller
{
    use CrudTrait;
    public function index(){
        $data = $this->listing('role');
        return view('pim.role.listing', $data);
    }

    public function create(Request $request) {
        $permission = PermissionHelper::getPermissions('role');
        if (!$permission || !$permission->create) {
            return redirect()->route('index');
        }

        $modules = Module::all();
        return view('pim.role.add', compact('modules'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permissions' => 'array',
        ], [
            'role_name.required' => 'Please enter Role name.',
        ]);

        $role = Role::create([
            'role' => $request->role_name,
            'creator_id' => $user->id,
        ]);

        if($request->permissions){
            foreach ($request->permissions as $moduleId => $actions) {
                $permission = [
                    'role_id' => $role->id,
                    'module_id' => $moduleId,
                    'view' => in_array('view', $actions),
                    'view_all' => in_array('view_all', $actions),
                    'create' => in_array('create', $actions),
                    'edit' => in_array('edit', $actions),
                    'delete' => in_array('delete', $actions)
                ];
                Permission::create($permission);
            }
        }

        return redirect()->route('pim.role.listing')->with('message', 'Role has beeen Created Successfully!');
    }
    public function edit($id){
        $permission = PermissionHelper::getPermissions('role');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $role = Role::with(['permissions.module'])->findOrFail($id);
        $modules = Module::all();

        $rolePermissions = [];
        foreach ($role->permissions as $perm) {
            $rolePermissions[$perm->module_id] = [
                'view_all' => $perm->view_all,
                'view'     => $perm->view,
                'create'   => $perm->create,
                'edit'     => $perm->edit,
                'delete'   => $perm->delete,
            ];
        }

        return view('pim.role.edit', compact('role', 'modules', 'rolePermissions'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permissions' => 'array',
        ], [
            'role_name.required' => 'Please enter Role name.',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['role' => $request->role_name]);

        Permission::where('role_id', $id)->delete();
        foreach ($request->permissions as $moduleId => $actions) {
            $permission = [
                'role_id' => $role->id,
                'module_id' => $moduleId,
                'view' => in_array('view', $actions),
                'view_all' => in_array('view_all', $actions),
                'create' => in_array('create', $actions),
                'edit' => in_array('edit', $actions),
                'delete' => in_array('delete', $actions)
            ];
            Permission::create($permission);
        }

        return redirect()->route('pim.role.listing')->with('message', 'Role has beeen Updated Successfully!');
    }

    public function view($id){
        $permission = PermissionHelper::getPermissions('role');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $role = Role::with(['permissions.module'])->findOrFail($id);
        $modules = Module::all();

        $rolePermissions = [];
        foreach ($role->permissions as $perm) {
            $rolePermissions[$perm->module_id] = [
                'view_all' => $perm->view_all,
                'view'     => $perm->view,
                'create'   => $perm->create,
                'edit'     => $perm->edit,
                'delete'   => $perm->delete,
            ];
        }

        return view('pim.role.view', compact('role', 'modules', 'rolePermissions'));
    }

    public function delete($id) {
        $permission = PermissionHelper::getPermissions('role');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $role = Role::findOrFail($id);
        $role->delete();
        Permission::where('role_id', $id)->delete();
        return redirect()->route('pim.role.listing');
    }

    public function multiDelete(Request $request){
        $permission = PermissionHelper::getPermissions('role');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        if (!empty($ids) && is_array($ids)) {
            Role::whereIn('id', $ids)->delete();
            Permission::whereIn('role_id', $ids)->delete();
        }

        return redirect()->route('pim.role.listing');
    }
}
