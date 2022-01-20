<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class CtrlResources extends Controller
{
   # Template Report Thumbnail Real Image #########################################################
   public function TemplateThumbnail($tplID) {
      $imgStoragePath = TEMPLATE_STORAGE_DIRNAME . "/" . $tplID . "/" . TEMPLATE_THUMBNAIL_FILENAME;

      //
      // $tplID MUST be sanitized first!
      //

      # If the thumbnail does not exist, create it (synchronously)
      if (Storage::disk('local')->missing($imgStoragePath)) template_create_thumbnail($tplID);

      # Return the image
      return response()->file(Storage::disk('local')->path($imgStoragePath));
   }


   # Report Preview Real Image ####################################################################
   public function ReportPreview($imgId) {
      # The image must have been already created (from the pdf) and is now already exists.
      # (This is in order to serve the front-end with the image immediately)

      //
      // $imgId MUST be sanitized first!
      //

      $imgStoragePath = PREVIEW_STORAGE_DIRNAME . "/" . sprintf(TEMPLATE_TEMPJPG_FILENAME, $imgId);

      # If the thumbnail does not exist, create it (synchronously)
      if (Storage::disk('local')->exists($imgStoragePath)) {
         return response()->file(Storage::disk('local')->path($imgStoragePath));
      }
   }
   
}