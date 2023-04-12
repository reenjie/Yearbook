@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Students',
    'activePage' => 'students',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header panel-header-sm">
  
  </div>
  <div class="content">
    <div class="row">
      @php
           $excel = DB::select("SELECT * FROM `excels` where typeof ='listfile'");
           $batcheswexcel = DB::select("SELECT * FROM `batches` where id in (select batch from excels where typeof='listfile')");
      @endphp
    <div class="card">
        <div class="card-body">
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ExcelFiles">Import File <i class="fas fa-save"></i></button>
          
          <div class="modal fade" id="ExcelFiles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">LIST OF STUDENTS ( <span style="font-size: 10px;">CSV File</span>)</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <h6 class="text-danger">Please be aware that importing a CSV file will overwrite all data currently stored for the corresponding batch and section.</h6>
                  <table class="table">
                    <thead>
                      <tr>

                        <th scope="col">File</th>
                        <th scope="col">Action</th>

                      </tr>
                    </thead>
                    <tbody>
                      @foreach($batcheswexcel as $row)
                      <tr class="table-danger">
                        <th colspan="3" style="text-align:center">Batch {{$row->Year}} - {{$row->Year + 1}}</th>
                      </tr>
                     
                        @foreach($excel as $ex)
                        <tr>
                        @if($ex->batch == $row->id)
                        <td class="text-primary">
                          {{$ex->file}}
                        </td>
                        <td>
                        <form action="{{route('importcsv')}}" method="post" enctype="multipart/form-data">
                          @csrf

                          <input type="hidden" value="{{$ex->file}}" name="csvfile">
                          <input type="hidden" name="batch" value="{{$ex->batch}}">
                          @if(Auth::user()->Role != 1)
                          <select name="section" id="" required class="form-control mb-2">
                            @php
                                $section = DB::select('select * from sections');
                            @endphp
                            <option value="">Select Section *</option>
                            @foreach ($section as $item)
                            <option value="{{$item->id}}">{{$item->Name}}</option>
                                
                            @endforeach
                          </select>
                          @else 
                           <input type="hidden" name="section" value="{{Auth::user()->SectionID}}">
                          
                          @endif
                        
                          <button type="submit" class="btn btn-sm btn-primary download" data-file="{{$ex->file}}"  data-batch="{{$ex->batch}}"  data-toggle="modal">Use</button>

                     
                        </form>
                          
                        
                        </td>
                        @endif
                      </tr>
                        @endforeach

                      




                      @endforeach
                    </tbody>
                  </table>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

              </div>
            </div>
          </div>
          @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{session()->get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          @endif
          @if(session()->has('error'))
          <div class="alert alert-danger alert-dismissible fade show">
            {{session()->get('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          <div class="table-responsive">
            <table class="table" style="color:gray">
              <thead class=" text-primary">
                <th>
                  Name
                </th>
                <th>
                 Sex
                </th>
                <th>
               Batch & Section
                </th>
                <th>
                 Registered Date
                 </th>
                <th class="text-center">
               Downloads
                </th>
                <th class="text-center">
                Got Diploma
                   </th>
           
              </thead>
              <tbody>
                @foreach ($data as $item)
                <tr>
                  <td class="text-center" style="font-weight: bold;text-transform:uppercase">
                {{ $item->Firstname.' '.$item->Middlename.' '.$item->Lastname}}
                  </td>
                  <td class="text-center">
                 {{$item->Sex}}
                  </td>
                  <td  class="text-center">
                    <span style="font-size:11px">
                      BATCH :
                      <span style="font-size:14px">
                        @foreach ($batch as $b)
                        @if($b->id == $item->BatchID)
                    <span style="color:rgb(86, 145, 194)"> {{$b->Name}}</span>
                       @endif
                    @endforeach
                      </span>
                      </span>
                      <br>
                    <span style="font-size:11px">
                    SECTION :
                    <span style="font-size:14px">
                      @foreach ($section as $sec)
                      @if($sec->id == $item->SectionID)
                  <span style="color:rgb(86, 145, 194)"> {{$sec->Name}}</span>
                     @endif
                  @endforeach
                    </span>
                    </span>
                   
                
                  </td>
                  <td class="text-center">
                    {{date('@h:m a Fj,Y',strtotime($item->created_at))}}
                  </td>
                  <td class="text-center">
                    {{3 - $item->download}}
                  </td>
                  <td>
                    @if($item->diploma == 0)
                   <button onclick="window.location.href='{{route('confirmStudent',['id'=>$item->id])}}' " class="btn btn-primary btn-sm">Confirm <i class="fas fa-check-circle"></i></button>
                    @else 
                   <span class="badge bg-success text-light" style="font-size:16px">Yes</span>
                    @endif
                  </td>
                </tr>
                @endforeach
             
            
              </tbody>
            </table>
          </div>
        </div>
    </div>
    </div>
  </div>

  <script>
    $('.download').click(function(){
      var file = $(this).data('file');
      var batch = $(this).data('batch');
    
    })
  </script>
 
@endsection