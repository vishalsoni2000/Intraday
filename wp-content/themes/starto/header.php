<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */

if ( ! isset( $content_width ) ) $content_width = 960;

if(session_id() == '') {
	session_start();
}

$starto_homepage_style = starto_get_homepage_style();

$starto_menu_layout = starto_menu_layout();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if(isset($starto_homepage_style) && !empty($starto_homepage_style)) { echo 'data-style="'.esc_attr($starto_homepage_style).'"'; } ?> data-menu="<?php echo esc_attr($starto_menu_layout); ?>">
<head>

<link rel="stylesheet" href="https://use.typekit.net/mys5piz.css">
<link rel="profile" href="//gmpg.org/xfn/11" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.fancybox.min.css">
	
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.fancybox.min.js"></script>
	


<style>

.site-loader{z-index:9999;pointer-events:none;position:fixed; left: 0; top: 0; background-color: #fff; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;}
.site-loader img{max-width: 450px; width: 100%; height: 100%;}

	.bank-popup {
		display: none;
	}
	.bank-popup .modal-content .modal-body iframe {
		width: 100%;
		height: 100%;
	}
	
	.fancybox-slide--html .fancybox-close-small {
		padding: 1px !important;
	}
	
	.brochures-link {
		outline: none;
	}
</style>
	
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=PT+Serif:wght@400;700&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">


<?php
	//Fallback compatibility for favicon
	if(!function_exists( 'has_site_icon' ) || ! has_site_icon() )
	{
		/**
		*	Get favicon URL
		**/
		$starto_favicon = get_theme_mod('starto_favicon');

		if(!empty($starto_favicon))
		{
?>
			<link rel="shortcut icon" href="<?php echo esc_url($starto_favicon); ?>" />
<?php
		}
	}
?>

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
	
</head>

<body <?php body_class(); ?>>
	<div class="site-loader">
	 <div class="bounce-animation">
		 <img src="https://intradayinc.com/wp-content/uploads/2021/03/Intraday_new-logo.gif">
	 </div>
	</div>
	
    <?php
		wp_body_open();

		$post = starto_get_wp_post();
		$custom_bg_style = '';

		//if password protected
		if(post_password_required())
		{
			$image_thumb = '';
			if(has_post_thumbnail(get_the_ID(), 'full'))
			{
			    $image_id = get_post_thumbnail_id(get_the_ID());
			    $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
			}

			if(isset($image_thumb[0]) && !empty($image_thumb[0]))
			{
				$custom_bg_style.='background-image:url('.esc_url($image_thumb[0]).');';
			}
		}
	?>
	<div id="perspective" style="<?php echo esc_attr($custom_bg_style); ?>">

	<?php
		switch($starto_menu_layout)
		{
			case 'centeralign':
			case 'hammenuside':
			case 'leftalign':
			case 'leftmenu':
			default:
				get_template_part("/templates/template-sidemenu");
			break;

			case 'full-burger-menu':
				get_template_part("/templates/template-fullmenu");
			break;
		}
	?>

	<!-- Begin template wrapper -->
	<?php

		$starto_page_menu_transparent = starto_get_page_menu_transparent();

		if(isset($post->ID))
		{
			$current_page_id = $post->ID;
		}
		else
		{
			$current_page_id = '';
		}

		//Get Page Menu Transparent Option
		$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);

	    $pp_page_bg = '';

	    //Get page featured image
	    if(has_post_thumbnail($current_page_id, 'full'))
	    {
	        $image_id = get_post_thumbnail_id($current_page_id);
	        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
	        $pp_page_bg = $image_thumb[0];
	    }

	   if(!empty($pp_page_bg) && basename($pp_page_bg)=='default.png')
	    {
	    	$pp_page_bg = '';
	    }

		if(is_search() OR is_404() OR is_archive() OR is_category() OR is_tag())
		{
		    $page_menu_transparent = 0;
		}

		//Check if default WordPress homepage
		if(is_front_page() && is_home())
		{
			$page_menu_transparent = 0;
		}

		//Check if Woocommerce is installed
		if(class_exists('Woocommerce') && starto_is_woocommerce_page())
		{
			$shop_page_id = get_option('woocommerce_shop_page_id');
			$page_menu_transparent = get_post_meta($shop_page_id, 'page_menu_transparent', true);
			$starto_page_menu_transparent = $page_menu_transparent;
		}
	?>
	<div id="wrapper" class="<?php if(!empty($starto_page_menu_transparent)) { ?>hasbg<?php } ?> <?php if(!empty($page_menu_transparent)) { ?>transparent<?php } ?>">

	<?php
		$starto_header_content = get_theme_mod('starto_header_content', 'menu');

		if($starto_header_content == 'content')
		{
			get_template_part("/templates/template-elementor-header");
		}
		else
		{
			//Get main menu layout
			$starto_menu_layout = starto_menu_layout();

			switch($starto_menu_layout)
			{
				case 'centeralign':
				case 'hammenuside':
				case 'full-burger-menu':
				default:
					get_template_part("/templates/template-topmenu");
				break;

				case 'leftalign':
					get_template_part("/templates/template-topmenu-left");
				break;

				case 'center-menu-logo':
					get_template_part("/templates/template-topmenu-center-menus");
				break;
			}
		}
	?>