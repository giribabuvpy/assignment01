<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategory = SubCategory::all();
        return view('admin.subcategory.index', ['subcategory'=>$subCategory]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.subcategory.create',['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_category_name' => 'required|regex:/^[\pL\s]+$/u|unique:sub_categories,sub_category_name',
            'category_id' => 'required', 
            'validation' => 'required', 
        ]);
 
        SubCategory::create($data);

        return redirect()->route('sub-category.index')
            ->with('success', 'Item created successfully.');
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
    public function edit(SubCategory $subCategory)
    {
        $category = Category::all(); //To list the parent category
        return view('admin.subcategory.create', ['subcategory'=>$subCategory,'category'=>$category]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    { 
        $data = $request->validate([
            'sub_category_name' => 'required|regex:/^[\pL\s]+$/u|unique:sub_categories,sub_category_name,'.$subCategory->id,
            'category_id' => 'required',
            'field_type' => 'required',
            'input_type' => 'required', 
            'validation' => 'required', 
        ]);
  
        $subCategory->update($data);  

        return redirect()->route('sub-category.index')
            ->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->userexpenses()->delete(); 
        $subCategory->delete();

        return redirect()->route('sub-category.index')
            ->with('success', 'Item deleted successfully');
    }
}
