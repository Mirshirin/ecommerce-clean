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
 
  public function printPdf($id)
  {
    $order = Order::find($id);
    // Correctly convert $id to a string
    $filename = (string)$id;
    $pdf = PDF::setPaper('a4', 'portrait')
               ->loadView('admin.report.pdf', compact('order'))
               ->save(storage_path('dir/' . $filename . '.pdf')); // Adjusted storage path    
    return $pdf->download($filename . '.pdf');
    
  }
}
