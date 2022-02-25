<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CtrlHome extends Controller
{
   # Home #########################################################################################
   public function Home() {
      $data['head_title'] = "Patho•Log | Create, archive, and share pathology reports for free!";
      $data['head_description'] = "Free service to create stylish pathology reports, archive them, and share them with your patients and other doctors.";
      $data['ogmeta_title'] = $data['head_title'];
      $data['ogmeta_description'] = $data['head_description'];
      $data['ogmeta_image'] = "/img/home/social-share.jpg"; // Must be JPG
      $data['ogmeta_url'] = config('app.url');
      $data['ogmeta_type'] = "website";
      $data['navbar_ishome'] = TRUE;

      echo view('home.asset-header', $data);
      echo view('home.page-home');
      echo view('home.asset-footer');
   }


   # Terms & Conditions ###########################################################################
   public function TermsConditions() {
      $data['head_title'] = "Terms and Conditions | Patho•Log";
      $data['head_description'] = "Patho•Log's Terms and Conditions";
      $data['ogmeta_title'] = $data['head_title'];
      $data['ogmeta_description'] = $data['head_description'];
      $data['ogmeta_image'] = "/img/home/social-share.jpg"; // Must be JPG
      $data['ogmeta_url'] = config('app.url') . "/terms-conditions";
      $data['ogmeta_type'] = "article";
      $data['navbar_ishome'] = FALSE;

      echo view('home.asset-header', $data);
      echo view('home.page-termsconds');
      echo view('home.asset-footer');
   }


   # Privacy Policy ###############################################################################
   public function PrivacyPolicy() {
      $data['head_title'] = "Privacy Policy | Patho•Log";
      $data['head_description'] = "Patho•Log's Privacy Policy";
      $data['ogmeta_title'] = $data['head_title'];
      $data['ogmeta_description'] = $data['head_description'];
      $data['ogmeta_image'] = "/img/home/social-share.jpg"; // Must be JPG
      $data['ogmeta_url'] = config('app.url') . "/privacy-policy";
      $data['ogmeta_type'] = "article";
      $data['navbar_ishome'] = FALSE;

      echo view('home.asset-header', $data);
      echo view('home.page-prvpolicy');
      echo view('home.asset-footer');
   }


   # Frequently Asked Questions (FAQs) ############################################################
	public function FrequentlyAskedQuestions() {
      $data['head_title'] = "Frequently Asked Questions | Patho•Log";
      $data['head_description'] = "Patho•Log's Frequently Asked Questions";
      $data['ogmeta_title'] = $data['head_title'];
      $data['ogmeta_description'] = $data['head_description'];
      $data['ogmeta_image'] = "/img/home/social-share.jpg"; // Must be JPG
      $data['ogmeta_url'] = config('app.url') . "/frequently-asked-questions";
      $data['ogmeta_type'] = "article";
      $data['navbar_ishome'] = FALSE;

      echo view('home.asset-header', $data);
      echo view('home.page-faqs');
      echo view('home.asset-footer');
   }
}