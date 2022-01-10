@extends('layout')
@section('content')
<style>
    .error{
    color: red;
  }
</style>
<div class="col-sm-8">
<h3>Login User</h3>
@if(Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{Session::get('error')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
@endif
<form action="loginUser" method="post" class="form">
<!-- @csrf -->
<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email">
</div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control" placeholder="Enter Password">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@endsection
@section('js')
<script>
$(document).ready(function(){
    $(".form").validate({
        rules: {
            email: {
                    required: true
                },
            password: {
                    required: true
                }
        },
        messages:{
            email:{
                required : 'Please enter email'
            },
            password:{
                required : 'Please enter password'
            }
        }    
    });    
});
</script>
@endsection