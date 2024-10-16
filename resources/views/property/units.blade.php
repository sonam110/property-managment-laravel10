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
              <i class="fa fa-mail-reply"></i>
          </a>
       
    </div>
@endsection
@section('content')
<div class="row">
 <div class="col-sm-3">
    <div class="card mb-4">
        <h5 class="mt-4 small text-uppercase text-muted">
            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#propertyDetail" aria-expanded="false" aria-controls="propertyDetail">
                <i class="ti ti-file"></i> Property Detail
            </button>
        </h5>
        <div class="collapse show" id="propertyDetail">
            <div class="card-body">
               
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
                            <span class="fw-medium me-1">Address:</span>
                            <span>{{ $property->property_address }}</span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('property.edit', $property->id) }}" class="btn btn-primary me-3" title="Edit">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <div class="col-sm-9">
    <div class="card mb-4">
       <h5 class="mt-4 small text-uppercase text-muted">
            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#propertyUnits" aria-expanded="false" aria-controls="propertyDetail">
                <i class="ti ti-home"></i> Property Units
            </button>
        </h5>
        <!-- Notifications -->
          <div class="collapse show" id="propertyUnits">
            <h5 class="card-header pb-1">Property Units</h5>
            <div class="card-body containernew">
              @foreach($propertyUnit as $floor)
              @php $allUnits = \App\Models\PropertyUnit::where('property_id',$floor->property_id)->where('unit_name_prefix',$floor->unit_name_prefix)->orderby('id','ASC')->get();     

              
              @endphp
                <div class="floor">
                    <h6 style="grid-column: span 9;"><span class="badge bg-label-primary">Floor {{ $floor->unit_floor }} ({{ $floor->unit_name_prefix }})</span></h6>
                    @foreach($allUnits as $unit)
                    @php  
                       
                        $is_rented =  ($unit->is_rented =='1') ? 'red' :'' ;
                        $is_rented_color =  ($unit->is_rented =='1') ? '#fff' :'' ;
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
</div>
  <div class="row">
  `
    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">Total Units</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ $property->units_count }}</h3>
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
     <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">Total Free</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ $totalFree }} </h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
     <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">Total Occupied</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ $totalOccupied }}</h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">Rent Total</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ formatIndianCurrency($countData['totalRent']) }}</h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">CAM Total</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ formatIndianCurrency($countData['totalCam']) }}</h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">Utilities Total</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ formatIndianCurrency($countData['totalUtility']) }}</h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
     <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">CAM Expense</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ formatIndianCurrency($countData['camExpense']) }}</h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
     <div class="col-xl-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
               <h5 class="mb-1 text-nowrap">Utilities Expense</h5>
              </div>
              <div class="chart-statistics">
               <h3 class="card-title mb-1">{{ formatIndianCurrency($countData['utilityExpense']) }}</h3>
               
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
   
  </div>

   <div class="row">
     <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
        
          <!-- Project table -->
          <div class="card mb-4">
             <h5 class="mt-4 small text-uppercase text-muted">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#tenantInfo" aria-expanded="false" aria-controls="propertyDetail">
                    <i class="ti ti-users"></i> Tenants Information
                </button>
            </h5>
            <!-- Notifications -->
             <div class="collapse show" id="tenantInfo">
            <h5 class="card-header pb-1">Tenants Information</h5>
             <div class="col action-btn-col">
                <div class="float-end">
                  <a href="{{ route('tenants.create') }}" data-title="{{__('Add New Tenant')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Add New Tenant')}}"  class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i>Add New Tenant
                  </a>
              </div>
            </div>
            <div class="card-body">
           
            </div>
            <div class="table-responsive">
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
            <!-- /Notifications -->
          </div>
          <!-- /Project table -->
        </div>
   </div>

    <div class="row">
     <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
        
          <!-- Project table -->
          <div class="card mb-4">
             <h5 class="mt-4 small text-uppercase text-muted">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#leaseInfo" aria-expanded="false" aria-controls="propertyDetail">
                    <i class="ti ti-users"></i> Lease Information
                </button>
            </h5>
            <!-- Notifications -->
           <div class="collapse show" id="leaseInfo">
            <h5 class="card-header pb-1">Lease Information</h5>
            <div class="card-body">
            </div>
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
            <!-- /Notifications -->
          </div>
          <!-- /Project table -->
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
                    var url = '{{ route('leases.create') }}'; // URL to load modal content

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

});
</script>
 @endsection