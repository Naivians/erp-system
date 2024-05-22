<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->session()->get('user');

        if(!$user){
            return redirect()->route('login');
        }

        if ($user->role != $role) {
            if ($user->role == 1) {
                return redirect()->route('Admins.home');
            } elseif ($user->role == 0) {
                return redirect()->route('Users.POS');
            }
        }

       return $next($request);
    }
}
