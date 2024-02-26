<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() { 
        //All users expenses for admin
        $expenses = User::with('userexpenses','userexpenses.subcategory','userexpenses.subcategory.categories')->get(); 
        return view('admin.dashboard',['expenses'=>$expenses]);
    }

    public function showLoginForm()
    {
        if (!auth()->check()) {
            return view('admin.login');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) { 
            return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => 'These credentials do not match our records.']);
        }
    }
 
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
