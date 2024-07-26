<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserMetricsController extends Controller
{
    public function getMetrics()
    {
        $user = auth()->user();
        $id = $user->id;

        $totalData = DB::table('orders')
            ->select(
                DB::raw('SUM(price) as total_price'),
                DB::raw('MAX(price) as highest_price'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN price ELSE 0 END) as revenue_Sales'),
                DB::raw('COUNT(DISTINCT CASE WHEN payment_status = "paid" THEN product_id END) as productSoldCount')
            )
            ->where('id', $id)
            ->first();

        return [
            'total_price' => $totalData->total_price?? null,
            'highest_price' => $totalData->highest_price?? null,
            'revenue_Sales' => $totalData->revenue_Sales?? null,
            'productSoldCount' => $totalData->productSoldCount?? null,
        ];
    }
}
