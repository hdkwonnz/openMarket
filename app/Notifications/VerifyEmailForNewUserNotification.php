<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;////
use Illuminate\Support\Facades\Config;////
use Illuminate\Support\Facades\URL;////
use Illuminate\Support\Facades\Lang;////
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

//아래 우측의 implements ShouldQueue 는 메일을 보낼때 queue 사용을 위해서 필요함
//queue 사용응 원치 않으면 제거할 것.(queue에 대한 내용은 별도로 정리 했으니 참고 할 것)
//queue 사용시 ubuntu => source folder => php artisan queue:work --tries=4 을 type 할것
//새로운 user가 register하면 verification을 위하여 email이 기본적으로(사실은 선택 사항임)보내 지는데
//아래 코드는 queue 사용,메일 내용 변경을 위해 overridding 하였다.
///참조:www.youtube.com/watch?v=ct56p3J42d0&list=PLe30vg_FG4OR3b24WlxeTWsj7Z2wOtYrH&index=22
//app/User.php 참조 할 것.
class VerifyEmailForNewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    //아래는 Notifications\VerifyEmail에서 copy/////////
    public static $toMailCallback;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');

        //아래는 Notifications\VerifyEmail에서 copy
        //내용을 한글로 바꾸어도 된다. laravel 5.8 과 다르다. "Lang::get" 이다.==>주의할것(11Feb2020)
        //laravel 5.8 과 다르다. "Lang::get" 이다.==>주의할것(11Feb2020)
        return (new MailMessage)
        ->subject(Lang::get('Verify Email Address'))
        ->line(Lang::get('Please click the button below to verify your email address.'))
        ->action(
            Lang::get('Verify Email Address'),
            $this->verificationUrl($notifiable)
        )
        ->line(Lang::get('If you did not create an account, no further action is required.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    //아래는 Notifications\VerifyEmail에서 copy
    //laravel 5.8 과 다르다. "hash" 추가.==>주의할것(11Feb2020)
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    //아래는 MustVerifyEmail. Notifications\VerifyEmail에서 copy
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
