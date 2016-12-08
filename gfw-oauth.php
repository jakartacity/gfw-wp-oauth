<?php
/*
Plugin Name: Global Fishing Watch OAuth
Plugin URI: http://104.197.241.25/gfw-oauth
Description: This plugin have button to do open authentication to get access token to call API to do operation of global fishing watch functions.
Version: 1.0
Author: Imam Prakoso
Author URI: http://104.197.241.25
*/
if ( ! defined( 'ABSPATH' ) ) exit;
class GFWOA {
	//Singleton Class Pattern
	 protected static $instance = NULL;
	 public static function get_instance() {
                NULL === self::$instance and self::$instance = new self;
                return self::$instance;
         }   
	
	 public $settings = array (
		//settings default value initialization are in this array
		'gfwoa_endpoint' => 'https://api-dot-skytruth-pleuston.appspot.com/v1/authorize', 
		'gfwoa_redirect_ui' => '',
		'gfwoa_redirect_page_title' => 'Oauth Redirect Page',
		'gfwoa_redirect_page' => 'oauth_callback',
		'gfwoa_client_id' => 'GLOBALFISHINGWATCH',
		'gfwoa_response_type' => 'token',
		'gfwoa_redirect_page_shortcode_name' => 'gfw_oauth_redirect_page', //shortcode
		'gfwoa_trigger_endpoint_shortcode_name' => 'gfw_oauth_starter', //shortcode
	 );
	
	function __construct() {
                // hook activation and deactivation for the plugin:
                register_activation_hook(__FILE__, array($this, 'gfwoa_activate'));
                register_deactivation_hook(__FILE__, array($this, 'gfwoa_deactivate'));
                // hook load event to handle any plugin updates:
                //add_action('plugins_loaded', array($this, 'gfwoa_update'));
                // hook init event to handle plugin initialization:
                add_action('init', array($this, 'init'));
        }   

		
	function init() {
		add_action( 'admin_menu', array($this, 'gfwoa_add_submenu_in_settings' ));
		add_action( 'admin_enqueue_scripts', array($this , 'gfwoa_admin_style'));
		add_shortcode($this->settings['gfwoa_redirect_page_shortcode_name'], array($this, 'gfwoa_redirect_shortcode_impl'));
		add_shortcode($this->settings['gfwoa_trigger_endpoint_shortcode_name'], array($this, 'gfwoa_trigger_endpoint_shortcode_name_impl'));
	}

	function gfwoa_trigger_endpoint_shortcode_name_impl($attributes, $content) {
		return  $this->gfwoa_oauth_endpoint_html();
	}

	function gfwoa_oauth_endpoint_html() {
		 $redirect_page=get_page_by_title($this -> settings['gfwoa_redirect_page_title']);
		 $url_redirect_page = get_permalink($redirect_page->ID);
		ob_start();
//https://api-dot-skytruth-pleuston.appspot.com/v1/authorize?response_type=token&client_id=wordpress&redirect_uri=YOUR_WORDPRESS_PAGE
		$url_end_point = $this -> settings['gfwoa_endpoint'].'?response_type='.$this->settings['gfwoa_response_type'].'&client_id='.$this->settings['gfwoa_client_id'].'&redirect_uri='.urlencode($url_redirect_page);
		?>
			<script type=text/javascript>
			jQuery(document).ready(function($) { 
			function endpoint() {
				window.location.href = "<?php echo $url_end_point;?>";
			}
				$('#gfw-oauth-button').click(function () {endpoint();})
			});
			</script>
			<button id="gfw-oauth-button" class="btn button">Get Access Token</button>
		<?php
		return ob_get_clean();
	}

	function gfwoa_redirect_shortcode_impl($attributes, $content) {
		include_once "templates/gfwoa-redirect-page-controller.php";
		return "";
	}

	function gfwoa_admin_style() {
		$url = plugins_url('assets/gfwoa-admin.css',__FILE__);
		wp_register_style('gfwoa_admin_css', $url, false, '1.0.0');	
		wp_enqueue_style( 'gfwoa_admin_css' );
	}
	
	function gfwoa_add_submenu_in_settings() {
		add_options_page( 'Global Fishing Watch Oauth2.0', 'GFW Open Auth', 'manage_options', 'gfwoa-settings-screeen', array($this,'gfwoa_options') );
	}

	function gfwoa_options() {
		if ( !current_user_can( 'manage_options' ) )  {
                        wp_die( __( 'You do not have sufficient permissions to access this page.' )); 
                }    
		include_once "templates/gfw-oauth-settings-page.php";	
	}

	function gfwoa_activate() {
		$this -> gfwoa_create_redirect_oauth_page();
	}

	function gfwoa_deactivate() {

	}	
	
	function gfwoa_slug_exists($post_name) {
		global $wpdb;
		if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
			return true;
		} else {
			return false;
		}
	}

	function gfwoa_create_redirect_oauth_page() {
		$blog_page = array(
				'post_type' => 'page',
				'post_title' => $this -> settings['gfwoa_redirect_page_title'],
				'post_content' => '['.$this -> settings['gfwoa_redirect_page_shortcode_name'].']', //shortcode
				'post_status' => 'publish',
				'post_author' => 1,			
				'post_slug' => $this -> settings['gfwoa_redirect_page'],
		);
		$blog_page_check = get_page_by_title($this -> settings['gfwoa_redirect_page_title']);
		if(!isset($blog_page_check->ID) && !$this->gfwoa_slug_exists($this -> settings['gfwoa_redirect_page'])){
        		$blog_page_id = wp_insert_post($blog_page);
    		}
	}	
	
} // End Class GFWOA
GFWOA::get_instance();
?>
