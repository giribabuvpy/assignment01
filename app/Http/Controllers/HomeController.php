<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExpenses;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    { 

        $subcategory = SubCategory::all();  
        $category = Category::all(); 
        $userId = Auth::id();

        $total_query = UserExpenses::orderBy('expense_date','desc')->with('users','category', 'subcategory');

        if ($request->has('sub_category') && !empty($request->sub_category) ) 
        {
            $total_query->where('sub_category_id', $request->sub_category);
        }

        if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date && !empty($request->end_date) ))
        {
            $total_query->whereBetween(DB::raw('DATE(expense_date)'), [$request->start_date, $request->end_date]);
        }
 
        $total_query->where('user_id',$userId);


        $totalExpenses = $total_query->sum('data');

        $query = UserExpenses::orderBy('expense_date','asc')->with('users','category', 'subcategory');
         
        $currentMonth = Carbon::now()->month; 

        if ($request->has('sub_category') && !empty($request->sub_category) ) 
        {
            $query->where('sub_category_id', $request->sub_category);
        }

        if ($request->has('category') && !empty($request->category) ) 
        {
            $query->where('category_id', $request->category);
        }

        if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date && !empty($request->end_date) ))
        {
            $query->whereBetween(DB::raw('DATE(expense_date)'), [$request->start_date, $request->end_date]);
        }
        else if ($request->has('month')  && !empty($request->month) )
        {
            $query->whereMonth(DB::raw('DATE(expense_date)'), $request->month);
        } else {
            $query->whereMonth(DB::raw('DATE(expense_date)'), $currentMonth);
        }

        $query->where('user_id',$userId);

        $expenses = $query->get() 
            
        ->groupBy([  
                'category.category_name',
                'subcategory.sub_category_name',  
                function ($rec) {
                    return Carbon::parse($rec->expense_date)->format('d-M-Y');
                }
        ]);   

       //dd(DB::getQueryLog());

        return view('home', ['expenses'=>$expenses,'subcategory'=>$subcategory,'category'=>$category,'totalexpenses'=>$totalExpenses]); 
    }

    public function getsubcategory(Category $category) {
        $subCategories = SubCategory::where('category_id', $category->id)->get();
        return response()->json($subCategories);
    }


    public function list() { 
       
        $userExpenses = UserExpenses::all();
        $expenses = [];
 
        foreach($userExpenses as $exp) {
            $userId = Auth::id();
            $users = User::find($userId);
            $subcat = $exp->subcategory()->get();  

            foreach($subcat as $scat) {
                $category = $scat->categories()->get();

                $subCategoryExpenses = $exp->where('sub_category_id', $scat->id)->sum('data');
                $userExpenses[$scat->name] = $subCategoryExpenses;

                foreach($category as $cat) { 
                  $categoryExpenses = $scat->where('category_id', $scat->id);
                  $userExpenses[$cat->name] = $categoryExpenses;
                }
            }
        }

        return view('user.list', [
            'users' => $userExpenses,
            'categories' => $category,
            'subCategories' => $subcat,
            'expenses' => $expenses,
        ]);
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

        $requiredNumbers = $request->input('required_numbers', []);
        $checkValid = array_keys($requiredNumbers);
        $rules = [];
        
        foreach ($request->input('record', []) as $key => $value) {
            
            $rules['record.'.$key.'.data'] = in_array($key, $checkValid) ? 'required|numeric' : 'nullable|numeric';
        }
 
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->validate([
            'record.*.sub_category_id' => 'nullable|numeric', 
            'record.*.data' =>  'nullable|numeric',
            'record.*.user_id' => 'nullable|numeric',
            'record.*.expense_date' => 'nullable',
        ]); 
 
        foreach ($data['record'] as $itemData) {
            
            $subCats = SubCategory::find($itemData['sub_category_id']);
            $Cats= $subCats->categories()->get()[0];
            $cat_id = $Cats->id; 
 
            UserExpenses::create([
                'category_id' => $cat_id,
                'sub_category_id' => $itemData['sub_category_id'],
                'data' => (empty($itemData['data']))?0:$itemData['data'],
                'expense_date'=>date('Y-m-d',strtotime($itemData['expense_date'])),
                'user_id' => $itemData['user_id'],
            ]);
        }
            
        return redirect()->route('home')
            ->with('success', 'Your expenses record added successfully.');
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