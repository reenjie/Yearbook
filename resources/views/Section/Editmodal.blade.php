 <button class="btn btn-link text-success btn-sm" data-toggle="modal" data-target="#modal{{$item->id}}"><i class="fas fa-edit"></i></button>

<div class="modal fade" id="modal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel">Edit Section</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('editsection')}}" method="post">
          @csrf
        <div class="modal-body">
          <input type="text" value="{{$item->Name}}" name="name" required class="form-control mb-2" placeholder="Section">
            <input type="hidden" name="id" value="{{$item->id}}">
          <textarea name="description" placeholder="Description .." class="form-control"  id=""  rows="3">{{$item->Description}}</textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button style="margin-left:5px" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>