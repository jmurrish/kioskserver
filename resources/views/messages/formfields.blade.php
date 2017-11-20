  <div class="form-group">
    <label for="name">Message Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{$message->name}}">
  </div>
 
  <div class="form-group">
    <label for="messagebody">Message Body</label>
    <textarea class="form-control" id="messagebody" rows="3" name="messagebody">{{$message->messagebody}}</textarea>
  </div>
  
  <div class="form-group">
      <label for="status">Message Status</label>
      <select class="form-control" id="status" name="status">
      	<option value="1" {{$message->status==1?"selected":""}}>Active</option>
		<option value="0" {{$message->status!=1?"selected":""}}>Inactive</option>
      </select>
    </div>
  
  <div class="form-group">
    <label for="uploadphoto">Message Image</label>
    <input type="file" class="form-control" id="uploadphoto" name="uploadphoto" >
    @if ($message->assetpath != "")
    <a href="{{asset('storage/'.$message->assetpath)}}" target="_blank">View</a>
    @endif
  </div>
  
  