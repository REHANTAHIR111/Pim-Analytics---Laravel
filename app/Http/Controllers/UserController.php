<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Auth;
use App\Events\UserCreated;
use App\Traits\CrudTrait;

class UserController extends Controller
{
    use CrudTrait;
    public function index() {
        $data = $this->listing('users');
        // event(new UserCreated(User::find(46)));
        return view('pim.users.listing', $data);
    }

    public function create(Request $request) {
        $permission = PermissionHelper::getPermissions('users');
        $rolePerm = PermissionHelper::getPermissions('role');

        if (!$permission || !$permission->create) {
            return redirect()->route('index');
        }

        $role = collect();
        if($rolePerm){
            if ($rolePerm->view_all) {
                $role = Role::all();
            } elseif ($rolePerm->view) {
                $role = Role::where('creator_id', auth()->id())->get();
            }
        }

        return view('pim.users.add', compact('role'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phn' => 'required|string|min:11|unique:users,phone_number',
            'password' => [
                'required',
                'min:8',
                'regex:/^[a-zA-Z0-9._%+-@]{8,16}+$/'
            ],
            'cpassword' => 'required|same:password',
        ], [
            'fname.required' => 'Please enter First Name.',
            'lname.required' => 'Please enter Last Name.',
            'email.required' => 'Please enter Email.',
            'email.email' => 'Please enter a valid Email.',
            'email.unique' => 'This email is already registered.',
            'phn.required' => 'Please enter Phone Number.',
            'phn.unique' => 'This Phone Number is already registered.',
            'phn.min' => 'Phone Number must be at least 11 characters.',
            'password.required' => 'Please enter Password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Please enter a Strong Password.',
            'cpassword.required' => 'Please confirm your Password.',
            'cpassword.same' => 'The confirmation password does not match.',
        ]);

        User::create([
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->email,
            'phone_number' => $request->phn,
            'profile_image' => $request->image_mobile,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'status' => $request->status ? 1 : 0,
            'role' => $request->selectRole,
            'creator_id' => $user->id,
        ]);

        return redirect()->route('pim.users.listing')->with('message', 'User has beeen Created Successfully!');
    }

    public function edit($id){
        $permission = PermissionHelper::getPermissions('users');
        $rolePerm = PermissionHelper::getPermissions('role');

        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $users = User::findOrFail($id);
        $role = collect();

        if($rolePerm){
            if ($rolePerm->view_all) {
                $role = Role::all();
            } elseif ($rolePerm->view) {
                $role = Role::where('creator_id', auth()->id())->get();
            }
        }

        return view('pim.users.edit', compact('users', 'role'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phn' => 'required|string|min:11|unique:users,phone_number,' . $id,
            'password' => [
                'nullable',
                'min:8',
                'regex:/^[a-zA-Z0-9._%+-@]{8,16}+$/'
            ],
            'cpassword' => 'nullable|same:password',
        ], [
            'fname.required' => 'Please enter First Name.',
            'lname.required' => 'Please enter Last Name.',
            'email.required' => 'Please enter Email.',
            'email.email' => 'Please enter a valid Email.',
            'email.unique' => 'This email is already registered.',
            'phn.required' => 'Please enter Phone Number.',
            'phn.unique' => 'This Phone Number is already registered.',
            'phn.min' => 'Phone Number must be at least 11 characters.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Please enter a Strong Password.',
            'cpassword.same' => 'The confirmation password does not match.',
        ]);

        $users = User::findOrFail($id);
        $users->first_name = $request->fname;
        $users->last_name = $request->lname;
        $users->email = $request->email;
        $users->phone_number = $request->phn;
        $users->profile_image = $request->image_mobile;
        $users->date_of_birth = $request->dob;
        $users->password = $request->password ? Hash::make($request->password) : $users->password;
        $users->status = $request->status ? 1 : 0;
        $users->role = $request->selectRole;
        $users->update();

        return redirect()->route('pim.users.listing')->with('message', 'User has beeen Updated Successfully!');
    }

    public function delete($id) {
        $permission = PermissionHelper::getPermissions('users');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('pim.users.listing');
    }

    public function view($id){
        $permission = PermissionHelper::getPermissions('users');
        $rolePerm = PermissionHelper::getPermissions('role');

        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $users = User::findOrFail($id);
        $role = collect();

        if($rolePerm){
            if ($rolePerm->view_all) {
                $role = Role::all();
            } elseif ($rolePerm->view) {
                $role = Role::where('creator_id', auth()->id())->get();
            }
        }
        return view('pim.users.view', compact('users', 'role'));
    }

    public function multiDelete(Request $request){
        $permission = PermissionHelper::getPermissions('users');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (!empty($ids) && is_array($ids)) {
            User::whereIn('id', $ids)->delete();
        }
        return redirect()->route('pim.users.listing');
    }
}
