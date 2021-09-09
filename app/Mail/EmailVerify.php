<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailVerify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    #
    # Public variables
    # (To be available in email view automatically)
    #
    public $username; # This is the name of the user as it is in the database
    public $is_newreg; # If this email is the first email-verification, or false if this user has requested to resend it
    public $email; # The user's email address
    public $ver_code; # The verification code

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $is_newreg, $email, $ver_code)
    {
        # Save member variables
        $this->username = $username;
        $this->is_newreg = $is_newreg;
        $this->email = $email; # Don't encode anything, address may contain characters that may be broken (like '+')
        $this->ver_code = $ver_code;

        # Set the "vercode_datetime" column to now (most likely will fail and ignored on debug route:/emailview)
        DB::update("UPDATE `users` SET `vercode_datetime` = :vdt WHERE `email` = :eml;", [
            'vdt' => gmdate(config('consts.DB_DATETIME_FMT')),
            'eml' => $email
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('consts.PATHOLOG_EMAIL_SUPPORT'), config('consts.PATHOLOG_EMAIL_SENDERNAME'))
                    ->subject("📧 Verify your email address")
                    ->view('emails.email_verify')
                    ->text('emails.email_verify_plain');
    }
}
