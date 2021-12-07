<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use App\Models\Api\User;
    use Exception;
    use Carbon\Carbon;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

    class JwtMiddleware extends BaseMiddleware
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
            
            try {
                $user = JWTAuth::parseToken()->authenticate();
               
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => 'Token is Invalid']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['status' => 'Token is Expired']);
                }else{
                    return response()->json(['status' => 'Authorization Token not found']);
                }
            }
            
            if(!isset($request->gateway_transaction) && $user->user_membership === 1){
                if($user->where('created_at', '>', Carbon::now()->subDays(7))->first() === null){
                return response()->json(['status' => 'Please upgrade to premium']);
            }
            }
            
            return $next($request);
        }
    }