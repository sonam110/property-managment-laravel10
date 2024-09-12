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
@section('content')
@php $paymentDueTerms = $data->lease->due_on ;   
$invoiceDate = $data->invoice_date;
$invoiceDateObject = new \DateTime($invoiceDate);
$due_on = $invoiceDateObject->modify('+' . $paymentDueTerms . ' days');
$partner_per = $data->partner_per;
$partner_type = $data->partner_type;
@endphp
<div class="row invoice-preview">
 <div class="card">
    <div class="card-body">
      <button
        class="btn btn-primary"
        data-bs-toggle="offcanvas"
        data-bs-target="#sendInvoiceOffcanvas">
        <span class="d-flex align-items-center justify-content-center text-nowrap"
          ><i class="ti ti-send ti-xs me-2"></i>Send Invoice</span
        >
      </button>
      <button class="btn btn-label-secondary">Download</button>
      <a
        class="btn btn-label-secondary"
        target="_blank"
        href="{{ route('invoice-view',$data->id)}}">
        Print
      </a>
      <a href="./app-invoice-edit.html" class="btn btn-label-secondary">
        Edit Invoice
      </a>
      <button
        class="btn btn-primary"
        data-bs-toggle="offcanvas"
        data-bs-target="#addPaymentOffcanvas">
        <span class="d-flex align-items-center justify-content-center text-nowrap"
          ><i class="ti ti-currency-rupee ti-xs me-2"></i>Add Payment</span
        >
      </button>
    </div>
  </div>
<div>
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
                      @foreach($cam_invoices as $key =>  $rent)
                      <?php 
                        $amount = $rent->amount;
                        $totalRent += $amount; 

                        $roundof = round($totalRent, $precision = 0, $mode = PHP_ROUND_HALF_UP);
                        $difference = $totalRent - $roundof;


                      ?>
                      <tr class="rent">
                       
                        <td class="text-nowrap"><b>{{ $rent->item_desc }}</b></td>
                       
                        <td class="text-nowrap">{{ $rent->quantity }}</td>
                         @if($key+1==1)
                        <td class="text-nowrap"> {{ $rent->rate }}</td>
                         @else
                         <td class="text-nowrap">{{ $rent->rate }} %</td>
                        @endif
                        <td>{{($key+1==1) ? 'Month' :'' }}</td>
                      
                        <td> {{ formatIndianCurrency($amount) }}</td>
                      </tr>
                     
                     
                      @endforeach
                       <tr class="rent">
                        <td><b>{{ __('R/O') }}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{ formatIndianCurrency(abs($difference)) }}</b></td>
                        
                     </tr>
                       <tr class="rent">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{ __('Total') }}</b></td>
                        <td><b>{{ formatIndianCurrency($roundof) }}</b></td>
                        
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
                        $total_amount = $data->cam_total ;
                        $cgst = ($total_amount*$data->cam_cgst_per)/100;
                        $sgst = ($total_amount*$data->cam_sgst_per)/100;

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

                      <tr class="rent">
                       <td>997212</td>
                        <td>{{ formatIndianCurrency($total_amount) }}</td>
                        <td>{{ $data->cam_cgst_per }} %</td>
                         <td>{{ formatIndianCurrency($cgst) }}</td>
                        <td>{{ $data->cam_sgst_per }} %</td>
                        <td>{{ formatIndianCurrency($sgst) }}</td>
                         <td>{{ formatIndianCurrency($gstTotal) }}</td>
                    
                    </tbody>
                    @php  $TotalGstInwords = getIndianCurrency(round($gstTotal,0)); @endphp
                    <tfoot>
                     <tr>
                        <td><strong>{{ __('Total') }}</strong></td>
                        <td><strong>{{ formatIndianCurrency($total_amount) }}</strong></td>
                        <td></td>
                        <td><strong>{{ formatIndianCurrency($cgst) }}</strong></td>
                        <td></td>
                        <td><strong>{{ formatIndianCurrency($sgst) }}</strong></td>
                        <td><strong>{{ formatIndianCurrency($gstTotal) }}</strong></td>
                        
                     </tr>
                     <tr>
                       
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
                <p class="fw-medium mb-0"><i class="ti ti-currency-rupee ti-xs me-2"></i> 5000.00</p>
              </div>
              <form>
                <div class="mb-3">
                  <label class="form-label" for="invoiceAmount">Payment Amount</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-currency-rupee ti-xs me-2"></i> </span>
                    <input
                      type="text"
                      id="invoiceAmount"
                      name="invoiceAmount"
                      class="form-control invoice-amount"
                      placeholder="100" />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment-date">Payment Date</label>
                  <input id="payment-date" class="form-control invoice-date" type="text" />
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment-method">Payment Method</label>
                  <select class="form-select" id="payment-method">
                    <option value="" selected disabled>Select payment method</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Credit Card">Credit Card</option>

                  </select>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="payment-note">Internal Payment Note</label>
                  <textarea class="form-control" id="payment-note" rows="2"></textarea>
                </div>
                <div class="mb-3 d-flex flex-wrap">
                  <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Add Payment Sidebar -->

          <!-- /Offcanvas -->
@endsection
@section('extrajs')     
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
  <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
   <!--  <script type="text/javascript">
      
      (function () {
        window.print();
      })();
    </script>  --> 

@endsection