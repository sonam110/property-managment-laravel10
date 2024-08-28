<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .invoice-header {
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        .section h2 {
            margin-top: 0;
            font-size: 20px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            font-size: 18px;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{url('/')}}/{{ $appSetting->app_logo}}" alt="{{$appSetting->app_name}}">
            <p>Company Name:{{ $appSetting->app_name }}</p>
            <p>{{ $appSetting->address }}</p>
            <p>Phone: {{ $appSetting->mobile_no }}</p>
            <p>Email: {{ $appSetting->email }}</p>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <h1>Lease </h1>
            <p>Date: {{ date('Y-m-d') }}</p>
            <p>Invoice #: {{ $invoice_number }}</p>
        </div>

       

        <!-- To Section -->
        <div class="section">
            <h2>To</h2>
            <p><strong>{{ @$lease->tenant->firm_name }}</strong></p>
            <p>{{  @$lease->tenant->phone }}</p>
            <p>Phone: {{  @$lease->tenant->phone }}</p>
            <p>Email: {{  @$lease->tenant->email }}</p>
        </div>

        <!-- Lease Details -->
        <div class="section">
            <h2>Lease Details</h2>
            @php
                $extra = 0;
            @endphp
            <table class="details-table">
                <tr>
                    <th>Lease Period</th>
                    <td>{{ date('M Y') }}</td>
                </tr>
                <tr>
                    <th>Total Area</th>
                    <td>{{ $lease->total_square }} sq ft</td>
                </tr>
                <tr>
                    <th>Price per sq ft</th>
                    <td>Rs. {{ $lease->price }} </td>
                </tr>
                <tr>
                    <th>Sq ft Value</th>
                    <td>{{ $lease->square_foot }} </td>
                </tr>
                <tr>
                    <th>Monthly Rent</th>
                    <td>Rs.{{ $monthly_rent }}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ $lease->start_date }}</td>
                </tr>
                <tr>
                    <th>Due On</th>
                    <td>{{ $lease->due_on }}</td>
                </tr>
                @foreach($LeaseUtilityDeposite as $deposite)
                 @php
                    // Extract the value of extra charges
                    $depositValue = $deposite->deposit_amount;
                @endphp
                <tr>
                    <th>{{ @$deposite->utilityInfo->name }} -Deposit <th>
                    <td>{{ @$deposite->deposit_amount }}</td>
                </tr>
                @endforeach
                
                @foreach($leaseExtraCharges as $extra)
                @php
                    // Extract the value of extra charges
                    $extraChargeValue = $extra->extra_charge_value;
                @endphp
                <tr>
                    <th>{{ @$extra->extraCharge->name }} - Extra/Late Charges <th>
                    <td>{{ @$extraChargeValue }}</td>
                </tr>
                @endforeach
                
            </table>
        </div>
        @php
        $totalExtraCharges = $leaseExtraCharges->sum('extra_charge_value');
        $totalDeposit = $LeaseUtilityDeposite->sum('depositValue');
    @endphp

        <!-- Summary -->
        <div class="section">
            <h2>Summary</h2>
            <p>Total Amount Due: <strong>Rs. {{ $monthly_rent+$totalExtraCharges+$totalDeposit}}</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
          
            <p>If you have any questions regarding this invoice, please contact us at (91) {{ $appSetting->mobile_no }} or email us at {{ $appSetting->email }}.</p>
        </div>
    </div>
</body>
</html>
