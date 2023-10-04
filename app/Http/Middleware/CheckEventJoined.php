<?php

namespace App\Http\Middleware;

use App\Model\EventParticipant;
use App\Services\UserInfo;
use Closure;
use Illuminate\Http\Request;

class CheckEventJoined
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
        $userInfo = UserInfo::getOrFail($request);
        if(!EventParticipant::whereUserId($userInfo->user_id)->whereEventId($request->route('eventId'))->exists()) {
            EventParticipant::whereUserId($userInfo->user_id)->where(function($query) use ($request){
                $query->where('event_id', $request->input('eventId'))
                    ->orWhere('event_id', $request->input('event_id'));
            })->firstOrFail();
        }

        return $next($request);
    }
}
