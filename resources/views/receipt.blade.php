<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #7367f0;
        }
        .content {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555555;
        }
        .content h3 {
            font-size: 18px;
            color: #333333;
            margin: 10px 0;
        }
        .content p {
            margin: 5px 0;
        }
        .content .details {
            font-size: 14px;
            color: #777777;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }
        .button {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <h2>Payment Receipt</h2>
            <p>{{ date('M d, Y') }}</p>
        </div>

        <!-- Content Section -->
        <div class="content">
            <p>Dear {{ @$payment->tenant->full_name }},</p>
            <p>We are pleased to inform you that your payment has been received successfully on behalf of the following invoice:</p>
            
            <h3>Invoice Details</h3>
            <p><strong>Invoice Type:</strong> {{ ucfirst(@$payment->invoice->invoice_type) }}-Charges</p>
            <p><strong>Invoice No:</strong> {{ @$payment->invoice->invoice_no }}</p>
            <p><strong>Amount Paid:</strong> {{ formatIndianCurrencyPdf($payment->amount) }}</p>
            <p><strong>Date Received:</strong> {{ (date('M d,Y',strtotime($payment->payment_date))) }}</p>
            
            <h3>Property Details</h3>
            <p><strong>Property:</strong> {{ $payment->property->property_name }}</p>
            
            <!-- Payment Details Section -->
            <div class="details">
                <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                <p><strong>Transaction ID:</strong> {{ $payment->reference_no }}</p>
            </div>
            
            
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for your prompt payment!</p>
            <p>If you have any questions, feel free to reach out to us at {{ $appSetting->email}}</p>
            <p><strong>{{ $appSetting->app_name}}</strong></p>
        </div>
    </div>
</body>
</html>
