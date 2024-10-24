<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Http\Middleware\AuthenticateOTP;
use App\Models\UserAuthApi;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $listGuard = Config::get('auth.guards');

        foreach ($listGuard as $guard) {

            $this->app['auth']->viaRequest($guard['driver'], function (Request $request) {

                $route = $request->route();

                $guardRequest = (explode(':', ($route->getAction()['middleware'][1])))[1] ?? (config('auth.defaults'))['guard'];
                $guardRequest = explode(",", $guardRequest);
                $result = null;
                foreach ($guardRequest as $availableGuards) {

                    $guardConfig = config('auth.guards.' . $availableGuards);

                    if ($request->header('authorization')) {
                        if (is_null($result)) {

                            $result = $this->authenticationOTP($request->header($guardConfig['authMethod']), $guardConfig['user']);

                            if ($result == null and env('APP_ENV') === 'development') {
                                $result = $this->authentication($request->header($guardConfig['authMethod']), $guardConfig['user']);
                            }
                        }
                    }
                }
                return $result;
            });
        }
    }

    private function authentication($apiToken, $username)
    {
        return UserAuthApi::where(
            [
                ['apiToken', $apiToken],
                ['username', $username],
            ]
        )->first();
    }

    private function authenticationOTP($apiToken, $username)
    {
        $otp = UserAuthApi::where(
            [
                ['username', $username],
            ]
        )->first();

        return AuthenticateOTP::factory()->verifyCode($otp['apiToken'], $apiToken, 1);
    }
}
