<?php
//SE IMPÓRTAN LOS ARCHIVOS DE CONFIGURACION Y EL CURL 
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/curl.php';
require_once __DIR__.'/../meeting-functions.php';
//SE CREA UNA NUEVA INSTANCIA DEL CURL PARA MANEJAR COONSULTAS A LA API DE ZOOM

$curl_class = new curl();
//$current_user = wp_get_current_user();
//$user_email = $current_user->user_email;

function print_meetings(){
    $unique=array();
    //OBTIONE EL USUARIO QUE INICIO SESION
    $current_user = wp_get_current_user();
    $user_email = $current_user->user_email;
    //OBTIENE TODAS LAS REUNIONES DEL USUARIO QUE INICIO SESION
    $meetings_class = new curl();
    $meetings= json_decode($meetings_class->body(ZOOM_URL."users/$user_email/meetings?page_size=30&type=scheduled",'GET',TOKEN,''));
    //var_dump($meetings);
    $first_name=$current_user->user_firstname;
    $last_name=$current_user->user_lastname;
    $displayname = $current_user->display_name;
    $primera = $meetings->meetings; 
    //ORDENA TODAS LAS REUNIONES POR DIAS
    if( empty($primera)){
        return false;
    }else{
    //empieza else        
    foreach($primera as $index => $meeting_object) {
        $time_stamp = $meeting_object->start_time;
        $date=strtotime($time_stamp);
        $time=getdate($date);//convierte en array asociativo y puedo acceder por claves day,month,year etc
        $time2=date('h:i A', $date);
        $day=$time['mday'];
        $month=$time['month'];
        $year=$time['year'];
        $day_and_month = $day.' '.$month.' '.$year;//23 January 2020
        if( array_key_exists($day_and_month,$unique)){
            array_push($unique[$day_and_month],$meeting_object);
        }else{
            $unique[$day_and_month] = [$meeting_object] ;
        }
    }
   //return $unique;  
    }
//MUESTRA LAS REUNIONES ORDENADAS
    foreach($unique as $day => $display_name){
        echo"<div class='row row-date'>";
        echo"    <label class='label label-date'>$day</label>";
        echo"</div>";
        foreach($display_name as $index => $meeting){
            $tzone=$meeting->timezone;
            $topic=$meeting->topic;
            $start_time=$meeting->start_time;
            $join = $meeting->join_url;
            $meetingid = $meeting->id;
    //LLAMA AL CONTENEDOR DE LAS REUNIONES
            $start_url_data= json_decode($meetings_class->body(ZOOM_URL."meetings/$meetingid",'GET',TOKEN,''),true);
            meetingContainer($start_time,$topic,$tzone,$meetingid,$join,$displayname,$start_url_data);
            
        }
    }
    echo"</div>";
}
//Crea una reunion programada
if(isset($_POST['btn_createmeeting'])){
  $user_email = "roger@o2gmail.com";
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
      $new_post = "{\"topic\":\"$topic\",\"type\":2,\"start_time\":\"$start_time\",\"duration\":\"1\",\"timezone\":\"$timezone\",\"settings\":{\"host_video\":\"$host\",\"participant_video\":\"$participant\"}}";
      $new_meeting = json_decode($curl_class->body($new_url,'POST', TOKEN,$new_post));
   }
}
//Elimina la reunion

  if (isset($_POST['btn-delete'])){
    $meeting_ID = $_POST['btn-delete'];
    $curl_class->body(ZOOM_URL."meetings/$meeting_ID",'DELETE',TOKEN,'');
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
  $new_meeting = json_decode($curl_class->body($new_url,'POST', TOKEN,$new_post));
  $start=$new_meeting->start_url;
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
}

