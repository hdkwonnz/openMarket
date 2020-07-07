<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

//아래 우측의 implements ShouldQueue 는 메일을 보낼때 queue 사용을 위해서 필요함
//queue 사용응 원치 않으면 제거할 것.(queue에 대한 내용은 별도로 정리 했으니 참고 할 것)
//queue 사용시 ubuntu => source folder => php artisan queue:work --tries=4 을 type 할것
//password reset하면 인증을 위하여 email이 기본적으로 보내 지는데 queue를 사용 하지 않아
//transaction time이 길어져 queue를 사용한다.
//아래 코드는 queue 사용,메일 내용 변경을 위해 overridding 하였다.
///참조:www.youtube.com/watch?v=ct56p3J42d0&list=PLe30vg_FG4OR3b24WlxeTWsj7Z2wOtYrH&index=22
//app/User.php 참조 할 것.
class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token; //추가

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token) //좌측 ($token) 추가
    {
        $this->token = $token; //추가
    }

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

        //아래는 내가 추가
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url('password/reset', $this->token))
            ->line('If you did not request a password reset, no further action is required.');

        // $link = url( "/password/reset/?token=" . $this->token ); //다른 예제
        // return ( new MailMessage )
        //   ->view('reset.emailer')
        //   ->from('info@example.com')
        //   ->subject( 'Reset your password' )
        //   ->line( "Hey, We've successfully changed the text " )
        //   ->action( 'Reset Password', $link )
        //   ->attach('reset.attachment')
        //   ->line( 'Thank you!' );
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
