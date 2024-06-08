<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Roles;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     //  handle function take 2 parameter 
    // first is: module or feature than you want to access.
    // second is: perticular permission,like create update
    public function handle(Request $request, Closure $next,$module,$permission): Response
    {

        if(auth()->user()->role_id==0){
            return $next($request);
        }

        else {
            $permissions=Roles::where('id',auth()->user()->role_id)->value('permission');
           
            if (array_key_exists($module, $permissions)) {
                
                if(array_search($permission,$permissions[$module])!==false){
                   
                    return $next($request);
                }else{
                    abort(404);  
                }
               
            } else {
                abort(404);
            }

        }

        

    }
}
