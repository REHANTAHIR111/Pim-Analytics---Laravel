<?php

namespace App\Helpers;

use App\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function getPermissions(string $moduleName)
    {
        $user = Auth::user();
        $roleId = $user->role ?? null;

        return Permission::where('role_id', $roleId)
            ->whereHas('module', fn($q) => $q->where('name', $moduleName))
            ->first();
    }
}
