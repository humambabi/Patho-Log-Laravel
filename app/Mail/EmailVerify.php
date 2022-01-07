<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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

   #
   # Create a new message instance.
   #
   # @return void
   #
   public function __construct($username, $is_newreg, $email, $ver_code)
   {
      # Save member variables
      $this->username = $username;
      $this->is_newreg = $is_newreg;
      $this->email = $email; # Don't encode anything, address may contain characters that may be broken (like '+')
      $this->ver_code = $ver_code;
   }

   #
   # Build the message.
   #
   # @return $this
   #
   public function build()
   {
      return $this->from(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_SENDERNAME)
                  ->subject("📧 Verify your email address")
                  ->view('emails.emailverify')
                  ->text('emails.emailverify_plain');
   }
}
