<?php
require_once (dirname(__FILE__).'/user-validation.php');
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https:workinglive.us
 * @since      1.0.0
 *
 * @package    Zoom_Integration
 * @subpackage Zoom_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zoom_Integration
 * @subpackage Zoom_Integration/admin
 * @author     Mateo Ramos-Freddy Buele <mateo@workinglive.us>
 */
class Zoom_Integration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Zoom_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zoom_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zoom-integration-admin.css', array(), $this->version, 'all' );
		//wp_enqueue_style('bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), '5.0' );
		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Zoom_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zoom_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/zoom-integration-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
	}
	function misha_log_history_link( $menu_links2 ){
 
		$menu_links2 = array_slice( $menu_links2, 0, 3, true ) 
		+ array( 'zoom-meetings' => 'Zoom Meetings' )
		+ array_slice( $menu_links2, 3, NULL, true );
		return $menu_links2;
	 
	}
	function misha_add_endpoint() {
		add_rewrite_endpoint( 'zoom-meetings', EP_PAGES );
	}
	function misha_my_account_endpoint_content() {
		$current_user = wp_get_current_user();
		$user_mail=$current_user->user_email;
		
		
		$validar = check_user($user_mail);
		echo $validar ;
		if ($validar === 0){
			?>
				<div class="alert alert-primary" role="alert">
					It seems you haven't accepted the invitation from WorkingL5555ive
				</div>
			<?php
		}else{
			if ($validar === 0){
				?>
				<div class="alert alert-primary" role="alert">
				It seems you haven't accepted the invitation from WorkingLive
				</div>
				<?php
			}else{
				//SI EL USUARIO EXISTE AVANZA NORMALMENTE
				require_once (dirname(__FILE__).'/partials/zoom-meetings-display.php');
			}
		}
	}
	//Zoom settings functions
	function zoom_settings_link2( $menu_links2 ){
 
		$menu_links2 = array_slice( $menu_links2, 0, 4, true ) 
		+ array( 'zoom-settings' => 'Zoom Settings' )
		+ array_slice( $menu_links2, 4, NULL, true );
	 
		return $menu_links2;
	 
	}
	function zoom_settings_add_endpoint() {
	
		add_rewrite_endpoint( 'zoom-settings', EP_PAGES );
	 
	}
	function zoom_settings_my_account_endpoint_content() {
		//$current_user = wp_get_current_user();
		
		$current_user = wp_get_current_user();
		$user_mail = $current_user->user_email;
		if (check_user($user_mail) === 0){
			?>
			<div class="alert alert-success" role="alert">
				<h4 class="alert-heading">Oh no!</h4>
				<p>It seems you h85555aven't accepted the invitation from Zoom.</p>
				<hr>
				<p class="mb-0">Please check your mail and accept the invitation or send a message to support@workinglive.us.</p>

			</div>
			<?php
		}else{
			require_once (dirname(__FILE__).'/partials/zoom-settings-display.php');
		}
		
	}
	//Zoom Recordings functions
	function zoom_recordings_link2( $menu_links2 ){
 
		$menu_links2 = array_slice( $menu_links2, 0, 5, true ) 
		+ array( 'zoom-recordings' => 'Zoom Recodings' )
		+ array_slice( $menu_links2, 5, NULL, true );
	 
		return $menu_links2;
	 
	}
	function zoom_recordings_add_endpoint() {
	
		add_rewrite_endpoint( 'zoom-recordings', EP_PAGES );
	 
	}
	function zoom_recordings_my_account_endpoint_content() {
		//$current_user = wp_get_current_user();
		//echo $current_user->user_email;
		$current_user = wp_get_current_user();
		$user_mail=$current_user->user_email;
		if (check_user($user_mail) == 1 or (check_user($user_mail)!=1 && check_user($user_mail) != 0 )){
			?>
			<div class="alert alert-success" role="alert">
				<h4 class="alert-heading">Oh no!</h4>
				<p>It seems you haven't accepted the invitation from Zoom.</p>
				<hr>
				<p class="mb-0">Please check your mail and accept the invitation or send a message to support@workinglive.us.</p>

			</div>
			<?php
		}else{
			require_once (dirname(__FILE__).'/partials/recordings-display.php');
		}
		
		
	}


	//Artificial Inteligence reports
	function ai_reports_link( $menu_links ){
 
		$menu_links = array_slice( $menu_links, 0, 2, true ) 
		+ array( 'ai-reports' => 'Artificial Intelligence Reports' )
		+ array_slice( $menu_links, 2, NULL, true );
	 
		return $menu_links;
	 
	}
	function ai_reports_add_endpoint() {
	
		add_rewrite_endpoint( 'ai-reports', EP_PAGES );
	 
	}
	function ai_reports_my_account_endpoint_content() {
		//$current_user = wp_get_current_user();
		//echo $current_user->user_email;
		$current_user = wp_get_current_user();
		$user_mail=$current_user->user_email;
		

		if (check_user($user_mail)==0){
			?>
			<div class="alert alert-success" role="alert">
				<h4 class="alert-heading">Oh no!</h4>
				<p>It seems you haven't accepted the invitation from Zoom.</p>
				<hr>
				<p class="mb-0">Please check your mail and accept the invitation or send a message to support@workinglive.us.</p>

			</div>
			<?php
		}else{
			require_once (dirname(__FILE__).'/partials/AI-meeting-display.php');
			
		}
			
	}
	//REGISTRO DEL SCRIPT JS
	function register_script(){
		wp_register_script( 'ajax_script', __DIR__.'../js/ajas.js', array('jquery'), '1.0', false);
		
		wp_localize_script( 'ajax_script', 'ajax_object',array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ow-nonce'),
			'hook' => 'ow_action',
		) );

		wp_enqueue_script('ajax_script');
	}

	
}
