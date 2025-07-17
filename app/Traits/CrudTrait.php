<?php

namespace App\Traits;
use App\Models\User;
use App\Helpers\PermissionHelper;
use App\Models\Role;

trait CrudTrait
{
    public function listing($module){
        $permission = PermissionHelper::getPermissions($module);
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $users = collect();
        $roles = collect();

        if ($permission) {
            if ($permission->view_all) {
                $users = User::with('roleRelation')->orderByDesc('id')->get();
                $roles = Role::orderByDesc('id')->get();
            } elseif ($permission->view) {
                $users = User::where('creator_id', auth()->id())->orderByDesc('id')->get();
                $roles = Role::where('creator_id', auth()->id())->orderByDesc('id')->get();
            }
        }

        // event(new UserCreated(User::find(46)));
        return compact('users', 'roles', 'permission');

        // $orders = Order::select(
        //     'date', 'order_number',
        //     'status', 'customer_details', 'payment_method',
        //     'coupon_code', 'shipping', 'ln_status', 'fetch_date',
        //     'total_value', 'city', 'user_device'
        // )
        // ->with([
        //    'shipments_data:order_id,shipment_no',
        //    'order_details' => function($q) {
        //         $q->flatMap(fn($detail) => $detail->order_detail_regional_qty)
        //         ->pluck('warehouse.ln_code')
        //         ->unique()
        //         ->take(2);
        //    }
        // ])
        // ->when($request->filled('date'), function ($q) use ($request) {
        //     $q->whereDate('date', $request->date);
        // })
        // ->when($request->filled('order_status'), function ($q) use ($request) {
        //     $q->whereIn('status', Arr::wrap($request->order_status));
        // })
        // ->when($request->filled('payment_methods'), function ($q) use ($request) {
        //     $q->whereIn('payment_method', Arr::wrap($request->payment_methods));
        // })
        // ->when($request->filled('city'), function ($q) use ($request) {
        //     $q->whereIn('city', Arr::wrap($request->city));
        // })
        // ->paginate(10);
    }

}
