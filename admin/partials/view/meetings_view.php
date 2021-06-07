<?php
function meetingContainer($startt,$topic,$timez,$meetingid,$join_url,$display_name){
    $date=strtotime($startt);
    $timeArray=getdate($date);
    $day=$timeArray['mday'];
    $month=$timeArray['month'];
    $year=$timeArray['year'];
    $time2=date('h:i A', $date);

    $start_url_data=get_start_url($meetingid);
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
          <button class="col-sm-offset-1 col-sm-3 col-xs-offset-1 col-xs-3 btn remove" name="btn-delete" id="btn-delete"  value="<?php echo $meetingid;?>" style="border-radius: 10px;" >Delete</button>
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
            <button id="btn-send" class="btn btn-primary col-md-offset-6 col-md-2" data-dismiss="" type='submit'>Send</button>
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
<?php 
}