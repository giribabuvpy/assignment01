<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['id','category_name'];

    public function subcategory():HasMany {
        return $this->hasMany(SubCategory::class);
    }

    public function expenses():HasMany {
        return $this->hasMany(UserExpenses::class);
    }

    public function showExpenseTracker()
    {
        return $categories = Category::with('subcategory.userexpenses')->get();
        //return view('expense_tracker', compact('categories'));
    }
 
}
