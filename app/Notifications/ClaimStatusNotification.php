<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimStatusNotification extends Notification
{
    use Queueable;

    protected $claim;
    protected $status;

    // Pass the claim object and the new status here
    public function __construct($claim, $status)
    {
        $this->claim = $claim;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        // Add 'database' if you want it to show up in a notification bell on your site
        return ['mail', 'database']; 
    }

    public function toMail(object $notifiable): MailMessage
    {
        $isApproved = $this->status === 'approved';
        
        return (new MailMessage)
            ->subject($isApproved ? 'Claim Approved!' : 'Claim Update')
            ->line("Hello {$notifiable->first_name},")
            ->line($isApproved 
                ? "Your claim for '{$this->claim->item->item_name}' has been approved." 
                : "Your claim for '{$this->claim->item->item_name}' was not approved.")
            ->action('View Details', route('dashboard'))
            ->line('Thank you for using our Lost and Found system!');
    }

    public function toArray($notifiable)
    {
        $isApproved = $this->status === 'approved';

        return [
            'claim_id' => $this->claim->id,
            'type' => $isApproved ? 'claim_approved' : 'claim_rejected',
            'title' => $isApproved ? 'Claim Approved!' : 'Claim Rejected',
            'message' => $isApproved 
                ? "Your claim for '{$this->claim->item->item_name}' was approved."
                : "Your claim for '{$this->claim->item->item_name}' was not approved.",
        ];
    }
}

