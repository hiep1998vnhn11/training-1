<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Spatie\Permission\Commands\CreateRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $currentUser=Auth::user();
        $this->middleware('auth');
        View::share('currentUser', $currentUser);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $users=User::all();
        $currentUser = Auth::user();
        if(Auth::user()->isAdmin) return redirect ('/admin');
        else return view('home')->with(['users'=> $users, 'currentUser'=>$currentUser]);
    }
}
