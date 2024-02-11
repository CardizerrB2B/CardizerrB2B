<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use PragmaRX\Google2FALaravel\Support\Authenticator;

use App\Http\Controllers\ApiController;

class VerifyTwoFactorAPI extends ApiController
{
    protected $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        //dd($request->input('2fa_code'));
        //dd($user->google2fa_secret);

        if(empty($request->input('2fa_code'))){
            return $this->errorStatus(__('msg.the2FaCodeRequired'));
        }
        
        if ($user && $user->google2fa_secret) {
            $isValid = $this->authenticator->verifyKey(
                $user->google2fa_secret,
                $request->input('2fa_code')
            );
            if ($isValid) {
                $user->update(['google2fa_enabled' => 1]);
                return $next($request);
            } else {
              return $this->errorStatus(__('msg.Invalid2faCode'));
            }
        }else{
             return $this->errorStatus(__('msg.generateKeyRequired'));
        }

        return $next($request);

    
    }
}
