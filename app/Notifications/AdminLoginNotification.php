<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use App\Models\Admin;
use Carbon\Carbon;

class AdminLoginNotification extends Notification
{
    use Queueable,Notifiable;
    

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $allAdmins = Admin::select('email')->get();
        $otherAdminsEmails = array();
        foreach($allAdmins as $v){
            $otherAdminsEmails[] = $v->email;
        }

        return (new MailMessage)
            ->subject('Admin Login Notification')
            ->line('Hello Admin,')
            ->line('The admin with the username ' . $notifiable->name . ' has logged in.')
            ->line('Date And Time : ' . Carbon::now()->format('d-m-Y h:i:s A'))
            ->line('Thank you!')
            ->cc($otherAdminsEmails); // cc() method is used to send a copy of the email to other addresses
    }

    public function via($notifiable)
    {
        return ['mail']; // You can add other channels if needed
    }

}
