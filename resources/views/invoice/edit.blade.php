@extends('layouts.master')
@section('extracss')
<style type="text/css">
  .table-wrapper {
    display: flex;
    justify-content: center;
    margin: 0 auto; /* Optional: centers the table horizontally */
  }

  .table {
    width: 100%; /* Ensure the table takes the full width of its container */
    text-align: center; /* Center-aligns the text inside table cells */
    border-collapse: collapse; /* Ensures borders are collapsed properly */
  }

  .table th, .table td {
    text-align: center; /* Center-aligns text in table headers and cells */
    vertical-align: middle; /* Centers text vertically */
    padding: 8px; /* Adds padding for better readability */
    border: 1px solid #dee2e6; /* Adds border for cells */
  }

  .table th {
    background-color: #f8f9fa; /* Adds a background color for table headers */
  }

  .form-control {
    border: 1px solid #ced4da; /* Light gray border for input fields */
    border-radius: 0.375rem; /* Rounded corners for input fields */
    padding: 0.375rem 0.75rem; /* Padding inside the input fields */
    font-size: 1rem; /* Font size for input fields */
    line-height: 1.5; /* Line height for better readability */
    background-color: #ffffff; /* White background color */
    color: #495057; /* Text color */
  }

  .form-control:focus {
    border-color: #80bdff; /* Border color on focus */
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25); /* Box shadow on focus */
  }

  .d-flex {
    display: flex;
    align-items: center; /* Align items vertically in the center */
  }

  .ml-2 {
    margin-left: 0.5rem; /* Space between inputs */
  }

  .invoice-preview-card {
    border: 1px solid #dee2e6; /* Border for the invoice card */
    border-radius: 0.375rem; /* Rounded corners for the card */
  }

  .invoice-preview-card .card-body {
    padding: 1.5rem; /* Padding inside the card body */
  }
</style>

@endsection
@section('page-title')
{{ __('Manage Invoice') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Invoice Management')}}</a></li>
<li class="breadcrumb-item">{{__('Edit Invoice')}}</li>
@endsection
@section('content')
@php $paymentDueTerms = $data->lease->due_on ;   
$invoiceDate = $data->invoice_date;
$invoiceDateObject = new \DateTime($invoiceDate);
$due_on = $invoiceDateObject->modify('+' . $paymentDueTerms . ' days');
$partner_per = $data->partner_per;
$partner_type = $data->partner_type;
@endphp

<div class="row invoice-preview">
  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-4">
    <div class="card invoice-preview-card">
      <div class="card-body">
        <div
          class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
          <div class="mb-xl-0 mb-4">
            <a class="header-brand" href="{{url('/')}}" class="app-brand-link">
              <img src="{{url('/')}}/{{ $appSetting->app_logo}}" class="" alt="{{$appSetting->app_name}}">
            </a> 
            <p class="mb-2">{{ $appSetting->address}}</p>
            <p class="mb-2">MADHYA PRADESH,INDIA</p>
            <p class="mb-0">(+91) {{ $appSetting->mobile_no}}</p>
          </div>
           <div class="col-md-5">
              <dl class="row mb-2">
                <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                  <span class="h4 text-capitalize mb-0 text-nowrap">Invoice</span>
                </dt>
                <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                  <div class="input-group input-group-merge disabled w-px-150">
                    <span class="input-group-text">#</span>
                    <input
                      type="text"
                      class="form-control"
                      disabled
                      placeholder="74909"
                      value="74909"
                      id="invoiceId" />
                  </div>
                </dd>
                <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                  <span class="fw-normal">Date:</span>
                </dt>
                <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                  <input type="date" name="issue_date" value="{{ date('Y-m-d',strtotime($data->invoice_date)) }}" class="form-control w-px-150 invoice-date" placeholder="YYYY-MM-DD" />
                </dd>
                <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                  <span class="fw-normal">Due Date:</span>
                </dt>
                <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                  <input type="date"  name="due_date" value="{{ $due_on->format('Y-m-d') }}" class="form-control w-px-150 due-date" placeholder="YYYY-MM-DD" />
                </dd>
              </dl>
            </div>
        </div>
      </div>
      <hr class="my-0" />
      <div class="card-body">
        <div class="row p-sm-3 p-0">
          <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
            <h6 class="mb-3">Party Name:</h6>
            <p class="mb-1">{{ $data->partner->first_name }} {{ $data->partner->last_name }}</p>
            <p class="mb-1">{{ $data->partner->postal_address }}</p>
            <p class="mb-1">{{ $data->partner->mobile }}</p>
            <p class="mb-0">{{ $data->tenant->email }}</p>
            <p class="mb-0">GSTIN/UIN: {{ $data->partner->gst_no }}</p>
          </div>
          <div class="col-xl-6 col-md-12 col-sm-7 col-12">
            <h6 class="mb-3">Invoice To:</h6>
            <p class="mb-1">{{ $data->tenant->full_name }}({{ $data->tenant->firm_name }})</p>
            <p class="mb-1">{{ $data->tenant->business_address }}</p>
            <p class="mb-1">{{ $data->tenant->phone }}</p>
            <p class="mb-0">{{ $data->tenant->email }}</p>
            <p class="mb-0">GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
          </div>
        </div>
        
      </div>
      <div class="table-responsive border-top">
        <table class="table m-0 datatables-basic table-bordered dataTable">
          <thead>
            <tr>
              <th>Description</th>
              <th>Quantity</th>
              <th>Rate</th>
              <th>PER</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @php $totalRent =0; 
              $camTotal =0;
              $utilityTotal =0;
            @endphp
            @foreach($rent_invoices as $key =>  $rent)
            <?php 
              if($partner_type=='1')
              {
                $amount = $partner_per;
                $rate = '';
                $persign = '';
              } else{
                $amount = ($rent->amount * $partner_per)/100;
                $rate = $rent->rate.'*'.$partner_per;
                $persign = '%';
              }
              $totalRent += $amount; 

              $roundof = round($totalRent, $precision = 0, $mode = PHP_ROUND_HALF_UP);
              $difference = $totalRent - $roundof;


            ?>
            <tr class="rent">
              <td class="text-nowrap"><input
                  type="text"
                  name="item_desc[]"
                  class="form-control"
                  value="{{ $rent->item_desc }}"
                  placeholder="Item Description"
                  /></td>
             
               @if($key+1==1)
                 <td> <input
                 type="number"
                    name="quantity[]"
                    class="form-control invoice-item-quantity mb-3"
                    value="{{ $rent->quantity }}"
                    placeholder="quantity"
                    min="0"
                  /></td>
                  @else
                  <td></td>
                  @endif
               @if($key+1==1)
              <td class="text-nowrap">
              <div class="d-flex align-items-center">
               <input
                 type="number"
                    name="rate[]"
                    class="form-control invoice-item-rate mb-3"
                    value="{{ $rent->rate }}"
                    placeholder="rate"
                    min="0"
                  /> <input
                 type="number"
                    name="partner_per[]"
                    class="form-control invoice-item-partner mb-3"
                    value="{{ $partner_per }}"
                    placeholder="partner share"
                    min="0"
                  />{{ $persign }}
                </div></td>
               @else
               <td class="text-nowrap">  <div class="d-flex align-items-center"><input
                 type="number"
                    name="rate[]"
                    class="form-control invoice-item-gst-{{$key}} mb-3"
                    value="{{ $rent->rate }}"
                    placeholder="rate"
                    min="0"
                  /> %</div></td>
              @endif
              <td>{{($key+1==1) ? 'Month' :'' }}</td>
              @if($key+1==1)
              <td class="invoice-item-amount"> {{ formatIndianCurrency($amount) }}</td>
              @else
              <td class="invoice-gst-{{$key}}"> {{ formatIndianCurrency($amount) }}</td>
              @endif
            </tr>
           
           
            @endforeach
             <tr class="">
              <td><b>{{ __('R/O') }}</b></td>
              <td></td>
              <td></td>
              <td></td>
              <td><b class="round-off">{{ formatIndianCurrency(abs($difference)) }}</b></td>
              
           </tr>
             <tr class="">
              <td></td>
              <td></td>
              <td></td>
              <td><b>{{ __('Total') }}</b></td>
              <td><b class="rent-total">{{ formatIndianCurrency($roundof) }}</b></td>
              
           </tr>
           

          </tbody>
          @php  $TotalInwords = getIndianCurrency($roundof); @endphp
        <tfoot>
          
           <tr>
             
              <td colspan="1"><b>Amount Chargeable (in words):</b></td>
              <td colspan="5"><b>INR {{ ucfirst($TotalInwords) }}</b></td>
              
          </tr>
          </tfoot>
        </table>
        <br>
        @if($data->is_gst=='1')
        <?php 
              if($partner_type=='1')
              {
                $total_amount = $partner_per;
                $persign = '';
              } else{
                $total_amount = ($data->rent_total * $partner_per)/100;
               
              }
              $cgst = ($total_amount*$data->rent_cgst_per)/100;
              $sgst = ($total_amount*$data->rent_sgst_per)/100;

              $gstTotal = $cgst+$sgst;
            ?>
        <table class="dt-complex-header table table-bordered dataTable">
          <thead>
            <tr>
              <th rowspan="2">HSN/SAC</th>
              <th rowspan="1">Taxable</th>
              <th colspan="2">Central Tax</th>
              <th colspan="2">State Tax</th>
              <th rowspan="1">Total</th>
            </tr>
            <tr>

              <th>Value</th>
              <th>Rate</th>
              <th>Amount</th>
              <th>Rate</th>
              <th>Amount</th>
              <th>Tax Amount</th>
            
            </tr>
          </thead>
          <tbody>
            <tr >
             <td>997212</td>
              <td  class="cam">{{ formatIndianCurrency($total_amount) }}</td>
              <td>{{ $data->rent_cgst_per }} %</td>
               <td class="cam">{{ formatIndianCurrency($cgst) }}</td>
              <td >{{ $data->rent_sgst_per }} %</td>
              <td class="cam">{{ formatIndianCurrency($sgst) }}</td>
               <td class="cam">{{ formatIndianCurrency($gstTotal) }}</td>
          
          </tbody>
          @php  $TotalGstInwords = getIndianCurrency(round($gstTotal,0)); @endphp
          <tfoot>
             <tr class="">
              <td><b >{{ __('Total') }}</b></td>
              <td><b class="cam">{{ formatIndianCurrency($total_amount) }}</b></td>
              <td></td>
              <td><b class="cam">{{ formatIndianCurrency($cgst) }}</b></td>
              <td></td>
              <td><b class="cam">{{ formatIndianCurrency($sgst) }}</b></td>
              <td><b class="cam">{{ formatIndianCurrency($gstTotal) }}</b></td>
              
           </tr>
           <tr class="">
             
              <td colspan="4"><b>Tax Amount ( (in words):</b></td>
              <td colspan="2"><b>{{ ucfirst($TotalGstInwords) }}</b></td>
              
          </tr>
          </tfoot>
        
        </table>
        @endif
        

      </div>

      <div class="card-body mx-3">
        <div class="row">

          <div class="col-12">
            <span class="fw-medium">Note:</span>
            <span
              >{{ $appSetting->invoice_disclaimer }}. Thank You!</span
            >
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Invoice -->

</div>
@endsection
@section('extrajs')     
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
  <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
  <script type="text/javascript">
$(document).ready(function() {

  function formatCurrency(value) {
    return new Intl.NumberFormat('en-IN', {
      style: 'currency',
      currency: 'INR',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(value);
  }
  // Function to update amount for a single row
  function updateRowAmount(row) {
    var quantity = parseFloat(row.find('.invoice-item-quantity').val()) || 0;
    var rate = parseFloat(row.find('.invoice-item-rate').val()) || 0;
    var partnerShare = parseFloat(row.find('.invoice-item-partner').val()) || 0;
    
    var amount = (quantity * rate * (partnerShare / 100)).toFixed(2);
    row.find('.invoice-item-amount').text(formatCurrency(amount));

    return parseFloat(amount);
  }

  // Function to update totals for rent, CGST, and SGST
  function updateTotals() {
    var totalRent = 0;
    $('.rent').each(function() {
      totalRent += updateRowAmount($(this));
    });

    // Round the total rent
   

   

    // Get CGST and SGST percentages
    var cgstPer = parseFloat($('.invoice-item-gst-1').val()) || 0;
    var sgstPer = parseFloat($('.invoice-item-gst-2').val()) || 0;

    // Calculate CGST and SGST amounts
    var cgstAmount = (totalRent * cgstPer / 100).toFixed(2);
    var sgstAmount = (totalRent * sgstPer / 100).toFixed(2);
    var gstTotal = (parseFloat(cgstAmount) + parseFloat(sgstAmount)).toFixed(2);

    var finalTotal = parseFloat(totalRent)+ parseFloat(gstTotal);
    var roundedRent = finalTotal.toFixed(0);
    var roundoff = (finalTotal - parseFloat(roundedRent)).toFixed(2);

     // Update the total rent amount on the table
    $('.rent-total').text(formatCurrency(finalTotal.toFixed(0)));
    $('.round-off').text('₹' + Math.abs(roundoff));
    // Update the CGST, SGST, and Total GST amounts on the table
    $('.invoice-gst-1').text(formatCurrency(cgstAmount));
    $('.invoice-gst-2').text(formatCurrency(sgstAmount));
    $('.gst-total').text(formatCurrency(gstTotal));
  }

  // Event listener for changes in quantity, rate, and partner share
  $('.invoice-item-quantity, .invoice-item-rate, .invoice-item-partner').on('input', function() {
    updateTotals();
  });

  // Event listener for changes in CGST and SGST percentages
  $('.invoice-item-gst-1, .invoice-item-gst-2').on('input', function() {
    updateTotals();
  });

  // Initial call to update totals
  updateTotals();
// Function to remove currency formatting and return raw value
  function parseCurrency(value) {
    return parseFloat(value.replace(/₹|,/g, '')) || 0;
  }
  function updateInputFormatting() {
    $('.cam').each(function() {
      var rawValue = parseCurrency($(this).text());
      $(this).text(formatCurrency(rawValue));
    });
  }

  // Event listener for changes in input fields
  $('input[type="number"]').on('input', function() {
    var rawValue = parseCurrency($(this).val());
    $(this).val(formatCurrency(rawValue));
  });

  // Initial formatting on document ready
  updateInputFormatting();
});
</script>


 <!-- <script type="text/javascript">
      
  $(document).ready(function() {
    // Function to update amount
    function updateAmount(row) {
      var quantity = parseFloat(row.find('.invoice-item-quantity').val()) || 0;
      var rate = parseFloat(row.find('.invoice-item-rate').val()) || 0;
      var partnerShare = parseFloat(row.find('.invoice-item-partner').val()) || 0;
      
      var amount = (quantity * rate * (partnerShare / 100)).toFixed(2);
      row.find('.invoice-item-amount').text('₹' + amount);
    }

    // Event listener for changes in input fields
    $('.invoice-item-quantity, .invoice-item-rate, .invoice-item-partner').on('input', function() {
      var row = $(this).closest('tr');
      updateAmount(row);
    });
  });
    </script>   -->

@endsection