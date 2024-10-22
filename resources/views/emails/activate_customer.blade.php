<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
</head>
<body>
    <p>Hello {{ $customer->name }},</p>
    <p>Thank you for registering with us. Please click the link below to activate your account:</p>
    
    <p>
        <a href="{{ route('customer.activate', $customer->activation_token) }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Activate Account
        </a>
    </p>
    
    <p>If you did not create an account, no further action is required.</p>

    <p>Regards,<br>{{ $companySettings['company_name']}}</p>
</body>
</html>
