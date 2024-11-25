@extends('layouts.master')
@section('page-title')
    {{ __('Expenses') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('report')}}">{{__('Report Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Report')}}</li>
@endsection
@section('content')
<!-- Users List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-3">Search Filter</h5>
    <div class="d-flex  align-items-center row pb-2 gap-3 gap-md-0">
      <div class="col-md-3 user_role">{{ Form::label('UserRole', __('Select Property'), ['class' => 'form-label']) }}<select id="property_id" class="select2 form-selec text-capitalize"><option value="" > Select Property
       </option>
       @foreach($propertyTypes as $key => $pp)
        <option  value="{{ $key }}">
        {{ $pp }}
      </option> 
      @endforeach</select></div>
    
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
  <div class="card-datatable table-responsive">
   <table id="report-table" class="table datatables-users">
      <thead class="border-top">
        <tr>
          <th>Property</th>
          <th>Year/Month</th>
          <th>CAM Received</th>
          <th>CAM Expense</th>
          <th>CAM Profit/Loss</th>
          <th>Utility Received</th>
          <th>Utility Expense</th>
          <th>Utility Profit/Loss</th>
        </tr>
      </thead>
      </table>
  </div>
  
</div>
@endsection
@section('extrajs')     
 <!-- <script src="{{ asset('assets/js/app-user-list.js') }}"></script>   -->       
<script>
    $(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
      placeholder: 'Select value',
      dropdownParent: $('.select2').parent()
    });

        var table = $('.datatables-users').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : '{{ route('report-list') }}',
           'type' : 'POST',
           dataSrc: function (json) {
              return json.data; // Ensure proper data is returned from the server
          },
              "data": function(d) {
            d.property_id = $('#property_id').val() || null;  // Null to fetch all properties if not selected
            d.start_date = $('#start_date').val();
            d.end_date = $('#end_date').val();
            },
           'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    "order": [["1", "desc" ]],
    "columns": [
        { data: 'property', name: 'property', title: 'Property' },
        { data: 'period', name: 'period', title: 'Year/Month' },
        { data: 'cam_received', name: 'cam_received', title: 'CAM Received' },
        { data: 'cam_expense', name: 'cam_expense', title: 'CAM Expense' },
         {
            data: 'cam_profit_loss',
            title: 'CAM Profit/Loss',
            render: function(data, type, row) {
                // Ensure HTML is rendered as HTML in the table (not escaped as text)
                return data; // Return the HTML directly (DataTable will render it as HTML)
            }
        },
        { data: 'utility_received', name: 'utility_received', title: 'Utility Received' },
        { data: 'utility_expense', name: 'utility_expense', title: 'Utility Expense' },
        {
            data: 'utility_profit_loss',
            title: 'Utility Profit/Loss',
            render: function(data, type, row) {
                // Ensure HTML is rendered as HTML in the table (not escaped as text)
                return data; // Return the HTML directly (DataTable will render it as HTML)
            }
        }
        ],
         escapeRegex: false,
        order: [[1, 'desc']],
       
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

$('#property_id, #start_date, #end_date').on('change', function() {
      table.draw();
    });
});



    


</script>
@endsection