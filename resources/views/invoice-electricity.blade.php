<html>
     <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
         <style type="text/css">
        .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #fff;
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
          <header class="clearfix">
                  <div id="company">
                    <h3 class="name" style="text-align: center; margin-right: 25px">
                         {{ $appSetting->app_name }}
                    </h3>
                    <p  style="text-align: center;">Office Add-  {{ $appSetting->address }}</p>
                  </div>
            </header>
       
         <table style="width: 100%; border-collapse: collapse; border: 1px solid black;vertical-align: top;">
            <tr>
               
                <td style="text-align: center; font-size:20px;line-height: 40px !important">
                  INVOICE
                </td>
                
                
            </tr>
            <tr>
                <td style="text-align: center;line-height: 40px !important;">
               This Invoice is issued in terms of Section 23 of Central Goods & Service Tax Act, 2017
                </td>
            </tr>

        </table>
       <table style="width: 100%; border-collapse: collapse; border: 1px solid black; vertical-align: top; line-height: 25px;">
            <tr>
                <!-- Party Details on the Left -->
                <td colspan="4" >
                    <h4>INVOICE NO : #{{ $data->invoice_no }}</h4>
                    <p>Gst Registration No : {{ $data->partner->gst_no }}</p>
                    <p>Category of Service : Category of Service    Utility Service for Electricity charges of immovable property </p>
                </td>
                <td colspan="4" >
                    <h4>DATE :{{ date('M d, Y', strtotime($data->invoice_date)) }}</h4>
                    <p>DUE DATE: {{ $due_on->format('M d, Y') }}</p>
                   
                </td>
                
            </tr>
           
         
         <tr>
            <tr style="width: 100%; border-collapse: collapse; border: 1px solid black; vertical-align: top; line-height: 25px;">
                <!-- Party Details on the Left -->
                <td colspan="4" >
                   <p><strong>To:</strong></p>
                    <h4>{{ $data->tenant->full_name }} ({{ $data->tenant->firm_name }})</h4>
                    <p>Address: {{ $data->tenant->business_address }}</p>
                </td>
                <td colspan="4" >
                     <p>Customer GST Registration No.: {{ $data->tenant->gst_no }}</p>
                   
                </td>
                
            </tr>
           
         
        </table>
    
       <table class="info-border ">
            <tr>
               
                <th style="text-align: left;">Particulars </th>
                <th style="text-align: left;">Quantity</th>
                <th style="text-align: left;">Rate</th>
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
               
                <td class="text-nowrap text-left"><b>{{ $rent->item_desc }}</b></td>
               
                <td class="text-nowrap text-right">{{ $rent->quantity }}</td>
                <td class="text-nowrap text-right">{{ $rent->rate }}</td>
                <td class="text-right"> {{ formatIndianCurrencyPdf($amount) }}</td>
              </tr>
             
             
              @endforeach
               <tr class="rent">
                <td class="text-left"><b>{{ __('R/O') }}</b></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf(abs($difference)) }}</b></td>
                
             </tr>
               

            <tr style="border-top: 1px solid;">
                <td colspan="3" style="text-align: right; border-top: 1px solid;"> <b>Total</b> </td>
                <td colspan="1"  style="text-align: right; border-top: 1px solid;" class="text-right"><b>{{ formatIndianCurrencyPdf($roundof) }}</b></td>
                
               
                
            </tr>

           

        </table>
         @php  $TotalInwords = getIndianCurrency($roundof); @endphp
         <table style="border-collapse: collapse;">
               <tr>
                <td colspan="5" rowspan="1"  style="text-align: center; border-right: 1px solid;"> <b>Rupees In Words :INR :INR {{ ucfirst($TotalInwords) }}</b>
                </td>
               
            </tr>
            <tr colspan="2" style="text-align: center; border-right: 1px solid;">
                
                <td style="text-align: center;"><b></b></td>
            </tr>

            

        </table>
         
         <table class="info-border ">
            <tr>
               
                <th style="text-align: left;">Computation of energy Charge </th>
                <th style="text-align: left;">Unit/Amount</th>
               
                
            </tr>
             
              <tr class="rent">
               
                <td class="text-nowrap text-left"><b>Energy Charge</b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->energy_charge }}</td>
           
              </tr>
               <tr class="rent">
               
                <td class="text-nowrap text-left"><b>FPPAS</b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->fppas }}</td>
           
              </tr>
               <tr class="rent">
               
                <td class="text-nowrap text-left"><b>ENERGY Duty</b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->energy_duty }}</td>
           
              </tr>
               <tr class="rent">
               
                <td class="text-nowrap text-left"><b>TOD(Net Sum)</b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->tod_net_sum }}</td>
           
              </tr>
              <tr class="rent">
               
                <td class="text-nowrap text-left"><b>Total energy charge</b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->energy_charge_as_per_bill }}</td>
           
              </tr>
              <tr class="rent">
               
                <td class="text-nowrap text-left"><b>Net Per Unit Rate </b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->energy_unit_per_unit }}</td>
           
              </tr>

        </table>
        <table>
           
            <tr>
                <td>N.B. :- Please Make RTGS of {{ formatIndianCurrencyPdf($roundof) }}/ - in favour of “{{ $data->partner->first_name }} {{ $data->partner->last_name }}”          </td>
                <td style="font-size: 12px; text-align: center;  border-left: 1px solid;"><b> {{ $data->partner->first_name }} {{ $data->partner->last_name }}</b></td>

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

       
         <footer style="text-align: center;">
          
        </footer>

    </div>

    </body>
</html>
