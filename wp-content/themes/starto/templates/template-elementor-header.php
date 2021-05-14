<?php
	//Check if using normal or transparent header
	if(is_page() OR is_single() OR (class_exists('Woocommerce') && starto_is_woocommerce_page()))
	{
		//Check if Woocommerce is installed	
		if(class_exists('Woocommerce') && starto_is_woocommerce_page())
		{
			$current_page_id = get_option('woocommerce_shop_page_id');
			$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
		}
		else
		{
			$current_page_id = $post->ID;
		}	
		
		$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
		
		//Check if Woocommerce is installed	
		if(class_exists('Woocommerce') && starto_is_woocommerce_page())
		{
			$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
		}
		
		//If normal header
		if(empty($page_menu_transparent))
		{
			$starto_header_content_default = get_post_meta($current_page_id, 'page_header', true);

			if(empty($starto_header_content_default))
			{
				$starto_header_content_default = get_theme_mod('starto_header_content_default');
			}
			else
			{
				$starto_header_content_default = $starto_header_content_default;
			}
		}
		//if transparent header
		else
		{
			$starto_transparent_header_content_default = get_post_meta($current_page_id, 'page_transparent_header', true);
		
			if(empty($starto_transparent_header_content_default))
			{
				$starto_header_content_default = get_theme_mod('starto_transparent_header_content_default');
			}
			else
			{
				$starto_header_content_default = $starto_transparent_header_content_default;
			}
		}
	}
	else
	{
		$page_menu_transparent = 0;
		
		//If normal header
		if(empty($page_menu_transparent))
		{
			$starto_header_content_default = get_theme_mod('starto_header_content_default');
		}
		//if transparent header
		else
		{
			$starto_header_content_default = get_theme_mod('starto_transparent_header_content_default');
		}
	}
	
	if(!empty($starto_header_content_default))
	{
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$starto_header_content_default = pll_get_post($starto_header_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$starto_header_content_default = icl_object_id($starto_header_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
?>
	<div id="elementor-header" class="main-menu-wrapper">
		<?php 
			if (class_exists("\\Elementor\\Plugin")) {
                echo starto_get_elementor_content($starto_header_content_default);
            }
		?>
	</div>
<?php
	}
	
	//Check if sticky menu
	$starto_fixed_menu = get_theme_mod('starto_fixed_menu', true);
	
	if(!empty($starto_fixed_menu))
	{
		//Check if using normal or transparent header
		if(is_page() OR is_single())
		{
			$starto_header_content_default = get_post_meta($post->ID, 'page_sticky_header', true);
		
			if(empty($starto_header_content_default))
			{
				$starto_header_content_default = get_theme_mod('starto_sticky_header_content_default');
			}
		}
		else
		{
			$starto_header_content_default = get_theme_mod('starto_sticky_header_content_default');
		}
		
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$starto_header_content_default = pll_get_post($starto_header_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$starto_header_content_default = icl_object_id($starto_header_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
?>
	<div id="elementor-sticky-header" class="main-menu-wrapper">
		<?php 
			if (class_exists("\\Elementor\\Plugin")) {
                echo starto_get_elementor_content($starto_header_content_default);
            }
		?>
	</div>
<?php
	}
?>