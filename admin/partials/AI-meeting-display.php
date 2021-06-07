<?php
    include_once (dirname(__FILE__).'/controller/curl.php');
    include_once (dirname(__FILE__).'/config/config.php');
    include_once (dirname(__FILE__).'/controller/curl.php');
    $current_user = wp_get_current_user();
    $user_email = $current_user->user_email;
    $new_token = array(TOKEN_CYRANO);
    $consulta = new curl_cyrano();
    if (isset($_POST['ai_save'])){
        if (isset($_POST['chk_ai']) && $_POST['chk_ai']== '1'){
            $status = 'trial';
        }else{
            $status='inactive';
        }
        $new_array = array(TOKEN_CYRANO,'Content-Type: text/plain');
        $post_field = '{"account_id":"YZwvfZtWSXq4diaCRhQPKQ","email": "'.$user_mail.'","fields":{"status":"'.$status.'"}}';
        $resultado = $consulta->body(URL_CYRANO.'zoom/user','PATCH',$new_array,$post_field);
        
    }
    $resultado_view = json_decode($consulta->body(URL_CYRANO."zoom/user?email=$user_mail&account_id=YZwvfZtWSXq4diaCRhQPKQ","GET",$new_token ,''),true);
   /* echo"<pre>";
        print_r ($resultado_view);
    echo"</pre>";*/
?>
<form method="post">
<div >
    <h4>Artificial Intelligence Meeting Reports. </h4>
    <p>Our simple virtual meeting enterprise software application reveals the values, motivations, and commitment of your prospects, customers, team members and partners, so you can better appeal to your audience and get the YES from anyone faster. </p>
    <div class="row ">
      <h4 class="s col-md-6"> <strong> Status: <?php echo $resultado_view['status']; ?> </strong></h4>
        <div class="material-switch  col-md-offset-1 col-md-2 ">
            <input  id="chk_ai" name="chk_ai" <?php if($resultado_view['status'] == 'trial'){echo 'checked';}; ?>  type="checkbox" value="1" />
            <label for="chk_ai" class="label-default"></label>
        </div>
    <?php
        if ($resultado_view['status']=='trial'){
            ?>
            <a href="/ai-meetings-product/"><button class="col-md-2 btn btn-warning">Upgrade</button></a>
            <?php
        }
        
    ?>

        
        <div class="row col-md-12">
        <button class="col-md-2 btn btn-warning" type="submit" name='ai_save' id='ai_save'>Save</button>
        </div>
    <hr class="col-md-11 " style="background-color: #909090;">
    </div>
</div>
    <p>Here is how it works! Simply record your meeting to the cloud. An audio transcript of your meeting will be created. That audio transcript is analyzed by the artificial intelligence software. Your privacy is important to us. No human ever looks at your meeting information. A report is then emailed to you with valuable information about you and the participants of your meeting. You will receive insights on how best to communicate with your people. </p>
    <p>Your Zoom settings are already set to Audio Transcript and Automatic Recordings (ON). All you need to do is to record to the cloud. Be sure your meetings are at least 10 minutes and you have at least one other person in your meeting. You also want to be sure that the names on your Zoom meeting match the names on the account. </p>
    <p>Every Working Live member gets a free trial of this service. If you would like to upgrade to unlimited reports, please click on the UPGRADE button above. </p>
    <p>To activate this service, please click on the TURN ON button above. </p> 
    <p> At any time, you may deactivate this service by clicking on the TURN OFF button above. </p>
    <p>To view an example report click here:               <a href="https://codebreakertech.com/wp-content/uploads/2021/01/Meeting-Advisor-document_final.pdf">VIEW SAMPLE REPORT</a> </p>
    <p>To learn more click here:                           <a href="/working-live-ai-meetings">LEARN MORE</a> </p>
    </p>
</div>


</form>
<?php


