<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
//TOKEN API ZOOM
require_once __DIR__.'/../../user-validation.php';
require_once __DIR__.'/../controller/curl.php';
define('URL_CYRANO','https://labs.cyrano.ai/');
define ('TOKEN','authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InZlZF9YcWRTU25hdEgzelNuNUkyZXciLCJleHAiOjE2NzIyNDc1MjAsImlhdCI6MTYwOTc5Mjg5NH0.h5mAbzcFDVe6PynKpbpnB8j_KwW_rbObElGwEeLDMlQ');
define ('TOKEN_CYRANO','x-api-key: oYByX8seP19kZpNSPNnTda8xDFNMYeBE4wv9qteW');
//URL ZOOM
add_action('init','do_stuff');
function do_stuff(){
  $current_user = wp_get_current_user();
  $user_email = $current_user->user_email;
  $validacion = check_user($user_email);

if ($validacion === 1){
    define('ZOOM_URL','https://api.zoom.us/v2/');
}elseif($validacion === 0){
    define('ZOOM_URL','https://api.zoom.us/v2/accounts/');
}elseif($validacion !== 0 && $validacion !== 1){
    define('ZOOM_URL',"https://api.zoom.us/v2/accounts/$validacion/");
}
 // return $user_email;
}
//$current_user = wp_get_current_user();
//$user_email = $current_user->user_email;
//$user_email = 
//var_dump($user_email);
//$user_email = 'mateoramos1997@gmail.com';

