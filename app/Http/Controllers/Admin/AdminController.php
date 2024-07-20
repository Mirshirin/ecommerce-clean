<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\SharedFunctionalityTrait;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;



class AdminController extends Controller
{
    use SharedFunctionalityTrait;

    public function dashboard() {
        $metrics = app(UserMetricsController::class)->getMetrics(); 
        $user = auth()->user();
        return view('admin.index', compact('user', 'metrics')); 
    }
    
    
   
    
    
    




}