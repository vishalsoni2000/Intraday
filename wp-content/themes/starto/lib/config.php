<?php
//Setup theme constant and default data
$theme_obj = wp_get_theme('starto');

define("STARTO_THEMENAME", $theme_obj['Name']);
if (!defined('STARTO_THEMEDEMO'))
{
	define("STARTO_THEMEDEMO", false);
}

define("STARTO_THEMEVERSION", $theme_obj['Version']);
define("STARTO_THEMEDEMOURL", $theme_obj['ThemeURI']);
define("STARTO_MEGAMENU", true);

if (!defined('STARTO_THEMEDATEFORMAT'))
{
	define("STARTO_THEMEDATEFORMAT", get_option('date_format'));
}

if (!defined('STARTO_THEMETIMEFORMAT'))
{
	define("STARTO_THEMETIMEFORMAT", get_option('time_format'));
}

define("ENVATOITEMID", 26271433);

//Get default WP uploads folder
$wp_upload_arr = wp_upload_dir();
define("STARTO_THEMEUPLOAD", $wp_upload_arr['basedir']."/".strtolower(sanitize_title(STARTO_THEMENAME))."/");
define("STARTO_THEMEUPLOADURL", $wp_upload_arr['baseurl']."/".strtolower(sanitize_title(STARTO_THEMENAME))."/");

if(!is_dir(STARTO_THEMEUPLOAD))
{
	wp_mkdir_p(STARTO_THEMEUPLOAD);
}

/**
*  Begin Global variables functions
*/

//Get default WordPress post variable
function starto_get_wp_post() {
	global $post;
	return $post;
}

//Get default WordPress file system variable
function starto_get_wp_filesystem() {
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	WP_Filesystem();
	global $wp_filesystem;
	return $wp_filesystem;
}

//Get default WordPress wpdb variable
function starto_get_wpdb() {
	global $wpdb;
	return $wpdb;
}

//Get default WordPress wp_query variable
function starto_get_wp_query() {
	global $wp_query;
	return $wp_query;
}

//Get default WordPress customize variable
function starto_get_wp_customize() {
	global $wp_customize;
	return $wp_customize;
}

//Get default WordPress current screen variable
function starto_get_current_screen() {
	global $current_screen;
	return $current_screen;
}

//Get default WordPress paged variable
function starto_get_paged() {
	global $paged;
	return $paged;
}

//Get default WordPress registered widgets variable
function starto_get_registered_widget_controls() {
	global $wp_registered_widget_controls;
	return $wp_registered_widget_controls;
}

//Get default WordPress registered sidebars variable
function starto_get_registered_sidebars() {
	global $wp_registered_sidebars;
	return $wp_registered_sidebars;
}

//Get default Woocommerce variable
function starto_get_woocommerce() {
	global $woocommerce;
	return $woocommerce;
}

//Get all google font usages in customizer
function starto_get_google_fonts() {
	$starto_google_fonts = array('starto_body_font', 'starto_header_font', 'starto_menu_font', 'starto_sidemenu_font', 'starto_sidebar_title_font', 'starto_button_font');
	
	global $starto_google_fonts;
	return $starto_google_fonts;
}

//Get menu transparent variable
function starto_get_page_menu_transparent() {
	global $starto_page_menu_transparent;
	return $starto_page_menu_transparent;
}

//Set menu transparent variable
function starto_set_page_menu_transparent($new_value = '') {
	global $starto_page_menu_transparent;
	$starto_page_menu_transparent = $new_value;
}

//Get no header checker variable
function starto_get_is_no_header() {
	global $starto_is_no_header;
	return $starto_is_no_header;
}

//Get deafult theme screen CSS class
function starto_get_screen_class() {
	global $starto_screen_class;
	return $starto_screen_class;
}

//Set deafult theme screen CSS class
function starto_set_screen_class($new_value = '') {
	global $starto_screen_class;
	$starto_screen_class = $new_value;
}

//Get theme homepage style
function starto_get_homepage_style() {
	global $starto_homepage_style;
	return $starto_homepage_style;
}

//Set theme homepage style
function starto_set_homepage_style($new_value = '') {
	global $starto_homepage_style;
	$starto_homepage_style = $new_value;
}

//Get page gallery ID
function starto_get_page_gallery_id() {
	global $starto_page_gallery_id;
	return $starto_page_gallery_id;
}

//Get default theme options variable
function starto_get_options() {
	global $starto_options;
	return $starto_options;
}

//Set default theme options variable
function starto_set_options($new_value = '') {
	global $starto_options;
	$starto_options = $new_value;
}

//Get top bar setting
function starto_get_topbar() {
	global $starto_topbar;
	return $starto_topbar;
}

//Set top bar setting
function starto_set_topbar($new_value = '') {
	global $starto_topbar;
	$starto_topbar = $new_value;
}

//Get is hide title option
function starto_get_hide_title() {
	global $starto_hide_title;
	return $starto_hide_title;
}

//Set is hide title option
function starto_set_hide_title($new_value = '') {
	global $starto_hide_title;
	$starto_hide_title = $new_value;
}

//Get theme page content CSS class
function starto_get_page_content_class() {
	global $starto_page_content_class;
	return $starto_page_content_class;
}

//Set theme page content CSS class
function starto_set_page_content_class($new_value = '') {
	global $starto_page_content_class;
	$starto_page_content_class = $new_value;
}

//Get Kirki global variable
function starto_get_kirki() {
	global $kirki;
	return $kirki;
}

//Get admin theme global variable
function starto_get_wp_admin_css_colors() {
	global $_wp_admin_css_colors;
	return $_wp_admin_css_colors;
}

//Get theme plugins
function starto_get_plugins() {
	global $starto_tgm_plugins;
	return $starto_tgm_plugins;
}

//Set theme plugins
function starto_set_plugins($new_value = '') {
	global $starto_tgm_plugins;
	$starto_tgm_plugins = $new_value;
}

$is_verified_envato_purchase_code = false;

//Get verified purchase code data
$pp_verified_envato_starto = get_option("pp_verified_envato_starto");
if(!empty($pp_verified_envato_starto))
{
	$is_verified_envato_purchase_code = true;
}

$is_imported_elementor_templates_starto = false;
$pp_imported_elementor_templates_starto = get_option("pp_imported_elementor_templates_starto");
if(!empty($pp_imported_elementor_templates_starto))
{
	$is_imported_elementor_templates_starto = true;
}
?>