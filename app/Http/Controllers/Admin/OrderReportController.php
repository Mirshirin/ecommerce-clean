<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderReportController extends Controller
{
  protected $pdf;

  public function __construct(Pdf $pdf)
  {
      $this->pdf = $pdf;
  }

  public function printPdf($id){
      $order = Order::find($id);
      $pdf = $this->pdf->loadView('admin.report.pdf', compact('order'));
      return $pdf->download('order_details.pdf');
  }
}
