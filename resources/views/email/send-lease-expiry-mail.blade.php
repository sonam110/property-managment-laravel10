<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #7367f0;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Lease Expiration Reminder</h2>
        </div>
        <div class="content">
            <p>Dear {{ $content['tenantName'] }},</p>

            <p>We wanted to remind you that your lease for the property <strong>{{ $content['propertyName'] }}</strong> is set to expire soon.</p>
            <p><strong>Expiration Date:</strong> {{ $content['leaseEndDate'] }}</p>

            <p>Please let us know if you wish to renew or have any questions about your lease expiration. We’re here to assist you with the process.</p>

            <p>Thank you,<br>
            Signature Group</p>
        </div>
        <div class="footer">
            <p>This is an automated reminder from Signature Group.</p>
        </div>
    </div>
</body>
</html>
