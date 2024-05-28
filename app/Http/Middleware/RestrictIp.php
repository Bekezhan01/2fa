<?php

// app/Http/Middleware/RestrictIp.php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use App\Models\AllowedIp;

class RestrictIp
{
    /**
    Обработка входящего запроса.*
    @param  \Illuminate\Http\Request  $request
    @param  \Closure  $next
    @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $allowedIp = AllowedIp::where('ip_address', $ip)->first();

        if (!$allowedIp) {
            abort(403, 'Unauthorized IP address.');
        }

        $now = now();
        $timeWindowStart = Carbon::createFromFormat('H:i:s', $allowedIp->time_window_start)->format('H:i');
        $timeWindowEnd = Carbon::createFromFormat('H:i:s', $allowedIp->time_window_end)->format('H:i');

        if (!$this->isTimeInWindow($now, $timeWindowStart, $timeWindowEnd)) {
            abort(403, 'Access allowed only between ' . $timeWindowStart . ' and ' . $timeWindowEnd . '.');
        }

        return $next($request);
    }

    private function isTimeInWindow($time, $start, $end)
    {
        return $time->between($time->copy()->setTimeFromTimeString($start), $time->copy()->setTimeFromTimeString($end));
    }
}
