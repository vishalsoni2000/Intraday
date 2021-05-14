<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 */
 
?>
</div>
<?php
	$starto_footer_content = get_theme_mod('starto_footer_content', 'sidebar');
	$starto_footer_sidebar = get_theme_mod('starto_footer_sidebar', 3);
	
	//Check if blank template
	$starto_is_no_header = starto_get_is_no_header();
	$starto_screen_class = starto_get_screen_class();
	
	if(!is_bool($starto_is_no_header) OR !$starto_is_no_header)
	{

	$starto_homepage_style = starto_get_homepage_style();
	$starto_page_hide_footer_default = 0;
	
	if(is_page())
	{
		//Check if hide footer
		$starto_page_hide_footer_default = get_post_meta($post->ID, 'page_hide_footer', false);
	}
	
	if(empty($starto_page_hide_footer_default))
	{
?>
<div id="footer-wrapper">
<?php
//if using footer post content
if($starto_footer_content == 'content')
{
	if(is_page())
	{
		$starto_footer_content_default = get_post_meta($post->ID, 'page_footer', true);
		
		if(empty($starto_footer_content_default))
		{
			$starto_footer_content_default = get_theme_mod('starto_footer_content_default');
		}
	}
	else
	{
		$starto_footer_content_default = get_theme_mod('starto_footer_content_default');
	}
	
	//Add Polylang plugin support
	if (function_exists('pll_get_post')) {
		$starto_footer_content_default = pll_get_post($starto_footer_content_default);
	}
	
	//Add WPML plugin support
	if (function_exists('icl_object_id')) {
		$starto_footer_content_default = icl_object_id($starto_footer_content_default, 'page', false, ICL_LANGUAGE_CODE);
	}

	if(!empty($starto_footer_content_default) && class_exists("\\Elementor\\Plugin"))
	{
		echo starto_get_elementor_content($starto_footer_content_default);
	}	
}
//end if using footer post content

//if use footer sidebar as content
else if($starto_footer_content == 'sidebar')
{
	//Check if page type
	if(is_page())
	{
		$page_show_footer_sidebar = get_post_meta($post->ID, 'page_show_footer_sidebar', true);
	}
	else
	{
		$page_show_footer_sidebar = 0;
	}
	
    if(!empty($starto_footer_sidebar) && empty($page_show_footer_sidebar))
    {
    	$footer_class = '';
    	
    	switch($starto_footer_sidebar)
    	{
    		case 1:
    			$footer_class = 'one';
    		break;
    		case 2:
    			$footer_class = 'two';
    		break;
    		case 3:
    			$footer_class = 'three';
    		break;
    		case 4:
    			$footer_class = 'four';
    		break;
    		default:
    			$footer_class = 'four';
    		break;
    	}
?>
<div id="footer" class="<?php if(isset($starto_homepage_style) && !empty($starto_homepage_style)) { echo esc_attr($starto_homepage_style); } ?> <?php if(!empty($starto_screen_class)) { echo esc_attr($starto_screen_class); } ?>">
<?php
	if(is_active_sidebar('Footer Sidebar')) 
	{
?>
	<ul class="sidebar-widget <?php echo esc_attr($footer_class); ?>">
	    <?php dynamic_sidebar('Footer Sidebar'); ?>
	</ul>
<?php
	}
?>
</div>
<?php
    }
    
	//Check if page type
	if(is_page())
	{
		$page_show_copyright = get_post_meta($post->ID, 'page_show_copyright', true);
	}
	else
	{
		$page_show_copyright = 0;
	}
	
	if(empty($page_show_copyright))
	{
	?>
	<div class="footer-main-container <?php if(isset($starto_homepage_style) && !empty($starto_homepage_style)) { echo esc_attr($starto_homepage_style); } ?> <?php if(!empty($starto_screen_class)) { echo esc_attr($starto_screen_class); } ?> <?php if(empty($starto_footer_sidebar)) { ?>noborder<?php } ?>">
	
		<div class="footer-main-container-wrapper <?php if(isset($starto_homepage_style) && !empty($starto_homepage_style)) { echo esc_attr($starto_homepage_style); } ?>">
			<?php
				//Check if display social icons or footer menu
				$starto_footer_copyright_right_area = get_theme_mod('starto_footer_copyright_right_area', 'menu');
				
				if($starto_footer_copyright_right_area=='social')
				{
					if($starto_homepage_style!='flow' && $starto_homepage_style!='fullscreen' && $starto_homepage_style!='carousel' && $starto_homepage_style!='flip' && $starto_homepage_style!='fullscreen_video')
					{	
						//Get Soical Icon
						get_template_part("/templates/template-socials");
					}
				} //End if display social icons
				else
				{
					if ( has_nav_menu( 'footer-menu' ) ) 
				    {
					    wp_nav_menu( 
					        	array( 
					        		'menu_id'			=> 'footer-menu',
					        		'menu_class'		=> 'footer_nav',
					        		'theme_location' 	=> 'footer-menu',
					        	) 
					    ); 
					}
				}
			?>
		    <?php
		    	//Display copyright text
		        $starto_footer_copyright_text = get_theme_mod('starto_footer_copyright_text', 'Copyright');
	
		        if(!empty($starto_footer_copyright_text))
		        {
		        	echo '<div id="copyright">'.wp_kses_post(wp_specialchars_decode($starto_footer_copyright_text)).'</div><br class="clear"/>';
		        }
		    ?>
		</div>
	</div>
	<?php
	}
} //end if using footer sidebar as content
?>
</div>
<?php
    } //End if not blank template
?>

<?php
	//Check if display to top button
	$starto_footer_copyright_totop = get_theme_mod('starto_footer_copyright_totop', true);
	
	if(!empty($starto_footer_copyright_totop))
	{
?>
 	<a id="go-to-top" href="<?php echo esc_js('javascript:;'); ?>"><span class="ti-arrow-up"></span></a>
<?php
 	}
?>

<?php
    //Check if theme demo then enable layout switcher
    if(STARTO_THEMEDEMO)
    {	
?>
    <div id="option_btn">
	    <a href="https://themegoods.com/contact/" class="demotip" title="Presale Question" target="_blank"><span class="ti-comment"></span></a>
    	<a href="https://docs.themegoods.com/docs/starto/" class="demotip" title="Theme Documentation" target="_blank"><span class="ti-book"></span></a>
    	
    	<a href="https://1.envato.market/PxQqY" title="Purchase Theme" class="demotip" target="_blank"><span class="ti-shopping-cart"></span></a>
    </div>
<?php
    	wp_enqueue_script("tooltipster", get_template_directory_uri()."/js/jquery.tooltipster.min.js", false, STARTO_THEMEDEMO, true);
    }
?>

<?php
    $starto_frame = get_theme_mod('starto_frame', false);
    
    if(!empty($starto_frame))
    {
?>
    <div class="frame_top"></div>
    <div class="frame_bottom"></div>
    <div class="frame_left"></div>
    <div class="frame_right"></div>
<?php
    }
?>

</div>
<?php
	} //End if page hide footer
?>
<?php
    $starto_enable_right_click = get_theme_mod('starto_enable_right_click', false);
    $starto_enable_right_click_content = get_theme_mod('starto_enable_right_click_content', false);

    if(!empty($starto_enable_right_click) && !empty($starto_enable_right_click_content))
    {
	    $starto_enable_right_click_content_text = get_theme_mod('starto_enable_right_click_content_text');
?>
    <div id="right-click-content">
	    <div class="right-click-content-table">
		    <div class="right-click-content-cell">
		    	<div><?php echo esc_html($starto_enable_right_click_content_text); ?></div>
	    	</div>
	    </div>
    </div>
<?php
    }
?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
