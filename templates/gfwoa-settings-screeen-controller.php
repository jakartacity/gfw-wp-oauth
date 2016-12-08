<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$gfwoa = GFWOA::get_instance(); 
$menu_page_url = menu_page_url('gfwoa-settings-screeen', false);
$end_point_value = get_permalink(get_page_by_title($gfwoa -> settings['gfwoa_redirect_page_title']) -> ID);
$redirect_page_title = $gfwoa -> settings['gfwoa_redirect_page_title'];
$client_id = $gfwoa -> settings['gfwoa_client_id'];
$end_point = $gfwoa -> settings['gfwoa_endpoint'];
?>
