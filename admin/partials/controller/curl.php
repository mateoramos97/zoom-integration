<?php
//require_once '/config/config.php';
class curl{
    public function body($link,$request,$token,$postfield){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "$link",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "$request",
          CURLOPT_POSTFIELDS => "$postfield",
          CURLOPT_HTTPHEADER => array(
            $token  ,
            
            /*"authorization: Bearer $token"*///,
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          return $err;
        } else {
          return $response;
        }
    }
}


class curl_cyrano{
  public function body($link,$request,$token = array(),$postfield){
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "$link",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "$request",
        CURLOPT_POSTFIELDS => "$postfield",
        CURLOPT_HTTPHEADER => $token,
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);
      
      if ($err) {
        return $err;
      } else {
        return $response;
      }
  }
}






