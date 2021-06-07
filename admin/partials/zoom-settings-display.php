<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
require_once (dirname(__FILE__).'/meeting-functions.php');
require_once __DIR__.'/controller/curl.php';
require_once __DIR__.'/config/config.php';
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://workinglive.us
 * @since      1.0.0
 *
 * @package    ZoomIntegration
 * @subpackage ZoomIntegration/public/partials
 */
 echo "<!-- This file should primarily consist of HTML with a little bit of PHP. -->";
$current_user = wp_get_current_user();
$user_email = $current_user->user_email;

//$user_settings = get_user_settings($user_email);



if(isset($_POST['btn-save'])){
  
  if( isset($_POST['use_pmi']) && $_POST['use_pmi'] == '1'){
 
    $pmi_for_scheduled2 = 'true';
  }else{

    $pmi_for_scheduled2 = 'false';
  }
  
  if(isset($_POST['waiting_room']) && $_POST['waiting_room'] == '1'){
    $waiting_room2 = 'true';
  }else{
    $waiting_room2 = 'false';
  }
  
  if(isset($_POST['require_password']) && $_POST['require_password'] == '1'){
   // $require_password_pmi2 = 'true';
    $require_password_sch2 = 'true';
  }else{
   // $require_password_pmi2 = 'true';
    $require_password_sch2 = 'false';
  }
  
  if(isset($_POST['facebook_live']) && $_POST['facebook_live'] == '1'){
    $live_streaming2 = 'true';
  }else{
    $live_streaming2 = 'false';
  }
  if(isset($_POST['breakout_rooms']) && $_POST['breakout_rooms'] == '1'){
    $breakout_rooms2 = 'true';
  }else{
    $breakout_rooms2 = 'false';
  }  
 //auto_recording

// echo $_POST['chk_auto_recording'];
  if(isset($_POST['chk_auto_recording']) && $_POST['chk_auto_recording'] == '1'){
    $auto_recording = "cloud";
  }else{
    $auto_recording = 'none';
  }  

  if(isset($_POST['screen_sharing']) && $_POST['screen_sharing'] == '1'){
    $screen_sharing = "true";
  }else{
    $screen_sharing = 'false';
  } 
  if(isset($_POST['recording_audio_transcript']) && $_POST['recording_audio_transcript'] == '1'){
    $recording_audio_transcript = "true";
  }else{
    $recording_audio_transcript = 'false';
  } 
  update_zoom_settings($user_email,$pmi_for_scheduled2,'','',$require_password_sch2,$waiting_room2,$live_streaming2,$breakout_rooms2, $auto_recording,$screen_sharing,$recording_audio_transcript);
}

$settings_class = new curl();
$user_settings= json_decode($settings_class->body(ZOOM_URL."users/$user_email/settings",'GET',TOKEN,''),true);
/*echo"<pre>";
print_r($user_settings);
echo"</pre>";*/
print_settings($user_settings);
?>
<style>

</style>

