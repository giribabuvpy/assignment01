@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">User</th>
                    @foreach ($categories as $category)
                        <th scope="col">{{ $category->name }}</th>
                        @foreach ($subCategories as $subCategory)
                            <th scope="col">{{ $category->name }} - {{ $subCategory->name }}</th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td scope="row">{{ $user->name }}</td>
                        @foreach ($categories as $category)
                            <td>{{ $expenses[$user->name][$category->name] }}</td>
                            @foreach ($subCategories as $subCategory)
                                <td>{{ $expenses[$user->name][$category->name . ' - ' . $subCategory->name] }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection