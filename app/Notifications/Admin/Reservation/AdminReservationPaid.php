<?php

namespace App\Notifications\Admin\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminReservationPaid extends Notification
{
    use Queueable;

    protected $invoice;
    private $payment_method;
    private $panel_message;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice, $payment_method)
    {
        $this->invoice = $invoice;
        $this->payment_method = $payment_method;
        $this->panel_message = 'User successfully paid the slot. Please check the reservation details below thank you.';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(config('app.name') . ': Reservation Paid')
                    ->markdown('emails.reservation-paid', [
                        'invoice' => $this->invoice,
                        'panel_message' => $this->panel_message,
                        'is_user' => false,
                        'name' => $notifiable->renderName(),
                        'terms_condition' => null
                    ]);
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
            'message' => 'Reservation Paid via '. $this->payment_method,
            'title' => 'Reservation Paid via '. $this->payment_method,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
