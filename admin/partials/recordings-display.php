<?php
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

$recordings_class = new curl();
$user_recordings= json_decode($recordings_class->body(ZOOM_URL."users/$user_email/recordings?trash_type=meeting_recordings&mc=false&page_size=30",'GET',TOKEN,''));
$meetings=$user_recordings->meetings;
//$user_recordings=get_user_recordings($user_email);
/*echo"<pre>";
print_r($user_recordings);
echo"</pre>";*/

?>
<div class='row row-date'>
    <label class='label label-date'><h2 class='label label-date' >Recordings</h2></label>
</div>
<?php
print_recordings($meetings); 
?>
<style>

   
</style>