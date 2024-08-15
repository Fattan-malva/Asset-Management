<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/')->with('fail', 'Anda harus login dulu');
        }

        // Jika user_id ada, ambil user_role dari sesi
        $userRole = $request->session()->get('user_role');
        
        // Set user_role di sesi jika belum ada
        if (is_null($userRole)) {
            // Ambil user_role dari database atau tempat lain
            $userId = $request->session()->get('user_id');
            $user = \App\Models\User::find($userId);
            
            // Misalkan `user_role` ada dalam model `User`
            if ($user) {
                $request->session()->put('user_role', $user->role);
            }
        }

        return $next($request);
    }
}
