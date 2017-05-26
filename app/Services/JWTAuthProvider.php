<?php

namespace App\Services;

use App\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Hash;
use Illuminate\Support\Str;

class JWTAuthProvider implements UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return User::find($identifier)->first();
    }

    public function retrieveByToken($identifier, $token)
    {
        //
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        //
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $id  = Redis::get(Config::get('jwt.redis_api_session_key_prefix') . $credentials['api_token']);

        if($id){
            $user = User::find($id);

            return $user;

        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if ($user->email == $credentials['email'] && Hash::check($credentials['password'], $user->getAuthPassword())){
            return true;
        }

        return false;
    }


    public function byCredentials($credentials = [])
    {
        $query = DB::table('users');
        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'password')) {
                $query->where($key, $value);
            }
        }

        $user = $query->first();

        return $this->getGenericUser($user);
    }

    /**
     * Get the generic user.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\GenericUser|null
     */
    protected function getGenericUser($user)
    {
        if (! is_null($user)) {
            return new GenericUser((array) $user);
        }
    }
}