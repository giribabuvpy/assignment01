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

                    @if(count($expenses)>0)
                    <form method="GET" action="{{ route('home') }}" name="filter_form" id="filter_form">

                        <table class="table">
                            <tr>
                                <td>
                                    <label for="category">Category</label>
                                    <select name="category" id="category">
                                        <option value="">Select category</option>
                                        @foreach($category as $cat)
                                        <option value="{{ $cat->id }}"  <?php $catSelect = request()->query('category'); echo ($cat->id==$catSelect)?'selected':'';  ?> >
                                            {{ ucwords($cat->category_name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <label for="sub_category">Items</label>
                                    <select name="sub_category" id="sub_category" class="text-capitalize">
                                        <option value="">All</option>
                                        @foreach($subcategory as $subcat)
                                        <option value="{{ $subcat->id }}" <?php $subcatSelect = request()->query('sub_category'); echo ($subcat->id==$subcatSelect)?'selected':'';  ?> >
                                            {{ ucwords($subcat->sub_category_name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>

                                    <label for="month_select">Month </label>
                                    <select name="month" id="month" class="text-capitalize">
                                        <option value="">All</option> 
                                        @for($month=1;$month<=12;$month++) 
                                            <option value="{{ $month }}" 
                                                <?php 
                                                $monthQuery = request('month'); 
                                                $default = ((int) $month===(int)date('m') && $monthQuery=='') ? 'selected ' :'';  
                                                      $monthSelect= ((int) $month===(int)$monthQuery) ? 'selected' :''; 
                                                      echo ($monthSelect=='') ? $default:$monthSelect; ?>>
                                                {{ date("F", mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </td>
                             
                                <td>

                                    <label for="start_date">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">

                                </td>

                                <td>

                                    <label for="end_date">End Date</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">

                                </td>

                                <td width="150" class="align-bottom">
                                    <button type="submit">Apply</button>
                                    <a href='{{ route('home') }}'>Reset</a>
                                </td>
                            </tr>
                        </table>

 
                    </form>

                    <hr />
                    @endif


                    <table class="table">

                        @if(count($expenses)>0)
                        <tr>
                            <td colspan="3" class="text-end">
                                <h2>All expenses: {{$totalexpenses}}</h2>
                            </td>
                        </tr>
                        @foreach($expenses as $categoryName => $subCategories)
                        <tr>
                            <td colspan="3">
                                <h3>{{ $categoryName }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th class="text-end">Total Expenses</th>
                            <th></th>
                        </tr>
                        <?php $sub_total = 0; ?>
                        @foreach($subCategories as $subCategoryName => $dates)
                        @foreach($dates as $date => $exp)
                        <tr>
                            <td>{{ $date }}</td>
                            <td>{{ ucwords($subCategoryName) }}</td>
                            <td class="text-end">{{ $exp->sum('data') }}<?php $sub_total = ($sub_total + (float)$exp->sum('data')); ?></td>
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
                */ ?>
                            </td>

                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end">Sub total: {{$sub_total}}</td>
                        </tr>
                        @endforeach

                        @else

                        <tr>
                            <td colspan="3" class="text-center">
                                <h3>No expense recorded</h3>
                            </td>
                        </tr>
                        @endif
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#category').change(function() {
        var category_id = $(this).val();
        $.ajax({
            url: '/sub-categories/' + category_id,
            type: 'GET',
            success: function(response) {
                var subCategoryOptions = '<option value="">Select Items</option>';
                response.forEach(function(subCategory) {
                    subCategoryOptions += '<option value="' + subCategory.id + '">' + subCategory.sub_category_name + '</option>';
                });
                $('#sub_category').html(subCategoryOptions);
            }
        });
    });
</script>
@endsection