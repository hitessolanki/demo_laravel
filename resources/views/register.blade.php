@extends('layout')

@section('content')
    <div class="col-sm-8">
        <h3>Register User</h3>
        @if(Session::get('register_status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('register_status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        <form action="registerUser" method="post" return="false">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter Name" >
                @if ($errors->has('name')) 
                        <div class="alert alert-danger">
                            {{$errors->first('name')}}
                        </div>
                @endif   
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email" >
                @if ($errors->has('email')) 
                    <div class="alert alert-danger">
                        {{$errors->first('email')}}
                    </div>
                @endif    
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="Enter Password" >
                @if ($errors->has('password')) 
                    <div class="alert alert-danger">
                        {{$errors->first('password')}}
                    </div>
                @endif    
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" class="form-control" placeholder="Confirm Password" >
                @if ($errors->has('confirm_password')) 
                    <div class="alert alert-danger">
                        {{$errors->first('confirm_password')}}
                    </div>
                @endif   
            </div>
            <div class="form-group">
                <label>Mobile</label>
                <input type="number" name="mobile_number" value="{{ old('mobile') }}" class="form-control" placeholder="Enter Mobile Number" >
                @foreach ($errors->get('mobile_number') as $message) 
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @endforeach   
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection