@extends('layouts.main')
	
@section('content')
	<div class="col-md-2"></div>
	<div class="col-md-8">
	<h1>form goes here</h1>
<form method="post" action="/messages/{{$message->id}}" enctype="multipart/form-data">
	{{csrf_field()}}
	{{method_field('PATCH')}}
  @include('messages.formfields')
 <div class="form-group"> 

<input type="submit" value="Submit" class="btn btn-primary">
<a href="/messages" class="btn btn-secondary" role="button">Back</a>
</div>
 </form>
 
 <form method="post" action="/messages/{{$message->id}}">
	 {{csrf_field()}}
	 {{method_field('DELETE')}}
	 <input type="submit" value="Delete" class="btn btn-danger">
</form>
</div>
@endsection
	