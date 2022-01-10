@extends('layout')

@section('content')
<div class="col-sm-8">
<h3> Restaurants List</h3>
@if(Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{Session::get('error')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
@endif
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Customer Name</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <!-- <th scope="col"></th> -->
    </tr>
  </thead>
  <tbody>
@if(sizeof($res)!=0)
    @foreach ($res as $object)
        <tr>
            <th scope="row">{{ $object['id'] }}</th>
            <td>{{ $object['Name'] }}</td>
            <td>{{ $object['customer_name'] }}</td>
            <td>{{ $object['email'] }}</td>
            <td>{{ $object['Address'] }}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan='4'>
           <span> No data found</span>
        </td>
    </tr>
@endif   
  </tbody>
</table>

</div>
@endsection