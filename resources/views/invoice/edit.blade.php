@extends('layouts.master')
@section('extracss')
 <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css')}}" />
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
                      @php 
                      $totalRent += $rent->amount; 
                      $persign =  ($key+1==1) ? '' :'' ;
                      @endphp
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
                            class="form-control invoice-item-price mb-3"
                            value="{{ $rent->quantity }}"
                            placeholder="quantity"
                            min="0"
                          /></td>
                          @else
                          <td></td>
                          @endif
                        <td class="text-nowrap"><input
                                    type="number"
                                    name="rate[]"
                                    class="form-control invoice-item-price mb-3"
                                    value="{{ $rent->rate }}"
                                    placeholder="Rate"
                                    min="1" />  {{$persign}}</td>
                        <td>{{($key+1==1) ? 'Month' :'' }}</td>
                      
                        <td> <input
                         type="number"
                            name="amount[]"
                            class="form-control invoice-item-price mb-3"
                            value="{{ $rent->amount }}"
                            placeholder="Amount"
                            min="0"
                          /></td>
                      </tr>
                      @endforeach
                       <tr class="rent">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{ __('Total') }}</b></td>
                        <td><b><i class="ti ti-currency-rupee ti-xs me-2"></i>{{ $totalRent }}</b></td>
                        
                     </tr>
                      @foreach($cam_invoices as $key =>  $cam)
                      @php $totalRent += $cam->amount; 
                      $camTotal += $cam->amount; 
                      $persign =  ($key+1==1) ? '' :'' ;
                      @endphp
                      <tr class="cam">
                        <td class="text-nowrap"> <input
                          type="text"
                          name="item_desc[]"
                          class="form-control"
                          value="{{ $cam->item_desc }}"
                          placeholder="Item Description"
                          /></td>
                           @if($key+1==1)
                         <td> <input
                         type="number"
                            name="quantity[]"
                            class="form-control invoice-item-price mb-3"
                            value="{{ $cam->quantity }}"
                            placeholder="quantity"
                            min="0"
                          /></td>
                          @else
                          <td></td>
                          @endif
                         <td> <input
                         type="number"
                            name="rate[]"
                            class="form-control invoice-item-price mb-3"
                            value="{{ $cam->rate }}"
                            placeholder="Amount"
                            min="0"
                          /></td>
                        <td>{{($key+1==1) ? 'Month' :'' }}</td>
                      
                        <td>  <input
                         type="number"
                            name="amount[]"
                            class="form-control invoice-item-price mb-3"
                            value="{{ $cam->amount }}"
                            placeholder="Amount"
                            min="0"
                          /></td>
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
                        <td colspan="5"><b>{{ $TotalInwords }}</b></td>
                        
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
                        <td colspan="4"><b>{{ $TotalGstInwords }}</b></td>
                        
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
                        <td colspan="4"><b>{{ $TotalUtilityInwords }}</b></td>
                        
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

         
@endsection
@section('extrajs')     
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
  <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
      <script src="{{ asset('assets/js/app-invoice-edit.js') }}"></script>
   <!--  <script type="text/javascript">
      
      (function () {
        window.print();
      })();
    </script>  --> 

@endsection