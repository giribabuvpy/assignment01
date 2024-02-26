<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\UserExpenses;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['id','sub_category_name','field_type','input_type','validation','category_id'];

    public function categories() {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function userexpenses() {
        return $this->hasMany(UserExpenses::class,'user_id','id');
    } 
}
