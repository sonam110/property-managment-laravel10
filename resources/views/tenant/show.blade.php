@extends('layouts.master')

@section('extracss')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<style>
    #tenantDetailsWrapper {
        transition: width 0.3s ease;
    }

    .collapse {
        width: 100%;
    }

    .collapse:not(.show) {
        display: none;
    }

    #tenantDetailsWrapper.collapsed {
        width: 0;
        overflow: hidden;
    }

    #mainContent {
        flex-grow: 1;
        transition: margin-left 0.3s ease;
    }

    #tenantDetailsWrapper.collapsed + #mainContent {
        margin-left: -20px; /* Adjust this value based on the width of your tenant details */
    }
</style>
@endsection

@section('page-title')
    {{ __('Manage Tenant') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('tenants.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Tenant')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('leases.create') }}" data-title="{{__('Leases')}}" title="{{__('Create Lease')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        <a href="{{ url()->previous() }}" data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-arrow-left"></i>
        </a>
       
    </div>
@endsection

@section('content')<div class="row">
 <div class="col-lg-12 col-md-12 col-12">
    <div class="tab-content py-0">
      <div class="tab-pane fade show active" id="payment" role="tabpanel">
        <div class="d-flex mb-3 gap-3">
          <div>
            <span class="badge bg-label-primary rounded-2 p-2">
              <i class="ti ti-user ti-lg"></i>
            </span>
          </div>
          <div>
            <h4 class="mb-0">
              <span class="align-middle">{{ $tenant->full_name }}</span>
            </h4>
          </div>
        </div>
        <div id="accordionPayment" class="accordion">
          <div class="card accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                aria-expanded="true"
                data-bs-target="#accordionPayment-1"
                aria-controls="accordionPayment-1">
               Tenant Info
              </button>
            </h2>

            <div id="accordionPayment-1" class="accordion-collapse collapse ">
              <div class="accordion-body containernew">
                <div class="info-container">
                       <table class="table table-bordered">
                          <tbody>
                              <tr>
                                  <th>Tenant Code</th>
                                  <td>{{ $tenant->unique_id }}</td>
                              </tr>
                              <tr>
                                  <th>Full Name</th>
                                  <td>{{ $tenant->full_name }}</td>
                              </tr>
                              <tr>
                                  <th>Firm Name</th>
                                  <td>{{ $tenant->firm_name }}</td>
                              </tr>
                              <tr>
                                  <th>Email</th>
                                  <td>{{ $tenant->email }}</td>
                              </tr>
                              <tr>
                                  <th>Phone No</th>
                                  <td>{{ $tenant->phone }}</td>
                              </tr>
                              <tr>
                                  <th>GST No</th>
                                  <td><span class="badge bg-label-success">{{ $tenant->gst_no }}</span></td>
                              </tr>
                              <tr>
                                  <th>PAN No</th>
                                  <td><span class="badge bg-label-warning">{{ $tenant->pan_no }}</span></td>
                              </tr>
                              <tr>
                                  <th>City</th>
                                  <td>{{ $tenant->city }}</td>
                              </tr>
                              <tr>
                                  <th>Business Name</th>
                                  <td>{{ $tenant->business_name }}</td>
                              </tr>
                              <tr>
                                  <th>Business Industry</th>
                                  <td>{{ $tenant->business_industry }}</td>
                              </tr>
                              <tr>
                                  <th>Business Address</th>
                                  <td>{{ $tenant->business_address }}</td>
                              </tr>
                              <tr>
                                  <th>Business Description</th>
                                  <td>{{ $tenant->business_description }}</td>
                              </tr>
                          </tbody>
                      </table>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary me-3" title="Edit">Edit</a>
                        </div>
                    </div>
            
            
              </div>
            </div>
          </div>

          <div class="card accordion-item active">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordionPayment-2"
                aria-controls="accordionPayment-2">
               Contact Information
              </button>

            </h2>
            <div id="accordionPayment-2" class="accordion-collapse collapse show">

              <div class="accordion-body">
                
                  <div class="table-responsive text-nowrap">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap ">Full Name</th>
                                    <th class="text-nowrap ">Email</th>
                                    <th class="text-nowrap ">Phone</th>
                                    <th class="text-nowrap ">Position</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($tenantContactInfo as $key => $info)
                                <tr>
                                    <td class="text-nowrap">{{ $info->contact_type }}</td>
                                    <td>{{ $info->full_name }}</td>
                                    <td>{{ $info->email }}</td>
                                    <td>{{ $info->phone }}</td>
                                    <td>{{ $info->position }}</td>
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
          

        </div>
      </div>
     
    </div>
  </div>

</div>


@endsection

@section('extrajs')           
  <script>
    const tenantDetailsToggle = document.querySelector('[data-bs-target="#tenantDetails"]');
    const tenantDetailsWrapper = document.getElementById('tenantDetailsWrapper');

    tenantDetailsToggle.addEventListener('click', function() {
        tenantDetailsWrapper.classList.toggle('collapsed');
    });
</script>   
<script>
  $(document).ready( function () {
     var table = $('.datatables-users').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('api.leases-list') }}',
           'type' : 'POST',
            "data": function(d) {
              d.tenant_id   = '{{ $tenant->id }}';
            },
           'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    "order": [["1", "desc" ]],
    "columns": [
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex' , orderable: false, searchable: false },
            { "data": "unique_id"},
            { "data": "property_id", "name":'property.property_code'},
            { "data": "tenant_id", "name":'tenant.firm_name'},
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
    var table = $('.invoice-list-table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('invoice-list') }}',
           'type' : 'POST',
            "data": function(d) {
            d.property_id   = $('#property_id').val();
            d.tenant_id   = '{{ $tenant->id }}';
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

/*--------------Payment----------------------------------------*/
  var tablePayment = $('.datatables-payment').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('payment-history-list') }}',
           'type' : 'POST',
            "data": function(d) {
               d.tenant_id   = '{{ $tenant->id }}';
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
 });
</script>
@endsection