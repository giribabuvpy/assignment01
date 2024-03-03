@extends('layouts.admin')

@section('admincontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Admin: All user's expense log</h5></div>

                <div class="card-body">

                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table id="example2" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Category Name</th>
                                <th>Sub Category</th>
                                <th>Date</th>
                                <th>Input Value</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($expenses as $user)
                            @foreach($user->userexpenses as $exp )
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$exp->subcategory->categories->category_name}}</td>
                                <td>{{$exp->subcategory->sub_category_name}}</td>
                                <td>{{date('d-M-Y',strtotime($exp->expense_date))}}</td>
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
        new DataTable('#example2', { 
            order: [[0, 'asc']],
            rowGroup: { dataSrc: 0 },  
        });
    });
</script>
@endsection