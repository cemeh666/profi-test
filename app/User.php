<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Генерация и созданение токена для входа
     */
    public function generateToken(){
        $this->api_token = bin2hex(random_bytes(30));
        $this->save();
        return $this->api_token;
    }


    /**
     * Валидация модели
     * @return bool|\Illuminate\Validation\Validator
     */
    public function Validate()
    {
        $rules = [
            'email'    => ['required', 'email', 'unique:users', 'max:191'],
            'password' => ['required', 'max:191'],
            'name'     => ['required', 'max:191'],
        ];

        $model = self::getAttributes();

        $validator = \Validator::make($model, $rules);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public static function registration($email, $password, $name){

        $user = new User([
            "email"    => $email,
            "password" => $password,
            "name"     => $name,
        ]);

        if($user->Validate() === true){
            $user->save();
            return $user;
        }

        return $user->Validate()->getMessageBag();
    }

    public function setPasswordAttribute($password)
    {
        if( $password )
            $this->attributes['password'] = bcrypt($password);
    }

}
