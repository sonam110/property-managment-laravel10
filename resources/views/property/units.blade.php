@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<style>
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
@section('page-title')
    {{ __('Property Manage') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('property.index')}}">{{__('Property Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Property')}}</li>
    
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="#" data-url="{{ route('expense.create') }}" data-ajax-popup="true" data-title="{{__('Add Expense')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Add Expense')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-plus"></i>
          </a>
           <a href="{{ url()->previous() }}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
@endsection
@section('content')

 <div class="row">
 <div class="col-lg-12 col-md-12 col-12">
    <div class="tab-content py-0">
      <div class="tab-pane fade show active" id="payment" role="tabpanel">
        <div class="d-flex mb-3 gap-3">
          <div>
            <span class="badge bg-label-primary rounded-2 p-2">
              <i class="ti ti-home ti-lg"></i>
            </span>
          </div>
          <div>
            <h4 class="mb-0">
              <span class="align-middle">{{ $property->property_name }}</span>
            </h4>
            <small>{{ $property->property_code }}</small>
          </div>
        </div>
        <div id="accordionPayment" class="accordion">
           <div class="card accordion-item active">
            <h2 class="accordion-header">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                aria-expanded="true"
                data-bs-target="#accordionPayment-0"
                aria-controls="accordionPayment-0">
               Property Detail
              </button>
            </h2>

            <div id="accordionPayment-0" class="accordion-collapse collapse show">
              <div class="accordion-body">
                 <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ $property->units_count }}</h5>
                                <p class="mb-0">Total Units</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ $totalFree }}</h5>
                                <p class="mb-0">Free</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ $totalOccupied }}</h5>
                                <p class="mb-0">Occupied</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </div>
                           <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ $property->lease_count }}</h5>
                                <p class="mb-0">Total Lease</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="menu-icon tf-icons ti ti-server"></i></span>
                              </span>
                            </div>
                          </div>
                        
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                           <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start">
                              <div>
                                <h5 class="mb-1">{{ $property->invoice_count }}</h5>
                                <p class="mb-0">Total Invoice</p>
                              </div>
                              <span class="avatar">
                                <span class="avatar-initial bg-label-danger rounded"
                                  ><i class="menu-icon tf-icons ti ti-file-invoice"></i></span>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalInVoiceAmount']) }}</h5>
                                <p class="mb-0">Total Rent</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalPaid']) }}</h5>
                                <p class="mb-0">Rent Paid</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUnPaid']) }}</h5>
                                <p class="mb-0">Rent Unpaid</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalCamInVoiceAmount']) }}</h5>
                                <p class="mb-0">Total CAM</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalCamPaid']) }}</h5>
                                <p class="mb-0">CAM Paid</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalCamUnPaid']) }}</h5>
                                <p class="mb-0">CAM Unpaid</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </div>
                           <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['camExpense']) }}</h5>
                                <p class="mb-0">CAM Expense</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                   <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityInVoiceAmount']) }}</h5>
                                <p class="mb-0">Total Utility</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityPaid']) }}</h5>
                                <p class="mb-0">Utility Paid</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityUnPaid']) }}</h5>
                                <p class="mb-0">Utility Unpaid</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['utilityExpense']) }}</h5>
                                <p class="mb-0">Utility Expense</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                             
            
              </div>
            </div>
          </div>
          <div class="card accordion-item active">
            <h2 class="accordion-header">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                aria-expanded="true"
                data-bs-target="#accordionPayment-1"
                aria-controls="accordionPayment-1">
               Property Units
              </button>
            </h2>

            <div id="accordionPayment-1" class="accordion-collapse collapse show">
              <div class="accordion-body">
          
              @foreach($propertyUnit as $floor)
              @php $allUnits = \App\Models\PropertyUnit::where('property_id',$floor->property_id)->where('unit_name_prefix',$floor->unit_name_prefix)->orderby('id','ASC')->get();     
              @endphp
                <div class="floor">
                    <h6 style="grid-column: span 12;"><span class="badge bg-label-primary">Floor {{ $floor->unit_floor }} ({{ $floor->unit_name_prefix }})</span></h6>
                    @foreach($allUnits as $unit)
                    @php  
                       
                        $is_color =  ($unit->is_rented =='1') ? 'red' :'' ;
                        $is_rented_color =  ($unit->is_rented =='1') ? '#fff !important' :'#767283' ;

                        $lease = \App\Models\Lease::WhereRaw("FIND_IN_SET(?, unit_ids) > 0", [$unit->id])->with('tenant')->first();

                        $tenantId = $lease ? @$lease->tenant->id : ''; 
                        $is_color =  ($lease) ? 'red' :'' ;
                        
                       

                       


                    @endphp
                  
                        @if(!empty($tenantId))
                        @php
                          $tenant = @$lease->tenant ;
                        @endphp
                        <a href="{{ route('tenants.show', $tenantId) }}" target="_blank" data-bs-toggle="tooltip"  data-bs-html="true" data-size="lg" title="<strong>{{ $tenant->full_name }}</strong><br>Email: {{ $tenant->email }}<br>Phone: {{ $tenant->phone }}<br>Total Area: {{ $unit->total_square }} <br>Rent Price:{{ formatIndianCurrency($unit->price) }} <br>Total Rent: {{ formatIndianCurrency($unit->total_rent) }} <br>CAM Total Area: {{ $unit->cam_square }} <br>CAM Price:{{ formatIndianCurrency($unit->cam_price) }} <br>Total CAM:{{ formatIndianCurrency($unit->total_cam) }}">
                        <div class="unit btn" style="background:{{ $is_color }};color:{{ $is_rented_color }}"> 
                        
                            {{ $unit->unit_name }} 
                             
                       
                      </div>
                       </a>
                        @else
                        <div class="unit btn-outline-primary" >
                            {{ $unit->unit_name }} 
                             
                        </div>

                        @endif
                    @endforeach
                </div>
            @endforeach
            
              </div>
            </div>
          </div>

          <div class="card accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordionPayment-2"
                aria-controls="accordionPayment-2">
               Tenants List
              </button>

            </h2>
            <div id="accordionPayment-2" class="accordion-collapse collapse">

              <div class="accordion-body">
                
                <div class="table-responsive">
                  <div class="col action-btn-col">
                      <div class="float-end">
                        <a href="{{ route('tenants.create') }}{{ isset($property) ? '?property_id=' . $property->id : '' }}" data-title="{{__('Add New Tenant')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Add New Tenant')}}"  class="btn btn-sm btn-primary">
                          <i class="ti ti-plus"></i>Add New Tenant
                        </a>
                    </div>
                  </div>

                  <table class="table table-striped border-top">
                    <thead>
                      <tr>
                        <th class="text-nowrap">Full Name</th>
                        <th class="text-nowrap text-center">Firm Name</th>
                        <th class="text-nowrap text-center">Email</th>
                        <th class="text-nowrap text-center">Phone</th>
                        <th class="text-nowrap text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($allTenants as $key=>  $info)
                      <tr>
                        <td class="text-nowrap">{{ $info->full_name }}</td>
                        <td>
                          {{ $info->firm_name }}
                        </td>
                        <td>
                          {{ $info->email }}
                        </td>
                        <td>
                         {{ $info->phone }}
                        </td>
                        
                         <td>
                          <div class="btn-group btn-group-xs"><a class="btn btn-sm btn-info" href="{{ route('tenants.show', $info->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"  title="View"><i class="fa fa-eye"></i></a></div>
                         </td>
                      </tr>
                      @endforeach
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="card accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordionPayment-3"
                aria-controls="accordionPayment-3">
               Leases List
              </button>
            </h2>
            <div id="accordionPayment-3" class="accordion-collapse collapse">
              <div class="accordion-body">
                <table class="datatables-users table">
                <thead class="border-top">
                  <tr>
                    <th></th>
                    <th>Lease Number</th>
                    <th>Property Code</th>
                    <th>Tenant Info</th>
                    <th>Start date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
              </table>
              </div>
            </div>
          </div>

          <div class="card accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordionPayment-4"
                aria-controls="accordionPayment-4">
               Invoice List
              </button>
            </h2>
            <div id="accordionPayment-4" class="accordion-collapse collapse">
              <div class="accordion-body">
               <div class="table-responsive">
                <table class="invoice-list-table table border-top">
                  <thead>
                    <tr>
                      <th></th>
                      <th>#Invoice No</th>
                      <th>Type</th>
                      <th>Lease</th>
                      <th>Partner</th>
                      <th>Tenant</th>
                      <th>Total</th>
                      <th>Total Paid</th>
                      <th>Total UnPaid</th>
                      <th class="text-truncate">Issued Date</th>
                      <th>Invoice Status</th>
                      <th>Payment Status</th>
                      <th class="cell-fit">Actions</th>
                    </tr>
                  </thead>
                </table>
              </div>
              </div>
            </div>
          </div>

          <div class="card accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordionPayment-5"
                aria-controls="accordionPayment-5">
               Payment History
              </button>
            </h2>
            <div id="accordionPayment-5" class="accordion-collapse collapse">
              <div class="accordion-body">
               <div class="table-responsive">
                    <table class="datatables-payment table">
                      <thead class="border-top">
                        <tr>
                          <th></th>
                          <th>Lease Number</th>
                          <th>Invoice No</th>
                          <th>Total Amount</th>
                          <th>Paid Amount</th>
                          <th>Remaining Amount</th>
                          <th>Payment Date</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
              </div>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordionPayment-6"
                aria-controls="accordionPayment-6">
               Expenses 
              </button>
            </h2>
            <div id="accordionPayment-6" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class=" table-responsive">
                    <table class="datatables-expense table">
                      <thead class="border-top">
                        <tr>
                          <th></th>
                          <th>Property</th>
                          <th>Type</th>
                          <th>Price</th>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Note</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
              </div>
            </div>
          </div>

        </div>
      </div>
     
    </div>
  </div>

</div>
@endsection
@section('extrajs')  
<script type="text/javascript">
  $(document).ready( function () {
    var userCreateUrl = '{{ route('leases.create') }}';
    var table = $('.datatables-users').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('api.leases-list') }}',
           'type' : 'POST',
            "data": function(d) {
            d.property_id   = '{{ $property->id }}';
           
            },
           'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    "order": [["1", "desc" ]],
    "columns": [
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex' , orderable: false, searchable: false },
            { "data": "unique_id"},
            { "data": "property_id"},
            { "data": "tenant_id"},
            { "data": "start_date"},
            { "data": "status"},
            { "data": "action"},
        ],
        order: [[1, 'desc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3',
          text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                //customize print view for dark
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        },
        {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New Lease</span>',
                className: 'add-new btn btn-primary',
                action: function (e, dt, node, config) {
                   var propertyId = '{{ $property->id }}';
                    var url = '{{ route('leases.create') }}?property_id=' + propertyId;   // URL to load modal content

                    // Fetch the content and show in the modal
                    $.get(url, function (data) {
                       window.location = url ;
                    });
                }
            }
      ],
        preDrawCallback: function(settings) {
            if ($.fn.DataTable.isDataTable('.datatables-users')) {
                var dt = $('.datatables-users').DataTable();
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        }
  });


/*-------------------Invoice--------------------*/
  var tableInvoice = $('.invoice-list-table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('invoice-list') }}',
           'type' : 'POST',
            "data": function(d) {
                d.property_id   = '{{ $property->id }}';
            },
           'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    "order": [["1", "desc" ]],
    "columns": [
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex' , orderable: false, searchable: false },
            { "data": "invoice_no"},
            { "data": "invoice_type"},
            { "data": "lease_id", "name":'lease.unique_id'},
            { "data": "partner_id", "name":'partner.first_name'},
            { "data": "tenant_id", "name":'tenant.firm_name'},
            { "data": "grand_total"},
            { "data": "total_paid"},
            { "data": "total_unpaid"},
            { "data": "invoice_date"},
            { "data": "status"},
            { "data": "payment_status"},
            { "data": "action"},
        ],
        order: [[1, 'desc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3',
          text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7,8,9,10],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                //customize print view for dark
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7,8,9,10],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7,8,9,10],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7,8,9,10],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7,8,9,10],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        }
        
      ],
        preDrawCallback: function(settings) {
            if ($.fn.DataTable.isDataTable('.invoice-list-table')) {
                var dt = $('.invoice-list-table').DataTable();
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        }
  });
/*--------------Payment----------------------------------------*/
  var tablePayment = $('.datatables-payment').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('payment-history-list') }}',
           'type' : 'POST',
            "data": function(d) {
              d.property_id   = '{{ $property->id }}';
            },
           'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    "order": [["1", "desc" ]],
    "columns": [
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex' , orderable: false, searchable: false },
            { "data": "lease_id"},
            { "data": "invoice_id"},
            { "data": "total_amount"},
            { "data": "amount"},
            { "data": "remaining_amount"},
            { "data": "payment_date"},
            { "data": "status"},
            { "data": "action"},
        ],
        order: [[1, 'desc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3',
          text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                //customize print view for dark
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        }
       
      ],
        preDrawCallback: function(settings) {
            if ($.fn.DataTable.isDataTable('.datatables-payment')) {
                var dt = $('.datatables-payment').DataTable();
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        }
  });

/*-----------Expense---------------------------------------------*/
    var tableExpense = $('.datatables-expense').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('api.expense-list') }}',
           'type' : 'POST',
            "data": function(d) {
            d.property_id   = '{{ $property->id }}';
            },
           'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    "order": [["1", "desc" ]],
    "columns": [
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex' , orderable: false, searchable: false },
            { "data": "property_id"},
            { "data": "type"},
            { "data": "price"},
            { "data": "ex_date"},
            { "data": "description"},
            { "data": "note"},
            { "data": "action"},
        ],
        order: [[1, 'desc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3',
          text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                //customize print view for dark
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5,6,7],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        },
        {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add Expense</span>',
                className: 'add-new btn btn-primary',
                action: function (e, dt, node, config) {
                    var propertyId = '{{ $property->id }}';
                    var url = '{{ route('expense.create') }}?property_id=' + propertyId;  // URL to load modal content

                    // Fetch the content and show in the modal
                    $.get(url, function (data) {
                        $('#commonModalOver .modal-body').html(data);
                        $('#commonModalOver').modal('show');
                    });
                }
            }
      ],
        preDrawCallback: function(settings) {
            if ($.fn.DataTable.isDataTable('.datatables-expense')) {
                var dt = $('.datatables-expense').DataTable();
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        }
  });

});
</script>
 @endsection