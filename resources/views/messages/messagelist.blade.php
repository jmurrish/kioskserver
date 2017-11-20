@extends('layouts.main');

@section('content')
	<a href="/messages/create" class="btn btn-primary pull-right">New Message</a>
	
	<table class="table">
		<thead>
		<tr>
			
			<th>Message Name</th>
			<th>Message Text</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
		<tbody>
			@if (count($messages))
			
			@foreach($messages as $message)
		<tr>
			<td>{{$message->name}}</td>
			<td>{{$message->messagebody}}</td>
			<td>{{$message->status==1?'Active':'Inactive'}}</td>
			<td><a href="/messages/{{$message->id}}/edit" class="btn btn-primary">Edit</a></td>
		</tr>
			@endforeach
			@else
			<tr>
				<td colspan="4">No Messages Found</td>
				
			</tr>
			@endif
		
	</tbody>
	</table>
@endsection
	
@section('scripts')
<script>
	$('#newmsgbtn').on('click', function(){
		document.location.href="/app/create";
	});
</script>
@endsection