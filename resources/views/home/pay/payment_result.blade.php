@if($payment->status == 'completed')
    <p>پرداخت با موفقیت انجام شد.</p>
@elseif($payment->status == 'failed')
    <p>پرداخت ناموفق بود.</p>
@endif
