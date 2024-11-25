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
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Leases')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="{{ url()->previous() }}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
@endsection
@section('content')
@php
    // Get the current date
    $currentDate = new DateTime();
    
    // Check if the current day is greater than 25
    if ($currentDate->format('d') > 25) {
        // If the current day is greater than 25, move to the next month and set the date to 25
        $nextInvoiceDate = (new DateTime('first day of next month'))->setDate($currentDate->format('Y'), $currentDate->format('m') + 1, 25);
    } else {
        // Otherwise, set the date to the 25th of the current month
        $nextInvoiceDate = (new DateTime())->setDate($currentDate->format('Y'), $currentDate->format('m'), 25);
    }
    if ($currentDate->format('d') > 30) {

        $invoiceDate = (new DateTime('first day of next month'))->setDate($currentDate->format('Y'), $currentDate->format('m') + 1, 25);
    } else {
     
        $invoiceDate = (new DateTime())->setDate($currentDate->format('Y'), $currentDate->format('m'), 30);
    }


@endphp
<!-- Users List Table -->
 <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
     <h6>Next Invoice Generation Date: {{ $nextInvoiceDate->format('F j, Y') }}</h6>
     <h6>Next Invoice Date:  {{ $invoiceDate->format('F j, Y') }}</h4>
      
    </div>

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
              <span class="align-middle">{{ $leaseInfo->unique_id }}</span>
            </h4>
           
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
                data-bs-target="#accordionPayment-1"
                aria-controls="accordionPayment-1">
               Lease Detail
              </button>
            </h2>

            <div id="accordionPayment-1" class="accordion-collapse collapse show">
              <div class="accordion-body containernew">
          
                <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th>Start Date</th>
                      <td>{{ date('M d ,Y',strtotime($leaseInfo->start_date)) }}</td>
                    </tr>
                    <tr>
                      <th>Expiry After Month</th>
                      <td>{{ $leaseInfo->end_month }} Month</td>
                    </tr>
                    <tr>
                      <th>Due On (Day of Month)</th>
                      <td>{{ $leaseInfo->due_on }}</td>
                    </tr>
                    <tr>
                      <th>Total Area</th>
                      <td>{{ $leaseInfo->total_square }}</td>
                    </tr>
                    <tr>
                      <th>Total Rent(Without GST)</th>
                      <td><span class="badge bg-label-success">{{ formatIndianCurrencyPdf($leaseInfo->total_rent) }}</span></td>
                    </tr>
                    <tr>
                      <th>Total CAM(Without GST)</th>
                      <td><span class="badge bg-label-success">{{ formatIndianCurrencyPdf($leaseInfo->total_cam) }}</span></td>
                    </tr>
                   
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
                data-bs-target="#accordionPayment-244"
                aria-controls="accordionPayment-244">
               Documents
              </button>

            </h2>
            <div id="accordionPayment-244" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class="table-responsive">
                 <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Document Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($leaseDocuments as $doc)
                      <tr>
                        <td>{{ $doc->file_name }}</td>
                        <td>
                          <a href="{{ url('/') }}/{{ $doc->document }}" class="btn btn-primary btn-sm" download>
                            <i class="ti ti-download"></i> Download
                          </a>
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
                data-bs-target="#accordionPayment-2"
                aria-controls="accordionPayment-2">
               Rent/CAM Rate Info
              </button>

            </h2>
            <div id="accordionPayment-2" class="accordion-collapse collapse">

              <div class="accordion-body">
                
                <div class="table-responsive">
                
                 <table class=" table border-top">
                      <thead>
                        <tr>
                          <th>Unit Name</th>
                          <th>Total Square</th>
                          <th>Rate</th>
                          <th>Rent Total</th>
                          <th>CAM Total Square</th>
                          <th>CAM Rate</th>
                          <th>CAM Total</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($propertyUnitsInfo as $key=>  $unit)
                        <tr>
                          <td>{{ $unit->unit_name }}</td>
                           <td>{{ $unit->total_square }} </td>
                           <td>{{ formatIndianCurrency($unit->price) }}  </td>
                           <td>{{ formatIndianCurrency($unit->total_rent) }}  </td>
                            <td>{{ $unit->cam_square }} </td>
                           <td>{{ formatIndianCurrency($unit->cam_price) }}  </td>
                           <td>{{ formatIndianCurrency($unit->total_cam) }}  </td>
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
                data-bs-target="#accordionPayment-22"
                aria-controls="accordionPayment-22">
               Rent Incremental Info
              </button>

            </h2>
            <div id="accordionPayment-22" class="accordion-collapse collapse">

              <div class="accordion-body">
                
                <div class="table-responsive">
                
                 <table class=" table border-top">
                      <thead>
                        <tr>
                          <th>From Month</th>
                          <th>To Month</th>
                          <th>Percentage</th>
                          <th>Increment Amount</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($rentCals as $key=>  $rent)
                        <tr>
                          <td>{{ $rent->from_month }}</td>
                           <td>{{ $rent->to_month }} </td>
                           <td>{{ $rent->inc_percentage }} % </td>
                           <td>{{ $rent->inc_amount }}  </td>
            
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
                data-bs-target="#accordionPayment-23"
                aria-controls="accordionPayment-23">
               CAM Incremental Info
              </button>

            </h2>
            <div id="accordionPayment-23" class="accordion-collapse collapse">

              <div class="accordion-body">
                
                <div class="table-responsive">
                
                 <table class=" table border-top">
                      <thead>
                        <tr>
                          <th>From Month</th>
                          <th>To Month</th>
                          <th>Percentage</th>
                          <th>Increment Amount</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($camCals as $key=>  $cam)
                        <tr>
                          <td>{{ $cam->from_month }}</td>
                           <td>{{ $cam->to_month }} </td>
                           <td>{{ $cam->inc_percentage }} % </td>
                           <td>{{ $cam->inc_amount }}  </td>
            
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
              Property Units
              </button>
            </h2>
            <div id="accordionPayment-3" class="accordion-collapse collapse">
              <div class="accordion-body containernew">
                @foreach($propertyUnit as $floor)
              @php $allUnits = \App\Models\PropertyUnit::where('property_id',$floor->property_id)->where('unit_name_prefix',$floor->unit_name_prefix)->orderby('id','ASC')->get();     
              @endphp
                <div class="floor">
                    <h6 style="grid-column: span 12;"><span class="badge bg-label-primary">Floor {{ $floor->unit_floor }} ({{ $floor->unit_name_prefix }})</span></h6>
                    @foreach($allUnits as $unit)
                     @php  
                      $is_color =  ($unit->is_rented =='1') ? 'red' :'' ;
                      $is_rented_color =  ($unit->is_rented =='1') ? '#fff !important' :'#767283' ;
                  
          
                      $leaseInfo = \App\Models\Lease::WhereRaw("FIND_IN_SET(?, unit_ids) > 0", [$unit->id])->with('tenant')->first();
                      $checkLease = \App\Models\Lease::whereRaw("FIND_IN_SET(?, unit_ids)", [$unit->id])->where('property_id',$unit->property_id)->where('id',$id)->first();

                      $is_color =  (!empty($checkLease)) ? 'green' : $is_color ;
                      $is_rented_color =  (!empty($checkLease)) ? '#fff' : $is_rented_color ;
                      $tenantId = $leaseInfo ? @$leaseInfo->tenant->id : ''; 
                    @endphp

                   
                        @if(!empty($tenantId))
                         @php
                          $tenant = @$leaseInfo->tenant ;
                        @endphp
                        <a href="{{ route('tenants.show', $tenantId) }}"  target="_blank" data-bs-toggle="tooltip"  data-bs-html="true" data-size="lg" title="<strong>{{ $tenant->full_name }}</strong><br>Email: {{ $tenant->email }}<br>Phone: {{ $tenant->phone }}<br>Total Area: {{ $unit->total_square }} <br>Rent Price:{{ formatIndianCurrency($unit->price) }} <br>Total Rent: {{ formatIndianCurrency($unit->total_rent) }} <br>CAM Total Area: {{ $unit->cam_square }} <br>CAM Price:{{ formatIndianCurrency($unit->cam_price) }} <br>Total CAM:{{ formatIndianCurrency($unit->total_cam) }}" >
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
                data-bs-target="#accordionPayment-4"
                aria-controls="accordionPayment-4">
               Tenants Detail 
              </button>
            </h2>
            <div id="accordionPayment-4" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class="info-container">
                      <ul class="list-unstyled">
                           <a href="{{ route('tenants.show', $tenant->id) }} "><li class="mb-2"><span class="fw-medium me-1">Full Name:</span> <span>{{ @$tenant->full_name }}</span></li></a>
                          <li class="mb-2"><span class="fw-medium me-1">Firm Name:</span> <span>{{ @$tenant->firm_name }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">Email:</span> <span>{{ @$tenant->email }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">Phone No:</span> <span>{{ @$tenant->phone }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">GST No:</span> <span class="badge bg-label-success">{{ @$tenant->gst_no }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">PAN No:</span> <span class="badge bg-label-warning">{{ @$tenant->pan_no }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">City:</span> <span>{{ @$tenant->city }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">Business name:</span> <span>{{ @$tenant->business_name }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">Business industry:</span> <span>{{ @$tenant->business_industry }}</span></li>
                          <li class="mb-2 pt-1"><span class="fw-medium me-1">Business Address:</span> <span>{{ @$tenant->business_address }}</span></li>
                          <li class="pt-1"><span class="fw-medium me-1">Business description:</span> <span>{{ @$tenant->business_description }}</span></li>
                      </ul>
                      
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
               Property Details
              </button>
            </h2>
            <div id="accordionPayment-5" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-medium me-1">Property Name:</span>
                            <span>{{ @$property->property_name }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-medium me-1">Property Code:</span>
                            <span>{{ @$property->property_code }}</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-medium me-1">Address:</span>
                            <span>{{ @$property->property_address }}</span>
                        </li>
                    </ul>
                   
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
               Partner's Share 
              </button>
            </h2>
            <div id="accordionPayment-6" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class=" table-responsive">
                  <table class=" table border-top">
                <thead>
                  <tr>
                    <th>Partner Name</th>
                    <th>Term</th>
                    <th>Percentage</th>
                    <th>Total Square</th>
                    <th>Total Rent</th>
                    <th>Total CAM</th>
                    <th>Rent Amount</th>
                    <th>Cam Amount</th>
                   
                  </tr>
                </thead>
                <tbody>

                   @foreach($paymentSetting as $key=>  $payment)
                   @php
                     $leaseInfo = \App\Models\Lease::where('id',$payment->lease_id)->first();
                 
                   $totalRent = @$leaseInfo->total_rent;
                   $totalCam =  @$leaseInfo->total_cam;
                   if($payment->commission_type=='1')
                  {
                    $amount = $payment->commission_value;
                    $camamount = $payment->commission_value;
                    $cam = $payment->commission_value;
                    $rate = @$leaseInfo->total_rent;
                    $cam = @$leaseInfo->total_cam;
                    $persign = '';
                   
                  } else{
                    $amount = ($totalRent * $payment->commission_value)/100;
                    $camamount = ($totalCam * $payment->commission_value)/100;
                    $rate = @$leaseInfo->total_rent.'*'.$payment->commission_value;
                    $cam = @$leaseInfo->total_cam.'*'.$payment->commission_value;
                    $persign = '%';
                   
                  }

                @endphp
                  <tr>
                    <td>{{ @$payment->partner->first_name }} {{ @$payment->partner->last_name }}</td>
                     <td>{{ (@$payment->commission_type == '1' ) ?'Fixed Value' :'% of Total Rent' }} </td>
                     <td>{{ $payment->commission_value }} %  {{ (@$payment->is_gst == '1' ) ?'With GST' :'No' }} </td>
                     <td>{{ @$leaseInfo->total_square }} </td>
                     <td>{{ $rate }} {{ $persign }} </td>
                     <td>{{ $cam }} {{ $persign }} </td>
                     <td>{{ formatIndianCurrency($amount) }} </td>
                     <td>{{ formatIndianCurrency($camamount) }} </td>
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
                data-bs-target="#accordionPayment-7"
                aria-controls="accordionPayment-7">
               Invoice List
              </button>
            </h2>
            <div id="accordionPayment-7" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class=" table-responsive">
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
                data-bs-target="#accordionPayment-8"
                aria-controls="accordionPayment-8">
                Payment History
              </button>
            </h2>
            <div id="accordionPayment-8" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class=" table-responsive">
                      <table class="datatables-users table">
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

        </div>
      </div>
     
    </div>
  </div>

</div>

  

@endsection
@section('extrajs')           
<script>
  $(document).ready( function () {
    var table = $('.invoice-list-table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('invoice-list') }}',
           'type' : 'POST',
            "data": function(d) {
            d.property_id   = $('#property_id').val();
            d.lease_id   = '{{ $id }}';
            d.status   = $('#status').val();
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
            { "data": "lease_id"},
            { "data": "partner_id"},
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
 });

   $(document).ready( function () {
    var tableNew = $('.datatables-users').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('payment-history-list') }}',
           'type' : 'POST',
            "data": function(d) {
             d.lease_id   = '{{ $id }}';
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
            if ($.fn.DataTable.isDataTable('.datatables-users')) {
                var dt = $('.datatables-users').DataTable();
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