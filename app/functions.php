<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; # Needed for template_create_thumbnail()


#
# Google's reCAPTCHA v3 check #####################################################################
#
if (!function_exists('reCAPTCHAv3Check')) {
   function reCAPTCHAv3Check($recaptchaToken, $action, $ip) {
      # Note: $recaptchaToken MUST be sanitized before passing to this function

      # Send request to Google
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $data = array("secret" => env('GOOGLERECAPTCHA3_SECRETKEY'), "response" => $recaptchaToken, "remoteip" => $ip);
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
# (Print or return) a css with timestamp to handle (cache vs update) issues. ######################
#
if (!function_exists('print_css')) {
   function print_css($href_rel2public) {
      $realpath = __DIR__ . '/../public' . $href_rel2public;
      $timestamp = 0;
      if (file_exists($realpath)) $timestamp = filemtime($realpath);
      
      echo "<link rel='stylesheet' type='text/css' href='$href_rel2public?t=$timestamp' />";
   }
}
if (!function_exists('return_css')) {
   function return_css($href_rel2public) {
      $realpath = __DIR__ . '/../public' . $href_rel2public;
      $timestamp = 0;
      if (file_exists($realpath)) $timestamp = filemtime($realpath);
      
      return "<link rel='stylesheet' type='text/css' href='$href_rel2public?t=$timestamp' />";
   }
}


#
# (Print or return) a js with timestamp to handle (cache vs update) issues. #######################
#
if (!function_exists('print_jscript')) {
   function print_jscript($href_rel2public) {
      $realpath = __DIR__ . '/../public' . $href_rel2public;
      $timestamp = 0;
      if (file_exists($realpath)) $timestamp = filemtime($realpath);
      
      echo "<script type='text/javascript' src='$href_rel2public?t=$timestamp'></script>";
   }
}
if (!function_exists('return_jscript')) {
   function return_jscript($href_rel2public) {
      $realpath = __DIR__ . '/../public' . $href_rel2public;
      $timestamp = 0;
      if (file_exists($realpath)) $timestamp = filemtime($realpath);
      
      return "<script type='text/javascript' src='$href_rel2public?t=$timestamp'></script>";
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
         $objIPAddr["$user_ip"]['lastlogin'] = gmdate(DB_DATETIME_FMT);
      } else {
         # A login from a new IP
         $newData = [
            'count'     => $firstCount, # New registration user still hasn't login yet (0), or logged in previously but this is a new ip (1)
            'lastlogin' => gmdate(DB_DATETIME_FMT)
         ];

         $objIPAddr["$user_ip"] = $newData;
      }

      # Re-convert the array to string
      return json_encode($objIPAddr);
   }


   #
   # Generates a url for a random user picture (to be used in the database) #######################
   #
   if (!function_exists('create_random_userpicurl')) {
      function create_random_userpicurl() {
         $picfolder = public_path(PATH_USER_PREDEFINEDPICTURES); # No "/" at the end
         $fileListTemp = scandir($picfolder);
         $fileList = array();

         if (count($fileListTemp) < 1) return "";
         for ($iC = 0; $iC < count($fileListTemp); $iC++) {
            if (strtoupper(substr($fileListTemp[$iC], 0, 7)) == "USERPIC") {
               if (is_dir($picfolder . "/" . $fileListTemp[$iC]) == false) array_push($fileList, $fileListTemp[$iC]);
            }
         }

         if (count($fileList) < 1) return "";
         
         # It MUST be a url usable DIRECTLY by <img src="">
         return '/' . PATH_USER_PREDEFINEDPICTURES . '/' . $fileList[random_int(0, count($fileList) - 1)];
      }
   }


   #
   # Create a template's thumbnail image
   #
   if (!function_exists('template_create_thumbnail')) {
      function template_create_thumbnail($tpl_id) {
         /*
         Must be *synchronous*
         */
         $tplStorageDir = TEMPLATE_STORAGE_DIRNAME . "/" . $tpl_id . "/"; # Ends with a backslash
         $tplAbsDir = Storage::disk('local')->path($tplStorageDir);

         if (Storage::disk('local')->missing($tplStorageDir . TEMPLATE_PDF_FILENAME)) {
            # Load the template
            $template = json_decode(Storage::disk('local')->get($tplStorageDir . TEMPLATE_PROPS_FILENAME), true);

            # Create a PDF object, setting its properties
            $mpdf = new \Mpdf\Mpdf([
               'mode'               => 'utf-8',
               'autoScriptToLang'   => TRUE,
               'autoLangToFont'     => TRUE,
               'format'             => $template[TEMPLATEPROPS_PAGE][TEMPLATEPROPS_PAGEFORMAT],
               'margin_top'         => $template[TEMPLATEPROPS_PAGE][TEMPLATEPROPS_PAGEMARGIN]["top"],
               'margin_left'        => $template[TEMPLATEPROPS_PAGE][TEMPLATEPROPS_PAGEMARGIN]["left"],
               'margin_right'       => $template[TEMPLATEPROPS_PAGE][TEMPLATEPROPS_PAGEMARGIN]["right"],
               'margin_bottom'      => $template[TEMPLATEPROPS_PAGE][TEMPLATEPROPS_PAGEMARGIN]["bottom"],
               'margin_header'      => 0,
               'margin_footer'      => 0
            ]);

            # Set document properties
            $mpdf->SetBasePath(substr($tplAbsDir, 0, strlen($tplAbsDir) - 1));
            $mpdf->SetCreator("Patho•Log");

            # Set components (html and styles)
            if (!empty($template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_STYLE])) {
               $css = Storage::disk('local')->get($tplStorageDir . $template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_STYLE]);
               $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
            }
            if (!empty($template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_BODY])) {
               $html = Storage::disk('local')->get($tplStorageDir . $template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_BODY]);
               $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
            }

            # Output the pdf file (synchronously)
            $mpdf->Output(Storage::disk('local')->path($tplStorageDir . TEMPLATE_PDF_FILENAME), \Mpdf\Output\Destination::FILE);
         }

         # Convert the pdf file to a jpg image (again, synchronously)
         if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            # Windows
            $strCmd = '"gswin64c.exe" ';
         } else {
            # Linux
            $strCmd = 'gs ';
         }
         
         $strCmd .= '-q -dQUIET -dSAFER -dBATCH -dNOPAUSE -dNOPROMPT -dMaxBitmap=500000000 -dAlignToPixels=0 ' .
            '-dGridFitTT=2 "-sDEVICE=jpeg" -dTextAlphaBits=4 -dGraphicsAlphaBits=4 "-r72x72" -dPrinted=false ' .
            '"-sOutputFile=' . $tplAbsDir . TEMPLATE_THUMBNAIL_FILENAME . '" "-f' . $tplAbsDir . TEMPLATE_PDF_FILENAME . '"';
         exec($strCmd);
      }
   }



}
