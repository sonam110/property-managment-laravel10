@extends('layouts.master')
@section('page-title')
    {{ __('Payment History') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Payment Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Payment')}}</li>
@endsection
@section('content')

<!-- Users List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-3">Search filter</h5>
    <div class="d-flex  align-items-center row pb-2 gap-3 gap-md-0">
      <div class="col-md-3 user_role">{{ Form::label('UserRole', __('Select Lease'), ['class' => 'form-label']) }}<select id="lease_id" class="select2 form-selec text-capitalize"><option value="" > Select Lease
       </option>
       @foreach($leases as $key => $lease)
        <option  value="{{ $key }}" {{ ($id ==$key)? 'Selected':'' }} >
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
    
      <div class="col-md-3 user_status">{{ Form::label('UserStatus', __('Select Status'), ['class' => 'form-label']) }}<select id="status" class="select2 form-selec text-capitalize"><option value=""> Select Status </option><option value="Full">Full</option><option value="Processing">Processing</option><option value="Partial">Partial</option></select></div>
    </div> 
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
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
  
</div>
@endsection
@section('extrajs')     
 <!-- <script src="{{ asset('assets/js/app-user-list.js') }}"></script>   -->       
<script>
   $(document).ready( function () {
    var userCreateUrl = '{{ route('leases.create') }}';
    var table = $('.datatables-users').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('payment-history-list') }}',
           'type' : 'POST',
            "data": function(d) {
            d.property_id   = $('#property_id').val();
            d.status   = $('#status').val();
            d.lease_id   = $('#lease_id').val();
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

$('#property_id, #status,#lease_id').on('change', function(e) {
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

</script>
@endsection