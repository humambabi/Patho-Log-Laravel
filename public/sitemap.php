<?php
#
# Dynamic sitemap.xml generator
# By: Humam Babi (humam_babi@yahoo.com), 2021
#

define('PL_LIVE_BASEURL', "https://www.patho-log.com"); # The base_uri of the live version

// General constants
define('OUTPUT_FILENAME', 'sitemap.xml');
define('NL', chr(0x0D) . chr(0x0A));
define('INDENT', '   ');


###################################################################################################
function AddURL($url, $file4time, $changefreq, $priority) {
   $Ret = '<url>' . NL;
   $Ret .= INDENT . '<loc>' . $url . '</loc>' . NL;
   $Ret .= INDENT . '<lastmod>' . date(DATE_ATOM, filemtime(__DIR__ . '/' . $file4time)) . '</lastmod>' . NL;
   $Ret .= INDENT . '<changefreq>' . $changefreq . '</changefreq>' . NL;
   $Ret .= INDENT . '<priority>' . $priority . '</priority>' . NL;
   $Ret .= '</url>' . NL;

   return $Ret;
}


###################################################################################################
function CreateSiteMap() {
   // XML file header
   $Str = '<?xml version="1.0" encoding="UTF-8"?>' . NL . NL;

   // Schema definitions - specific to sitemaps
   $Str .= '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" ';
   $Str .= 'xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" ';
   $Str .= 'xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"';
   $Str .= '>' . NL . NL;

   // Add known pages
   $Str .= AddURL(PL_LIVE_BASEURL, 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/terms-conditions', 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/privacy-policy', 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/frequently-asked-questions', 'index.php', 'weekly', '1.0') . NL;
   
   $Str .= AddURL(PL_LIVE_BASEURL . '/login', 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/register', 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/forgotpw', 'index.php', 'weekly', '1.0') . NL;
   
   $Str .= AddURL(PL_LIVE_BASEURL . '/newreport', 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/howto', 'index.php', 'weekly', '1.0') . NL;
   $Str .= AddURL(PL_LIVE_BASEURL . '/contact', 'index.php', 'weekly', '1.0') . NL;

   // Close the 'urlset' tag
   $Str .= '</urlset>';

   return $Str;
}


// Script entry-point
header('Content-type: application/xml');
header('Content-disposition: attachment; filename="' . OUTPUT_FILENAME . '"');
header('Content-Transfer-Encoding: utf-8');
header('Content-Description: File Transfer');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$XML = CreateSiteMap();
header('Content-Length: ' . strlen($XML));

if (ob_get_length()) ob_clean();
flush();
echo $XML;
exit;
?>