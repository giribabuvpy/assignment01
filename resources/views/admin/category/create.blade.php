@extends('layouts.admin')

@section('admincontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@if(isset($categories)) Update Category @else Create Category @endif</div>

                <div class="card-body">
                        @if(isset($categories))
                            <!-- Form for updating category -->
                            <form action="{{ route('category.update', ['category' => $categories->id]) }}" method="POST">
                                @method('PUT')
                        @else
                            <!-- Form for creating category -->
                            <form action="{{ route('category.store') }}" method="POST">
                        @endif
                        @csrf

                        <div class="form-group row py-2">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">

                                <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name', isset($categories) ? $categories->category_name : '') }}" required autocomplete="category_name" autofocus>

                                @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row py-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($categories) ? 'Update Category' : 'Create Category' }}
                                </button>

                                <button type="button" class="btn btn-secondary btn-space" onClick="window.history.back();">
                                    Cancel
                                </button>
 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection