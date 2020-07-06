<?php
namespace App\Http\Middleware;
use Closure;
use Carbon\Carbon;
use Cache;
use App\Models\User;
use Illuminate\Http\Request;

class LastUserActivity
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
        if (auth()->check() && !auth()->user()->admin) {
            $id = auth()->user()->id;
            Cache::put('user-is-online-' . $id, true, Carbon::now()->addMinutes(1));
            auth()->user()->update(['last_seen' => now()]);
        }
        return $next($request);
    }
}