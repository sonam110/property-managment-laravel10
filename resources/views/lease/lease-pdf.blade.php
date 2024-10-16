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
    border-radius: 6px;
    font-size: 10px;
    width: 32px;
    background-color: #f9f9f9;
    border: 1px solid;
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
              <i class="fa fa-mail-reply"></i>
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
<div class="card">
  <div class="card-header border-bottom">
<h6>Next Invoice Generation Date: {{ $nextInvoiceDate->format('F j, Y') }}</h6>
     <h6>Next Invoice Date:  {{ $invoiceDate->format('F j, Y') }}</h4>
    </div>
 <div class="row">
  <div class="col-sm-6">
     <div class="card mb-4">
          <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#leaseDetail" aria-expanded="true" aria-controls="leaseDetail">
            <i class="ti ti-home"></i> Lease Details
        </button>
         <div class="collapse show" id="leaseDetail">
            <div class="card-body">
              
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2"><span class="fw-medium me-1">Start Date:</span> <span>{{ $lease->start_date }}</span></li>
                            <li class="mb-2"><span class="fw-medium me-1">End Month:</span> <span>{{ $lease->end_month }}</span></li>
                            <li class="mb-2"><span class="fw-medium me-1">Due On(Day of month):</span> <span>{{ $lease->due_one }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Total Area:</span> <span>{{ $lease->total_square }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Current Rate:</span> <span>Rs.  {{ $lease->price }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">CAM Rate:</span> <span>Rs .{{ $lease->camp_price }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Total Rent:</span> <span class="badge bg-label-success">{{ formatIndianCurrencyPdf($lease->total_square* $lease->price) }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Total CAM:</span> <span class="badge bg-label-success">{{ formatIndianCurrencyPdf($lease->total_square* $lease->camp_price) }}</span></li>

                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
          <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#rencaminfo" aria-expanded="true" aria-controls="leaseDetail">
            <i class="ti ti-home"></i> Rent/CAM Rate Info
        </button>
         <div class="collapse" id="rencaminfo">
            <div class="card-body">
                 <table class=" table border-top">
                      <thead>
                        <tr>
                          <th>Unit Name</th>
                          <th>Total Square</th>
                          <th>Rate</th>
                          <th>CAM</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($propertyUnitsInfo as $key=>  $unit)
                        <tr>
                          <td>{{ $unit->unit_name }}</td>
                           <td>{{ $unit->total_square }} </td>
                           <td>{{ $unit->price }}  </td>
                           <td>{{ $unit->cam_price }}  </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-4">
         <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#tenantDetail" aria-expanded="true" aria-controls="tenantDetail">
            <i class="ti ti-user"></i> Tenant Details 
        </button>
         <div class="collapse" id="tenantDetail">
            <div class="card-body">
               
                    <div class="info-container">
                        <ul class="list-unstyled">
                             <a href="{{ route('tenants.show',$lease->tenant->id)}}"><li class="mb-2"><span class="fw-medium me-1">Full Name:</span> <span>{{ $lease->tenant->full_name }}</span></li></a>
                            <li class="mb-2"><span class="fw-medium me-1">Firm Name:</span> <span>{{ $lease->tenant->firm_name }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Email:</span> <span>{{ $lease->tenant->email }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Phone No:</span> <span>{{ $lease->tenant->phone }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">GST No:</span> <span class="badge bg-label-success">{{ $lease->tenant->gst_no }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">PAN No:</span> <span class="badge bg-label-warning">{{ $lease->tenant->pan_no }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">City:</span> <span>{{ $lease->tenant->city }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Business name:</span> <span>{{ $lease->tenant->business_name }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Business industry:</span> <span>{{ $lease->tenant->business_industry }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Business Address:</span> <span>{{ $lease->tenant->business_address }}</span></li>
                            <li class="pt-1"><span class="fw-medium me-1">Business description:</span> <span>{{ $lease->tenant->business_description }}</span></li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
     
        <div class="card mb-4">
          <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#propertyDetail" aria-expanded="true" aria-controls="tenantDetails">
            <i class="ti ti-file"></i> Property Details
        </button>
         <div class="collapse" id="propertyDetail">
            <div class="card-body">
               
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-medium me-1">Property Name:</span>
                            <span>{{ $lease->property->property_name }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-medium me-1">Property Code:</span>
                            <span>{{ $lease->property->property_code }}</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-medium me-1">Address:</span>
                            <span>{{ $lease->property->property_address }}</span>
                        </li>
                    </ul>
                   
                </div>
            </div>
        </div>
        </div>

         <div class="card mb-4">
          <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#partnetShare" aria-expanded="true" aria-controls="partnetShare">
            <i class="ti ti-home"></i> Partner's Share
        </button>
         <div class="collapse" id="partnetShare">
            <div class="card-body">
              <div class="card-datatable table-responsive">
              <table class=" table border-top">
                <thead>
                  <tr>
                    <th>Partner Name</th>
                    <th>Term</th>
                    <th>Percentage</th>
                    <th>Total Square</th>
                    <th>Rate</th>
                    <th>Amount</th>
                   
                  </tr>
                </thead>
                <tbody>
                   @foreach($paymentSetting as $key=>  $payment)
                   @php
                   $ramount =  $lease->total_square*$lease->price;
                   if($payment->commission_type=='1')
                  {
                    $amount = $payment->commission_value;
                    $rate ='';
                    $persign = '';
                   
                  } else{
                    $amount = ($ramount * $payment->commission_value)/100;
                    $rate = $lease->price.'*'.$payment->commission_value;
                    $persign = '%';
                   
                  }
                @endphp
                  <tr>
                    <td>{{ @$payment->partner->first_name }} {{ @$payment->partner->last_name }}</td>
                     <td>{{ (@$payment->commission_type == '1' ) ?'Fixed Value' :'% of Total Rent' }} </td>
                     <td>{{ $payment->commission_value }} %  {{ (@$payment->is_gst == '1' ) ?'With GST' :'No' }} </td>
                     <td>{{ $lease->total_square }} </td>
                     <td>{{ $rate }} {{ $persign }} </td>
                     <td>{{ $amount}} </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

                </div>
            </div>
        </div>

     
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
                  $checkLease = \App\Models\Lease::whereRaw("FIND_IN_SET(?, unit_ids)", [$unit->id])->where('property_id',$unit->property_id)->where('id',$id)->first();

                  $is_rented =  (!empty($checkLease)) ? 'green' : $is_rented ;
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
   <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
        
          <!-- Project table -->
         
            <div class="card mb-4">
            <!-- Notifications -->
            <h5 class="card-header pb-1">Invoice History</h5>
            <div class="card-body">
            </div>
             <div class="card-datatable table-responsive">
              <table class="invoice-list-table table border-top">
                <thead>
                  <tr>
                    <th></th>
                    <th>#Invoice No</th>
                    <th>Type</th>
                    <th>Lease</th>
                    <th>Partner</th>
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
           
            <!-- /Notifications -->
          </div>
          <!-- /Project table -->
        </div>
      <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
        
          <!-- Project table -->
         
            <div class="card mb-4">
            <!-- Notifications -->
            <h5 class="card-header pb-1">Payment History</h5>
            <div class="card-body">
            </div>
             <div class="card-datatable table-responsive">
              <table class="datatables-users table border-top">
                <thead>
                 <tr>
                    <th></th>
                    <th>Lease Number</th>
                    <th>Invoice No</th>
                    <th>Total Amount</th>
                    <th>Paid Amountr</th>
                    <th>Remaining Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
              </table>
            </div>
           
            <!-- /Notifications -->
          </div>
          <!-- /Project table -->
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