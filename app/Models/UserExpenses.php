<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExpenses extends Model
{
    use HasFactory;

    protected $fillable = ['sub_category_id','user_id','data'];

    public function users() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function subcategory() {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }

}
