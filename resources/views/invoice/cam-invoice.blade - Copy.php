@extends('layouts.master')
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
                      <h6 class="mb-3">Invoice To:</h6>
                      <p class="mb-1">{{ $data->tenant->full_name }}</p>
                      <p class="mb-1">{{ $data->tenant->firm_name }}</p>
                      <p class="mb-1">{{ $data->tenant->business_address }}</p>
                      <p class="mb-1">{{ $data->tenant->phone }}</p>
                      <p class="mb-0">{{ $data->tenant->email }}</p>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                      <h6 class="mb-4">Bill To:</h6>
                      <table>
                        <tbody>
                          <tr>
                            <td class="pe-4">Total Due:</td>
                            <td class="fw-medium"><i class="ti ti-currency-rupee ti-xs me-2"></i> {{ $data->grand_total }}</td>
                          </tr>
                          <tr>
                            <td class="pe-4">GST NO:</td>
                            <td>{{ $data->tenant->gst_no }}</td>
                          </tr>
                          <tr>
                            <td class="pe-4">PAN NO:</td>
                            <td>{{ $data->tenant->pan_no }}</td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="table-responsive border-top">
                  <table class="table m-0 datatables-basic table dataTable">
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
                      @php $totalRent += $rent->amount; 
                      $persign =  ($key+1==1) ? '' :'%' ;
                      @endphp
                      <tr class="rent">
                        @if($key+1==1)
                        <td class="text-nowrap"><b>{{ $rent->item_desc }}</b></td>
                        @else
                         <td class="text-nowrap">{{ $rent->item_desc }}</td>
                        @endif
                        <td class="text-nowrap">{{ $rent->quantity }}</td>
                        <td class="text-nowrap"> {{ $rent->rate }} {{$persign}}</td>
                        <td>{{($key+1==1) ? 'Month' :'' }}</td>
                      
                        <td> {{ $rent->amount }}</td>
                      </tr>
                      @endforeach
                       <tr class="rent">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{ __('Total') }}</b></td>
                        <td><b><i class="ti ti-currency-rupee ti-xs me-2"></i>{{ $totalRent }}</b></td>
                        
                     </tr>
                      @foreach($cam_invoices as $key =>  $rent)
                      @php $totalRent += $rent->amount; 
                      $camTotal += $rent->amount; 
                      $persign =  ($key+1==1) ? '' :'%' ;
                      @endphp
                      <tr class="cam">
                        @if($key+1==1)
                        <td class="text-nowrap"><b>{{ $rent->item_desc }}</b></td>
                        @else
                         <td class="text-nowrap">{{ $rent->item_desc }}</td>
                        @endif
                        <td class="text-nowrap">{{ $rent->quantity }}</td>
                        <td class="text-nowrap"> {{ $rent->rate }} {{$persign}}</td>
                        <td>{{($key+1==1) ? 'Month' :'' }}</td>
                      
                        <td> {{ $rent->amount }}</td>
                      </tr>
                      @endforeach
                      <tr class="cam">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{ __('Total') }}</b></td>
                        <td><b><i class="ti ti-currency-rupee ti-xs me-2"></i>{{ $camTotal }}</b></td>
                        
                     </tr>
                    </tbody>
                    @php  $TotalInwords = $numberTransformer->toWords($totalRent); @endphp
                  <tfoot>
                      <tr>
                       
                        <td colspan="1"><b>{{ __(' Grand Total') }}</b></td>
                        <td colspan="4"><b><i class="ti ti-currency-rupee ti-xs me-2"></i>{{ $totalRent }}</b></td>
                        
                    </tr>
                     <tr>
                       
                        <td colspan="1"><b>Amount Chargeable (in words):</b></td>
                        <td colspan="5"><b>{{ ucfirst($TotalInwords) }}</b></td>
                        
                    </tr>
                    </tfoot>
                  </table>
                  <br>
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
                        <td>{{ $data->rent_total }}</td>
                        <td>{{ $data->rent_cgst_per }} %</td>
                         <td>{{ $data->rent_cgst_amount }}</td>
                        <td>{{ $data->rent_sgst_per }} %</td>
                        <td>{{ $data->rent_sgst_amount }}</td>
                        <td>{{ $data->rent_cgst_amount +  $data->rent_sgst_amount }}</td>
                     <tr class="cam">
                      <tr>
                       <td>CAM</td>
                        <td>{{ $data->cam_total }}</td>
                        <td>{{ $data->cam_cgst_per }} %</td>
                         <td>{{ $data->cam_cgst_amount }}</td>
                        <td>{{ $data->cam_sgst_per }} %</td>
                        <td>{{ $data->cam_sgst_amount }}</td>
                        <td>{{ $data->rentcam_cgst_amount +  $data->cam_sgst_amount }}</td>
                     <tr>
                    </tbody>
                    @php  $TotalGstInwords = $numberTransformer->toWords($data->rent_cgst_amount +  $data->rent_sgst_amount+ $data->cam_cgst_amount +  $data->cam_sgst_amount); @endphp
                    <tfoot>
                      <tr>
                        <td><b>Total</b></td>
                        <td>{{ $data->rent_total+$data->cam_total }}</td>
                        <td></td>
                        <td><b>{{ $data->rent_cgst_amount+$data->cam_cgst_amount }}</b></td>
                        <td></td>
                        <td><b>{{ $data->rent_sgst_amount+$data->cam_sgst_amount }}</b></td>
                        <td><b>{{ $data->rent_cgst_amount +  $data->rent_sgst_amount+ $data->cam_cgst_amount +  $data->cam_sgst_amount  }}</b></td>
                        
                    </tr>
                     <tr>
                       
                        <td colspan="2"><b>Tax Amount ( (in words):</b></td>
                        <td colspan="4"><b>{{ ucfirst($TotalGstInwords) }}</b></td>
                        
                    </tr>
                    </tfoot>
                  
                  </table>

                   <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Service Description</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($utility_invoices as $utility)
                      @php $utilityTotal += $utility->amount; @endphp
                      <tr>
                       <td>{{ $utility->item_desc}}</td>
                       <td>1</td>
                      <td>{{ $utility->amount}}</td>
                     </tr>
                     @endforeach
                    </tbody>
                    @php  $TotalUtilityInwords = $numberTransformer->toWords($utilityTotal); @endphp
                    <tfoot>
                       <tr>
                        <td></td>
                        <td><b>{{ __('Total') }}</b></td>
                        <td><b><i class="ti ti-currency-rupee ti-xs me-2"></i>{{ $utilityTotal }}</b></td>
                        
                    </tr>
                     <tr>
                       
                        <td colspan="2"><b>Utility Chargeable ( (in words):</b></td>
                        <td colspan="4"><b>{{ ucfirst($TotalUtilityInwords) }}</b></td>
                        
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
      We have generated a new invoice in the amount of <i class="ti ti-currency-rupee ti-xs me-2"></i> 95.59
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