<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->text('data')->nullable();
            $table->date('expense_date')->default(DB::raw('CURRENT_DATE'));
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete;
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->cascadeOnDelete;
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_expenses');
    }
};
