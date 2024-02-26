@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Expense Report of {{ Auth::user()->name }}</div>
                 
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
 
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Item Name</th> 
                                <th>Date</th> 
                                <th>Input Value</th> 
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($expenses as $user)
                             @foreach($user->userexpenses as $exp ) 
                              <tr>
                                <td>{{$exp->subcategory->categories->category_name}}</td>
                                <td>{{$exp->subcategory->sub_category_name}}</td>
                                <td>{{$exp->expense_date}}</td>
                                <td>{{$exp->data}}</td> 
                              </tr>
                              @endforeach
                            @endforeach 
                        </tbody> 
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection
 