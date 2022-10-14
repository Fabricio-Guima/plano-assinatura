<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsStripeCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
     public function handle(Request $request, Closure $next): mixed {
        if ($request->user() && ! $request->user()->hasStripeId()) {
            return redirect(route("dashboard"));
        }

        return $next($request);
    }
}
