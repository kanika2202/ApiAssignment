<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. ឆែកថាបាន Login ហើយឬនៅ?
        // 2. ឆែកថា Role របស់ User ត្រូវនឹងអ្វីដែល Route ត្រូវការដែរឬទេ?
        if (!Auth::check() || Auth::user()->role !== $role) {
            
            // ប្រសិនបើ User បាន Login រួចហើយ តែ Role មិនមែនជា Admin (ច្រឡំចូល Admin)
            if (Auth::check()) {
                Auth::logout(); // Logout ចេញដើម្បីឱ្យគាត់ Login ជា Admin វិញបាន
            }

            // ប្តូរពី abort(403) មកជាការ Redirect ទៅទំព័រ Login វិញ
            return redirect()->route('login')->with('error', 'សូមចូលប្រើប្រាស់ជា Admin ដើម្បីបន្ត!');
        }

        return $next($request);
    }
}