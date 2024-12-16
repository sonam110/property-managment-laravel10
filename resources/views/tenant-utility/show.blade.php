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
        grid-template-columns: repeat(12, 1fr);
        /* gap: 10px;
       border: 1px solid #b2aaaa;
        padding: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);*/
    }
    .unit {
    border-radius: 6px;
    font-size: 10px;
    padding: 0px;
    aspect-ratio: 1 / 1;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
  </style>
  @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('tenant-utility.index')}}">{{__('Utility Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Utility')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="{{ url()->previous() }}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
@endsection
@section('content')

<!-- Users List Table -->
<div class="row">
 <div class="col-lg-12 col-md-12 col-12">
   <div class="card">
      <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
     <h6>Bill Date: {{ date('F j, Y',strtotime($data->bill_date)) }}</h6>
      <h6>Property: {{ $data->property->property_name }}</h6>
   
      
    </div>
  </div>
</div>
</div>
<div class="row">
 <div class="col-lg-12 col-md-12 col-12">
   <div class="card">
      <div class="table-responsive">
        <table class="table table-bordered" style="width: 100%;">
                <tr>
                    <th>S.NO </th>
                    <th> Detail </th>
                    <th>Amount(Rs)</th>
                    
                </tr>
              
              
                  <tr class="rent">
                  
                    <td class="">1</td>
                    <td class="">Energy Charges</td>
                   
                    <td class="">{{ $data->energy_charge }}</td>
                    
                   
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">2</td>
                    <td class="">FPPAS</td>
                   
                    <td class="">{{ $data->fppas }}</td>
                    
                   
                   
                  </tr>
                  <tr class="rent">
                  
                    <td class="">3</td>
                    <td class="">Energy Duty</td>
                   
                    <td class="">{{ $data->energy_duty }}</td>
                    
                   
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">4</td>
                    <td class="">PF Incentive</td>
                   
                    <td class="">{{ $data->pf_incentive }}</td>
                    
                   
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">5</td>
                    <td class="">TOD(Net Sum)</td>
                   
                    <td class="">{{ $data->tod_net_sum }}</td>
                    
                   
                   
                  </tr>
                  </tr>
                   <tr class="rent">
                  
                    <td class="">6</td>
                    <td class="">Energy Charge As PER BILL</td>
                   
                    <td class="">{{ $data->energy_charge_as_per_bill }}</td>
                    
                   
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">7</td>
                    <td class="">Total Unit</td>
                    
                    <td class=""> {{ $data->total_units }}</td>
                   
                  </tr>
                    
                    <tr class="rent">
                  
                    <td class="">8</td>
                    <td class="">Total Tenant Units</td>
                    
                    <td class=""> {{ $data->total_tenant_units }}</td>
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">9</td>
                    <td class="">Per Unit Charge</td>
                    <td class=""> {{ $data->per_unit_charge }}</td>
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">10</td>
                    <td class="">Unit Lost</td>
                    
                    <td class=""> {{ $data->unit_lost }}</td>
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">11</td>
                    <td class="">Energy Losses</td>
                    
                    <td class=""> {{ $data->energy_losses }}</td>
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">12</td>
                    <td class="">Energy Losses Per Tenant</td>
                    
                    <td class=""> {{ $data->energy_losses_per_tenant_unit }}</td>
                   
                  </tr>
                   <tr class="rent">
                  
                    <td class="">13</td>
                    <td class="">Energy Per Unit Charge</td>
                    
                    <td class=""> {{ $data->energy_unit_per_unit }}</td>
                   
                  </tr>

                  
        </table>
        <hr>
        <div class="table-responsive">
           <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tenant</th>
                  <th>No of units Consumed</th>
                </tr>
              </thead>
              <tbody>
                @foreach($tenantDetails as $tenant)
                @php   $tenantinfo = App\Models\Tenant::where('id',$tenant['tenant_id'])->first();     @endphp
                <tr>
                  <td>{{ @$tenantinfo->firm_name }}</td>
                 <td>{{ $tenant['no_units_consume'] }}</td>
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
