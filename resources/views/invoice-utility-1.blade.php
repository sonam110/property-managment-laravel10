<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
        <style type="text/css">

        .top_rw {
            background-color: #f4f4f4;
        }

        .td_w {}

        button {
            padding: 5px 10px;
            font-size: 12px;
        }

        .invoice-box {
            max-width: 890px;
            margin: auto;
            padding: 10px;
            border: 1px solid #eee;
            font-size: 11px;
            line-height: 18px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box td {
            border: none;
            vertical-align: top;
        }

        .invoice-box-border {
            border: 1px solid;
            vertical-align: top;
        }


        .invoice-box table {
           /* border: 1px solid black;*/
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-bottom: solid 1px black;
        }

        .invoice-box table td {
            padding-left: 5px;
            vertical-align: middle;
        }

        .info-border {
            border-collapse: collapse;
        }

        .info-border tr:first-child td {
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-left: 1px solid black;
            border-bottom: 1px solid black;
            /* Added bottom border */
        }

        .info-border tr:first-child td {
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-left: 1px solid black;
        }

        .info-border td {
            padding: 4px;
            text-align: center;
            border-right: 1px solid black;
            border-left: 1px solid black;
        }


        .info-border td {
            padding: 4px;
            text-align: center;
            border-right: 1px solid black;
            border-left: 1px solid black;
        }



        .invoice-box table tr.top table td {
            padding-bottom: 1px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            font-size: 12px;
        }


        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding-right: 5px;
        }

        .td_td{
          border: 1px solid black !important;
            padding: 18px !important;
            width: 55% !important;
            vertical-align: top !important;
        }

        </style>
    </head>

    <body >
         @php $paymentDueTerms = $data->lease->due_on ;   
$invoiceDate = $data->invoice_date;
$invoiceDateObject = new \DateTime($invoiceDate);
$due_on = $invoiceDateObject->modify('+' . $paymentDueTerms . ' days');
$partner_per = $data->partner_per;
$partner_type = $data->partner_type;
@endphp
        <div class="invoice-box">
        <table class="invoice-box">
            <tr>
                <td colspan="3">
                    <h1 style="text-align: left; padding-left: 5px;">Signature Group</h1>
                </td>
            </tr>
            <tr>
                <td>
                   {{ $appSetting->address}} <br>
                   India <br> 
                   GSTIN/UIN :  {{ $appSetting->gst_no}} 
                </td>
                <td style="text-align: right; padding-right: 20px;">
                    Mobile No. (+91) {{ $appSetting->mobile_no}} <br>
                    <br>
                    E-Mail :{{ $appSetting->email}}
                </td>
                <!-- <td>
                    <img src="{{url('/')}}/{{ $appSetting->app_logo}}" class="" alt="{{$appSetting->app_name}}" width="70" height="70">

                </td> -->
            </tr>
        </table>
        <table>
            <tr>
               
                <td style="text-align: center; color: darkblue;">
                    <h1 style="margin-top: 16px">TAX INVOICE </h1>
                </td>
                
            </tr>

        </table>
        <table>
            <tr>
                <td style="text-align: left; border: 1px solid;" colspan="1">
                    <h4>PARTY NAME:{{ $data->partner->first_name }} {{ $data->partner->last_name }}</h4>
                    <p>Address: {{ $data->partner->postal_address }}</p>
                    <p>GSTIN/UIN: {{ $data->partner->gst_no }}</p>
                    <p>State Name : MADHYA PRADESH</p>
                </td>
                <td colspan="4">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                        <tr>
                            <td class="td_td">
                                <p style="margin: 0;">Invoice No: #{{ $data->invoice_no }}</p>
                            </td>
                            <td class="td_td">
                                <p style="margin: 0;">Dated: {{ date('M d, Y', strtotime($data->invoice_date)) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_td">
                                <p style="margin: 0;">Delivery Note: &nbsp;&nbsp;&nbsp;</p>
                            </td>
                            <td class="td_td">
                                <p style="margin: 0;">Mode/Terms of Payment &nbsp;&nbsp;&nbsp;</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_td">
                                <p style="margin: 0;">Due Date: {{ $due_on->format('M d,Y') }}</p>
                            </td>
                            <td class="td_td">
                                <p style="margin: 0;">Reference No. & Date.</p>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
             <tr>
                <td style="text-align: left; border: 1px solid;" colspan="1">
                    <p>Consignee (Ship to)</p>
                    <h4>{{ $data->tenant->full_name }}({{ $data->tenant->firm_name }})</h4>
                    <p>Address: {{ $data->tenant->business_address }}</p>
                    <p>GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
                    <p>State Name : MADHYA PRADESH</p>
                </td>
                <td colspan="4"> 
                          <p>Buyer (Bill to)</p>
                    <h4>{{ $data->tenant->full_name }}({{ $data->tenant->firm_name }})</h4>
                    <p>Address: {{ (!empty($data->tenant->company_address)) ? $data->tenant->company_address : $data->tenant->business_address  }}</p>
                    <p>GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
                    <p>State Name : MADHYA PRADESH</p>
                </td>

            </tr>
           
            
        </table>
        <table style="border: 1px solid black; ">
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>

        <table class="info-border ">
            <tr>
               
                <td>Name of Product / Service </td>
                <th>Quantity</th>
                <th>PER</th>
                <th>Amount</th>
                
            </tr>
              @php $totalRent =0; 
                $camTotal =0;
                $utilityTotal =0;
                $roundof =0;
                $difference =0;
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
                <td>{{($key+1==1) ? 'Month' :'' }}</td>
              
                <td> {{ formatIndianCurrencyPdf($amount) }}</td>
              </tr>
             
             
              @endforeach
               <tr class="rent">
                <td><b>{{ __('R/O') }}</b></td>
                <td></td>
                <td></td>
                <td><b>{{ formatIndianCurrencyPdf(abs($difference)) }}</b></td>
                
             </tr>
               

            <tr style="border-top: 1px solid;">
                <td colspan="2" style="text-align: right; border-top: 1px solid;"> <b>Total</b> </td>
                <td colspan="2"><b>{{ formatIndianCurrencyPdf($roundof) }}</b></td>
                
               
                
            </tr>

           

        </table>
         @php  $TotalInwords = getIndianCurrency($roundof); @endphp
         <table style="border-collapse: collapse;">
             <tr>
                <td colspan="2" style="text-align: center; border-right: 1px solid;"> <b>Amount Chargeable (in words) :INR {{ ucfirst($TotalInwords) }}</b>
                </td>
               
            </tr>
            <tr>
                <td colspan="2"  style="text-align: center; border-right: 1px solid;">
                    &nbsp;
                </td>
                
            </tr>

            

        </table>
          <?php 
                $total_amount = $totalRent;
                $cgst = ($total_amount*9)/100;
                $sgst = ($total_amount*9)/100;

                $gstTotal = $cgst+$sgst;
              ?>
          @if($data->is_gst=='1')
         
          <table class="info-border">
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

           </tbody>
          </table>
           <table style="border-collapse: collapse;">
            
            <tr>
                <td colspan="5" rowspan="2" style="text-align: center; "><b>Tax Amount (in words): INR {{ ucfirst($TotalGstInwords) }}</b>
                </td>
                
            </tr>
            <tr colspan="2" style="text-align: center; border-right: 1px solid;">
                
                <td style="text-align: center;"><b></b></td>
            </tr>
        </table>
          @endif
          
        <table style="border-collapse: collapse;">
           

            <tr style="border-bottom: 1px solid;">
                <td colspan="2" style="text-align: center; border-right: 1px solid;">  Company's Bank Details </td>
                <td colspan="2"> Remarks: </td>

            </tr>

            <tr>
                <td>A/c Holder's Name:</td>
                <td>{{ $data->partner->account_holder_name  }}</td>
                <td style="text-align: right;border-left: 1px solid;"></td>
                <td style="text-align: right;">(E & O.E.)</td>
            </tr>

            <tr>
                <td>Bank Name:</td>
                <td>{{ $data->partner->bank_name  }}</td>    
                <td rowspan="3" style=" border-left: 1px solid;"><b>Company's PAN : {{ $data->partner->pan_no  }}</b></td>
                <td rowspan="3" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>A/c No.:</td>
                <td> {{ $data->partner->account_no  }}</td>
            </tr>

            <tr>
                <td>Branch & IFS Code:</td>
                <td>   {{ $data->partner->bank_address  }},{{ $data->partner->bank_ifsc_code  }}</td>


            </tr>
        </table>

        <table>
            <tr>
                <td style="text-align: center; border-bottom: 1px solid;">
                    <h4> Declaration: </h4>
                </td>
                <td  style="text-align: center; font-size: 10px;  border-left: 1px solid;">
                    Certified that the particulars given above are true and correct.
                </td>


            </tr>


            <tr>
                <td>{{ $appSetting->invoice_disclaimer }} </td>
                <td style="font-size: 14px; text-align: center;  border-left: 1px solid;"><b> {{ $data->partner->first_name }} {{ $data->partner->last_name }}</b></td>

            </tr>

            <tr>
                <td>&nbsp;</td>
                <td  rowspan="3" style="border: 1px solid;"></td>
            </tr>
            <tr>
                <td >&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center; border-left: 1px solid;"><b> Authorised Signatory</b>
                </td>
            </tr>

        </table>
         <footer>
           
          Invoice was created on a computer and is valid without the signature and seal.
        </footer>

    </div>

    </body>
</html>
