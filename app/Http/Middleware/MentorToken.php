<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\Mentors\MentorCredentials;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MentorToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = trim($request->header('X-Mentor-Token'));
        $unauthorized = ResponseHelper::error('Unauthorized', null, Response::HTTP_UNAUTHORIZED);

        if (empty($token)) return response()->json($unauthorized, $unauthorized['code']);

        $mentor = MentorCredentials::where('token', $token)->first();

        if (!$mentor) return response()->json($unauthorized, $unauthorized['code']);

        $request->merge(['mentor' => $mentor]);

        return $next($request);
    }
}
