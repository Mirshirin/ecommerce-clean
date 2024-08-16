<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
class OrderReportController extends Controller
{
  protected $pdf;

  public function __construct(Pdf $pdf)
  {
      $this->pdf = $pdf;
  }

  // public function printPdf($id){
  //     $order = Order::find($id);    
  //     //$filename = (string)($id);
  //     $pdf = PDF::setPaper('a4', 'portrait')->loadView('admin.report.pdf', compact('order'))->save(storage_path('/dir') . '/' . 'orders_detail.pdf');

  //    // return $pdf->download($filename.'.pdf');
  //     return $pdf->download('orders_detail.pdf');
  // }

  public function printPdf($id)
  {
    $order = Order::find($id);
    // Correctly convert $id to a string
    $filename = (string)$id;
    $pdf = PDF::setPaper('a4', 'portrait')
               ->loadView('admin.report.pdf', compact('order'))
               ->save(storage_path('dir/' . $filename . '.pdf')); // Adjusted storage path

    // Use the dynamic filename for downloading
    return $pdf->download($filename . '.pdf');
    
  }
}
