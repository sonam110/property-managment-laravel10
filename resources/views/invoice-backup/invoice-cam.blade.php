
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>    
    <link href='https://fonts.googleapis.com/css?family=Source Sans Pro' rel='stylesheet'>
    <style type="text/css">


.clearfix:after {
  content: "";
  display: table;
  clear: both;
}
a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 100%;
  max-width: 21cm; /* Width of an A4 page */
  margin: 0 auto;
 /* color: #555555;
  background: #FFFFFF; */
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: Source Sans Pro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 20px;
}
#details1 {
  margin-bottom: 20px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
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
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
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
  background: #ffad33;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #ffad33;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
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
.currency-symbol {
    font-family: 'Arial', sans-serif; /* Ensure font supports the ₹ symbol */
}

.currency {
    text-align: right;
}

.currency-amount {
    font-size: 1.2em;
    font-weight: bold;
}

.currency-symbol::before {
    content: "₹";
    font-size: 1.2em;
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
    <header class="clearfix">
      <div id="logo">
        <img src="https://www.nrtsms.com/assets/img/nrt-sms.png">
      </div>
      <div id="company">
        <h2 class="name">{{ $appSetting->app_name}}</h2>
        <div>{{ $appSetting->address}},<br> India</div>
        <div>M : (+91) {{ $appSetting->mobile_no}} | E : <a href="{!! $appSetting->email !!}">{{ $appSetting->email}}</a></div>  
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">PARTY NAME:</div>
          <h2 class="name">{{ $data->partner->first_name }} {{ $data->partner->last_name }}</h2>
          <div class="address">{{ $data->partner->postal_address }}</div>
          <div class="phone">{{ $data->partner->mobile }}</div>
          <div class="email"><a href="{!!$data->partner->email !!}">{!!$data->partner->email !!}</a></div>
          <div class="gst">GSTIN/UIN: {{ $data->partner->gst_no }}</div>
        </div>
        <div id="invoice">
          <h4>INVOICE #{{ $data->invoice_no}}</h4>
          <div class="date">Invoice Date:  {{ date('M d,Y',strtotime($data->invoice_date)) }}</div>
          <div class="date">Delivery Note   </div>
          <div class="date">Reference No. & Date.  </div>
         
        </div>
      </div>
      <div id="details1" class="clearfix">
        <div id="client">
          <div class="to">INVOICE TO:</div>
          <h2 class="name">{{ $data->tenant->full_name }}({{ $data->tenant->firm_name }})</h2>
          <div class="address"> {{ $data->tenant->business_address }}</div>
          <div class="phone"> {{ $data->tenant->phone }}</div>
          <div class="email"><a href="{!!$data->tenant->email !!}">{!!$data->tenant->email !!}</a></div>
          <div class="gst">GSTIN/UIN: {{ $data->tenant->gst_no }}</div>
        </div>
        <div id="invoice">
          
          <div class="date">Due Date:  {{ $due_on->format('M d,Y') }} </div>
         <div class="date">Buyer's Order No.  </div>
          <div class="date">Terms of Delivery  </div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
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
                $amount = $rent->amount;
                $totalRent += $amount; 

                $roundof = round($totalRent, $precision = 0, $mode = PHP_ROUND_HALF_UP);
                $difference = $totalRent - $roundof;


              ?>
              <tr class="rent">
               
                <td class="text-nowrap"><b>{{ $rent->item_desc }}</b></td>
               
                <td class="text-nowrap">{{ $rent->quantity }}</td>
                 @if($key+1==1)
                <td class="text-nowrap"> {{ $rent->rate }} </td>
                 @else
                 <td class="text-nowrap">{{ $rent->rate }} %</td>
                @endif
                <td>{{($key+1==1) ? 'Month' :'' }}</td>
              
                <td> {{ formatIndianCurrencyPdf($amount) }}</td>
              </tr>
             
             
              @endforeach
               <tr class="rent">
                <td><b>{{ __('R/O') }}</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b>{{ formatIndianCurrencyPdf(abs($difference)) }}</b></td>
                
             </tr>
               <tr class="rent">
                <td></td>
                <td></td>
                <td></td>
                <td><b>{{ __('Total') }}</b></td>
                <td><b>{{ formatIndianCurrencyPdf($roundof) }}</b></td>
                
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
                $total_amount = $data->cam_total;
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
                <td>{{ formatIndianCurrencyPdf($total_amount) }}</td>
                <td>{{ $data->cam_cgst_per }} %</td>
                 <td>{{ formatIndianCurrencyPdf($cgst) }}</td>
                <td>{{ $data->cam_sgst_per }} %</td>
                <td>{{ formatIndianCurrencyPdf($sgst) }}</td>
                 <td>{{ formatIndianCurrencyPdf($gstTotal) }}</td>
            
           
            @php  $TotalGstInwords = getIndianCurrency(round($gstTotal,0)); @endphp
            
               <tr class="rent">
                <td><b>{{ __('Total') }}</b></td>
                <td><b>{{ formatIndianCurrencyPdf($total_amount) }}</b></td>
                <td></td>
                <td><b>{{ formatIndianCurrencyPdf($cgst) }}</b></td>
                <td></td>
                <td><b>{{ formatIndianCurrencyPdf($sgst) }}</b></td>
                <td><b>{{ formatIndianCurrencyPdf($gstTotal) }}</b></td>
                
             </tr>
              <tr>
            <td colspan="8" class="amount-in-words">
              <b>Tax Amount (in words):</b> INR {{ ucfirst($TotalGstInwords) }}
            </td>
          </tr>
          
            
           </tbody>
          </table>
          @endif
      <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
         <div class="notice">{{ $appSetting->invoice_disclaimer }}</div> 
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>