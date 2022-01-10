@extends('layout')

@section('content')
<div class="col-sm-8">
<h3> Add Restaurant</h3>
@if(Session::get('register_status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{Session::get('register_status')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        </div>
@endif
<form action="add" method="post" return="false">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter Name" required>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <textarea type="number" name="address"  class="form-control" placeholder="Enter Address" required>{{ old('address') }} </textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@endsection