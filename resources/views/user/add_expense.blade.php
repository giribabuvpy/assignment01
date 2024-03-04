@extends('layouts.design')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
             
                <div class="card-header">
                  <h4 style="float: left;">Add your expenses</h4> 
                  <div style="float: right;"> <input type="date" name="current_date" id="current_date"  value="<?php echo date('Y-m-d'); ?>" onblur="updatedate();"/> </div>
              </div>

                <?php /*
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                */ ?>
                
                <div class="card-body">
                    <form name="formaddexpenses" id="formaddexpenses" action="{{ route('expense.store') }}" method="POST" novalidate>
                        @method('POST')
                        @csrf
                        <div class="table-responsive">
                            <table class="table">
                                @foreach($items as $cat=>$category)
                                @if(count($category->subcategory)>0)
                                <tr>
                                    <td colspan="2">
                                        <h4>{{$category->category_name}}</h4>
                                    </td>
                                    <td></td>
                                </tr>
                                @endif

                                @foreach($category->subcategory as $key=>$item)
                                <tr>
                                    <td>{{ ucwords($item->sub_category_name) }}</td>
                                    <td>
                                        <input type='hidden' name='record[{{$item->id}}][sub_category_id]' value='{{$item->id}}' />

                                        <input type='hidden' name='record[{{$item->id}}][expense_date]' value="" class="expense_date" />
                                        <input type='hidden' name='record[{{$item->id}}][user_id]' value="{{$userId}}" />
                                        <input type='hidden' name='record[{{$item->id}}][validation]' value='{{$item->validation==='required' ?'required':''}}{{$item->input_type}}' /> 
                                        <input name='record[{{$item->id}}][data]' type='number' min='10' class="form-control {{ $item->validation==='required' ?'needs-validation':''}} @error('record.'.$item->id.'.data') is-invalid @enderror" value="{{ old('data[$item->id]') }}" {{ $item->validation==='required' ?'required autofocus':''}}  />
                                       
                                        @if($item->validation==='required')
                                            <input name='required_numbers[{{$item->id}}]' type='hidden' value="{{ $item->validation==='required' ? $item->id:''}}" />
                                        @endif

                                        <div class="invalid-feedback">
                                            Please add valid expense amount of {{ucwords($item->sub_category_name)}}. (Number, minimum 10)
                                        </div>
                                        <?php /*
                                        @error('record.'.$item->id.'.data')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        */ ?>
 
                                        
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
  // JavaScript for form validation
  document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);

      var fields = form.querySelectorAll('.form-control');
      fields.forEach(function(field) {
        field.addEventListener('blur', function() {
            console.log('test');
          if (!field.checkValidity()) {
            field.classList.add('is-invalid');
          } else {
            field.classList.remove('is-invalid');
          }
        });
      });
    });
  }); 

   
function updatedate() {
    let expense_date = document.getElementById("current_date").value;
    $(".expense_date").val(expense_date); 
    console.log(expense_date);
  }

  $(document).ready(function() {

    

  $('.needs-validation').blur(function() {
    validateInput($(this));
  });

  $('#formaddexpenses').submit(function(event) {
    
    var isValid = true;
    $('.needs-validation').each(function() {
      if (!validateInput($(this))) {
        isValid = false;
        
      }
    });
    if (isValid) {
      // Form submission logic  
      console.log("Form submitted successfully");
      return true;
    } else {
      event.preventDefault();
      return false;
    }
  });

  function validateInput(input) {
    var value = input.val();
    // Check if value is a number and is greater than or equal to 10
    if (!isNaN(value) && parseFloat(value) >= 10) {
      input.removeClass('is-invalid');
      input.addClass('is-valid');
      return true;
    } else {
      input.addClass('is-invalid');
      input.removeClass('is-valid');
      return false;
    }
  } 
});

</script>
 
@endsection