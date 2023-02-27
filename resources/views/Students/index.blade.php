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

    <div class="card">
        <div class="card-body">
          <button class="btn btn-primary btn-sm">Import File <i class="fas fa-save"></i></button>
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
 
@endsection