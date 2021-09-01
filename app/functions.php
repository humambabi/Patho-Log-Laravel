<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


# Google's reCAPTCHA v3 check #####################################################################
if (!function_exists('reCAPTCHAv3Check')) {
   function reCAPTCHAv3Check($recaptchaToken, $action, Request $request) {
      # Note: $recaptchaToken MUST be sanitized before passing to this function
      
      # Send request to Google
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $data = array("secret" => config('constants.GR_PATHOLOG_SECRETKEY'), "response" => $recaptchaToken, "remoteip" => $request->ip());
      $options = array(
         "http" => [
            "header"	=> "Content-type: application/x-www-form-urlencoded\r\n",
            "method"	=> "POST",
            "content" => http_build_query($data)
         ]
      );
      $context  = stream_context_create($options);
      $response = file_get_contents($url, false, $context);
      $responseKeys = json_decode($response, true);
      
      # Check the response: hostname
      if (in_array($responseKeys["hostname"], ["localhost", "patho-log.com", "78.188.71.116"]) == FALSE) {
         $str = "functions.php: reCAPTCHAv3Check(): reCAPTCHA verification response hostname = ";
         $str .= "\"" . $responseKeys["hostname"] . "\"" . ", php.hostname = \"" . $_SERVER["HTTP_HOST"] . "\".";
         Log::warning($str);
         return FALSE;
      }
      
      # Check the response: action
      if (strcmp($responseKeys['action'], $action) != 0) {
         $str = "functions.php: reCAPTCHAv3Check(): reCAPTCHA verification response action = ";
         $str .= "\"" . $responseKeys["action"] . "\"" . ", Needed action = \"" . $action . "\".";
         Log::warning($str);
         return FALSE;
      }

      # Check the response: score
      if (floatval($responseKeys['score']) < 0.5) {
         $str = "functions.php: reCAPTCHAv3Check(): reCAPTCHA verification response score = ";
         $str .= "\"" . $responseKeys["score"] . "\"" . ", threshold = \"0.5\".";
         Log::warning($str);
         return FALSE;
      }

      # Check the response: success
      if ($responseKeys["success"] != true) {
         $str = "functions.php: reCAPTCHAv3Check(): reCAPTCHA verification response success = ";
         $str .= "\"" . $responseKeys["success"] . "\".";
         Log::warning($str);
         return FALSE;
      }
      
      # Seems OK
      return TRUE;
   }
}

