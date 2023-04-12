@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Book',
    'activePage' => 'books',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header panel-header-sm">
   
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
            <div class="card p-2">

                <div class="card-body">
                    <button onclick="window.location.href='{{route('books')}}' " class="btn btn-link btn-sm text-primary">Back</button>
                 <h4>Manage Book Background</h4>
                 <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Batch</th>
                        <th scope="col">Background-Image</th>
                        <th scope="col">Action</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($batch as $item)
                        <tr>
                       
                            <td>{{$item->Name}}</td>
                            <td>
                                @if($item->bg == null)
                                <img src="https://img.freepik.com/free-vector/graduation-greeting-card_53876-89341.jpg?w=740&t=st=1670294908~exp=1670295508~hmac=6c5367105b93ffc370a6892b37d896d56e197c259ca13639505361ca43d33aaa" width="200px" height="200px" alt="">
                                <br>
                                <span style="color:grey">Default</span>
                                @else 
                                <img src="{{asset('public/photos').'/'.$item->bg}}" width="200px" height="200px" alt="">
                                @endif
                               
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#change{{$item->id}}" class="btn btn-dark btn-sm">Change <i class="fas fa-sync"></i></button>

     
  
  <div class="modal fade" id="change{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change BG</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('savebookbg')}}" method="post" enctype="multipart/form-data" >
            @csrf
        <div class="modal-body">
            <input type="file" accept="image/*" required name="bgimage" class="form-control">
            <input type="hidden" name="batchid" value="{{$item->id}}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" style="margin-left:4px " class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>

 
                            </td>
                          </tr>
                            
                        @endforeach
                     
                   
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
      </div>



@endsection