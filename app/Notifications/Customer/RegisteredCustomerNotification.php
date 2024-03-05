<?php

namespace App\Notifications\Customer;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(private User $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS', 'sercan@localkod.com'), 'Yeni Kullanıcı Kaydı')
            ->subject('Yeni Kullanıcı Kaydı')
            ->greeting('Ailemize Hoşgeldin !!!')
            ->line('Merhaba ' . $this->user?->name . ',')
            ->line('Büyük Ailemize Katıldığın İçin Sana Teşekkür Etmek İsteriz :)')
            ->salutation('Saygılarımızla, Localkod');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
