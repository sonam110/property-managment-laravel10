<html>
     <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
         <style type="text/css">
        
         body {
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: opensanscondensed;
           font-size: 12px;
          }
           table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            overflow: hidden;
            border: #00338d 3px solid;

          }

          table td,
          table th {
            /*border-top: 1px solid #ecf0f1;*/
            padding: 2px;
          }

        .invoice-box {
           /*padding: 10px 20px !important;*/
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


        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding-right: 5px;
        }

        .td_td{
          border: 1px solid black !important;
          vertical-align: top !important;
          padding:10px;
        }
        .text-left {
            text-align: left!important;
        }

        .text-right {
            text-align: right!important;
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
       
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black;vertical-align: top;;">
            <tr>
               
                <td style="text-align: center; color: darkblue;line-height: 18px !important">
                    {{ ($data->is_gst=='1') ?'TAX' :''}} INVOICE 
                </td>
                
            </tr>

        </table>

       <table style="width: 100%; border-collapse: collapse; border: 1px solid black; vertical-align: top; line-height: 25px;">
            <tr>
                <!-- Party Details on the Left -->
                <td colspan="2" rowspan="7" style="width: 60%; border: 1px solid black; vertical-align: top;">
                    <h4>PARTY NAME: {{ $data->partner->first_name }} {{ $data->partner->last_name }}</h4>
                    <p>Address: {{ $data->partner->postal_address }}</p>
                    <p>GSTIN/UIN: {{ $data->partner->gst_no }}</p>
                    <p>State Name: MADHYA PRADESH</p>
                </td>
                
                <!-- Invoice Details on the Right -->
                <td style="width: 20%; border: 1px solid black; vertical-align: top;">
                    <p>Invoice No: #{{ $data->invoice_no }}</p>
                </td>
                <td style="width: 20%; border: 1px solid black; vertical-align: top;">
                    <p>Dated: {{ date('M d, Y', strtotime($data->invoice_date)) }}</p>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Delivery Note:</p>
                </td>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Mode/Terms of Payment:</p>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Reference No. & Date:</p>
                </td>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Due Date: {{ $due_on->format('M d, Y') }}</p>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Buyer's Order No.:</p>
                </td>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Dated:</p>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Dispatch Doc No.:</p>
                </td>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Delivery Note Date:</p>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Dispatched Through:</p>
                </td>
                <td style="border: 1px solid black; vertical-align: top;">
                    <p>Destination:</p>
                </td>
            </tr>
           
          <tr>
         <tr>
            <!-- Consignee (Ship to) and Buyer (Bill to) on the Left -->
            <td colspan="2" style="width: 60%; text-align: left; border: 1px solid black; vertical-align: top;">
                <p><strong>Consignee (Ship to):</strong></p>
                <h4>{{ $data->tenant->full_name }} ({{ $data->tenant->firm_name }})</h4>
                <p>Address: {{ $data->tenant->business_address }}</p>
                <p>GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
                <p>State Name: MADHYA PRADESH</p>
                <hr>
                <p><strong>Buyer (Bill to):</strong></p>
                <h4>{{ $data->tenant->full_name }} ({{ $data->tenant->firm_name }})</h4>
                <p>Address: {{ $data->tenant->company_address ?? $data->tenant->business_address }}</p>
                <p>GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
                <p>State Name: MADHYA PRADESH</p>
            </td>
            
            <!-- Terms of Delivery on the Right -->
            <td colspan="2" style="width: 40%; text-align: left; border: 1px solid black; vertical-align: top;">
                Terms of Delivery
               
            </td>
        </tr>



        </table>
    
        <table class="info-border ">
            <tr>
               
                <th style="text-align: left;">Name of Product / Service </th>
                <th style="text-align: left;">Quantity</th>
                <th style="text-align: left;">Rate</th>
                <th style="text-align: left;">PER</th>
                <th style="text-align: left;">Amount</th>
                
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
               
                <td class="text-nowrap text-left" style="text-align: left;"><b>{{ $rent->item_desc }}</b></td>
               
                <td class="text-nowrap text-right" style="text-align: right;">{{ $rent->quantity }}</td>
                <td class="text-nowrap text-right" style="text-align: right;">{{ $rent->rate }}</td>
                <td>{{($key+1==1) ? 'Month' :'' }}</td>
              
                <td class="text-right" style="text-align: right;"> {{ formatIndianCurrencyPdf($amount) }}</td>
              </tr>
             
             
              @endforeach
               <tr class="rent">
                <td class="text-left" style="text-align: left;"><b>{{ __('R/O') }}</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right" style="text-align: right;"><b>{{ formatIndianCurrencyPdf(abs($difference)) }}</b></td>
                
             </tr>
               

            <tr style="border-top: 1px solid;">
                <td colspan="4" style="text-align: right; border-top: 1px solid;"> <b>Total</b> </td>
                <td colspan="1"  style="text-align: right; border-top: 1px solid;" class="text-right"><b>{{ formatIndianCurrencyPdf($roundof) }}</b></td>
                
               
                
            </tr>

           

        </table>
         @php  $TotalInwords = getIndianCurrency($roundof); @endphp
         <table style="border-collapse: collapse;">
               <tr>
                <td colspan="5" rowspan="1"  style="text-align: center; border-right: 1px solid;"> <b>Amount Chargeable (in words) :INR {{ ucfirst($TotalInwords) }}</b>
                </td>
               
            </tr>
            <tr colspan="2" style="text-align: center; border-right: 1px solid;">
                
                <td style="text-align: center;"><b></b></td>
            </tr>

            

        </table>
          <?php 
                $total_amount = $totalRent;
                $cgst = ($total_amount*9)/100;
                $sgst = ($total_amount*9)/100;

                $gstTotal = $cgst+$sgst;
              ?>
          @if($data->is_gst=='1')
         
         <!--  <table class="info-border">
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
               <td class="text-left">997212</td>
                <td class="text-right">{{ formatIndianCurrencyPdf($total_amount) }}</td>
                <td class="text-right">{{ $data->cam_cgst_per }} %</td>
                 <td class="text-right">{{ formatIndianCurrencyPdf($cgst) }}</td>
                <td class="text-right">{{ $data->cam_sgst_per }} %</td>
                <td class="text-right">{{ formatIndianCurrencyPdf($sgst) }}</td>
                 <td class="text-right">{{ formatIndianCurrencyPdf($gstTotal) }}</td>
            
           
            @php  $TotalGstInwords = getIndianCurrency(round($gstTotal,0)); @endphp
            
               <tr class="rent">
                <td class="text-left"><b>{{ __('Total') }}</b></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($total_amount) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($cgst) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($sgst) }}</b></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($gstTotal) }}</b></td>
                
             </tr>

           </tbody>
          </table> -->
           <!-- <table style="border-collapse: collapse;">
            
            <tr>
                <td colspan="5" rowspan="2" style="text-align: center; "><b>Tax Amount (in words): INR {{ ucfirst($TotalGstInwords) }}</b>
                </td>
                
            </tr>
            <tr colspan="2" style="text-align: center; border-right: 1px solid;">
                
                <td style="text-align: center;"><b></b></td>
            </tr>
        </table> -->
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
          <footer style="text-align: center;">
          <small> SUBJECT TO BHOPAL JURISDICTION</small><br>
          <small>Invoice was created on a computer and is valid without the signature and seal</small>
        </footer>

    </div>

    </body>
</html>
