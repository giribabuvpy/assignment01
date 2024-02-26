<?php

namespace App\Http\Controllers;

use App\Models\Category; 
use App\Models\User;
use App\Models\UserExpenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = auth()->id();

        //Logged in users expense record
        $expenses = User::with('userexpenses','userexpenses.subcategory','userexpenses.subcategory.categories')->where('id',$userId)->get(); 
         
        return view('home',['expenses'=>$expenses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addexpenses() 
    {
        $userId = Auth::id();
        $allItems = Category::with('subcategory')->get();
        return view('user.add_expense',['items'=>$allItems,'userId'=>$userId]);
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $data = $request->validate([
            'record.*.sub_category_id' => 'required', 
            'record.*.data' =>  'required',
            'record.*.user_id' => 'required',
        ]); 
 
        foreach ($data['record'] as $itemData) {
            UserExpenses::create([
                'sub_category_id' => $itemData['sub_category_id'],
                'data' => $itemData['data'],
                'user_id' => $itemData['user_id'],
            ]);
        }
            
        return redirect()->route('home')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //return view('admin.user_create');
        return view('admin.user.create', ['user'=>$user]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required' 
        ]);

        if ($request->filled('password')) { 
            $password = $request->validate(['password'=>'min:6']);
            $data['password'] = $password['password'];
        } 

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->userexpenses()->delete(); 
        $users->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}