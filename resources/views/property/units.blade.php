@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<style>
    .containernew {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .floor {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 10px;
        border: 1px solid #b2aaaa;
        padding: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .unit {
        background-color: #f9f9f9;
        border: 1px solid #333;
        padding: 10px;
        aspect-ratio: 1 / 1; /* Keeps the box square */
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
</style>

@endsection
@section('page-title')
    {{ __('Property Manage') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('property.index')}}">{{__('Property Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Property')}}</li>
@endsection

@section('content')

 <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
          <!-- User Card -->
          <div class="card mb-4">
            <div class="card-body">
        
              <h5 class="mt-4 small text-uppercase text-muted">Details</h5>
              <div class="info-container">
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <span class="fw-medium me-1">Property Name:</span>
                    <span>{{ $property->property_name }}</span>
                  </li>
                  <li class="mb-2">
                    <span class="fw-medium me-1">Property Code:</span>
                    <span>{{ $property->property_code }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">Location:</span>
                        <span>{{ $property->location }}</span>

                  </li>
                  
                </ul>
                <div class="d-flex justify-content-center">
                  <a
                    href="{{ route('property.edit',$property->id) }}"
                    class="btn btn-primary me-3"
                    title="Edit"
                    >Edit</a
                  >
                  
                </div>
              </div>
            </div>
          </div>
          <!-- /User Card -->
         
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        
          <!-- Project table -->
          <div class="card mb-4">
            <!-- Notifications -->
            <h5 class="card-header pb-1">Partner's Share Information</h5>
            <div class="card-body">
            </div>
            <div class="table-responsive">
              <table class="table table-striped border-top">
                <thead>
                  <tr>
                    <th class="text-nowrap text-center">Partner Info</th>
                    <th class="text-nowrap text-center">Phone</th>
                    <th class="text-nowrap">Type</th>
                    <th class="text-nowrap text-center">Value</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($paymentSetting as $key=>  $payment)
                  <tr>
                    <td>
                      {{ $payment->partner->first_name }}  {{ $payment->partner->lastname }}<br>
                      <span class="badge bg-label-danger">{{ $payment->partner->email }}</span>
                    </td>
                    
                    <td>
                     {{ $payment->partner->mobile }}
                    </td>
                    <td>
                     @if($payment->commission_type=='1')
                      <span class="badge bg-label-success">Fixed Value</span>
                     @else
                     <span class="badge bg-label-warning">% of Total Rent</span>
                     @endif
                    </td>
                    <td>
                     {{ $payment->commission_value }}
                    </td>
                    
                  </tr>
                  @endforeach
                 
                </tbody>
              </table>
            </div>
           
            <!-- /Notifications -->
          </div>
          <!-- /Project table -->
        </div>
        <!--/ User Content -->
      </div>
 <div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
     <div class="card mb-4">
        <!-- Notifications -->
        <h5 class="card-header pb-1">Property Units</h5>
        <div class="card-body containernew">
          @foreach($propertyUnit as $floor)
          @php $allUnits = \App\Models\PropertyUnit::where('property_id',$floor->property_id)->where('unit_name_prefix',$floor->unit_name_prefix)->orderby('id','ASC')->get();     @endphp
            <div class="floor">
                <h2 style="grid-column: span 12;"><span class="badge bg-label-primary">Floor {{ $floor->unit_floor }} ({{ $floor->unit_name_prefix }})</span></h2>
                @foreach($allUnits as $unit)
                @php  
                  $is_rented =  ($unit->is_rented =='1') ? '#b68282' :'' ;
                  $is_rented_color =  ($unit->is_rented =='1') ? '#fff' :'' ;
                @endphp
                    <div class="unit" style="background:{{ $is_rented }};color:{{ $is_rented_color  }}">
                        {{ $unit->unit_name }} 
                         
                    </div>
                @endforeach
            </div>
        @endforeach
        </div>
      </div>
  </div>
 </div>
@endsection
@section('extrajs')  

 @endsection