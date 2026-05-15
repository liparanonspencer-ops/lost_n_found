<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOTPNotification extends Notification
{
    use Queueable;

    private string $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your OTP')
                    ->line('Your verification code is: ' . $this->otp)
                    ->line('This code will expire in 10 minutes.')
                    ->action('View Details', route('otp.verify', ['email' => $notifiable->email]))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        'title' => 'Security Verification',
        'otp' => $this->otp,
        'type' => 'registration_otp',
        'message' => 'Your verification code is: ' . $this->otp,
        'icon' => 'fas fa-key', // Example FontAwesome icon
        'url' => route('otp.verify', ['email' => $notifiable->email]),
        ];
    }
}