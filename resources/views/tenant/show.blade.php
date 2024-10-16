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
            <i class="fa fa-mail-reply"></i>
        </a>
        <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#tenantDetails" aria-expanded="true" aria-controls="tenantDetails">
            <i class="ti ti-user"></i> Tenant Details
        </button>
    </div>
@endsection

@section('content')

<div class="d-flex">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 pe-3" id="tenantDetailsWrapper">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">
               
                <div class="collapse show" id="tenantDetails">
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2"><span class="fw-medium me-1">Full Name:</span> <span>{{ $tenant->full_name }}</span></li>
                            <li class="mb-2"><span class="fw-medium me-1">Firm Name:</span> <span>{{ $tenant->firm_name }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Email:</span> <span>{{ $tenant->email }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Phone No:</span> <span>{{ $tenant->phone }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">GST No:</span> <span class="badge bg-label-success">{{ $tenant->gst_no }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">PAN No:</span> <span class="badge bg-label-warning">{{ $tenant->pan_no }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">City:</span> <span>{{ $tenant->city }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Business name:</span> <span>{{ $tenant->business_name }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Business industry:</span> <span>{{ $tenant->business_industry }}</span></li>
                            <li class="mb-2 pt-1"><span class="fw-medium me-1">Business Address:</span> <span>{{ $tenant->business_address }}</span></li>
                            <li class="pt-1"><span class="fw-medium me-1">Business description:</span> <span>{{ $tenant->business_description }}</span></li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary me-3" title="Edit">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7" id="mainContent">
        <div class="card mb-4">
            <h5 class="mt-4 small text-uppercase text-muted">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#contactInfo" aria-expanded="false" aria-controls="invoiceHistory">
                    <i class="ti ti-users"></i> Contact Information
                </button>
            </h5>
            <div class="collapse show" id="contactInfo">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped border-top">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap text-center">Full Name</th>
                                    <th class="text-nowrap text-center">Email</th>
                                    <th class="text-nowrap text-center">Phone</th>
                                    <th class="text-nowrap text-center">Position</th>
                                </tr>
                            </thead>
                            <tbody>
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

        <div class="card mb-4">
            <h5 class="mt-4 small text-uppercase text-muted">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#leaseInfo" aria-expanded="false" aria-controls="invoiceHistory">
                    <i class="ti ti-home"></i> Leases
                </button>
            </h5>
            <div class="collapse show" id="leaseInfo">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped border-top">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Lease ID</th>
                                    <th class="text-nowrap text-center">Property</th>
                                    <th class="text-nowrap text-center">Start Date</th>
                                    <th class="text-nowrap text-center">Total Area</th>
                                    <th class="text-nowrap text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leases as $key => $lease)
                                <tr>
                                    <td class="text-nowrap"><a href="{{ route('generate-pdf', $lease->id) }}">{{ $lease->unique_id }}</a></td>
                                    <td><a href="{{ route('generate-pdf', $lease->id) }}">{{ $lease->property->property_name }} - ({{ $lease->property->property_code }})</a></td>
                                    <td>{{ $lease->start_date }}</td>
                                    <td>{{ $lease->total_square }}</td>
                                    <td>{{ $lease->price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
           <h5 class="mt-4 small text-uppercase text-muted">
             <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#invoiceHistory" aria-expanded="false" aria-controls="invoiceHistory">
                  <i class="ti ti-mail"></i> Invoice History
              </button>
          </h5>
            <div class="collapse" id="invoiceHistory">
                <div class="card-body">
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
 });
</script>
@endsection