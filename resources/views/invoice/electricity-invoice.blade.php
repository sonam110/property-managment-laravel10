@extends('layouts.master')
@section('extracss')
<style type="text/css">
 .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }
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
              <div class="card invoice-preview-card">
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
                  Reimbursement of Electric Consumption
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
                <td colspan="5" rowspan="1"  style="text-align: center; border-right: 1px solid;"> <b>Rupees In Words :INR {{ ucfirst($TotalInwords) }} Only</b>
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
            <?php
                  $tenants_units = (!empty(@$data->TenantPropertyUtility->tenants_units)) ? json_decode($data->TenantPropertyUtility->tenants_units, true): NULL;
                  $tenantConsumption = NULL;
                  foreach($tenants_units as $unit) {
                      if ($unit['tenant_id'] == $data->tenant_id) {
                          $tenantConsumption = $unit['no_units_consume'];
                          break;
                      }
                  }
             ?>
             <tr class="rent">
               
                <td class="text-nowrap text-left"><b>Total Unit Consume</b></td>
               
                <td class="text-nowrap text-right">{{ @$tenantConsumption }}</td>
           
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
               
                <td class="text-nowrap text-left"><b>PF Incentive</b></td>
               
                <td class="text-nowrap text-right">{{ @$data->TenantPropertyUtility->pf_incentive }}</td>
           
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
                <td> {{ (!empty($bankdata)) ? $bankdata->bank_address: NULL ; }},{{ (!empty($bankdata)) ? $bankdata->bank_ifsc_code : NULL ; }}</td>


            </tr>
        </table>

       
         <footer style="text-align: center;">
          
        </footer>

    </div>
              </div>
            </div>
            <!-- /Invoice -->

           
          </div>

          <!-- Offcanvas -->
        

          <!-- Add Payment Sidebar -->
           @php  $invoiceBalance = (!empty($data->remaining_amount)) ? $data->remaining_amount : formatIndianCurrency($roundof)   @endphp
          @include('invoice.payment-sidebar')
          <!-- /Add Payment Sidebar -->

          <!-- /Offcanvas -->
@endsection
@section('extrajs')     
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>

   <!--  <script type="text/javascript">
      
      (function () {
        window.print();
      })();
    </script>  --> 
 <script>
 $(document).on('click','#downloadPdfButton',function() {
      var id = '{{ $data->id }}'; 
      var type =  'Utility'; 
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
            if(value=='print'){
              var printWindow = window.open(pdfUrl, '_blank');
              printWindow.onload = function() {
              printWindow.print();
              };
            } else{
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
@endsection