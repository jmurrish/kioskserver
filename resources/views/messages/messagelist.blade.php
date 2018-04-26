@extends('layouts.main')

@section('content')
	<a href="/messages/create" class="btn btn-primary pull-right">New Message</a>

<form method="get" action="/messages/" onChange="document.statusform.submit()" name="statusform" id="statusform">
	<select name="status">
		<option <?php if ($status=="") print "selected";?> value="">All</option>
		<option <?php if ($status=="1") print "selected";?> value="1">Active</option>
		<option <?php if ($status=="0") print "selected";?> value="0">Inactive</option>
	</select>
</form>
	
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
			<td>
				<form method="post" action="/messages/togglestatus/{{$message->id}}" name="toggle-{{$message->id}}-frm" id="toggle-{{$message->id}}-frm">
					{{ csrf_field() }}
			<select name="toggle-{{$message->id}}" id="toggle-{{$message->id}}" class="togglestatus">
				<option value="0" <?php if ($message->status == 0) print "selected";?>>Inactive</option>
				<option value="1" <?php if ($message->status == 1) print "selected";?>>Active</option>
			</select>
			</form>
			
			</td>
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
	
	$('.togglestatus').on('change', function(){
		$(this.form).submit();
	});
</script>
@endsection