<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRoleByCode($roles)) {
            throw new ApiException(403, 'Доступ запрещён');
        }
        return $next($request);
    }

}
