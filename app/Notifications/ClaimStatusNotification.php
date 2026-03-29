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
        $itemName = $this->claim->item->item_name;
        
        $email = (new MailMessage)
            ->subject($isApproved ? 'Claim Approved!' : 'Claim Update')
            ->line("Hello {$notifiable->first_name},");

            if($notifiable->role === 'admin') {
               $email->line($isApproved 
            ? "You approved the claim request for {$itemName}." 
            : "You rejected the claim request for {$itemName}.");
            } else {
              $email->line($isApproved 
            ? "Your claim request for {$itemName} has been approved. Please visit the office to claim your item." 
            : "Your claim request for {$itemName} has been rejected.");
            }
        return $email->action('View Details', route('dashboard'))
                     ->line('Thank you for using STI Lost and Found system!');
    }

    public function toArray($notifiable)
    {
        $isApproved = $this->status === 'approved';
        $itemName = $this->claim->item->item_name;

        if($notifiable->role === 'admin') {
        return [
            'claim_id' => $this->claim->id,
            'type' => $isApproved ? 'claim_approved' : 'claim_rejected',
            'title' => $isApproved ? 'Claim Approved!' : 'Claim Rejected',
            'message' => $isApproved 
                ? "Request Approval claim for '{$this->claim->item->item_name}' was approved."
                : "Request Approval claim for '{$this->claim->item->item_name}' was not approved.",
        ];
    }
    return [
         'claim_id' => $this->claim->id,
            'type' => $isApproved ? 'claim_approved' : 'claim_rejected',
            'title' => $isApproved ? 'Claim Approved!' : 'Claim Rejected',
            'message' => $isApproved 
                ? "Your claim for '{$itemName}' was approved."
                : "Your claim for '{$itemName}' was not approved.",
    ];
}
}
