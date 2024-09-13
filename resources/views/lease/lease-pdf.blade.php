@extends('layouts.master')
@section('page-title')
    {{ __('Manage Lease') }}
@endsection
@section('extracss')
<style>
      #pdf-viewer {
          width: 100%;
          height: 100vh;
          border: none;
      }
       .containernew {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .floor {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        border: 1px solid #b2aaaa;
        padding: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .unit {
        width: 50px;
        background-color: #f9f9f9;
        border: 1px solid #333;
        padding: 0px;
        aspect-ratio: 1 / 1; /* Keeps the box square */
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
  </style>
  @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Leases')}}</li>
@endsection
@section('content')

<!-- Users List Table -->
<div class="card">
  <div class="card-header border-bottom">
   
    </div>
 <div class="row">
  <div class="col-sm-6">
      <iframe id="pdf-viewer" src="{{ $fullPath  }}" frameborder="0"></iframe>
  </div>
  <div class="col-sm-6">
   <div class="card-body containernew">
          @foreach($propertyUnit as $floor)
          @php $allUnits = \App\Models\PropertyUnit::where('property_id',$floor->property_id)->where('unit_name_prefix',$floor->unit_name_prefix)->orderby('id','ASC')->get();     @endphp
            <div class="floor">
                <h6 style="grid-column: span 6;"><span class="badge bg-label-primary">Floor {{ $floor->unit_floor }} ({{ $floor->unit_name_prefix }})</span></h6>
                @foreach($allUnits as $unit)
                @php  
                  $is_rented =  ($unit->is_rented =='1') ? 'red' :'' ;
                  $is_rented_color =  ($unit->is_rented =='1') ? '#fff' :'' ;

                  $is_color = (in_array($unit->id,$unit_ids)) ? 'green' :$is_rented; 
                  $lease = \App\Models\Lease::WhereRaw("FIND_IN_SET(?, unit_ids) > 0", [$unit->id])->with('tenant')->first();

                $tenantId = $lease ? @$lease->tenant->id : ''; 
                @endphp
                    @if(!empty($tenantId))
                    <a href="{{ route('tenants.show', $tenantId) }}" target="_blank"><div class="unit" style="background:{{ $is_rented }};color:{{ $is_rented_color  }}">
                        {{ $unit->unit_name }} 
                         
                    </div></a>
                    @else
                    <div class="unit" style="background:{{ $is_rented }};color:{{ $is_rented_color  }}">
                        {{ $unit->unit_name }} 
                         
                    </div>
                    @endif
                @endforeach
            </div>
        @endforeach
        </div>
  </div>
   
 </div>
  
</div>
@endsection
