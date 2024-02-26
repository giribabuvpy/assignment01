@extends('layouts.admin')

@section('title', 'Category Listing')

@section('admincontent')
<div class="container">
    <div class="row h-100 justify-content-center align-items-center">
         <h2>Items (sub-category) Management</h2> 
    </div>
    
    <div class="row">
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
    <div class="col">
        <a href="{{route('sub-category.create')}}" class="btn btn-primary float-end">Create Item</a>
    </div>  
    </div>
    <div class="col-md-12 float-start">
        
        <table id="category-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Category Name</th> 
                    <th>Item Name</th> 
                    <th>Field Type</th>
                    <th>Input Type</th>
                    <th>Validation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subcategory as $category)
                  <tr>
                    <td>{{ $category->categories->category_name }}</td> 
                    <td>{{ $category->sub_category_name }}</td>
                    <td>{{ ucfirst($category->field_type) }}</td>
                    <td>{{ ucfirst($category->input_type) }}</td>
                    <td>{{ ucfirst($category->validation) }}</td>
                    <td>
                        <a href='{{route('sub-category.edit', $category)}}' class="btn btn-secondary float-start px-2">Edit</a> 
                        
                        <form class='float-start px-2' action="{{ route('sub-category.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td> 
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#category-table').DataTable();
    });
</script>
 
@endsection