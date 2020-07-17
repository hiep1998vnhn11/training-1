<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;

class SuperAdminController extends Controller
{
    public function setAdmin(User $user){
        //set role admin
        
        $user->assignRole('admin');
        session()->flash('success', 'User was changed to role admin!');
        return redirect('/admin');
    }

    public function setViewer(User $user){
        //set role viewer
        $user->assignRole('viewer');
        session()->flash('success', 'User was changed to role viewer!');
        return redirect('/admin');
    }

    public function blockUser(User $user){
        //set role block
        $user->assignRole('blocked');
        session()->flash('success', 'User was Blocked!');
        return redirect('/admin');
    }
}
