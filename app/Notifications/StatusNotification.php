<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
class StatusNotification extends Notification //implements ShouldQueue
{
    use Queueable;
    private $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */

     public $booking;
     public $users;
     public $furnitures;
     public $electronics;
     public $duration;
    public function __construct($details ,$booking, $users, $furnitures, $electronics, $duration)
    {
        $this->details=$details;
        $this->booking = $booking;
        $this->users = $users;
        $this->furnitures = $furnitures;
        $this->electronics = $electronics;
        $this->duration = $duration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        \Log::info('via() called for: ' . $notifiable->email);
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
        \Log::info('Sending mail to: ' . $notifiable->email);
        return (new MailMessage)
            ->subject('📢 Booking Reminder: ' . $this->booking->room->name)
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('You have an upcoming room booking:')
            ->line('📅 Date: ' . $this->booking->booking_date)
            ->line('🕐 Time: ' . $this->booking->booking_time_start . ' - ' . $this->booking->booking_time_end)
            ->line('⏱ Duration: ' . $this->duration . ' hour(s)')
            ->line('👥 Students Involved:')
            ->line(implode(', ', collect($this->users)->pluck('name')->toArray()))
            ->line('🪑 Furnitures: ' . (count($this->furnitures) ? implode(', ', $this->furnitures) : 'None'))
            ->line('⚡ Electronics: ' . (count($this->electronics) ? implode(', ', $this->electronics) : 'None'))
            ->line('Thank you for using ' . config('app.name') . '!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'title'=>$this->details['title'],
    //         'actionURL'=>$this->details['actionURL'],
    //         'fas'=>$this->details['fas']
    //     ];
    // }
    public function toArray($notifiable)
    {
        return [
            'title'=>$this->details['title'],
            'actionURL'=>$this->details['actionURL'],
            'fas'=>$this->details['fas']
        ];
    }


    
    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->details['title'],
            'actionURL' => $this->details['actionURL'],
            'url' => route('admin.notification', $this->id),
            'fas' => $this->details['fas'],
            'time' => date('F d, Y h:i A')
        ]);
    }


    
}
