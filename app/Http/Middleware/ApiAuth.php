<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 12:06
 */

namespace App\Http\Middleware;
use App\User;
use Closure;
use Illuminate\Auth\AuthenticationException;

class ApiAuth
{

    /**
     * Проверка на наличие токена
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $api_token = $request->header('authorization');
        if(!$api_token)
            throw new AuthenticationException();

        $this->authenticate($api_token);

        return $next($request);
    }

    /**
     * Авторизация пользователя
     * @param $api_token
     * @throws AuthenticationException
     */
    protected function authenticate($api_token)
    {
        $user = User::where('api_token', $api_token)->first();

        if(!$user)
            throw new AuthenticationException('Токен недействителен');

        \Auth::login($user);
    }
}