<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 100px;
        }
        .header .company-details {
            text-align: right;
        }
        .company-details p {
            margin: 0;
        }
        .tenant-info {
            margin-bottom: 20px;
        }
        .tenant-info p {
            margin: 5px 0;
        }
        .table-container {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table-container th {
            background-color: #f4f4f4;
        }
        .table-container tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table-container tr:hover {
            background-color: #ddd;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
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
         .total {
            text-align: right;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with logo and company details -->
        <div class="header">
            <img src="{{url('/')}}/{{ $appSetting->app_logo}}" alt="{{$appSetting->app_name}}">
            <div class="company-details">
                <p><strong>{{ $appSetting->app_name }}</strong></p>
                <p>{{ $appSetting->address }}</p>
                <p>Phone: {{ $appSetting->mobile_no }}</p>
                <p>Email: {{ $appSetting->email }}</p>
            </div>
        </div>

        <!-- Tenant Information -->
        <div class="tenant-info">
            <h2>To</h2>
            <p><strong>Name:</strong> {{ @$lease->tenant->firm_name }}</p>
            <p><strong>Address:</strong> {{  @$lease->tenant->business_address }}</p>
            <p><strong>Phone:</strong>{{  @$lease->tenant->phone }}</p>
            <p><strong>Email:</strong> {{  @$lease->tenant->email }}</p>
        </div>

        <!-- Lease Information Table -->
        <h2>Lease Details</h2>
        <table class="table-container">
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Amount</th>
                   
                </tr>
            </thead>
            <tbody>
                
                    <tr>
                        <td>Rent - {{ date('M Y') }}</td>
                        <td>1</td>
                        <td>Rs.{{ $lease->price }},Total Area: {{ $lease->total_square }} sq ft</td>
                        <td>Rs.{{ $monthly_rent }}</td>
                    </tr>
                      <tr>
                        <td>CAM </td>
                        <td>1</td>
                        <td>Rs.{{ $lease->camp_price }},Total Area: {{ $lease->total_square }} sq ft</td>
                        <td>Rs.{{ $cam_amount }}</td>
                    </tr>
                     @foreach($LeaseUtilityDeposite as $key=> $deposite)
                      @php
                        // Extract the value of extra charges
                        $depositValue = $deposite->deposit_amount;
                    @endphp
                    <tr>
                        <td>{{ @$deposite->utilityInfo->name }} -Deposit</td>
                        <td>1</td>
                        <td></td>
                        <td>{{ @$deposite->deposit_amount }}</td>
                    </tr>
                    @endforeach
                      @foreach($leaseExtraCharges as $extra)
                      @php
                        // Extract the value of extra charges
                        $extraChargeValue = $extra->extra_charge_value;
                    @endphp
                    <tr>
                        <td>{{ @$extra->extraCharge->name }} - Extra/Late Charges</td>
                        <td>1</td>
                        <td></td>
                        <td>{{ @$extraChargeValue }}</td>
                    </tr>
                    @endforeach
                
            </tbody>
        </table>
         @php
            $totalExtraCharges = $leaseExtraCharges->sum('extra_charge_value');
            $totalDeposit = $LeaseUtilityDeposite->sum('depositValue');
        @endphp
        <div class="section">
            <h2>Summary</h2>
            <p>Total Amount Due: <strong>Rs. {{ $monthly_rent+$cam_amount+$totalExtraCharges+$totalDeposit}}</strong></p>
        </div>


        <!-- Footer -->
        <div class="footer">
          
            <p>If you have any questions regarding this invoice, please contact us at (91) {{ $appSetting->mobile_no }} or email us at {{ $appSetting->email }}.</p>
        </div>
    </div>
</body>
</html>
