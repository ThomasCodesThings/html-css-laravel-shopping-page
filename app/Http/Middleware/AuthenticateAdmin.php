<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            if($user->hasRole("ADMIN"))
                return $next($request);
            else 
                return redirect('/');
        }
        else
            return redirect('/login');
    }
}