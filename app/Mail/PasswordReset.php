<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class PasswordReset extends Mailable implements ShouldQueue
{
   use Queueable, SerializesModels;

   #
   # Public variables
   # (To be available in email view automatically)
   #
   public $username; # This is the name of the user as it is in the database
   public $email; # The user's email address
   public $pwr_code; # The verification code

   #
   # Create a new message instance.
   #
   # @return void
   #
   public function __construct($username, $email, $pwr_code)
   {
      # Save member variables
      $this->username = $username;
      $this->email = $email; # Don't encode it in the url, email addresses may contain characters that may be broken if url encoded (like '+')
      $this->pwr_code = $pwr_code;
   }

   #
   # Build the message.
   #
   # @return $this
   #
   public function build()
   {
      return $this->from(config('mail.from.address'), config('mail.from.name'))
                  ->subject("✳ Request to reset your password")
                  ->view('emails.passwordreset')
                  ->text('emails.passwordreset_plain');
   }
}
