<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification
{
    use Queueable;

    private User $user;

    private string $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
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
        $dashboardUrl = config('app.dashboard_url');

        return (new MailMessage)
            ->priority(1)
            ->subject(config('app.name') . ' Email Verification')
            ->greeting('New User Created')
            ->line("Hi {$this->user->name}:")
            ->line('Please verify your email address is correct by clicking on button below')
            ->action('Verify Your Email', "{$dashboardUrl}/auth/email-verification?code={$this->code}")
            ->line('Thank you for using ' . config('app.name') . ' application!');
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
