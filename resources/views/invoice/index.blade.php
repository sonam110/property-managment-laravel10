@extends('layouts.master')
@section('page-title')
    {{ __('Manage Invoice') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('invoice')}}">{{__('Invoice Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Invoices')}}</li>
@endsection
@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Invoice /</span> List</h4>

<!-- Invoice List Widget -->

<div class="card mb-4">
  <div class="card-widget-separator-wrapper">
    <div class="card-body card-widget-separator">
      <div class="row gy-4 gy-sm-1">
        <div class="col-sm-6 col-lg-3">
          <div
            class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
            <div>
              <h6 class="mb-1">{{ $countData['totalInvoice'] }}</h6>
              <p class="mb-0">Total Invoices</p>
            </div>
            <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-user ti-md"></i
              ></span>
            </span>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-4" />
        </div>
        <div class="col-sm-6 col-lg-3">
          <div
            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalInVoiceAmount']) }}</h6>
              <p class="mb-0">Total Rent</p>
            </div>
            <span class="avatar me-lg-4">
              <span class="avatar-initial bg-label-secondary rounded"
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
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalPaid']) }}</h6>
              <p class="mb-0">Paid Rent </p>
            </div>
            <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-checks ti-md"></i
              ></span>
            </span>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalUnPaid']) }}</h6>
              <p class="mb-0">Unpaid Rent </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
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
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalCamInVoiceAmount']) }}</h6>
              <p class="mb-0">Total CAM </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
              ></span>
            </span>
          </div>
        </div>
         <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalCamPaid']) }}</h6>
              <p class="mb-0">CAM Paid </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
              ></span>
            </span>
          </div>
        </div>
         <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalCamUnPaid']) }}</h6>
              <p class="mb-0">CAM Unpaid </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
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
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityInVoiceAmount']) }}</h6>
              <p class="mb-0">Total Utility </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
              ></span>
            </span>
          </div>
        </div>
         <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityPaid']) }}</h6>
              <p class="mb-0">Utility Paid </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
              ></span>
            </span>
          </div>
        </div>
         <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityUnPaid']) }}</h6>
              <p class="mb-0">Utility Unpaid </p>
            </div>
            <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"
                ><i class="ti ti-circle-off ti-md"></i
              ></span>
            </span>
          </div>
        </div>
        
      </div>
      
    </div>
  </div>
</div>


<!-- Invoice List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-3">Search filter</h5>
    <div class="d-flex  align-items-center row pb-2 gap-3 gap-md-0">
      <div class="col-md-3 user_role">{{ Form::label('UserRole', __('Select Lease'), ['class' => 'form-label']) }}<select id="lease_id" class="select2 form-selec text-capitalize"><option value="" > Select Lease
       </option>
       @foreach($leases as $key => $lease)
        <option  value="{{ $key }}" >
        {{ $lease }}
      </option> 
      @endforeach</select></div>
      <div class="col-md-3 user_role">{{ Form::label('UserRole', __('Select Property'), ['class' => 'form-label']) }}<select id="property_id" class="select2 form-selec text-capitalize"><option value="" > Select Property
       </option>
       @foreach($propertyTypes as $key => $pp)
        <option  value="{{ $key }}">
        {{ $pp }}
      </option> 
      @endforeach</select></div>
       <div class="col-md-3 user_role">{{ Form::label('UserRole', __('Select Tenant'), ['class' => 'form-label']) }}<select id="tenant_id" class="select2 form-selec text-capitalize"><option value="" > Select Tenant
       </option>
       @foreach($tenants as $key1 => $tenant)
        <option  value="{{ $key1 }}">
        {{ $tenant }}
      </option> 
      @endforeach</select></div>
    
      <div class="col-md-3 user_status">{{ Form::label('UserStatus', __('Select Status'), ['class' => 'form-label']) }}<select id="status" class="select2 form-selec text-capitalize"><option value=""> Select Status </option><option value="Full">Full</option><option value="Pending">Pending</option><option value="Partial">Partial</option></select></div>
       <div class="col-md-3 type">{{ Form::label('type', __('Select Type'), ['class' => 'form-label']) }}<select id="type" class="select2 form-selec text-capitalize"><option value=""> Select Type </option><option value="rent">Rent</option><option value="cam">CAM</option><option value="utility">Utility</option></select></div>
         <div class="col-md-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" id="start_date" class="form-control">
      </div>
      <div class="col-md-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" id="end_date" class="form-control">
      </div>
    </div>

    </div> 
  </div>
  <div class="card-datatable table-responsive">
    <table class="invoice-list-table table border-top">
      <thead>
        <tr>
          <th></th>
          <th>#Invoice No</th>
          <th>Type</th>
          <th>Property</th>
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
<div id="dynamicOffcanvasContainer"></div>

@endsection
@section('extrajs')     
<!-- <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script> -->
 <!-- <script src="{{ asset('assets/js/app-user-list.js') }}"></script>   -->       
<script>
   $(document).ready( function () {
    var userCreateUrl = '{{ route('leases.create') }}';
    var table = $('.invoice-list-table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('invoice-list') }}',
           'type' : 'POST',
            "data": function(d) {
            d.property_id   = $('#property_id').val();
            d.status   = $('#status').val();
            d.tenant_id   = $('#tenant_id').val();
            d.lease_id   = $('#lease_id').val();
            d.type   = $('#type').val();
            d.start_date = $('#start_date').val();
            d.end_date = $('#end_date').val();
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
            { "data": "property_id", "name":'property.property_name'},
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

$('#property_id, #status,#lease_id,#tenant_id,#type,#start_date, #end_date').on('change', function(e) {
       table.draw();
   });
});

// Initialize Select2
  $(document).ready(function() {
      $('#multicol-country').select2();

      // Attach event handler to Select2 dropdown
      $('#multicol-country').on('change', function() {
          getState();
      });
  });
    // Select2 Country
  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }
  function getState() {
      var country_id = $('#multicol-country').val(); // Get the selected value from Select2

      $.ajax({
          url: appurl + "get-state",
          type: "post",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          data: { country_id: country_id },
          success: function(response) {
              $(".state").html(response);
          }
      });
  }
  $(document).on('click', '.payment-model', function() {
    let id = $(this).data('id'); // Get the dynamic ID
    $.ajax({
        url: "{{ route('payment.modal') }}", 
        type: "POST",
         headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
        data: { id: id },
        success: function (response) {
            // Inject the returned HTML into the offcanvas container
            $('#dynamicOffcanvasContainer').html(response);

            // Initialize and show the offcanvas
            let offcanvasElement = document.getElementById('addPaymentOffcanvas');
            if (offcanvasElement) {
                let offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            } else {
                console.error('Offcanvas element not found.');
            }
        },
        error: function (xhr) {
            console.error('Error fetching invoice data:', xhr.responseText);
        }
    });
});

$(document).ready(function() {
    // Function to format the number as Indian currency
    function formatIndianCurrency(amount) {
        if (isNaN(amount)) return '0';
        return amount.toLocaleString('en-IN', { style: 'currency', currency: 'INR' });
    }

    // Attach submit event handler to the form
  $(document).ready(function() {
    // Use event delegation for dynamic form elements
    $(document).on('click', '.submitForm', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var $button = $(this); // Reference to the clicked button
        var type = $button.data('type'); // Get the action type ('submit' or 'send')

        // Find the closest offcanvas-body
        var $offcanvasBody = $button.closest('.offcanvas-body'); 

        // Ensure the required fields are available from the specific offcanvas form
        var formData = new FormData();
        formData.append('id',  $offcanvasBody.find('.invoice_id').val());
        formData.append('type', $offcanvasBody.find('.type').val());
        formData.append('grand_total', $offcanvasBody.find('.grand_total').val());
        formData.append('totalAmount', $offcanvasBody.find('.totalAmount').val());
        formData.append('invoiceAmount', $offcanvasBody.find('#invoiceAmount').val());
        formData.append('paymentDate', $offcanvasBody.find('#payment-date').val());
        formData.append('paymentStatus', $offcanvasBody.find('#payment-status').val());
        formData.append('paymentMethod', $offcanvasBody.find('#payment-method').val());
        formData.append('paymentNote', $offcanvasBody.find('#payment-note').val());
        formData.append('reference_no', $offcanvasBody.find('#reference_no').val());
        formData.append('type', type); // Add action type for "submit" or "send"

        // Append the file input (if any)
        var fileInput = $offcanvasBody.find('#payment_image')[0].files[0];  // Get the selected file
        if (fileInput) {
            formData.append('payment_image', fileInput);
        }

        // Debugging: Log form data to ensure it’s being collected correctly
        console.log('Form Data:', formData);

        // AJAX request to save the payment data
        $.ajax({
            url: appurl + 'add-payment', // Replace with your endpoint URL
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            processData: false,
            contentType: false, 
            success: function(response) {
                // Handle the response from the server
                toastr.success(response.message || "Payment Added successfully!");
                $('#addPaymentOffcanvas').offcanvas('hide'); // Hide the offcanvas
                window.location.reload(); // Optionally, reload the page to reflect changes
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = '';
                if (errors) {
                    $.each(errors, function(key, messages) {
                        errorMessage += messages.join('<br>') + '<br>';
                    });
                } else {
                    errorMessage = "An unexpected error occurred.";
                }
                toastr.error(errorMessage);
            }
        });
    });
});



    // Event handler for keyup event on the invoiceAmount input field (delegated for dynamically added content)
    $(document).on('keyup', '.invoice-amount', function() {
        var $invoiceListing = $(this).closest('.offcanvas-body'); // Find the parent offcanvas body of the current input field
        var invoiceBalance = parseFloat($invoiceListing.find('.invoice-balance').text().replace(/[^0-9.-]+/g, '')) || 0; // Get the invoice balance for the current invoice
        var paymentAmount = parseFloat($(this).val().replace(/[^0-9.-]+/g, '')) || 0; // Get the current payment amount from the input field

        // Calculate the remaining balance
        var remainingBalance = invoiceBalance - paymentAmount;

        if (paymentAmount > invoiceBalance) {
            $(this).val('0'); // Reset the input to 0
            $invoiceListing.find('.remaining').text(formatIndianCurrency(0)); // Update remaining balance
            $invoiceListing.find('.warning').text('Payment amount exceeds invoice balance.').show(); // Show warning
        } else {
            $invoiceListing.find('.remaining').text(formatIndianCurrency(remainingBalance)); // Update remaining balance
            $invoiceListing.find('.warning').hide(); // Hide warning
        }
    });
});

</script>
@endsection