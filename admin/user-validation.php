<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
require_once __DIR__.'/partials/config/config.php';
require_once __DIR__.'/partials/controller/curl.php';
/*
class zoom { 
    private function body($email){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zoom.us/v2/users/".$email,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
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
            return json_decode($err,true);
        } else {
            return json_decode($response,true);
        }

    }
  //ESTE METODO VALIDA QUE EL CORREO ESTE REGISTERADO EN WORKINGLIVE  
    function check_user($email){
        $response = $this->body($email);
        //SE AÑADIO VERIFICACION DE VARIABLE PARA SABER SI ES UN ARRAY
        if (is_array($response)){
            //SE VERIFICA SI EXISTE UN ERROR EN LA RESPUESTA DE API
            if (array_key_exists('code',$response)){
                return true;
            }elseif (array_key_exists('email',$response)){
                return  false;
            }
        }else{
            return true;
        }    
    }
}*/

function check_user ($ccorreo){
    $ids = '';
    $page_token = '';
    $curl = new curl();
        $ejecutar = json_decode($curl->body("https://api.zoom.us/v2/users/$ccorreo",'GET',TOKEN,''),true);
        if (is_array($ejecutar)){
            //SE VERIFICA SI EXISTE UN ERROR EN LA RESPUESTA DE API
            if (array_key_exists('code',$ejecutar)){
                $ids = 0;
            }elseif (array_key_exists('email',$ejecutar)){
                $ids = 1;
            }
        }else{
            $ids = 0;
        }   
        
    while (empty($ids)){
        $ruta = "https://api.zoom.us/v2/accounts?".$page_token."&page_size=100";
        $ejecutar = json_decode($curl->body($ruta,'GET',TOKEN,''),true);
        if (isset($ejecutar['next_page_token'])){
            $page_token = "next_page_token=".$ejecutar['next_page_token'];
            foreach($ejecutar['accounts'] as $datos){
                if ($datos['owner_email']== $ccorreo){
                    $ids = $datos['id'];
                }
            }
        }
        if (empty($ejecutar['next_page_token']) && empty($ids)){
            $page_token = '';
            if(isset($ejecutar['accounts']) == false){
                $ids = 'false';
            }else{
                foreach($ejecutar['accounts']  as $datos){
                    if ($datos['owner_email']== $ccorreo){
                        $ids = $datos['id'];
                    }
                }
                if (empty($ids)){
                    $ids = 'false';
                }
            }
        }
    }
    return $ids;
}
