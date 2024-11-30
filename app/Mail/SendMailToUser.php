<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $password;
    public $currentDate;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->currentDate = Carbon::now()->format('d/m/Y');
    }

    /**
     * Send mail to users.
     */
   
     public function build(){
       return $this->markdown('mail.change_password_to_user')
       ->subject('Thông báo thay đổi mật khẩu của người dùng');
     }
}
