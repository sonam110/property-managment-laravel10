@extends('layouts.master')
@section('extracss')
<style type="text/css">
 .top_rw {
            background-color: #f4f4f4;
        }

        .td_w {}

        button {
            padding: 5px 10px;
            font-size: 12px;
        }
        h4 {
            font-size: 12px;
        }
        .invoice-box {
            max-width: 890px;
            margin: auto;
            padding: 0px;
            border: 1px solid #eee;
            font-size: 11px !important;
            line-height: 18px  !important;
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
            padding: 11px !important;
            vertical-align: top !important;
        }
        .text-left {
            text-align: left!important;
        }

        .text-right {
            text-align: right!important;
        }


</style>
@endsection
@section('page-title')
{{ __('Manage Invoice') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('invoice')}}">{{__('Invoice Management')}}</a></li>
<li class="breadcrumb-item">{{__('Invoices')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="{{ url()->previous() }}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
@endsection
@section('content')
@php $paymentDueTerms = $data->lease->due_on ;   
$invoiceDate = $data->invoice_date;
$invoiceDateObject = new \DateTime($invoiceDate);
$due_on = $invoiceDateObject->modify('+' . $paymentDueTerms . ' days');
$partner_per = $data->partner_per;
$partner_type = $data->partner_type;
$bankdata = (!empty(partnetBankDetail(@$data->partner->id,$data->invoice_type))) ? partnetBankDetail(@$data->partner->id,$data->invoice_type) : NULL;
@endphp

 @include('invoice.invoice-head')

<div class="row invoice-preview">
  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-4">
  
 <div class="invoice-preview-card">
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
               
                <th>Name of Product / Service </th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>PER</th>
                <th>Amount</th>
                
            </tr>
            @php $totalRent =0; 
                $camTotal =0;
                $utilityTotal =0;
                $difference =0;
                $roundof =0;
              @endphp
              @foreach($rent_invoices as $key =>  $rent)
              <?php 
                if($partner_type=='1')
                {
                  $amount = $rent->amount;
                  $rate = 'Fixed';
                  $persign = '';
                } else{
                  $amount = $rent->amount;
                  $rate = $rent->rate.'*'.$partner_per;
                  $persign = '%';
                }
                if($rent->item_type=='extra'){
                    $persign = '';
                }
                $totalRent += $amount; 

                $roundof = round($totalRent, $precision = 0, $mode = PHP_ROUND_HALF_UP);
                $difference = $totalRent - $roundof;


              ?>
              <tr class="rent">
              
                <td class="text-left"><b>{{ $rent->item_desc }}</b></td>
               
                <td class="text-right">{{ $rent->quantity }}</td>
                 @if($key+1==1)
                <td class="text-right"> {{ $rate }} {{ $persign }}</td>
                 @else
                 <td class="text-right">{{ $rent->rate }} {{ $persign }}</td>
                @endif
                <td >{{($key+1==1) ? 'Month' :'' }}</td>
              
                <td class="text-right"> {{ formatIndianCurrencyPdf($amount) }}</td>
              </tr>
             
             
              @endforeach
               <tr class="rent">
                <td class="text-left"><b>{{ __('R/O') }}</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf(abs($difference)) }}</b></td>
                
             </tr>
               

            <tr style="border-top: 1px solid;">
                <td colspan="4" style="text-align: right; border-top: 1px solid;"> <b>Total</b> </td>
                <td colspan="1"   style="text-align: right; border-top: 1px solid;" class="text-right"><b>{{ formatIndianCurrencyPdf($roundof) }}</b></td>
                
               
                
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
               <td class="text-left">997212</td>
                <td class="text-right">{{ formatIndianCurrencyPdf($total_amount) }}</td>
                <td class="text-right">{{ $data->rent_cgst_per }} %</td>
                 <td class="text-right">{{ formatIndianCurrencyPdf($cgst) }}</td>
                <td class="text-right">{{ $data->rent_sgst_per }} %</td>
                <td class="text-right">{{ formatIndianCurrencyPdf($sgst) }}</td>
                 <td class="text-right">{{ formatIndianCurrencyPdf($gstTotal) }}</td>
            
           
            @php  $TotalGstInwords = getIndianCurrency(round($gstTotal,0)); @endphp
            
               <tr class="rent">
                <td class="text-left"><b>Total</b></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($total_amount) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($cgst) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($sgst) }}</b></td>
                <td class="text-right"><b>{{ formatIndianCurrencyPdf($gstTotal) }}</b></td>
                
             </tr>

           </tbody>
          </table>
           <table style="border: 1px solid black; ">
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
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
                <td colspan="2"> Remarks: {{ $data->partner->id}} </td>

            </tr>

            <tr>
                <td>A/c Holder's Name:</td>
                <td>{{ (!empty($bankdata)) ? $bankdata->account_holder_name : NULL;  }}</td>
                <td style="text-align: right;border-left: 1px solid;"></td>
                <td style="text-align: right;">(E & O.E.)</td>
            </tr>

            <tr>
                <td>Bank Name:</td>
                <td>{{ (!empty($bankdata)) ? $bankdata->bank_name : NULL;  }}</td>    
                <td rowspan="3" style=" border-left: 1px solid;"><b>Company's PAN : {{ $data->partner->pan_no  }}</b></td>
                <td rowspan="3" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>A/c No.:</td>
                <td> {{ (!empty($bankdata)) ? $bankdata->account_no : NULL; }}</td>
            </tr>

            <tr>
                <td>Branch & IFS Code:</td>
                <td>   {{ (!empty($bankdata)) ? $bankdata->bank_address: NULL ; }},{{ (!empty($bankdata)) ? $bankdata->bank_ifsc_code : NULL ; }}</td>


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
        <footer style="text-align: center;">
          <small> SUBJECT TO BHOPAL JURISDICTION</small><br>
          <small>Invoice was created on a computer and is valid without the signature and seal</small>
        </footer>

    </div>
  </div>
  </div>
  <!-- /Invoice -->

 
</div>

          <!-- Offcanvas -->
          <!-- Send Invoice Sidebar -->
         
          <!-- /Send Invoice Sidebar -->

          <!-- Add Payment Sidebar -->
           @php  $invoiceBalance = (!empty($data->remaining_amount)) ? $data->remaining_amount : formatIndianCurrency($roundof)   @endphp
             @include('invoice.payment-sidebar')

          <!-- /Add Payment Sidebar -->

          <!-- /Offcanvas -->
@endsection
@section('extrajs')     
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
  <script>
   
    $(document).on('click','#downloadPdfButton',function() {
      var id = '{{ $data->id }}'; 
      var type =  'Rent'; 
      var value = $(this).data('ttype');
     // console.log(value);

      $.ajax({
          url: appurl + "download-pdf",
          type: "post",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          data: { id: id,type:type },
           success: function(response) {
            var pdfUrl = response.pdfUrl; 
            if (value == 'print') {
                var printWindow = window.open(pdfUrl, '_blank');
                printWindow.onload = function() {
                    printWindow.print();
                };
            } else {
                var link = document.createElement('a');
                link.href = pdfUrl;
                link.download = pdfUrl.split('/').pop();
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
          },
          
          error: function(xhr, status, error) {
              console.error('Error:', error);
          }
      });
    });

    $(document).ready(function() {
        // Attach a submit event handler to the form
       $('.submitForm').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var formData = new FormData();
            formData.append('id', '{{ $data->id }}'); 
            formData.append('type', '{{ $data->invoice_type }}');
            formData.append('grand_total', '{{ $roundof }}');
            formData.append('totalAmount', '{{ $invoiceBalance }}');
            formData.append('invoiceAmount', $('#invoiceAmount').val());
            formData.append('paymentDate', $('#payment-date').val());
            formData.append('paymentStatus', $('#payment-status').val());
            formData.append('paymentMethod', $('#payment-method').val());
            formData.append('paymentNote', $('#payment-note').val());
            formData.append('reference_no', $('#reference_no').val());
            formData.append('type', $(this).data('type'));

            // Append the file input (if any)
            var fileInput = $('#payment_image')[0].files[0];  // Get the selected file
            if (fileInput) {
                formData.append('payment_image', fileInput);
            }
            

            $.ajax({
                url: appurl+'add-payment', // Replace with your endpoint URL
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                processData: false,
                contentType: false, 
                success: function(response) {
                    // Handle the response from the server
                     toastr.success(response.message || "Payment Added successfully!");
                    $('#addPaymentOffcanvas').offcanvas('hide'); // Hide the offcanvas
                    // Optionally, you might want to clear the form or update other parts of the UI
                    window.location.reload();
                },
                error: function(xhr) {
                  const errors = xhr.responseJSON.errors;
                  let errorMessage = '';

                  if (errors) {
                      $.each(errors, function(key, messages) {
                          errorMessage += messages.join('<br>') + '<br>';
                      });

                  } else {
                      errorMessage = "An unexpected error occurred.";
                  }
                  
                  toastr.error(errorMessage);
              }
            });
        });
    });


  $(document).ready(function() {
        // Function to format the number as Indian currency
        function formatIndianCurrency(amount) {
            if (isNaN(amount)) return '0';
            return amount.toLocaleString('en-IN', { style: 'currency', currency: 'INR' });
        }

        // Get the invoice balance from the text
        var invoiceBalance = parseFloat($('.invoice-balance').text().replace(/[^0-9.-]+/g, '')) || 0;

        // Event handler for keyup event on the invoiceAmount input field
        $('#invoiceAmount').on('keyup', function() {
            // Get the current payment amount
            var paymentAmount = parseFloat($(this).val().replace(/[^0-9.-]+/g, '')) || 0;

            // Calculate the remaining balance
            var remainingBalance = invoiceBalance - paymentAmount;
            if (paymentAmount > invoiceBalance) {
            $('#invoiceAmount').val(formatIndianCurrency(0));
            $('.remaining').text(formatIndianCurrency(0));
            $('.warning').text('Payment amount exceeds invoice balance.').show();
            } else {
                $('.remaining').text(formatIndianCurrency(remainingBalance));
                $('.warning').hide();
            }

            // Update the remaining balance
            $('.remaining').text(formatIndianCurrency(remainingBalance));
        });
    });

      
  </script>

   <!--  <script type="text/javascript">
      
      (function () {
        window.print();
      })();
    </script>  --> 

@endsection