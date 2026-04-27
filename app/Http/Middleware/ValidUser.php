<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // echo "This is a valid user middleware. Required role: " . $role . "<br>";

        //  if(Auth::check()  && Auth::user()->role === $role){
        //          return $next($request);
        //     }else{
        //         return redirect()->route('login')->with('error', 'Please login to access the Software');
        //     }
            
        
         if(Auth::user()->role == $role){
                 return $next($request);

            }else if(Auth::user()->role == "user"){

             return redirect()->route('blank')->with('success', 'Welcome to the added page');

            }else{
                return redirect()->route('login')->with('error', 'Please login to access the Software');
            }
       
    }

    public function terminate(Request $request, Response $response) :void
    {
        // echo "This is a terminate method of valid user middleware.";
    }
}
