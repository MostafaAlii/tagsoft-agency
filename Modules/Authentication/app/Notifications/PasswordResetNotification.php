<?php

declare(strict_types=1);

namespace Authentication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class PasswordResetNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $token,
        private readonly string $guard,
    ) {}

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Reset Request')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->line("Reset token: {$this->token}")
            ->line('This token will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.');
    }
}