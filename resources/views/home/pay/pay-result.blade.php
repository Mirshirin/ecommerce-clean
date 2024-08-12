<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   pay-resault 

   <div class="payment-details">
    <h2>اطلاعات پرداخت</h2>
    <p>مبلغ پرداختی: {{ number_format($payment->amount_paid, 2, '.', ',') }}</p>
    <p>تاریخ پرداخت: {{ $payment->payment_date->format('Y-m-d H:i:s') }}</p>
    <!-- سایر اطلاعات قابل نمایش -->
</div>
</body>
</html>