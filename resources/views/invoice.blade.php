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
    width: 21cm;  
    margin: 0 auto; 
    color: #555555;
    background: #FFFFFF; 
    font-family: Arial, sans-serif; 
    font-size: 14px; 
    font-family: Source Sans Pro;
  }
  
  header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #AAAAAA;
  }
  
 
.d-flex {
    display: flex;
    justify-content: space-between;
}

.party-name {
    width: 50%; /* Adjust width as needed */
}

.invoice-details {
    width: 50%; /* Adjust width as needed */
    text-align: right;
}

  
 table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
}

table th,
table td {
    padding: 20px;
    text-align: center;
    border: 1px solid #AAAAAA; /* Add border color */
    background: transparent; /* Remove background color */
}

table th {
    white-space: nowrap;
    font-weight: normal;
}

table td {
    text-align: right;
}

table td h3{
    color: #ffad33;
    font-size: 1.2em;
    font-weight: normal;
    margin: 0 0 0.2em 0;
}

table .no {
    color: #FFFFFF;
    font-size: 1.6em;
    background: transparent; /* Remove background color */
}

table .desc {
    text-align: left;
}

table .unit {
    background: transparent; /* Remove background color */
}

table .total {
    color: #FFFFFF;
    background: transparent; /* Remove background color */
}

table td.unit,
table td.qty,
table td.total {
    font-size: 1.2em;
}

table tbody tr:last-child td {
    border: none; /* Remove bottom border for last row */
}

table tfoot td {
    padding: 10px 20px;
    background: transparent; /* Remove background color */
    border-bottom: 1px solid #AAAAAA; /* Add border */
    font-size: 1.2em;
    white-space: nowrap;
    border-top: 1px solid #AAAAAA; /* Add border */
}

table tfoot tr:first-child td {
    border-top: none;
}

table tfoot tr:last-child td {
    color: #ffad33;
    font-size: 1.4em;
    border-top: 1px solid #ffad33; /* Add border */
}

table tfoot tr td:first-child {
    border: none;
}
.dt-complex-header {
    width: 100%;
    border-collapse: collapse; /* Ensures that borders between cells are not doubled */
    margin-bottom: 20px;
}

.dt-complex-header th,
.dt-complex-header tbody td {
    padding: 20px;
    text-align: center;
    border: 1px solid #AAAAAA; /* Border color and style for cells */
}

.dt-complex-header th {
    background-color: #f4f4f4; /* Light grey background for header cells */
}

.dt-complex-header tfoot td {
    font-weight: bold;
    border-top: 2px solid #AAAAAA; /* Border on top of footer cells */
    padding-top: 20px;
}

.dt-complex-header thead th,
.dt-complex-header tfoot td {
    border-bottom: 2px solid #AAAAAA; /* Border at the bottom of header and footer cells */
}


  
  #thanks{
    font-size: 2em;
    margin-bottom: 50px;
  }
  
  #notices{
    padding-left: 6px;
    border-left: 6px solid #0087C3;  
  }
  
  #notices .notice {
    font-size: 1.2em;
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
  /* Styling for amount in words section */
.amount-in-words {
    font-size: 1.0em;
    font-weight: bold;
    text-align: right; /* Align to right or center based on your preference */
    padding: 10px;
    background-color: #f4f4f4; /* Light background color for emphasis */
    border-top: 2px solid #AAAAAA; /* Add a top border to separate from the table above */
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
	        <div class="d-flex justify-content-between">
	          <div class=" party-name"  >
	            <h6 class="mb-3">Party Name:</h6>
	            <p class="mb-1">{{ $data->partner->first_name }} {{ $data->partner->last_name }}</p>
	            <p class="mb-1">{{ $data->partner->postal_address }}</p>
	            <p class="mb-1">{{ $data->partner->mobile }}</p>
	            <p class="mb-0">{{ $data->tenant->email }}</p>
	            <p class="mb-0">GSTIN/UIN: {{ $data->partner->gst_no }}</p>
	          </div>
	          <div class="invoice-details text-right" >
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