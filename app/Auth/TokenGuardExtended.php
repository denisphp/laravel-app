<?php
namespace App\Auth;

use Illuminate\Auth\TokenGuard;
use Illuminate\Support\Facades\Redis;
use Illuminate\Auth\Events\Authenticated;
use Hash;

class TokenGuardExtended extends TokenGuard
{
    /**
     * Attempt to authenticate the user and return the token.
     *
     * @param array $credentials
     *
     * @return false|string
     */
    public function attempt(array $credentials = [])
    {
        $user = $this->provider->byCredentials($credentials);
        if ($this->hasValidCredentials($user, $credentials)) {
            $this->user = $user;
            $token = $this->setApiToken($user);

            return $token;
        }

        return false;
    }

    public function setApiToken($user)
    {
        $token = $this->generateRandomKey();

        Redis::set('session::' . $token, $user->id);

        return $token;
    }

    protected function generateRandomKey()
    {
        $bytes = 'base64:' . base64_encode(random_bytes(32));

        return strtolower(strtr(substr(base64_encode($bytes), 0, 32), '+/', '_-'));
    }

    protected function hasValidCredentials($user, $credentials)
    {
        return !is_null($user) && $this->provider->validateCredentials($user, $credentials);
    }

    /**
     * Fire the authenticated event if the dispatcher is set.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    protected function fireAuthenticatedEvent($user)
    {
        if (isset($this->events)) {
            $this->events->dispatch(new Authenticated($user));
        }
    }
}
