<?php
add_action( 'wp_footer', 'gfwoa_enqueue_scripts');
function gfwoa_enqueue_scripts() {
       wp_enqueue_script('ajax_save_access_token', plugins_url('/js/save-access-token.js',__FILE__));
       $url = admin_url('admin-ajax.php');
       wp_localize_script( 'ajax_save_access_token', 'PT_Ajax_Access_Token', array(
                                    'ajaxurl'       => $url,
                                     'nextNonce'     => wp_create_nonce('gfwoa_ajax_nonce'),
       )); 
       wp_enqueue_script('ajax_test_access_token', plugins_url('/js/test-access-token.js',__FILE__));
	wp_localize_script( 'ajax_test_access_token', 'PT_Ajax_Test_Access_Token', array(
                                    'ajaxurl'       => $url,
                                     'nextNonce'     => wp_create_nonce('gfwoa_ajax_nonce'),
       )); 	
}  
?>
<p id="access-token"></p>
<script language="javascript">
var url=document.URL;
var hashidx=url.indexOf("#access_token=");
var access_token = url.substring(hashidx+14);
document.getElementById('access-token').innerHTML = access_token;
</script>
<button id="test-access-token-button" class="btn button">Test Token</button>
