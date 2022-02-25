<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; # Needed for: template_create_thumbnail(), template_create_preview(), clean_oldrepprevs()


#
# Returns user value if exists, otherwise returns defualt template-defined value ##################
#
if (!function_exists('template_user_or_def')) {
   function template_user_or_def($def, $user, $depth1, $depth2, $depth3) {
      if (empty($depth1)) return $def;

      if (empty($depth2)) {
         if (empty($user)) return $def[$depth1];
         if (empty($user[$depth1])) return $def[$depth1];
         return $user[$depth1];
      }

      if (empty($depth3)) {
         if (empty($user)) return $def[$depth1][$depth2];
         if (empty($user[$depth1])) return $def[$depth1][$depth2];
         if (empty($user[$depth1][$depth2])) return $def[$depth1][$depth2];
         return $user[$depth1][$depth2];
      }

      if (empty($user)) return $def[$depth1][$depth2][$depth3];
      if (empty($user[$depth1])) return $def[$depth1][$depth2][$depth3];
      if (empty($user[$depth1][$depth2])) return $def[$depth1][$depth2][$depth3];
      if (empty($user[$depth1][$depth2][$depth3])) return $def[$depth1][$depth2][$depth3];

      return $user[$depth1][$depth2][$depth3];
   }
}


#
# Delete old ReportPreview files (pdfs & jpgs & any other files) ##################################
#
if (!function_exists('clean_oldrepprevs')) {
   function clean_oldrepprevs() {
      #
      # This function will delete ALL files older than the set MaxTimeout
      # but not recursively, only those files in the folder itself.
      #
      $pvwPath = Storage::disk('local')->path(PREVIEW_STORAGE_DIRNAME); # No backslash at the end

      if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
         # Should run on Windows 7 and later
         $Dir = str_replace("/", "\\", $pvwPath); # Needed for Windows
         $ExpDays = TEMPLATE_TEMP_MAXTIMEOUT_DAYS;

         # FORFILES
         #  /P     Indicates the path to start searching.
         #  /D     Date. less than or equal to (-) the current date minus "dd" days.
         #  /C     Indicates the command to execute for each file. Command strings should be wrapped in double quotes.
         #  @file  returns the name of the file.
         #  @path  returns the full path of the file.
         #  @isdir returns "TRUE" if a file type is a directory, and "FALSE" for files.
         # CMD
         #  /C     Carries out the command specified by string and then terminates.
         # DEL
         #  /F     Force deleting of read-only files.
         #  /Q     Quiet mode, do not ask if ok to delete on global wildcard.
         exec("ForFiles /P \"$Dir\" /D -$ExpDays /C \"cmd /c if @isdir==FALSE del /f /q @path\"");
      } else {
         # Should run on any kind of linux
         $Dir = $pvwPath . '/';
         $ExpMinutes = intval(TEMPLATE_TEMP_MAXTIMEOUT_DAYS) * 24 * 60;
         exec("find \"$Dir\" -maxdepth 1 -type f -mmin +$ExpMinutes -exec rm {} \\;");
      }
   }
}


#
# Google's reCAPTCHA v3 check #####################################################################
#
if (!function_exists('reCAPTCHAv3Check')) {
   function reCAPTCHAv3Check($recaptchaToken, $action, $ip) {
      # Note: $recaptchaToken MUST be sanitized before passing to this function

      # Send request to Google
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $data = array("secret" => config('app.GreCAPTCHAv3_SecretKey'), "response" => $recaptchaToken, "remoteip" => $ip);
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
      if (in_array($responseKeys["hostname"], [
            "local.patho-log.com",
            "localhost",
            "dev.patho-log.com",
            "patho-log.com",
            "www.patho-log.com",
            "78.188.71.116"
            ]) == FALSE) {
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
      # In Windows, the background process shows a window, and this is good because we can see php's
      # debug info there (also warning or errors). In Linux server, write output to log instead.
      # NOTE: In Windows, you need to have php.exe in your system environment settings.

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
   // if (!function_exists('create_random_userpicurl')) {
   //    function create_random_userpicurl() {
   //       $picfolder = public_path(PATH_USER_PREDEFINEDPICTURES); # No "/" at the end
   //       $fileListTemp = scandir($picfolder);
   //       $fileList = array();

   //       if (count($fileListTemp) < 1) return "";
   //       for ($iC = 0; $iC < count($fileListTemp); $iC++) {
   //          if (strtoupper(substr($fileListTemp[$iC], 0, 7)) == "USERPIC") {
   //             if (is_dir($picfolder . "/" . $fileListTemp[$iC]) == false) array_push($fileList, $fileListTemp[$iC]);
   //          }
   //       }

   //       if (count($fileList) < 1) return "";
         
   //       # It MUST be a url usable DIRECTLY by <img src="">
   //       return '/' . PATH_USER_PREDEFINEDPICTURES . '/' . $fileList[random_int(0, count($fileList) - 1)];
   //    }
   // }


   #
   # Get a Grevatar for the email-registered user #################################################
   #
   // if (!function_exists('get_gravatar_userpicurl')) {
   //    function get_gravatar_userpicurl($email) {
   //       # @source https://gravatar.com/site/implement/images/php/
   //       $s = 175; # Size in pixels, defaults to 175px [ 1 - 2048 ]
   //       $d = 'mp'; # Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
   //       $r = 'g'; # Maximum rating (inclusive) [ g | pg | r | x ]
   //       $img = false; # True to return a complete IMG tag False for just the URL
   //       $atts = array(); # Optional, additional key/value attributes to include in the IMG tag

   //       $url = 'https://www.gravatar.com/avatar/';
   //       $url .= md5(strtolower(trim($email)));
   //       $url .= "?s=$s&d=$d&r=$r";
   //       if ($img) {
   //          $url = '<img src="' . $url . '"';
   //          foreach ($atts as $key => $val) {
   //             $url .= ' ' . $key . '="' . $val . '"';
   //          }
   //          $url .= ' />';
   //       }

   //       return $url;
   //    }
   // }


   #
   # returns an array of template fields belonging to a specific template step
   #
   if (!function_exists('get_template_step_fields')) {
      function get_template_step_fields($fields, $stepname) {
         $stepfields = [];

         foreach ($fields as $field) {
            if ($field["class"] == "step_" . $stepname) array_push($stepfields, $field);
         }

         return $stepfields;
      }
   }


   #
   # Compile template's html (html passed as a reference to a string)
   #
   if (!function_exists('template_compile_html')) {
      function template_compile_html(&$html, $fieldsDef, $fieldsUser) {
         foreach ($fieldsDef as $field) {
            if (array_key_exists($field["const"], $fieldsUser)) {
               $html = str_replace($field["const"], $fieldsUser[$field["const"]], $html);
            } else {
               $html = str_replace($field["const"], $field["data"], $html);
            }
         }
      }
   }


   #
   # Create a template's thumbnail image
   #
   if (!function_exists('template_create_thumbnail')) {
      function template_create_thumbnail($tpl_id) {
         /*
         This function MUST be synchronous
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
            $mpdf->SetBasePath(Storage::disk('local')->path(TEMPLATE_STORAGE_DIRNAME . "/"));
            $mpdf->SetCreator("Patho•Log");

            # Set components (html and styles)
            if (!empty($template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_STYLE])) {
               $css = Storage::disk('local')->get($tplStorageDir . $template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_STYLE]);
               $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
            }
            if (!empty($template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_BODY])) {
               $html = Storage::disk('local')->get($tplStorageDir . $template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_BODY]);
               template_compile_html($html, $template[TEMPLATEPROPS_FIELDS], []);
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

         # Should send an image with a width (90 x 2 = 180px) because we have set the width to a fixed 90px to workaround
         # Firefox bug (see CtrlPortal -> NewReport() method). BUT I haven't figure out how to set the image dimaention in
         # GS (for JPG images)!
         $strCmd .= '-dSAFER -dBATCH -dNOPAUSE -dNOPROMPT -dMaxBitmap=15000000 -sDEVICE=jpeg -dJPEGQ=75 -dTextAlphaBits=1 ' .
            '-dGraphicsAlphaBits=1 -r72x72 -dPrinted=false ' .
            '"-sOutputFile=' . $tplAbsDir . TEMPLATE_THUMBNAIL_FILENAME . '" "-f' . $tplAbsDir . TEMPLATE_PDF_FILENAME . '"';

         exec($strCmd);
      }
   }


   #
   # Create a template's preview image
   #
   if (!function_exists('template_create_preview')) {
      function template_create_preview($userData, $imgId) {
         /*
         - This function MUST be synchronous
         - $userData members are written in /public/js/portal/newreport.js. They are the same members of g_oReportData.
         */
         $tplId = $userData[TEMPLATE_USERDATA_TPLID];
         $tplStorageDir = TEMPLATE_STORAGE_DIRNAME . "/"; # Ends with a backslash

         # Load the template
         $template = json_decode(Storage::disk('local')->get($tplStorageDir . $tplId . "/" . TEMPLATE_PROPS_FILENAME), true);

         # Create a PDF object, setting its properties
         $pageFormat = template_user_or_def($template, $userData, TEMPLATEPROPS_PAGE, TEMPLATEPROPS_PAGEFORMAT, NULL);
         $pageMarginTop = template_user_or_def($template, $userData, TEMPLATEPROPS_PAGE, TEMPLATEPROPS_PAGEMARGIN, "top");
         $pageMarginLeft = template_user_or_def($template, $userData, TEMPLATEPROPS_PAGE, TEMPLATEPROPS_PAGEMARGIN, "left");
         $pageMarginRight = template_user_or_def($template, $userData, TEMPLATEPROPS_PAGE, TEMPLATEPROPS_PAGEMARGIN, "right");
         $pageMarginBottom = template_user_or_def($template, $userData, TEMPLATEPROPS_PAGE, TEMPLATEPROPS_PAGEMARGIN, "bottom");

         $mpdf = new \Mpdf\Mpdf([
            'mode'               => 'utf-8',
            'autoScriptToLang'   => TRUE,
            'autoLangToFont'     => TRUE,
            'format'             => $pageFormat,
            'margin_top'         => $pageMarginTop,
            'margin_left'        => $pageMarginLeft,
            'margin_right'       => $pageMarginRight,
            'margin_bottom'      => $pageMarginBottom,
            'margin_header'      => 0,
            'margin_footer'      => 0
         ]);

         # Set document properties
         $mpdf->SetBasePath(Storage::disk('local')->path(TEMPLATE_STORAGE_DIRNAME . "/"));
         $mpdf->SetCreator("Patho•Log");

         # Set components (html and styles)
         if (!empty($template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_STYLE])) {
            $css = Storage::disk('local')->get($tplStorageDir . $tplId . "/" . $template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_STYLE]);
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
         }
         if (!empty($template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_BODY])) {
            $html = Storage::disk('local')->get($tplStorageDir . $tplId . "/" . $template[TEMPLATEPROPS_COMPONENTS][TEMPLATEPROPS_BODY]);
            template_compile_html($html, $template[TEMPLATEPROPS_FIELDS], empty($userData[TEMPLATEPROPS_FIELDS]) ? [] : $userData[TEMPLATEPROPS_FIELDS]);
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
         }

         
         clean_oldrepprevs(); # Delete old previews (pdfs & jpgs)
         
         # Output the pdf file (synchronously)
         $pvwDir = PREVIEW_STORAGE_DIRNAME . "/"; # Ends with a slash
         $pdfFilePath = Storage::disk('local')->path($pvwDir . sprintf(TEMPLATE_TEMPPDF_FILENAME, $imgId));
         $jpgFilePath = Storage::disk('local')->path($pvwDir . sprintf(TEMPLATE_TEMPJPG_FILENAME, $imgId));
         $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

         # Convert the pdf file to a jpg image (again, synchronously)
         $strCmd = "";
         if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') $strCmd = '"gswin64c.exe"'; else $strCmd = 'gs';
         $strCmd .= ' ';
         
         $strCmd .= '-q -dQUIET -dSAFER -dBATCH -dNOPAUSE -dNOPROMPT -dMaxBitmap=500000000 -dAlignToPixels=0 -sDEVICE=jpeg ' .
            '-dJPEGQ=95 -dGridFitTT=2 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r150x150 -dPrinted=false "-sOutputFile=' .
            $jpgFilePath . '" "-f' . $pdfFilePath . '"';

         exec($strCmd);
      }
   }


   #
   # Create an HTML script representing a template step
   #
   if (!function_exists('create_templatestep_html')) {
      function create_templatestep_html($stepFields) {
         $html =
               '<form><br/>';

         foreach ($stepFields as $field) {
            if ($field["type"] == "PLAINTEXT") { # ------------------------------------------------
               $inputTag = '<input type="text" class="form-control"';
               if (!empty($field["idname"])) $inputTag .= ' id="' . $field["idname"] . '" name="' . $field["idname"] . '"';
               if (!empty($field["placeholder"])) $inputTag .= ' placeholder="' . $field["placeholder"] . '"';
               if (!empty($field["maxstrlen"])) $inputTag .= ' maxlength="' . $field["maxstrlen"] . '"';
               $inputTag .= ' required>';

               $html .=
                  '<div class="form-group">' .
                     '<label for="' . $field["idname"] . '">' . $field["label"] . ':</label>' .
                     $inputTag .
                  '</div>';
            } else
            if ($field["type"] == "OPTION") { # ---------------------------------------------------
               $grpClass = 'form-group';
               $cntStyle = "";
               if (!empty($field["width"])) $cntStyle .= 'width:' . $field["width"] . ';';
               if (!empty($field["min-w"])) $cntStyle .= 'min-width:' . $field["min-w"] . ';';
               if (!empty($field["max-w"])) $cntStyle .= 'max-width:' . $field["max-w"] . ';';
               if (!empty($field["orientation"])) {
                  if ($field["orientation"] == "row") {
                     $grpClass .= ' d-flex flex-row align-items-baseline';
                     $cntStyle .= 'display:flex;flex-direction:row;align-items:center;justify-content:space-between;';
                  }
               }
               $styleLbl = "";
               if (!empty($field["label-width"])) $styleLbl .= 'width:' . $field["label-width"] . ';';

               $html .=
                  '<div class="' . $grpClass . '">' .
                     '<label' . (strlen($styleLbl) > 0 ? ' style="' . $styleLbl . '"' : '') . '>' . $field["label"] . ':</label>' .
                     '<div' . (strlen($cntStyle) > 0 ? ' style="' . $cntStyle . '"' : '') . '>';
               for ($iC = 0; $iC < count($field["options"]); $iC++) {
                  $html .=
                        '<div class="custom-control custom-radio">' .
                           '<input class="custom-control-input" type="radio" id="' . $field["options"][$iC]["id"] . '" name="' . $field["name"] . '">' .
                           '<label for="' . $field["options"][$iC]["id"] . '" class="custom-control-label">' . $field["options"][$iC]["label"] . '</label>' .
                        '</div>';
               }
               $html .=
                     '</div>' .
                  '</div>';
            } else
            if ($field["type"] == "NUMBER") { # ---------------------------------------------------
               $grpClass = 'form-group';
               $cntStyle = "";
               if (!empty($field["width"])) $cntStyle .= 'width:' . $field["width"] . ';';
               if (!empty($field["min-w"])) $cntStyle .= 'min-width:' . $field["min-w"] . ';';
               if (!empty($field["max-w"])) $cntStyle .= 'max-width:' . $field["max-w"] . ';';
               if (!empty($field["orientation"])) {
                  if ($field["orientation"] == "row") {
                     $grpClass .= ' d-flex flex-row align-items-baseline';
                     $cntStyle .= 'display:flex;flex-direction:row;align-items:center;justify-content:space-between;';
                  }
               }
               $styleLbl = "";
               if (!empty($field["label-width"])) $styleLbl .= 'width:' . $field["label-width"] . ';';
               $inputTag = '<input type="number" class="form-control"';
               if (!empty($field["idname"])) $inputTag .= ' id="' . $field["idname"] . '" name="' . $field["idname"] . '"';
               if (!empty($field["placeholder"])) $inputTag .= ' placeholder="' . $field["placeholder"] . '"';
               if (!empty($field["minmax"])) $inputTag .= ' min="' . $field["minmax"][0] . '" max="' . $field["minmax"][1] . '"';
               $inputTag .= ' required>';

               $html .=
                  '<div class="' . $grpClass . '">' .
                     '<label' . (empty($field["idname"]) ? '' : ' for="' . $field["idname"] . '"') . (strlen($styleLbl) > 0 ? ' style="' . $styleLbl . '"' : '') . '>' . $field["label"] . ':</label>' .
                     '<div' . (strlen($cntStyle) > 0 ? ' style="' . $cntStyle . '"' : '') . '>' .
                        $inputTag;

               if (!empty($field["sep-width"])) {
                  $html .=
                        '<div style="height:100%;width:' . $field["sep-width"] . ';"></div>';
               }

               if (!empty($field["addOptions"])) {
                  $html .=
                        '<select class="form-control" id="' . $field["addid"] . '">';
                  for ($iC = 0; $iC < count($field["addOptions"]); $iC++) {
                     $html .=
                           '<option' . (empty($field["defOptionIdx"]) ? '' : (intval($field["defOptionIdx"]) != $iC ? '' : ' selected')) . '>' . $field["addOptions"][$iC] . '</option>';
                  }

                  $html .=
                        '</select>';
               }

               $html .=
                     '</div>' .
                  '</div>';
            }
         }
         
         $html .=
               '</form>';
         return $html;

         // Also return an autofucus (specific to step)
         // cannot do this here because the DOM is already ready before the Ajax request
      }
   }


}
