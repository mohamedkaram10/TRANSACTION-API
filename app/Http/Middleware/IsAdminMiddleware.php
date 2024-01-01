<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $user = auth()->user();
        abort_if($user->role_id !== Role::ADMIN->value, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
