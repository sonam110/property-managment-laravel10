<html>
   <head>
      <meta content="text/html; charset=UTF-8" http-equiv="content-type" />\
      <style type="text/css">
         #invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:2mm;
  margin: 0 auto;
  width: 44mm;
  background: #FFF;
  
  }
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}
 
#top, #mid,#bot{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}

#top{min-height: 100px;}
#mid{min-height: 80px;} 
#bot{ min-height: 50px;}

#top .logo{
  //float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
	background-size: 60px 60px;
}
.clientlogo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  //float:left;
  margin-left: 0;
}
.title{
  float: right;
}
.title p{text-align: right;} 
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  //padding: 5px 0 5px 15px;
  //border: 1px solid #EEE
}
.tabletitle{
  //padding: 5px;
  font-size: .5em;
  background: #EEE;
}
.service{border-bottom: 1px solid #EEE;}
.item{width: 24mm;}
.itemtext{font-size: .5em;}

#legalcopy{
  margin-top: 5mm;
}

  
  
}

      </style>
  </head>

    <body >
  <div id="invoice-POS">
    
    <center id="top">
      <div class=""><a class="header-brand" href="{{url('/')}}" class="app-brand-link">
              <img src="{{url('/')}}/{{ $appSetting->app_logo}}" class="" alt="{{$appSetting->app_name}}">
            </a> </div>
      <div class="info"> 
        <h2>Signature Group</h2>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <h2>Contact Info</h2>
        <p> 
            Address : {{ $appSetting->address}}/br>
            Email   : {{ $appSetting->email}}</br>
            Phone   : {{ $appSetting->mobile_no}}</br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Item</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
								<td class="Rate"><h2>Sub Total</h2></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">{{ ucfirst(@$payment->invoice->invoice_type) }}-Charges</p></td>
								<td class="tableitem"><p class="itemtext">1</p></td>
								<td class="tableitem"><p class="itemtext">{{ formatIndianCurrencyPdf($payment->amount) }}</p></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total Paid </h2></td>
								<td class="payment"><h2>{{ formatIndianCurrencyPdf($payment->amount) }}</h2></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Remaining Amount</h2></td>
								<td class="payment"><h2>{{ formatIndianCurrencyPdf($payment->remaining_amount) }}</h2></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total </h2></td>
								<td class="payment"><h2>{{ formatIndianCurrencyPdf($payment->grand_total) }}</h2></td>
							</tr>
							

							

						</table>
					</div><!--End Table-->

					<div id="legalcopy">
						<p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. 
						</p>
					</div>

				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->
  </body>
  </html>
