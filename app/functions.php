<?php

use Illuminate\Support\Facades\Log;


#
# Google's reCAPTCHA v3 check #####################################################################
#
if (!function_exists('reCAPTCHAv3Check')) {
   function reCAPTCHAv3Check($recaptchaToken, $action, $ip) {
      # Note: $recaptchaToken MUST be sanitized before passing to this function

      # Send request to Google
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $data = array("secret" => config('consts.GR_PATHOLOG_SECRETKEY'), "response" => $recaptchaToken, "remoteip" => $ip);
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
      if (in_array($responseKeys["hostname"], ["local.patho-log.com", "localhost", "dev.patho-log.com", "patho-log.com", "78.188.71.116"]) == FALSE) {
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


#
# Start a Laravel queue worker (and gracefully stop other workers) ################################
#
if (!function_exists('laravel_queueworker')) {
   function laravel_queueworker() {
      # In Windows, the background process shows a window, and this is good because we can see php's debug
      # info there (also warning or errors). In Linux server, write output to log instead.
      # Note that in Windows, you need to have php.exe in your system environment settings.

      # Start a new queue worker
      if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
         $command = 'start "" php ' . __DIR__ . '\..\artisan queue:work --daemon'; # 1st quoted param is the window title
      } else {
         // 1st try: 'php -f /www/wwwroot/convengine/worker.php /dev/null &';
         // 2nd try: 'php -f /www/wwwroot/convengine/worker.php 1>/www/wwwroot/convengine/worker_sysout.log 2>/www/wwwroot/convengine/worker_syserr.log &';
         $command = 'php ' . __DIR__ . '/../artisan queue:work --daemon &>' . __DIR__ . '/../storage/logs/laravel_queueworker.log &';
      }

      $handle = popen($command, 'r'); # Run command asynchronously
      if ($handle !== false) pclose($handle);


      # Send a stop signal to all currently running workers (to stop after finishing their jobs)
      if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
         $command = 'start "" php ' . __DIR__ . '\..\artisan queue:restart'; # 1st quoted param is the window title
      } else {
         // 1st try: 'php -f /www/wwwroot/convengine/worker.php /dev/null &';
         // 2nd try: 'php -f /www/wwwroot/convengine/worker.php 1>/www/wwwroot/convengine/worker_sysout.log 2>/www/wwwroot/convengine/worker_syserr.log &';
         $command = 'php ' . __DIR__ . '/../artisan queue:restart &>' . __DIR__ . '/../storage/logs/laravel_queueworker.log &';
      }

      $handle = popen($command, 'r'); # Run command asynchronously
      if ($handle !== false) pclose($handle);
   }
}


#
# Include a css with timestamp to handle (cache vs update) issues. ################################
#
if (!function_exists('include_css')) {
   function include_css($href_rel2public) {
      $realpath = __DIR__ . '/../public' . $href_rel2public;
      $timestamp = 0;
      if (file_exists($realpath)) $timestamp = filemtime($realpath);
      
      echo "<link rel='stylesheet' type='text/css' href='$href_rel2public?t=$timestamp' />";
   }
}


#
# Include a js with timestamp to handle (cache vs update) issues. #################################
#
if (!function_exists('include_jscript')) {
   function include_jscript($href_rel2public) {
      $realpath = __DIR__ . '/../public' . $href_rel2public;
      $timestamp = 0;
      if (file_exists($realpath)) $timestamp = filemtime($realpath);
      
      echo "<script type='text/javascript' src='$href_rel2public?t=$timestamp'></script>";
   }
}


#
# Adds a user IP to the list of saved IPs, and returns a JSON-encoded string ######################
#
if (!function_exists('add_userlogin_record')) {
   function add_userlogin_record($strIPaddrs, $user_ip) {
      # Convert the DB string into an associative array
      $objIPAddr = [];
      $firstCount = 0;
      if (!empty($strIPaddrs)) {
         $objIPAddr = json_decode($strIPaddrs, true);
         $firstCount = 1;
      }

      if (array_key_exists($user_ip, $objIPAddr)) {
         # A login with an already-saved IP
         $objIPAddr["$user_ip"]['count']++;
         $objIPAddr["$user_ip"]['lastlogin'] = gmdate(config('consts.DB_DATETIME_FMT'));
      } else {
         # A login from a new IP
         $newData = [
            'count'     => $firstCount, # New registration user still hasn't login yet (0), or logged in previously but this is a new ip (1)
            'lastlogin' => gmdate(config('consts.DB_DATETIME_FMT'))
         ];

         $objIPAddr["$user_ip"] = $newData;
      }

      # Re-convert the array to string
      return json_encode($objIPAddr);
   }
}
