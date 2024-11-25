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

</style>
@endsection
@section('page-title')
{{ __('Manage Invoice') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Invoice Management')}}</a></li>
<li class="breadcrumb-item">{{__('Invoices')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="{{ route('invoice') }}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="{{route('invoice')}}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
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
            <p class="mb-2">{{ $appSetting->address}}</p>
            <p class="mb-2">MADHYA PRADESH,INDIA</p>
            <p class="mb-0">(+91) {{ $appSetting->mobile_no}}</p>
          </div>
          <div>
            <h5 class="fw-medium mb-2">INVOICE #{{ $data->invoice_no}}</h5>
            <div class="mb-2 pt-1">
              <span>Issues Date:</span>
              <span class="fw-medium">{{ date('M d,Y',strtotime($data->invoice_date)) }}</span>
            </div>

            <div class="pt-1">
              <span>Due Date:</span>
              <span class="fw-medium">{{ $due_on->format('M d,Y') }}</span>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-0" />
      <div class="card-body">
        <div class="row p-sm-3 p-0">
          <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
            <h6 class="mb-3">Party Name:</h6>
            <p class="mb-1">{{ @$data->partner->first_name }} {{ @$data->partner->last_name }}</p>
            <p class="mb-1">{{ @$data->partner->postal_address }}</p>
            <p class="mb-1">{{ @$data->partner->mobile }}</p>
            <p class="mb-0">{{ $data->tenant->email }}</p>
            <p class="mb-0">GSTIN/UIN: {{ @$data->partner->gst_no }}</p>
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
          <tbody id="invoice-rows">
            @php $totalRent =0; 
              $camTotal =0;
              $utilityTotal =0;
              $difference =0;
              $roundof =0;
            @endphp
            @foreach($rent_invoices as $key =>  $rent)
            <?php 
              if($data->invoice_type =='rent'){
                if($partner_type=='1')
                {
                  $amount =$rent->amount;
                  $rate = '';
                  $persign = '';
                  $parshow = '<span class="input-group-text">Fixed</span>';
                  if($key+1 == 1){
                    $rent_rate = $rent->amount;
                  } else{
                    $rent_rate = $rent->rate;
                  }
                  
                } else{
                  $amount = $rent->amount ;
                  $rate = $rent->rate.'*'.$partner_per;
                  $rent_rate = $rent->rate;
                  $persign = '%';
                  $parshow = '<span class="input-group-text">'.$partner_per.'%'.'</span>';
                }

                
              } else{
                $amount = $rent->amount ;
                $rate = $rent->rate;
                $rent_rate = $rent->rate;
                $parshow ='';
              }
              $totalRent += $amount; 

              $roundof = round($totalRent, $precision = 0, $mode = PHP_ROUND_HALF_UP);
              $difference = $totalRent - $roundof;


            ?>
            
            <tr class="{{ ($rent->type == 'rent'  ||  $rent->type == 'cam' || $rent->type == 'utility'  || $rent->item_type == 'extra') ? 'rent' : 'gst' }} {{ $rent->type }} {{ ($rent->item_type == 'rent' || $rent->item_type == 'cam' || $rent->item_type == 'utility') ? '' : $rent->item_type }}">
           <input type="hidden" name="item_type[]" class=="item_type" value="{{ $rent->item_type == 'rent' ? '' : $rent->item_type }}">
           <td class="text-nowrap text-left"><input type="text" class="form-control" name="description[]" value="{{ $rent->item_desc }}" placeholder="Enter description" /></td>
            <td class="text-nowrap text-right"><input type="number" class="form-control quantity" name="quantity[]" value="{{ $rent->quantity }}" /></td>
            <td class="text-nowrap   text-righ "><div class="input-group"><input type="number" class="form-control rate" name="rate[]" value="{{ $rent_rate }}" /> {!! ($key+1 == 1) ? $parshow : '' !!}</div></td>
            <td>{{ ($key+1 == 1) ? 'Month' : '' }}</td>
            <td class="text-nowrap  text-righ"><input type="number" class="form-control amount" name="amount[]" value="{{ $amount }}" readonly /></td>
            <td><a href="#" class="remove-row-btn">X</a></td>
          </tr>
           
           
            @endforeach
            </tbody>
              <tr class="rent">
                  <td><button type="button" id="add-row-btn" class="btn btn-primary mt-2">Add New Row</button></td>
                  <td><button type="button" id="save-invoice-btn" class="btn btn-primary mt-2">Save</button></td>
                  <td><a href="{{ route('invoice-view',$data->id)}}" id="save-invoice-btn" class="btn btn-primary mt-2">View</a></td>
              </tr>

             <tr class="rent">
              <td class="text-left"><b >{{ __('R/O') }}</b></td>
              <td></td>
              <td></td>
              <td></td>
             <td class="text-right"><b id="ro-value">{{ formatIndianCurrency(abs($difference)) }}</b></td>
        
           </tr>
             <tr class="rent">
              <td></td>
              <td></td>
              <td></td>
              <td><b>{{ __('Total') }}</b></td>
             <td class="text-left"> <b id="total-value">{{ formatIndianCurrency($roundof) }}</b></td>
              
           </tr>
           

          
          @php  $TotalInwords = getIndianCurrency($roundof); @endphp
        <tfoot>
          
           <tr>
             
              <td colspan="1"><b>Amount Chargeable (in words):</b></td>
             <td colspan="5"><b id="amount-in-words">INR {{ ucfirst(getIndianCurrency($roundof)) }}</b></td>
              
          </tr>
          </tfoot>
        </table>
      
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

          <!-- Offcanvas -->
          <!-- Send Invoice Sidebar -->
          <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
            <div class="offcanvas-header my-1">
              <h5 class="offcanvas-title">Send Invoice</h5>
              <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-0 flex-grow-1">
              <form>
                <div class="mb-3">
                  <label for="invoice-from" class="form-label">From</label>
                  <input
                    type="text"
                    class="form-control"
                    id="invoice-from"
                    value="shelbyComapny@email.com"
                    placeholder="company@email.com" />
                </div>
                <div class="mb-3">
                  <label for="invoice-to" class="form-label">To</label>
                  <input
                    type="text"
                    class="form-control"
                    id="invoice-to"
                    value="qConsolidated@email.com"
                    placeholder="company@email.com" />
                </div>
                <div class="mb-3">
                  <label for="invoice-subject" class="form-label">Subject</label>
                  <input
                    type="text"
                    class="form-control"
                    id="invoice-subject"
                    value="Invoice of purchased Admin Templates"
                    placeholder="Invoice regarding goods" />
                </div>
                <div class="mb-3">
                  <label for="invoice-message" class="form-label">Message</label>
                  <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">
      Dear Queen Consolidated,
      Thank you for your business, always a pleasure to work with you!
      We have generated a new invoice in the amount of  95.59
      We would appreciate payment of this invoice by 05/11/2021</textarea
                  >
                </div>
                <div class="mb-4">
                  <span class="badge bg-label-primary">
                    <i class="ti ti-link ti-xs"></i>
                    <span class="align-middle">Invoice Attached</span>
                  </span>
                </div>
                <div class="mb-3 d-flex flex-wrap">
                  <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Send Invoice Sidebar -->

          <!-- Add Payment Sidebar -->
           @php  $invoiceBalance = (!empty($data->remaining_amount)) ? $data->remaining_amount : formatIndianCurrency($roundof)   @endphp
          <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">
            <div class="offcanvas-header mb-3">
              <h5 class="offcanvas-title">Add Payment</h5>
              <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
              <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                <p class="mb-0">Invoice Balance:</p>
                <p class="fw-medium mb-0 invoice-balance" > {{ formatIndianCurrency($invoiceBalance) }}</p>
              </div>

               <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                <p class="mb-0">Remaining Balance:</p>
                <p class="fw-medium mb-0 remaining">{{ (!empty($data->remaining_amount)) ?  formatIndianCurrency($data->remaining_amount) : 0 }}</p>
              </div>
              <form>
                
                <div class="mb-3">
                  <label class="form-label" for="invoiceAmount">Payment Amount</label><span class="requiredLabel">*</span>
                  <div class="input-group">
                    <span class="input-group-text"> </span>
                    <input
                      type="text"
                      id="invoiceAmount"
                      name="invoiceAmount"
                      class="form-control invoice-amount"
                      placeholder=""  required/>
                  </div>
                </div>
                <span class="warning" style="color:red"></span>
                <div class="mb-3">
                  <label class="form-label" for="payment-date">Payment Date</label> <span class="requiredLabel">*</span>
                  <input id="payment-date" class="form-control invoice-date" type="date"  required/>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment-status">Payment Status</label> <span class="requiredLabel">*</span>
                  <select class="form-select" id="payment-status" required>
                    <option value="" selected disabled>Select paymet Status</option>
                    <option value="Full">Full</option>
                    <option value="Partial">Partial</option>
                  

                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment-method">Payment Method</label>
                  <select class="form-select" id="payment-method">
                    <option value="" selected disabled>Select payment method</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="UPI">UPI</option>
                    <option value="cheque">Cheque</option>

                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="reference_no">Transaction Id</label>
                  <div class="input-group">
                    <span class="input-group-text"> </span>
                    <input
                      type="text"
                      id="reference_no"
                      name="reference_no"
                      class="form-control reference_no"
                      placeholder=""  />
                  </div>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="payment-note">Internal Payment Note</label>
                  <textarea class="form-control" id="payment-note" rows="2"></textarea>
                </div>
                <div class="mb-3 d-flex flex-wrap">
                  <button type="button" class="btn btn-primary me-3 submitForm" data-bs-dismiss="offcanvas">Send</button>
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Add Payment Sidebar -->

          <!-- /Offcanvas -->
@endsection
@section('extrajs')     

 
  <script>
   $(document).ready(function() {
    // Assume partner_per is available as a global variable or passed via data attribute
    const partner_per = '{{ $partner_per }}'; // Example: partner share is 30%
    const partner_type = '{{ $partner_type }}'; 
    const invoice_type = '{{ $data->invoice_type }}';// Example: partner share is 30%


    // Function to format currency
    function formatIndianCurrency(amount) {
        return amount.toLocaleString('en-IN', { style: 'currency', currency: 'INR' });
    }

    // Function to convert numbers to words
    function numberToWords(num) {
        const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
            'Seventeen', 'Eighteen', 'Nineteen'];
        const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        const thousands = ['','Thousand'];

        if (num === 0) return 'Zero';
        if (num < 20) return ones[num];
        if (num < 100) return tens[Math.floor(num / 10)] + (num % 10 > 0 ? ' ' + ones[num % 10] : '');
        if (num < 1000) return ones[Math.floor(num / 100)] + ' Hundred' + (num % 100 > 0 ? ' ' + numberToWords(num % 100) : '');
        
        let word = '';
        for (let i = 0; i < thousands.length; i++) {
            const divisor = Math.pow(1000, i);
            if (num < divisor * 1000) {
                word = numberToWords(Math.floor(num / divisor)) + ' ' + thousands[i] + (num % divisor > 0 ? ' ' + numberToWords(num % divisor) : '');
                break;
            }
        }
        return word.trim();
    }
    function updateTotals() {
        let totalRent = 0;
        let cgstAmount = 0;
        let sgstAmount = 0;

        $('#invoice-rows tr').each(function(index) {
            const row = $(this);
            const itemType = row.hasClass('rent') ? 'rent' : 'gst';
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const rate = parseFloat(row.find('.rate').val()) || 0;
            let amount = 0;

            if (itemType === 'rent') {
                if (row.hasClass('extra')) {
                   //console.log(itemType);
                    amount = quantity * rate;
                    totalRent += amount;  // Accumulate rent amount
                    row.find('.amount').val(amount.toFixed(2));
                }
                else if (row.hasClass('cam')) {
                    
                    amount =  rate;

                    totalRent += amount;  // Accumulate rent amount
                    row.find('.amount').val(amount.toFixed(2));
                } else if (row.hasClass('utility')) {
                  console.log(itemType)
                    amount = quantity * rate;
                    totalRent += amount;  // Accumulate rent amount
                    row.find('.amount').val(amount.toFixed(2));
                } else{
                  if(partner_type==1){
                    amount =  rate ;
                    totalRent += amount;  // Accumulate rent amount
                    row.find('.amount').val(amount.toFixed(2));
                  } else{
                    amount =  rate * (partner_per / 100);
                    totalRent += amount;  // Accumulate rent amount
                    row.find('.amount').val(amount.toFixed(2));
                  }
                  
                  
                }
            } else if (itemType === 'gst') {
                // Calculate GST based on totalRent
                  
                if (row.hasClass('cgst')) {
                    cgstAmount = (totalRent * rate) / 100;
                    //console.log(row.find('.amount'));
                    row.find('.amount').val(cgstAmount.toFixed(2));  // Update CGST amount
                }
                if (row.hasClass('sgst')) {
                    sgstAmount = (totalRent * rate) / 100;
                    row.find('.amount').val(sgstAmount.toFixed(2));  // Update SGST amount
                }
                
            }

            //row.find('.amount').val(amount.toFixed(2));  // Update amount field
        });

        // Update the total with GST included
        const grandTotal = totalRent + cgstAmount + sgstAmount;
        const roundTotal = Math.round(grandTotal);
        const difference = grandTotal - roundTotal;
        $('#total-value').text(formatIndianCurrency(roundTotal));  // Update total
        $('#ro-value').text(formatIndianCurrency(Math.abs(difference)));  // Update R/O

        // Update amount in words directly
        $('#amount-in-words').text('INR ' + ucfirst(numberToWords(roundTotal)));  // Update amount in words
    }

   
    // Add a new row to the table
    $('#add-row-btn').on('click', function() {
        const newRow = `
            <tr class="rent extra">
                <input type="hidden" name="item_type[]" class="item_type" value="extra">
                <td><input type="text" class="form-control" name="description[]" placeholder="Enter description" /></td>
                <td><input type="number" class="form-control quantity" name="quantity[]" placeholder="0" /></td>
                <td><input type="number" class="form-control rate" name="rate[]" placeholder="0" /></td>
                <td></td>
                <td><input type="number" class="form-control amount" name="amount[]" readonly /></td>
                <td><a type="button" class="remove-row-btn">X</a></td>
            </tr>`;
        $('#invoice-rows').append(newRow);
    });

    // Calculate the amount when quantity and rate change
    $(document).on('keyup change', '.quantity, .rate', function() {
        updateTotals();  // Update totals whenever a row changes
    });

    // Remove the row when the remove button is clicked
    $(document).on('click', '.remove-row-btn', function() {
        $(this).closest('tr').remove();
        updateTotals();  // Update totals when a row is removed
    });

    // Helper function to capitalize the first letter of a string
    function ucfirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});



$('#save-invoice-btn').on('click', function(e) {
        e.preventDefault(); // Prevent form from submitting the traditional way
        // Prepare data to send
        let invoiceData = [];
        $('#invoice-rows tr').each(function(index) {
            const row = $(this);
            const description = row.find('input[name="description[]"]').val();
            const quantity = parseFloat(row.find('input[name="quantity[]"]').val()) || 1;
            const rate = parseFloat(row.find('input[name="rate[]"]').val()) || 0;
            const amount = parseFloat(row.find('input[name="amount[]"]').val()) || 0;
            const item_type = row.find('input[name="item_type[]"]').val();
          
            
            if (description && rate) {
                invoiceData.push({
                    description: description,
                    quantity: quantity,
                    rate: rate,
                    amount: amount,
                    item_type: item_type
                });
            }
        });

        // Send the data via AJAX to the server to save the invoice
        $.ajax({
            url: '{{ route("invoices.save") }}', // Define the route for saving the invoice
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', 
                invoiceData: invoiceData,    
                total: $('#total-value').text(), 
                roundOff: $('#ro-value').text(),  
                id: '{{ $data->id }}',  // Send round-off amount
                is_gst: '{{ $data->is_gst }}',  // Send round-off amount
            },
            success: function(response) {
      
                toastr.success(response.message || "Invoice Updated successfully!");
        
                  window.location.reload();
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

      
  </script>

   <!--  <script type="text/javascript">
      
      (function () {
        window.print();
      })();
    </script>  --> 

@endsection