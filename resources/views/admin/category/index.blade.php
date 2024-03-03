@extends('layouts.admin')

@section('title', 'Category Listing')

@section('admincontent')
<div class="container">
    <div class="row h-100 justify-content-center align-items-center">
         <h2>Category Management</h2> 
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
        <a href="{{route('category.create')}}" class="btn btn-primary float-end">Create category</a>
    </div>  
    </div>
    <div class="col-md-12 float-start">
        
        <table id="category-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th> 
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                  <tr>
                    <td>{{ $category->category_name }}</td> 
                    <td>
                        <a href='{{route('category.edit', $category)}}' class="btn btn-secondary float-start px-2">Edit</a> 
                        
                        <form class='float-start px-2' action="{{ route('category.destroy', $category->id) }}" method="POST">
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