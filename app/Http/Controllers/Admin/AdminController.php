<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); 
        $currentUser = Auth::user();
        return view('home')->with(['users'=> $users, 'currentUsers'=>$currentUser]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $currentUser = Auth::user();
        $permissions = $currentUser->getPermissionsViaRoles();
        $hasPermission = 0;
        foreach($permissions as $permission){
            if($permission->name == 'create user') $hasPermission = 1;
        } 
        if($hasPermission){
        return view('admin.create');
        } else {
            session()->flash('fail', 'Permission Denied!');
            return redirect('/admin');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|max:25',
            'password_confirmation' => 'required|same:password'
        ], [
            'name.required' => 'You did not input your name',
            'name.min' => 'Name at least 4 character',
            'email.required' => 'You did not input your email!',
            'email.email' => 'You should input EMAIL',
            'email.unique' => 'This email was exist',
            'password.required' => 'You did not input password!',
            'password.min' => 'password at least 4 character!',
            'password.max' => 'password maximum 25 character!',
            'password_confirmation.required' => 'You did not input reset password!',
            'password_confirmation.same' => 'Please input reset password and password same!'
        ]);
        
        $role = Role::findByID(1);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole($role);
        $user->save();
            session()->flash('success', 'Create User successfully!');
        return redirect('/admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        if($user->email == 'superadmin@admin'){
            session()->flash('fail', 'Can not Edit The Super-Admin!');
            return redirect('/admin');
       }
        $currentUser = Auth::user();
        
        $permissions = $currentUser->getPermissionsViaRoles();
        $hasPermission = 0;
        if($currentUser == $user) $hasPermission = 1;
        foreach($permissions as $permission){
            if($permission->name == 'edit user') $hasPermission = 1;
        } 
        if($hasPermission){
        return view('admin.edit')->with('user', $user);
        } else {
            session()->flash('fail', 'Permission Denied!');
            return redirect('/admin');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();
        $permissions = $currentUser->getPermissionsViaRoles();
        $hasPermission = 0;
        if($currentUser == $user) $hasPermission = 1;
       
        foreach($permissions as $permission){
            if($permission->name == 'edit user') $hasPermission = 1;
        } 
        if($hasPermission){
            if($user->email == 'superadmin@admin'){
                session()->flash('fail', 'Can not Edit The Super-Admin!');
                return redirect('/admin');
           }
        $this->validate(request(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:4|max:25',
            'password_confirmation' => 'required|same:password'
        ], [
            'name.required' => 'You did not input your name',
            'name.min' => 'Name at least 4 character',
            'email.required' => 'You did not input your email!',
            'email.email' => 'You should input EMAIL',
            'password.required' => 'You did not input password!',
            'password.min' => 'password at least 4 character!',
            'password.max' => 'password maximum 25 character!',
            'password_confirmation.required' => 'You did not input reset password!',
            'password_confirmation.same' => 'Please input reset password and password same!'
        ]);

        $data = request()->all();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);

        $user->save();
        session()->flash('success', 'User was updated!');
        
        } else {
            session()->flash('fail', 'Permission Denied!');
        }
        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {   
        if($user->email == 'superadmin@admin'){
            session()->flash('fail', 'Can not Delete The Super-Admin!');
            return redirect('/admin');
        } 
        $currentUser = Auth::user();
        $permissions = $currentUser->getPermissionsViaRoles();
        $hasPermission = 0;
        foreach($permissions as $permission){
            if($permission->name == 'delete user') $hasPermission = 1;
        } 
        if($hasPermission){
        $user->delete();
        session()->flash('success', 'User was Deleted!');
        return redirect('/admin');
        } else {
            session()->flash('fail', 'Permission Denied!');
            return redirect('/admin');
        }
        
    }

    public function search(Request $request){
        $keyword = $request->get('keyword');
        $users = User::where('name', 'like', '%' .$keyword. '%')->orWhere('email', 'like', '%'.$keyword.'%')
            ->orWhere('id', 'like', '%'.$keyword.'%')->paginate(5);
        return view('home')->with('users', $users);
    }
}
