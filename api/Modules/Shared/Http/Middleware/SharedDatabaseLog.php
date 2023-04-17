<?php

namespace Modules\Shared\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use DB;
use Log;

final class SharedDatabaseLog
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!config('db_log')) {
            return $next($request);
        }

        DB::enableQueryLog();

        $response = $next($request);

        foreach (DB::getQueryLog() as $log) {
            Log::debug($log['query'], ['bindings' => $log['bindings'], 'time' => $log['time']]);
        }

        return $response;
    }
}
