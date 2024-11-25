@php $paymentDueTerms = $data->lease->due_on ;   
$invoiceDate = $data->invoice_date;
$invoiceDateObject = new \DateTime($invoiceDate);
$due_on = $invoiceDateObject->modify('+' . $paymentDueTerms . ' days');
$partner_per = $data->partner_per;
$partner_type = $data->partner_type;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .invoice-container {
            width: 100%;
            margin: 0 auto;
            padding: 0;
            border: 1px solid #000;
        }

        h4, p {
            margin: 0;
            padding: 0;
        }
         table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Ensures equal column widths */
        }

        td {
            border: 1px solid #000; /* Optional: For visual clarity */
            padding: 8px;
            vertical-align: top;
        }
        .left-column, .right-column {
            width: 50%;
        }


        .section h4, .section p {
            margin: 0;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            color: #00338d;
            padding: 10px 0;
        }

        .section {
            padding: 0;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
        }

        .section td, .section th {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }

        .header-table th {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }
        .party-details h4 {
            margin-bottom: 5px; /* Adds a small gap below the PARTY NAME */
        }
        .party-details p {
            margin-bottom: 5px; /* Adds a small gap below each paragraph */
        }

        .footer {
            text-align: center;
            font-size: 10px;
            padding: 5px 0;
        }

        .invoice-details, .bank-details, .declaration {
            border: 1px solid #000;
            padding: 0;
        }

        .bank-details td {
            padding: 5px;
        }

        .bank-details .remarks {
            border-left: 1px solid #000;
        }
        .no-border {
        border: none !important;  /* Removes the borders for these specific cells */
        }

        .signature-space {
            padding-top: 50px !important;  /* Adds space for the signature */
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">INVOICE</div>

            <div class="section">
                <table>
                    <tr>
                        <td rowspan="7" colspan="4" class="left-column">
                           <div class="party-details">
                            <h4>PARTY NAME: {{ $data->partner->first_name }} {{ $data->partner->last_name }}</h4>
                            <p>Address: {{ $data->partner->postal_address }}</p>
                            <p>GSTIN/UIN: {{ $data->partner->gst_no }}</p>
                            <p>State Name: MADHYA PRADESH</p>
                        </div>
                        </td>
                        <td colspan="2">Invoice No: #{{ $data->invoice_no }}</td>
                        <td colspan="2">Dated: {{ date('M d, Y', strtotime($data->invoice_date)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Delivery Note:</td>
                        <td colspan="2">Mode/Terms of Payment:</td>
                    </tr>
                    <tr>
                        <td colspan="2">Reference No. & Date:</td>
                        <td colspan="2">Due Date: {{ $due_on->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Buyer's Order No.:</td>
                        <td colspan="2">Dated:</td>
                    </tr>
                    <tr>
                        <td colspan="2">Dispatch Doc No.:</td>
                        <td colspan="2">Delivery Note Date:</td>
                    </tr>
                    <tr>
                        <td colspan="2">Dispatched Through:</td>
                        <td colspan="2">Destination:</td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <table>
                    <tr>
                        <!-- Left Side: Consignee and Buyer Details (Split into two parts) -->
                        <td class="left-column">
                            <div class="party-details">
                                <p><strong>Consignee (Ship to):</strong></p>
                                <h4>{{ $data->tenant->full_name }} ({{ $data->tenant->firm_name }})</h4>
                                <p>Address: {{ $data->tenant->business_address }}</p>
                                <p>GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
                                <p>State Name: MADHYA PRADESH</p>
                            </div>
                            <hr>
                            <div class="party-details">
                                <p><strong>Buyer (Bill to):</strong></p>
                                <h4>{{ $data->tenant->full_name }} ({{ $data->tenant->firm_name }})</h4>
                                <p>Address: {{ $data->tenant->business_address }}</p>
                                <p>GSTIN/UIN: {{ $data->tenant->gst_no }}</p>
                                <p>State Name: MADHYA PRADESH</p>
                            </div>
                        </td>

                        <!-- Right Side: Terms of Delivery -->
                        <td  colspan="2" class="right-column">
                            <strong>Terms of Delivery:</strong>
                        
                        </td>
                    </tr>
                </table>
            </div>

        <div class="section">
            <table>
                <tr>
                    <th>Description of Services</th>
                    <th>HSN/SAC</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Per</th>
                    <th>Amount (₹)</th>
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
                $persign = '%';
                $roundof = round($totalRent, $precision = 0, $mode = PHP_ROUND_HALF_UP);
                $difference = $totalRent - $roundof;
                if($rent->item_type=='extra'){
                    $persign = '';
                }


              ?>
                <tr>
                    <td class="text-left"><b>{{ $rent->item_desc }}</b></td>
                     @if($key+1==1)
                    <td class="text-right">997212</td>
                     @else
                     <td class="text-right"></td>
                     @endif
                    <td class="text-right">{{ $rent->quantity }}</td>
                    <td class="text-nowrap text-right" style="text-align: right;">{{ $rent->rate }}</td>
                   
                    <td class="text-right">{{($key+1==1) ? 'Month' :'' }}</td>
                  
                    <td class="text-right"> {{ formatIndianCurrencyPdf($amount) }}</td>
                
                </tr>
                 @endforeach
                 <tr class="rent">
                    <td class="text-right"><b>{{ __('R/O') }}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right" ><b>{{ formatIndianCurrencyPdf(abs($difference)) }}</b></td>
                    
                 </tr>
                <tr>
                    <td colspan="5" class="text-right bold">Total</td>
                    <td class="text-right bold">{{ formatIndianCurrencyPdf($roundof) }}</td>
                </tr>
            </table>
        </div>
         <div class="section">
         @php  $TotalInwords = getIndianCurrency($roundof); @endphp
         <table>
             <tr>
                <td colspan="5" rowspan="1" class="text-center" > <b>Amount Chargeable (in words) :INR {{ ucfirst($TotalInwords) }}</b>
                </td>
               
            </tr>
            
         </table>
        </div>
           
        <div class="bank-details section">
            <table>
                <tr>
                    <!-- Left Side: Company's PAN -->
                    <td rowspan="5" style="width: 50%; vertical-align: top;">
                        <p>Remarks:<p><br>
                        <strong>Company's PAN:</strong> {{ $data->partner->pan_no  }}
                    </td>

                    <!-- Right Side: Company's Bank Details -->
                    <td colspan="2"><strong>Company's Bank Details</strong></td>
                </tr>
                <tr>
                    <td>A/c Holder's Name:</td>
                    <td>{{ $data->partner->account_holder_name  }}</td>
                </tr>
                <tr>
                    <td>Bank Name:</td>
                    <td>{{ $data->partner->bank_name  }}</td>
                </tr>
                <tr>
                    <td>A/c No.:</td>
                    <td>{{ $data->partner->account_no  }}</td>
                </tr>
                <tr>
                    <td>Branch & IFS Code:</td>
                    <td> {{ $data->partner->bank_address  }},{{ $data->partner->bank_ifsc_code  }}</td>
                </tr>
            </table>
        </div>
        <div class="bank-details section">
            <table >
                <tr>
                   
                    <td rowspan="2"  class="text-center">
                        <p><strong>Declaration:</strong></p><br>
                        <p>We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</p>
                    </td>
                    <!-- Right Side: For Company -->
                    <td class="text-left" class="no-border">
                        <p >For {{ $data->partner->first_name }} {{ $data->partner->last_name }}</p>
                    </td>
                </tr>
                <tr >
                    
                    <td rowspan="2"   class="no-border signature-space">
                        <p class="text-left">Does not require signature.</p>
                       
                    </td>
                    <td  class="no-border signature-space">
                       
                        <strong  class="text-right">Authorised Signatory</strong>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>SUBJECT TO BHOPAL JURISDICTION</p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>
</html>
