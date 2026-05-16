<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminActivityNotification extends Notification
{
    use Queueable;

    protected $claim;
    protected $status;

    /**
     * Pass the claim into the constructor
     */
    public function __construct($claim, $status = null)
    {
        $this->claim = $claim;
        $this->status = $status;
    }

    /**
     * Change this to include 'database'
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; 
    }

    public function toMail(object $notifiable): MailMessage
    {
        $action = $this->status ? ucfirst($this->status) : 'Processed';
        return (new MailMessage)
            ->subject('System Action Logged')
            ->line("You {$action} the claim for '{$this->claim->item->item_name}'.")
            ->action('View Admin History', route('admin.claims.history'));
    }
  
    /**
     * This is what gets saved in the 'notifications' table for your Blade view
     */
    public function toArray($notifiable)
    {
        $action = $this->status ? ucfirst($this->status) : 'Processed';
        return [
            'type' => 'admin_log',
            'icon' => 'fas fa-user-shield',
            'claim_id' => $this->claim->id,
            'title' => 'System: Action Logged',
            'message' => "You {$action} the claim for '{$this->claim->item->item_name}' submitted by {$this->claim->user->email}.",
            'url' => route('admin.claims.history'),
        ];
    }
}