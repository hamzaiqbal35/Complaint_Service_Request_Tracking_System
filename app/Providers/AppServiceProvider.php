<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Customize the Email Verification Content
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject(Lang::get('Welcome to ' . config('app.name') . '! Please Verify Your Email'))
                ->greeting(Lang::get('Hello ' . $notifiable->name . ','))
                ->line(Lang::get('We are absolutely thrilled to welcome you to **' . config('app.name') . '**!'))
                ->line(Lang::get('To ensure the security of your account and to grant you full access to all features—including submitting, tracking, and managing your service requests—we just need to quickly verify your email address.'))
                ->action(Lang::get('Verify Email Address'), $url)
                ->line(Lang::get('If you did not create an account with us, please disregard this email. Your information remains secure.'))
                ->salutation(Lang::get('Warm regards,'));
        });

        // Customize the Password Reset Content
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject(Lang::get('Password Reset Request - ' . config('app.name')))
                ->greeting(Lang::get('Hello ' . $notifiable->name . ','))
                ->line(Lang::get('We received a request to reset the password for your **' . config('app.name') . '** account.'))
                ->line(Lang::get('To set up a new password and regain access to your account, please click the secure button below:'))
                ->action(Lang::get('Reset Password'), $url)
                ->line(Lang::get('For security reasons, this password reset link will safely expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(Lang::get('If you did not request a password reset, no further action is required and your account is completely safe.'))
                ->salutation(Lang::get('Best regards,'));
        });
    }
}
