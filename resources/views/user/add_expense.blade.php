@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
             
                <div class="card-header"><h4>Add your expenses</h4></div>
                
                <div class="card-body">

                    <form action="{{ route('expense.store') }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="table-responsive">
                            <table class="table">
                                @foreach($items as $cat=>$category)
                                @if(count($category->subcategory)>1)
                                <tr>
                                    <td colspan="2">
                                        <h4>{{$category->category_name}}</h4>
                                    </td>
                                    <td></td>
                                </tr>
                                @endif

                                @foreach($category->subcategory as $key=>$item)
                                <tr>
                                    <td>{{ $item->sub_category_name }}</td>
                                    <td>
                                        <input type='hidden' name='record[{{$item->id}}][sub_category_id]' value='{{$item->id}}' />
                                        <input type='hidden' name='record[{{$item->id}}][user_id]' value="{{$userId}}" />
                                        <input type='hidden' name='record[{{$item->id}}][validation]' value='{{$item->validation==='required' ?'required|':''}}{{$item->input_type}}' />

                                        @if($item->field_type=='textarea')
                                        <textarea name='record[{{$item->id}}][data]' class="form-control" {{$item->validation==='required' ?'required':''}} autofocus>{{ old('data[$item->id]') }}</textarea>
                                        @else
                                        <input name='record[{{$item->id}}][data]' type='{{$item->input_type==='decimal' ?'number':'text'}}' {{$item->input_type==='decimal' ?'min=1':''}} class="form-control {{$item->input_type==='date' ?'datepicker':''}}" value="{{ old('data[$item->id]') }}" {{ $item->validation==='required' ?'required':''}} autofocus />
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @endforeach
                            </table>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary"> Save </button>
                                <button type="button" class="btn btn-secondary btn-space" onClick="window.history.back();"> Cancel </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
        });
    });
</script>
@endsection