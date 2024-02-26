@extends('layouts.admin')

@section('title', 'User Listing')

@section('admincontent')
<div class="container">
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
        <a href="{{route('users.create')}}" class="btn btn-primary float-end">Create user</a>
    </div>  
    </div>
    <div class="col-md-12 float-start">
        
        <table id="user-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <a href='{{route('users.edit', $user)}}' class="btn btn-secondary float-start px-2">Edit</a> 
                        
                        <form class='float-start px-2' action="{{ route('users.destroy', $user->id) }}" method="POST">
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
        $('#user-table').DataTable();
    });
</script>
 
@endsection