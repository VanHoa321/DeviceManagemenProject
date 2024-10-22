<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UseUnitAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role_id == 4){
            return $next($request);
        }
        $request->session()->put("messenge", ["style"=>"danger","msg"=>"Đăng nhập quyền đơn vị sử dụng để vào giao diện"]);
        return redirect()->route("login");
    }
}
