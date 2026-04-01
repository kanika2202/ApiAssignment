<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AccessToken; // កុំភ្លេច Import Model នេះ

class CheckAccessToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ១. ចាប់យក token ពី URL query string (ឧទាហរណ៍: ?token=ABC123)
        $token = $request->query('token');

        // ២. បើមិនមានបញ្ជូន token មកទេ ឱ្យឈប់ត្រឹមនេះ
        if (!$token) {
            return response()->json([
                'error' => 'Token is required'
            ], 400);
        }

        // ៣. ឆែកមើលក្នុង Database ថាមាន Token ហ្នឹង ហើយវាមាន status active ឬអត់
        $validToken = AccessToken::where('token', $token)
            ->where('is_active', true)
            ->first();

        // ៤. បើឆែកទៅមិនឃើញ ឬ Token ងាប់ (inactive) មិនឱ្យចូលឡើយ
        if (!$validToken) {
            return response()->json([
                'error' => 'Invalid or inactive token'
            ], 403);
        }

        // ៥. បើត្រឹមត្រូវទាំងអស់ អនុញ្ញាតឱ្យទៅមុខបន្ត
        return $next($request);
    }
}