<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class AdminAuthenticated
{
        
    public function handle($request, Closure $next)
    {
     
        if ( ($request->user()->hasRole('Super Admin') || $request->user()->hasRole('Admin') || $request->user()->hasRole('Product Manager')) && $request->user() )  {
        
            return $next($request);
         
        }
  
            return redirect('/');

    }   
    //     if (Auth::check())
    //     {
        
    //     //     /** @var App\Models\User */
    //     //     $user= Auth::user();
    //     //   //  dd( $user->hasRole('Super Admin'));
    //     //     if  ($user->hasRole(['Super Admin','Admin']) )  {
        

    //             return $next($request);
             
    //         //}
    //         abort(403);
    //             //return redirect('/');
    
        
    //     }
        
    //    abort(401);


    // }




 }

