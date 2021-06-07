<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/controller/curl.php';

//SE CREA NUEVA INSTANCIA DE LA CLASE CURL

//$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ";
//funcion retorna dia y mes como string de un timestamp
/*function day_month($timestamp){
    $date=strtotime($timestamp);
    $time=getdate($date);//convierte en array asociativo y puedo acceder por claves day,month,year etc
    $time2=date('h:i A', $date);
    $day=$time['mday'];
    $month=$time['month'];
    $year=$time['year'];
    return $day.' '.$month.' '.$year;//23 January 2020
}*/
//Funcion ordenar por dias
//Recive un array de meetings [ [0] => Object([id]=>dsfdsvsadfd,[joinurl]=>htths:zoom.us/j/fdsfdsfd/.....),... ]
/*function sort_by_day($array){
    if( empty($array)){
        return false;
    }else{
    //empieza else    
    $unique=array();    
    foreach($array as $index => $meeting_object) {
        $time_stamp = $meeting_object->start_time;
        $day_and_month = day_month($time_stamp);
        if( array_key_exists($day_and_month,$unique)){
            array_push($unique[$day_and_month],$meeting_object);
        }else{
            $unique[$day_and_month] = [$meeting_object] ;
        }
    }
    return $unique;  
    }//termina else  
}*/
//funcion para recorrer el array asociativo
/*function print_meetings($array,$display_name){
    foreach($array as $day => $arrayM){
        echo"<div class='row row-date'>";
        echo"    <label class='label label-date'>$day</label>";
        echo"</div>";
        foreach($arrayM as $index => $meeting){
            $tzone=$meeting->timezone;
            $topic=$meeting->topic;
            $start_time=$meeting->start_time;
            $join = $meeting->join_url;
            $meetingid = $meeting->id;
            meetingContainer($start_time,$topic,$tzone,$meetingid,$join,$display_name);
        }
    }
    echo"</div>";
}*/

//funcion para obtener todas las reuniones
/*function getMeetings($email){
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.zoom.us/v2/users/$email/meetings?page_size=30&type=scheduled",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_TIMEOUT => 60,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ",
  ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    return json_decode($response);
  }
}*/
function meetingContainer($startt,$topic,$timez,$meetingid,$join_url,$display_name,$start_url_data){
    $date=strtotime($startt);
    $timeArray=getdate($date);
    $day=$timeArray['mday'];
    $month=$timeArray['month'];
    $year=$timeArray['year'];
    $time2=date('h:i A', $date);
    //$start_url_data=get_start_url($meetingid);
    $start_url = $start_url_data['start_url'];
?>
  <form class="row frm" method="POST" action="" name="meetingform" id="form<?php echo $meetingid;?>">
    <div class="col-md-4 col-sm-4 col-xs-12 first-meeting-column">
        <label class="label-title-meeting col-xs-12"><?php echo $time2; ?></label>
        <label class="label-body-meeting col-xs-12"><?php echo $time2.'  '.$timez; ?></label>
        <a class="btn col-xs-7" style="text-decoration: none; border-radius: 50px;" data-toggle="modal" href="#mi_modal<?php echo $meetingid; ?>">Send Invitation</a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12 second-meeting-column">
        <label class="label-title-meeting col-xs-12"><?php echo $topic;?></label>
        <label class="label-body-meeting col-xs-12" name="lbl-meeting">Meeting ID: <?php echo $meetingid;?></label>
        <button class="btn col-xs-7 " style="border-radius: 50px;" id="<?php echo $meetingid;?>" value="<?php echo $join_url;?>">Copy Invitation</button>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12 ">
      <div class="button-container">
          <a class="col-sm-offset-1 col-sm-3 col-xs-offset-1 col-xs-3 btn start" style="border-radius: 10px;" id="btn-start" name="btn-start" href="<?php echo $start_url;?>" target="_blank" value="<?php echo $meetingid;?>">Start</a>
          <!--<button class="col-sm-offset-1 col-sm-3 col-xs-offset-1 col-xs-3 btn edit" style="border-radius: 10px;" >Edit</button>-->
          <button class="col-sm-offset-1 col-sm-3 col-xs-offset-1 col-xs-3 btn remove" name="btn-delete" id="btn-delete"  value="<?php echo $meetingid;?>" style="border-radius: 10px;" type="submit" >Delete</button>
      </div>
    </div>  
    </form>
    <!--Modal send invitation-->
    <form method="POST">
    <div class="modal fade" id="mi_modal<?php echo $meetingid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top:100px;border-radius: 100px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" >
           <h5 class="modal-title" id="myModalLabel" style="text-align:center">Send Invitation</h5>
        <div class="modal-body">
          <div class="row" >
          <div class="row col-md-12">
              <label class="col-md-offset-1 col-md-2 lbl-topic">To:</label>
              <input class="col-md-8 txt-modal" name="to-email" placeholder="Comma separated emails" type="text"/>
          </div>

          <div class="row col-md-12">
              <label class="col-md-offset-1 col-md-2 lbl-topic">Message  </label>
              <textarea class="col-md-8 " id="text-area" name="text-area" rows="10" cols="50"><?php echo $display_name;?> is inviting you to join in a Zoom call
              Date: <?php echo $time2;?>

              URL: <?php echo $join_url;?>

              </textarea>

          </div>
          <!--Send-->
          <div class="row col-md-12" style="margin-top: 15px;">
            <button id="btn-send" class="btn btn-primary col-md-offset-6 col-md-2" data-dismiss="" type='submit' name="btn_sendinvitation">Send</button>
          </div>
          </div>
        </div>
        </div>
      </div>
    </div>
    </div>
    </form>
    <script>
        $=jQuery;
        $(document).ready(function(){
            $('#<?php echo $meetingid;?>').click(function(event){
                event.preventDefault();
                copiarAlPortapapeles('<?php echo $meetingid;?>');
            alert('URL Copied!');
                });
        });
        function copiarAlPortapapeles(id_elemento) {
                var aux = document.createElement("input");
                aux.setAttribute("value", document.getElementById(id_elemento).value);
                document.body.appendChild(aux);
                aux.select();
                document.execCommand("copy");
                document.body.removeChild(aux);
        }
    </script>
    <hr> 
<!--Modal Para crear una nueva Reunion-->
<form method="post" name="frm_newmeeting" id="frm_newmeeting">
 <div class="modal fade" id="mi_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top:100px;border-radius: 100px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" >
           <h5 class="modal-title" id="myModalLabel" style="text-align:center">NEW MEETING</h5>
        <div class="modal-body">
        <div class="col-md-4 logos">
                <div class="col-md-11" style="margin-left: 80px;" >
                    <img class="col-sm-offset-4" src="/wp-content/plugins/zoom-integration/admin/img/WL_Logo.png"/>
                </div>
            </div>
            <div class="col-md-4 logos ">
                <div class="col-md-11" style="margin-left: 30px; margin-top: 15px;" >
                    <img class="col-sm-offset-4" src="/wp-content/plugins/zoom-integration/admin/img/zoom_logo.png"/>
                </div>
        </div>   
            
          <div class="row" >
          <div class="row col-md-12">
                 <div class="col-md-12 form-group">
                    <label class="lbl-topic">Topic</label>
                    <input class="col-md-8 form-control" name='txt-modal' type="text" required>
                 </div>
             </div>
             <!--DATEPICKER-->
             <div class="row col-md-12 dv-date" style="margin-top: 10px;">
                <div class="col-md-12 form-group">   
                    <label class="lbl-topic"> Date</label>
                    <div class="row">   
                        <div class="col-md-6">
                            <input class="form-control" name="txt-date" type="date" required>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" name="txt-time" type="time" required >
                        </div>
                    </div>                   
                </div>
             </div>
             <div class="row col-md-12">
                 <div class="col-md-12 form-group">  
                    <label class="lbl-topic">Time Zone</label>
                    <select class="form-control" name="timezone" required>    
                        <option value="Pacific/Midway">Pacific/Midway </option>         
                        <option value="Pacific/Pago_Pago">Pacific/Pago_Pago	</option>
                        <option value="Pacific/Honolulu">Pacific/Honolulu	</option>
                        <option value="America/Anchorage">America/Anchorage	</option>
                        <option value="America/Vancouver">America/Vancouver	</option>
                        <option value="America/Los_Angeles">America/Los_Angeles	</option>
                        <option value="America/Tijuana">America/Tijuana	</option>
                        <option value="America/Edmonton">America/Edmonton	</option>
                        <option value="America/Denver">America/Denver	</option>
                        <option value="America/Phoenix">America/Phoenix	</option>
                        <option value="America/Mazatlan">America/Mazatlan	</option>
                        <option value="America/Winnipeg">America/Winnipeg	</option>
                        <option value="America/Regina">America/Regina	</option>
                        <option value="America/Chicago">America/Chicago	</option>
                        <option value="America/Mexico_City">America/Mexico_City	</option>
                        <option value="America/Guatemala">America/Guatemala	</option>
                        <option value="America/El_Salvador">America/El_Salvador	</option>
                        <option value="America/Managua">America/Managua	</option>
                        <option value="America/Costa_Rica">America/Costa_Rica	</option>
                        <option value="America/Montreal">America/Montreal	</option>
                        <option value="America/New_York">America/New_York	</option>
                        <option value="America/Indianapolis">America/Indianapolis	</option>
                        <option value="America/Panama">America/Panama	</option>
                        <option value="America/Bogota">America/Bogota	</option>
                        <option value="America/Lima">America/Lima	</option>
                        <option value="America/Halifax">America/Halifax	</option>
                        <option value="America/Puerto_Rico">America/Puerto_Rico	</option>
                        <option value="America/Caracas">America/Caracas	</option>
                        <option value="America/Santiago">America/Santiago	</option>
                        <option value="America/St_Johns">America/St_Johns	</option>
                        <option value="America/Montevideo">America/Montevideo	</option>
                        <option value="America/Araguaina">America/Araguaina	</option>
                        <option value="America/Argentina/Buenos_Aires">America/Argentina/Buenos_Aires	</option>
                        <option value="America/Godthab">America/Godthab	</option>
                        <option value="America/Sao_Paulo">America/Sao_Paulo	</option>
                        <option value="Atlantic/Azores">Atlantic/Azores	</option>
                        <option value="Canada/Atlantic">Canada/Atlantic	</option>
                        <option value="Atlantic/Cape_Verde">Atlantic/Cape_Verde	</option>
                        <option value="Etc/Greenwich">Etc/Greenwich	</option>
                        <option value="Europe/Belgrade">Europe/Belgrade	</option>
                        <option value="Atlantic/Reykjavik">Atlantic/Reykjavik	</option>
                        <option value="Europe/Dublin">Europe/Dublin	</option>
                        <option value="Europe/London">Europe/London	</option>
                        <option value="Europe/Lisbon">Europe/Lisbon	</option>
                        <option value="Africa/Casablanca">Africa/Casablanca	</option>
                        <option value="Africa/Nouakchott">Africa/Nouakchott	</option>
                        <option value="Europe/Oslo">Europe/Oslo	</option>
                        <option value="Europe/Copenhagen">Europe/Copenhagen	</option>
                        <option value="Europe/Brussels">Europe/Brussels	</option>
                        <option value="Europe/Berlin">Europe/Berlin	</option>
                        <option value="Europe/Helsinki">Europe/Helsinki	</option>
                        <option value="Europe/Amsterdam">Europe/Amsterdam	</option>
                        <option value="Europe/Rome">Europe/Rome	</option>
                        <option value="Europe/Stockholm">Europe/Stockholm	</option>
                        <option value="Europe/Vienna">Europe/Vienna	</option>
                        <option value="Europe/Luxembourg">Europe/Luxembourg	</option>
                        <option value="Europe/Paris">Europe/Paris	</option>
                        <option value="Europe/Zurich">Europe/Zurich	</option>
                        <option value="Europe/Madrid">Europe/Madrid	</option>
                        <option value="Africa/Bangui">Africa/Bangui	</option>
                        <option value="Africa/Algiers">Africa/Algiers	</option>
                        <option value="Africa/Tunis">Africa/Tunis	</option>
                        <option value="Africa/Harare">Africa/Harare</option>
                        <option value="Africa/Nairobi">Africa/Nairobi	</option>
                        <option value="Europe/Warsaw">Europe/Warsaw	</option>
                        <option value="Europe/Prague">Europe/Prague	</option>
                        <option value="Europe/Budapest">Europe/Budapest	</option>
                        <option value="Europe/Sofia">Europe/Sofia	</option>
                        <option value="Europe/Istanbul">Europe/Istanbul	</option>
                        <option value="Europe/Athens">Europe/Athens	</option>
                        <option value="Europe/Bucharest">Europe/Bucharest	</option>
                        <option value="Asia/Nicosia">Asia/Nicosia	</option>
                        <option value="Asia/Beirut">Asia/Beirut	</option>
                        <option value="Asia/Damascus">Asia/Damascus	</option>
                        <option value="Asia/Jerusalem">Asia/Jerusalem	</option>
                        <option value="Asia/Amman">Asia/Amman	</option>
                        <option value="Africa/Tripoli">Africa/Tripoli	</option>
                        <option value="Africa/Cairo">Africa/Cairo	</option>
                        <option value="Africa/Johannesburg">Africa/Johannesburg	</option>
                        <option value="Europe/Moscow">Europe/Moscow	</option>
                        <option value="Asia/Baghdad">Asia/Baghdad	</option>
                        <option value="Asia/Kuwait">Asia/Kuwait	</option>
                        <option value="Asia/Riyadh">Asia/Riyadh	</option>
                        <option value="Asia/Bahrain">Asia/Bahrain	</option>
                        <option value="Asia/Qatar">Asia/Qatar	</option>
                        <option value="Asia/Aden">Asia/Aden	</option>
                        <option value="Asia/Tehran">Asia/Tehran	</option>
                        <option value="Africa/Khartoum">Africa/Khartoum	</option>
                        <option value="Africa/Djibouti">Africa/Djibouti	</option>
                        <option value="Africa/Mogadishu">Africa/Mogadishu	</option>
                        <option value="Asia/Dubai">Asia/Dubai	</option>
                        <option value="Asia/Muscat">Asia/Muscat	</option>
                        <option value="Asia/Baku">Asia/Baku	</option>
                        <option value="Asia/Kabul">Asia/Kabul	</option>
                        <option value="Asia/Yekaterinburg">Asia/Yekaterinburg	</option>
                        <option value="Asia/Tashkent">Asia/Tashkent	</option>
                        <option value="Asia/Calcutta">Asia/Calcutta	</option>
                        <option value="Asia/Kathmandu">Asia/Kathmandu	</option>
                        <option value="Asia/Novosibirsk">Asia/Novosibirsk	</option>
                        <option value="Asia/Almaty">Asia/Almaty	</option>
                        <option value="Asia/Dacca">Asia/Dacca	</option>
                        <option value="Asia/Krasnoyarsk">Asia/Krasnoyarsk	</option>
                        <option value="Asia/Dhaka">Asia/Dhaka	</option>
                        <option value="Asia/Bangkok">Asia/Bangkok	</option>
                        <option value="Asia/Saigon">Asia/Saigon	</option>
                        <option value="Asia/Jakarta">Asia/Jakarta	</option>
                        <option value="Asia/Irkutsk">Asia/Irkutsk	</option>
                        <option value="Asia/Shanghai">Asia/Shanghai	</option>
                        <option value="Asia/Hong_Kong">Asia/Hong_Kong	</option>
                        <option value="Asia/Taipei">Asia/Taipei	</option>
                        <option value="Asia/Kuala_Lumpur">Asia/Kuala_Lumpur	</option>
                        <option value="Asia/Singapore">Asia/Singapore	</option>
                        <option value="Australia/Perth">Australia/Perth	</option>
                        <option value="Asia/Yakutsk">Asia/Yakutsk	</option>
                        <option value="Asia/Seoul">Asia/Seoul	</option>
                        <option value="Asia/Tokyo">Asia/Tokyo	</option>
                        <option value="Australia/Darwin">Australia/Darwin	</option>
                        <option value="Australia/Adelaide">Australia/Adelaide	</option>
                        <option value="Asia/Vladivostok">Asia/Vladivostok	</option>
                        <option value="Pacific/Port_Moresby">Pacific/Port_Moresby	</option>
                        <option value="Australia/Brisbane">Australia/Brisbane	</option>
                        <option value="Australia/Sydney">Australia/Sydney	</option>
                        <option value="Australia/Hobart">Australia/Hobart	</option>
                        <option value="Asia/Magadan">Asia/Magadan	</option>
                        <option value="SST">SST	</option>
                        <option value="Pacific/Noumea">Pacific/Noumea	</option>
                        <option value="Asia/Kamchatka">Asia/Kamchatka	</option>
                        <option value="Pacific/Fiji">Pacific/Fiji	</option>
                        <option value="Pacific/Auckland">Pacific/Auckland	</option>
                        <option value="Asia/Kolkata">Asia/Kolkata	</option>
                        <option value="Europe/Kiev">Europe/Kiev	</option>
                        <option value="America/Tegucigalpa">America/Tegucigalpa	</option>
                        <option value="Pacific/Apia">Pacific/Apia</option>
                    </select>
                 </div>
            </div>
            <div class="row col-md-12">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="lbl-topic">Host Video</label>
                        <input class="" name='host-video1' type="radio"/>
                    </div>
                    <div class="col-md-6">
                        <label class="lbl-topic">Participant Video</label>
                        <input class="txt" type="radio" name='participant-video1'/>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-12 form-group">
                    <label class="lbl-topic">Description</label>
                    <textarea class="form-control" minlength="10" maxlength="300"></textarea>
                </div>
             </div>
          <div class="row col-md-12" style="margin-top: 15px;">
            <button class="btn btn-primary col-md-offset-2 col-md-2" type="submit" name="btn_createmeeting" id="btn_createmeeting">Save</button>
            <button class="btn btn-primary col-md-offset-4 col-md-2" data-dismiss="modal">Cancel</button>
          </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  </form>
  <!--Modal Para una reunion instantanea-->
 <form method="post" >
 <div class="modal fade" id="instant_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top:100px;border-radius: 100px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" >
           <h5 class="modal-title" id="myModalLabel" style="text-align:center">INSTANT MEETING</h5>
        <div class="modal-body">
        <div class="col-md-4 logos">
                <div class="col-md-11" style="margin-left: 80px;" >
                    <img class="col-sm-offset-4" src="/wp-content/plugins/zoom-integration/admin/img/WL_Logo.png"/>
                </div>
        </div>
        <div class="col-md-4 logos ">
                <div class="col-md-11" style="margin-left: 30px; margin-top: 15px;" >
                    <img class="col-sm-offset-4" src="/wp-content/plugins/zoom-integration/admin/img/zoom_logo.png"/>
                </div>
        </div>   
          <div class="row" style="margin-top: 100px;" >
          <div class="row col-md-12">
              <label class="col-md-offset-1 col-md-5 lbl-topic">Host Video</label>
              <input class="col-md-1" name='host-video' type="radio"/>
          </div>
          <!--checkbox-->
          <div class="row col-md-12">
              <label class="col-md-offset-1 col-md-5 lbl-topic">Participant Video</label>
              <input class="col-md-1 txt" type="radio" name='participant-video'/>
          </div>
          <div class="row col-md-12" style="margin-top: 15px;">
            <button class="btn btn-primary col-md-offset-2 col-md-2" id="start-instant" name="start-instant" type="submit">Start</button>
            <button class="btn btn-primary col-md-offset-4 col-md-2" data-dismiss="modal">Cancel</button>
          </div>
          </div>
        </div>
        </div>
      </div>
    </div>
    </div>
  </form>
<script>

</script>
<?php 
}





/* function get_start_url($meetingID){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.zoom.us/v2/meetings/$meetingID",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_SSL_VERIFYHOST => 0,
	CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ"
    ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return json_decode($response,true);
    }
}
function delete_meeting($meetingID){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.zoom.us/v2/meetings/$meetingID",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_SSL_VERIFYHOST => 0,
	CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "DELETE",
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ"
    ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}*/
function get_zuser($correo){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/users/$correo",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_TIMEOUT => 60,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return json_decode($response);
    }
   }
//funcion para obtener los zoom settings   
/*function get_user_settings($mail){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.zoom.us/v2/users/$mail/settings",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ"
    ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    return json_decode($response,true);
    }
}  */
//funcino para actualizar los settings
function update_zoom_settings($mail,$pmi_for_scheduled,$pmi_for_instant,$require_password_pmi,$require_password_sch,$waiting_room,$live_streaming,$breakout_rooms, $auto_recording,$screen_sharing , $recording_audio_transcript){
   // echo "{\"schedule_meeting\":{\"use_pmi_for_scheduled_meetings\":$pmi_for_scheduled,\"use_pmi_for_instant_meetings\":$pmi_for_instant,\"require_password_for_scheduling_new_meetings\":$require_password_sch,\"require_password_for_instant_meetings\":\"$require_password_pmi\"},\"in_meeting\":{\"breakout_room\":$breakout_rooms,\"waiting_room\":$waiting_room,\"allow_live_streaming\":$live_streaming,\"screen_sharing\":$screen_sharing},\"recording\":{\"auto_recording\":\"$auto_recording\",\"recording_audio_transcript\":$recording_audio_transcript}}";
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.zoom.us/v2/users/$mail/settings",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 40,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PATCH",
    CURLOPT_POSTFIELDS => "{\"schedule_meeting\":{\"use_pmi_for_scheduled_meetings\":$pmi_for_scheduled,\"require_password_for_scheduling_new_meetings\":$require_password_sch},\"in_meeting\":{\"breakout_room\":$breakout_rooms,\"waiting_room\":$waiting_room,\"allow_live_streaming\":$live_streaming,\"screen_sharing\":$screen_sharing},\"recording\":{\"auto_recording\":\"$auto_recording\",\"recording_audio_transcript\":$recording_audio_transcript}}", 
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ",
        "content-type: application/json"
    ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
        return ( json_decode($response,true));
    }
}    
//funcion para imprimir los settings
function print_settings($settings){
    //inicio
    $schedule_meeting_settings=$settings['schedule_meeting'];
     $pmi_for_scheduled = $schedule_meeting_settings['use_pmi_for_scheduled_meetings'];
     $pmi_for_instant = $schedule_meeting_settings['use_pmi_for_instant_meetings'];
     $require_password_sch = $schedule_meeting_settings['require_password_for_scheduling_new_meetings'];
    $in_meeting_settings=$settings['in_meeting'];
     $screen_sharing = $in_meeting_settings['screen_sharing'];
     $waiting_room = $in_meeting_settings['waiting_room'];
     $live_streaming = $in_meeting_settings['allow_live_streaming'];
      $breakout_rooms = $in_meeting_settings['breakout_room'];
    $recording = $settings['recording'];
    $auto_recording = $recording['auto_recording'];
    $recording_audio_transcript = $recording['recording_audio_transcript'];
    ?>
    <div class="container col-md-12 col-sm-12 col-lg-12" style="margin-bottom: 10px;">
        <div class="row row-settings">
            <label class="label">Zoom Settings</label>
        </div>
    </div>
    <!--Primera Opcion -->
    <form method="POST">
    <div class="row ">
    <label class="label-topic col-md-10">Use personal meeting id:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
    
    <div class="material-switch pull-right col-md-2">
        <input id="use_pmi" name="use_pmi"<?php if($pmi_for_scheduled == true){echo("checked");}?> type="checkbox" value="1" />
        <label for="use_pmi" class="label-default"></label>
    </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <!--Segunda Opcion -->
    <div class="row ">
    <label class="label-topic col-md-10">Waiting Room:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
    
    <div class="material-switch pull-right col-md-2">
        <input id="waiting_room" name="waiting_room"<?php if( $waiting_room == true){echo("checked");}?> type="checkbox" value="1" />
        <label for="waiting_room" class="label-default"></label>
    </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <!--Tercera Opcion -->
    <div class="row ">
    <label class="label-topic col-md-10">Require Password for future meetings:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
    
    <div class="material-switch pull-right col-md-2">
        <input id="require_password" name="require_password" <?php if($require_password_sch == true){echo("checked");}?> type="checkbox" value="1"  />
        <label for="require_password" class="label-default"></label>
    </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <!--Cuarta Opcion -->
    <div class="row ">
    <label class="label-topic col-md-10">Facebook/Youtube Live Streaming:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
    
    <div class="material-switch pull-right col-md-2">
        <input id="facebook_live" name="facebook_live" <?php if($live_streaming == true){echo("checked");}?> type="checkbox" value="1" />
        <label for="facebook_live" class="label-default"></label>
    </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <!--Quinta Opcion -->
    <div class="row ">
    <label class="label-topic col-md-10">Breakout Rooms:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
    
    <div class="material-switch pull-right col-md-2">
        <input id="breakout_rooms" name="breakout_rooms" <?php if($breakout_rooms == true){echo("checked");}?> type="checkbox" value="1" />
        <label for="breakout_rooms" class="label-default"></label>
    </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <div class="row ">
    <label class="label-topic col-md-10">Auto Recording:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
        <div class="material-switch pull-right col-md-2">
            <input id="chk_auto_recording" name="chk_auto_recording" <?php if($auto_recording == 'cloud'){echo("checked");}?> type="checkbox" value="1" />
            <label for="chk_auto_recording" class="label-default"></label>
        </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <div class="row ">
    <label class="label-topic col-md-10">Audio Transcript:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
        <div class="material-switch pull-right col-md-2">
            <input id="recording_audio_transcript" name="recording_audio_transcript" <?php if($recording_audio_transcript == true){echo("checked");}?> type="checkbox" value="1" />
            <label for="recording_audio_transcript" class="label-default"></label>
        </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <div class="row ">
    <label class="label-topic col-md-10">Screen Share:</label>
    <label class="label-son col-md-10">This can be used by participants at any time to access your personal virtual room.</label>
        <div class="material-switch pull-right col-md-2">
            <input id="screen_sharing" name="screen_sharing" <?php if($screen_sharing == true){echo("checked");}?> type="checkbox" value="1" />
            <label for="screen_sharing" class="label-default"></label>
        </div>
    <hr class="col-md-11" style="background-color: #909090;">
    </div>
    <button class='btn btn-primary col-md-2 col-md-offset-9' name="btn-save" id="btn-save" type='submit'> SAVE </button>
    </form>
    <?php 
}
//funcion para obtener las grabaciones
/*function get_user_recordings($email){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.zoom.us/v2/users/$email/recordings?trash_type=meeting_recordings&mc=false&page_size=30",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ"
    ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
        return json_decode($response,true);
    }
}*/
function print_recordings($array){
    $c = 0;
    foreach($array as $index => $recording){
        $topic = $recording->topic;
        $start_time = $recording->start_time;
        $url = $recording->share_url;
        $duration = $recording->duration;
        $date=strtotime($start_time);
        $timeArray=getdate($date);
        $day=$timeArray['mday'];
        $month=$timeArray['month'];
        $year=$timeArray['year'];
        $time=date('h:i A', $date);
        ?>
        <div class="col-md-12 container-recording">
            <div class="col-md-4">
                <div class="col-md-11 container-icon" >
                    <img class="img-play col-sm-offset-4" src="/wp-content/plugins/zoom-integration/admin/img/indice.jpg"/>
                </div>
            </div>
            <div class="col-md-4">
                <label class="topic-recording"><?php echo $topic;?></label>
                <label class="second-recording"><?php echo $time,' '.$day.' '.$month.' '.$year;?></label>
            </div>
            <div class="col-md-4">
                <!--<button class="btn btn-primary col-sm-offset-3 col-sm-3" ></button-->
                <a class="btn btn-primary col-sm-3 col-sm-offset-3" href="<?php echo $url;?>" target="_blank">Play</a>
                <button class="btn btn-primary col-sm-offset-2 col-sm-3" id="<?php echo $c.'meeting';?>" value="<?php echo $url;?>">Share</button>
            </div>
        <!--<hr  class="col-md-11" style="background-color: #909090;"> -->   
        </div>
        <script>
        jQuery(function($){
  
        $(document).ready(function(){
            $("#<?php echo $c.'meeting';?>").click(function(event){
                event.preventDefault();
                copiarAlPortapapeles("<?php echo $c.'meeting';?>");
                
            alert('URL Copied!');
                });
        });});
        function copiarAlPortapapeles(id_elemento) {
                // Crea un campo de texto "oculto"
                var aux = document.createElement("input");

                // Asigna el contenido del elemento especificado al valor del campo
                aux.setAttribute("value", document.getElementById(id_elemento).value);

                // Añade el campo a la página
                document.body.appendChild(aux);

                // Selecciona el contenido del campo
                aux.select();

                // Copia el texto seleccionado
                document.execCommand("copy");

                // Elimina el campo de la página
                document.body.removeChild(aux);

        }
</script> 
    <?php  
    $c = $c + 1;  
    }
}
?>    