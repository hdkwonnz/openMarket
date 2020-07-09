<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;////
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyEmailForNewUserNotification;////

//아래 implements MustVerifyEmail은 register 후에 email을 보내 verification을 하기 위해.
//참조. ==> www.youtube.com/watch?v=ivYxiCPjpqc
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    //이곳에서 Notifications/VerifyEmailForNewUserNotification.php.php에 있는 mail이 보내 지도록
    //launch 한다.
    //원래는 아래 코드 없이도 new user register가 정상적으로 끝나면 user에게 mail이 보내지도록 기본 세팅이
    //되어있다.그러나 기본 세팅은 queue를 사용 않아 transaction time이 길어 지는 불편함이 있어
    //아래를 추가 하였다.
    //1.php artisan queue:table 2.php artisan migrate
    //3.env file 의 QUEUE_CONNECTION=sync 를 QUEUE_CONNECTION=database(혹은 beanstalkd)로 변경
    //4.php artisan queue:work --tries=2 --sleep=3
    //5.php artisan make:notification VerifyEmailForNewUserNotification
    //6.Notifications/VerifyEmailForNewUserNotification.php 수정
    //아래는 User.php/MustVerifyEmail.php에서 copy.
    public function sendEmailVerificationNotification()
    {
        //$this->notify(new Notifications\VerifyEmail); //원본 코드

        $this->notify((new VerifyEmailForNewUserNotification)->delay(now()->addSeconds(10)));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    //이곳에서 Notifications/ResetPasswordNotification.php에 있는 mail이 보내 지도록
    //launch 한다.
    //원래는 아래 코드 없이도 reset password가 정상적으로 끝나면 user에게 mail이 보내지도록 기본 세팅이
    //되어있다.그러나 기본 세팅은 queue를 사용 하지 않아 transaction time이 길어 지는 불편함이 있어
    //아래를 추가 하였다.vendor/laravel/framework/src/illuminate/Auth/Passwords/CanResetPassword.php에서
    //copy 하였다.참조:www.thewebtier.com/laravel/modify-password-reset-email-text-laravel/
    //1.php artisan make:notification ResetPasswordNotification
    //2.app\Notifications==>public function toMail($notifiable)을 modify한다.
    //3.vendor/laravel/framework/src/illuminate/Auth/Passwords/CanResetPassword.php에서
    //  public function sendPasswordResetNotification($token)을 copy하여 이곳에 paste한다.
    public function sendPasswordResetNotification($token)
    {
        //$this->notify(new MailResetPasswordNotification($token)); //13/04/2019

        $this->notify((new ResetPasswordNotification($token))->delay(now()->addSeconds(10)));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function orderdetails()
    {
        return $this->hasManyThrough('App\Orderdetail', 'App\Order');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }
}
