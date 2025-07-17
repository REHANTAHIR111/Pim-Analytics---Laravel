<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Module;
use App\Models\Permission;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(){
        View::composer('components.layout.default', function ($view) {
            $user = auth()->user();

            if (!$user) {
                $view->with('modules', collect());
                return;
            }

            $roleId = $user->role;

            $permittedModuleIds = Permission::where('role_id', $roleId)
                ->where(function ($query) {
                    $query->where('view', 1)->orWhere('view_all', 1);
                })
                ->pluck('module_id');

            $modules = Module::whereIn('id', $permittedModuleIds)
                ->orderBy('id', 'desc')
                ->get();

            $view->with('modules', $modules);
        });
    }
}
