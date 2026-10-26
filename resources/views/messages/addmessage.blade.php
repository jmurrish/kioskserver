@extends('layouts.main')
	
@section('content')
	<div class="col-md-2"></div>
	<div class="col-md-8">
	<h1>form goes here</h1>
<form method="post" action="/messages" enctype="multipart/form-data">
	{{csrf_field()}}
  @include('messages.formfields')
 <div class="form-group"> 

<input type="submit" value="Submit" class="btn btn-primary">
<a href="/messages" class="btn btn-secondary" role="button">Back</a>
</div>
  
 
  
</form>
</div>
@endsection
	