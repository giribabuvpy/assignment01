<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExpenses extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','sub_category_id','user_id','data','expense_date'];

    public function users():BelongsTo {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function category():BelongsTo {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subcategory():BelongsTo {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }

}
