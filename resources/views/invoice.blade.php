<!DOCTYPE html>
<html lang="en">
	<head>


<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>A simple, clean, and responsive HTML invoice template</title>

<!-- Favicon -->
<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

<!-- Invoice styling -->
<style>
	
  
  body {
    position: relative;
    margin: 0 auto;
    color: #555555;
    background: #FFFFFF;
    font-family: Arial, sans-serif;
    font-size: 15px;
}

header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #AAAAAA;
}

.d-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-start; /* Align items to the start of the cross axis */
}

.party-name, .invoice-details {
    flex: 1; /* Allow each section to take up equal space */
}

.party-name {
    text-align: left;
}

.invoice-details {
    text-align: right;
}

.text-right {
    text-align: right;
    padding-right: 15px;
    margin-right: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
}

table th, table td {
    padding: 20px;
    text-align: center;
    border: 1px solid #AAAAAA;
    background: transparent;
}

table th {
    white-space: nowrap;
    font-weight: normal;
}

table td {
    text-align: right;
}

table td h3 {
    color: #ffad33;
    font-size: 1.2em;
    font-weight: normal;
    margin: 0 0 0.2em 0;
}

table .no {
    color: #FFFFFF;
    font-size: 1.6em;
    background: transparent;
}

table .desc {
    text-align: left;
}

table .unit {
    background: transparent;
}

table .total {
    color: #FFFFFF;
    background: transparent;
}

table td.unit, table td.qty, table td.total {
    font-size: 1.2em;
}

table tbody tr:last-child td {
    border: none;
}

table tfoot td {
    padding: 10px 20px;
    background: transparent;
    border-bottom: 1px solid #AAAAAA;
    font-size: 1.2em;
    white-space: nowrap;
    border-top: 1px solid #AAAAAA;
}

table tfoot tr:first-child td {
    border-top: none;
}

table tfoot tr:last-child td {
    color: #ffad33;
    font-size: 1.4em;
    border-top: 1px solid #ffad33;
}

table tfoot tr td:first-child {
    border: none;
}

.dt-complex-header {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.dt-complex-header th, .dt-complex-header tbody td {
    padding: 20px;
    text-align: center;
    border: 1px solid #AAAAAA;
}

.dt-complex-header th {
    background-color: #f4f4f4;
}

.dt-complex-header tfoot td {
    font-weight: bold;
    border-top: 2px solid #AAAAAA;
    padding-top: 20px;
}

.dt-complex-header thead th, .dt-complex-header tfoot td {
    border-bottom: 2px solid #AAAAAA;
}



footer {
    color: #777777;
    width: 100%;
    height: 30px;
    position: absolute;
    bottom: 0;
    border-top: 1px solid #AAAAAA;
    padding: 8px 0;
    text-align: center;
}

.amount-in-words {
    font-size: 1.0em;
    font-weight: bold;
    text-align: right;
    padding: 10px;
    background-color: #f4f4f4;
    border-top: 2px solid #AAAAAA;
}

.justify-content-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
}

 .multi-line-address {
    display: block;
    white-space: pre-line; /* Allows line breaks in the content */
}
.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.invoice-number {
    text-align: right;
}
@media print {
    /* Print-specific styles */
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
}
		</style>
	</head>
	<body>
@php $paymentDueTerms = $data->lease->due_on ;   
$invoiceDate = $data->invoice_date;
$invoiceDateObject = new \DateTime($invoiceDate);
$due_on = $invoiceDateObject->modify('+' . $paymentDueTerms . ' days');
$partner_per = $data->partner_per;
$partner_type = $data->partner_type;
@endphp
	<div class="row invoice-preview">
	  <!-- Invoice -->

	  <div class="">
	    <div class="card invoice-preview-card">
	      <div class="card-body">
	        <div class="header-content">
	          <div class="header-brand">
	            <a class="" href="{{url('/')}}" class="app-brand-link">
	              <img src="{{url('/')}}/assets/uploads/property-management-1724824115.jpg" class="" alt="{{$appSetting->app_name}}">
	            </a> 
	            <p class="mb-2 multi-line-address">{{ $appSetting->address}}</p>
	            <p class="mb-0">(+91) {{ $appSetting->mobile_no}}</p>
	          </div>
	          <div class="invoice-number">
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
	        <div class="d-flex justify-content-between header-content">
	          <div class=" party-name"  >
	            <h6 class="mb-3">Party Name:</h6>
	            <p class="mb-1">{{ $data->partner->first_name }} {{ $data->partner->last_name }}</p>
	            <p class="mb-1 multi-line-address">{{ $data->partner->postal_address }}</p>
	            <p class="mb-1">{{ $data->partner->mobile }}</p>
	            <p class="mb-0">{{ $data->tenant->email }}</p>
	            <p class="mb-0">GSTIN/UIN: {{ $data->partner->gst_no }}</p>
	          </div>
	          <div class="invoice-details text-right" >
	            <h6 class="mb-3">Invoice To:</h6>
	            <p class="mb-1">{{ $data->tenant->full_name }}({{ $data->tenant->firm_name }})</p>
	            <p class="mb-1 multi-line-address">{{ $data->tenant->business_address }}</p>
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
	             
	              <td class="text-nowrap"><b>{{ $rent->item_desc }}</b></td>
	             
	              <td class="text-nowrap">{{ $rent->quantity }}</td>
	               @if($key+1==1)
	              <td class="text-nowrap"> {{ $rate }} {{ $persign }}</td>
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
	           

	         
	          @php  $TotalInwords = getIndianCurrency($roundof); @endphp
	       
	          <tr>
			      <td colspan="8" class="amount-in-words">
			        <b>Amount Chargeable (in words):</b> INR {{ ucfirst($TotalInwords) }}
			      </td>
			    </tr>
	          
	          </tbody>
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
	            <tr class="rent">
	             <td>997212</td>
	              <td>{{ formatIndianCurrency($total_amount) }}</td>
	              <td>{{ $data->rent_cgst_per }} %</td>
	               <td>{{ formatIndianCurrency($cgst) }}</td>
	              <td>{{ $data->rent_sgst_per }} %</td>
	              <td>{{ formatIndianCurrency($sgst) }}</td>
	               <td>{{ formatIndianCurrency($gstTotal) }}</td>
	          
	         
	          @php  $TotalGstInwords = getIndianCurrency(round($gstTotal,0)); @endphp
	          
	             <tr class="rent">
	              <td><b>{{ __('Total') }}</b></td>
	              <td><b>{{ formatIndianCurrency($total_amount) }}</b></td>
	              <td></td>
	              <td><b>{{ formatIndianCurrency($cgst) }}</b></td>
	              <td></td>
	              <td><b>{{ formatIndianCurrency($sgst) }}</b></td>
	              <td><b>{{ formatIndianCurrency($gstTotal) }}</b></td>
	              
	           </tr>
	            <tr>
			      <td colspan="8" class="amount-in-words">
			        <b>Tax Amount (in words):</b> INR {{ ucfirst($TotalGstInwords) }}
			      </td>
			    </tr>
			    
	          
	         </tbody>
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
       
</body>
</html>