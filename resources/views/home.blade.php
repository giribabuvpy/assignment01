@extends('layouts.design')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Expense Report of {{ Auth::user()->name }}</div>
                 
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div class="col">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>


<form method="GET" action="{{ route('home') }}" name="filter_form" id="filter_form">
  
    <label for="sub_category">Category:</label> 
    <select name="sub_category" id="sub_category">
        <option value="">All</option>
        @foreach($category as $cat) 
            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
        @endforeach
    </select>


    <label for="sub_category">Items:</label> 
    <select name="sub_category" id="sub_category">
        <option value="">All</option>
        @foreach($subcategory as $subcat) 
            <option value="{{ $subcat->id }}">{{ $subcat->sub_category_name }}</option>
        @endforeach
    </select>

 
    <label for="sub_category">|</label> 

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">

    <button type="submit">Apply</button>
    <a href='{{ route('home') }}'>Reset</a>

</form>

 <hr />

 
 <table class="table">
 
    <tr>
        <td colspan="3" class="text-end"><h2>All expenses: {{$totalexpenses}}</h2></td> 
    </tr> 
    @foreach($expenses as $categoryName => $subCategories)
        <tr>
            <td colspan="3"><h3>{{ $categoryName }}</h3> </td> 
        </tr> 
        <tr> 
            <th>Date</th>
            <th>Item</th>
            <th class="text-end">Total Expenses</th>
            <th></th>
        </tr>
        <?php $sub_total=0; ?>
        @foreach($subCategories as $subCategoryName => $dates)   
            @foreach($dates as $date => $exp)
                <tr> 
                    <td>{{ $date }}</td>
                    <td >{{ $subCategoryName }}</td>
                    <td class="text-end">{{ $exp->sum('data') }}<?php $sub_total= ($sub_total+(float)$exp->sum('data')); ?></td>
                    <td>
                       <?php /*
                    <ul>
                    @foreach($exp as $e) 
                        <li>
                            <?=date('d-M-Y', strtotime($e->expense_date));?>:
                        <a href='{{route('expenses.edit', $e->id)}}' class="btn btn-secondary float-start px-2">Edit</a> 
                
                        <form class='float-start px-2' action="{{ route('expense.destroy', $e->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </li> 
                    @endforeach
                    </ul> 
                */?>
                    </td>
                            
                </tr>
            @endforeach  
        @endforeach
        <tr><td colspan="3" class="text-end">Sub total: {{$sub_total}}</td></tr>
            
    @endforeach
    </table>
 

                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#example2').DataTable(); 
});
</script>
@endsection
 