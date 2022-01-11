<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class CtrlResources extends Controller
{
   # Home #########################################################################################
   public function TemplateThumbnail($tplID) {
      $imgStoragePath = TEMPLATE_STORAGE_DIRNAME . "/" . $tplID . "/" . TEMPLATE_THUMBNAIL_FILENAME;

      # If the thumbnail does not exist, create it (synchronously)
      if (Storage::disk('local')->missing($imgStoragePath)) template_create_thumbnail($tplID);

      # Return the image
      return response()->file(Storage::disk('local')->path($imgStoragePath));
   }


}