<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
require_once (dirname(__FILE__).'/meeting-functions.php');

//
require_once __DIR__.'/controller/meeting_function_controller.php';

//SE CREA NUEVA INSTANCIA DE LA CLASE CURL
$meetings_class = new curl();


/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://workinglive.us
 * @since      1.0.0
 *
 * @package    ZooIntegration
 * @subpackage Zoomintegration/admin/partials
 */
echo "<!-- This file should primarily consist of HTML with a little bit of PHP. -->";
?>
  <div class='container col-md-12 col-sm-12 col-lg-12'>
      <div class='row'>
      <a class='col-md-offset-7 col-md-3 inst-meeting-label' data-toggle='modal' href='#instant_modal'>Instant Meeting +</a>
      <a class='col-md-2 new-meeting-label' data-toggle='modal' href='#mi_modal'>New Meeting +</a> 
  </div>
<?php



/*$current_user = wp_get_current_user();
//$user_email = $current_user->user_email;

$user_email = "mateoramos1997@gmail.com";
echo ZOOM_URL."users/$user_email/meetings?page_size=30&type=scheduled";
$meetings=$meetings_class->body(ZOOM_URL."users/$user_email/meetings?page_size=30&type=scheduled",'GET',TOKEN,'');
$first_name=$current_user->user_firstname;
$last_name=$current_user->user_lastname;
$displayname = $current_user->display_name;
$primera = $meetings->meetings; 
$ordenada= sort_by_day($primera);*/
//print_meetings($ordenada,$displayname);
print_meetings();
//CUANDO SE ENVIA UNA INVITACION DE LA REUNION CREADA.(SEND INVITATION)
/*if(isset($_POST['to-email'])){
  if(isset($_POST['text-area'])){
    $emails = $_POST['to-email'];
    $str_arr = explode (",", $emails);
    $message=$_POST['text-area'];
    foreach($str_arr as $index => $email){
      wp_mail($email,"Zoom invitation",$message);
    }
}}
//GUARDA LAS REUNIONES CUANDO SE CREA UNA REUNION PROGRAMADA DESDE EL MODAL
if(isset($_POST['txt-date'])){
  if(isset($_POST['txt-time'])){
    $topic=$_POST['txt-modal'];
    $date=$_POST['txt-date'];
    $time=$_POST['txt-time'];
    if(empty($_POST['host-video1'])){
      $host = "false";
    }else{
      $host = "true";
    }
    if(empty($_POST['participant-video1'])){
      $participant = "false";
    }else{
      $participant = "true";
    }
    $start_time= $date.'T'.$time.':00Z';
    $timezone= $_POST['timezone'];
    $duration = 1;
    $type=2;
    $new_url= ZOOM_URL.'users/'.$user_email.'/meetings';
    echo $new_post = "{\"topic\":\"$topic\",\"type\":2,\"start_time\":\"$start_time\",\"duration\":\"1\",\"timezone\":\"$timezone\",\"settings\":{\"host_video\":\"$host\",\"participant_video\":\"$participant\"}}";
    $new_meeting = $meetings_class->body($new_url,'POST', TOKEN,$new_post);
    var_dump($new_meeting);
                                  //$email,$topic,$time,$duration,$type,$host_video,$participant_video,$tzone)
    //$new_meeting=createMeeting($user_email,$topic,$start_time,1,2,$host,$participant,$timezone);
    $tzone=$new_meeting['timezone'];
    $topic=$new_meeting['topic'];
    $starttime=$new_meeting['start_time'];
    $join = $new_meeting['join_url'];
    $meetingid = $new_meeting['id'];
    meetingContainer($starttime,$topic,$tzone,$meetingid,$join,$displayname);
 }}

//ELIMINA UNA RERUNION PROGRAMADA
 if (!empty($_POST)) {
  if (!empty($_POST['btn-delete'])) {
    $meeting_ID = $_POST['btn-delete'];
    delete_meeting($meeting_ID);
    ?>
    <script>
        function clearcontent(elementID) { 
            document.getElementById(elementID).innerHTML = ""; 
        } 
        clearcontent('form<?php echo $meeting_ID;?>');
    </script> 
    <?php
  }
}

//REUNION INSTANTANEA
if(isset($_POST['start-instant'])){
  if(empty($_POST['host-video'])){
    $host = "false";
  }else{
    $host = "true";
  }
  if(empty($_POST['participant-video'])){
    $participant = "false";
  }else{
    $participant = "true";
  }
  $type=1;
  $new_url= ZOOM_URL.'users/'.$user_email.'/meetings';
  $new_post = "{\"type\":1,\"duration\":\"2\",\"settings\":{\"host_video\":\"$host\",\"participant_video\":\"$participant\"}}";
  //$new_meeting=createMeeting($user_email,"","",2,1,$host,$participant);
  $new_meeting = $meetings_class->body($new_url,'POST', TOKEN,$new_post);
  $start=$new_meeting['start_url'];
  ?>
  <script>
  function openwin(url) {
      var a = document.createElement("a");
      a.setAttribute("href", url);
      a.setAttribute("target", "_blank");
      a.setAttribute("id", "openwin");
      document.body.appendChild(a);
      a.click();
        }
  openwin("<?php echo $start;?>");  
</script>
<?php
}*/
?>
 
<script>
$=jQuery;
$('input[type=radio]').click(function(){
    if (this.previous) {
        this.checked = false;
    }
    this.previous = this.checked;
});  
</script>
<!-- Estilos CSS -->
<style>
/**
 * All of the CSS for your admin-specific functionality should be
 * included in this file.
 */

</style>