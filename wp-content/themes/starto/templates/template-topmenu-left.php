<?php
//Get page ID
if(is_object($post))
{
    $obj_page = get_page($post->ID);
}
$current_page_id = '';

if(isset($obj_page->ID))
{
    $current_page_id = $obj_page->ID;
}
elseif(is_home())
{
    $current_page_id = get_option('page_on_front');
}
?>

<div class="main-menu-wrapper">
<?php
    //Check if display top bar
    $starto_topbar = get_theme_mod('starto_topbar', false);
    
    $starto_topbar = starto_get_topbar();
    starto_set_topbar($starto_topbar);
    
    if(!empty($starto_topbar))
    {
?>

<!-- Begin top bar -->
<div class="above-top-menu-bar">
    <div class="page-content-wrapper">
    
    <div class="top-contact-info">
		<?php
		    $starto_menu_contact_hours = get_theme_mod('starto_menu_contact_hours');
		    
		    if(!empty($starto_menu_contact_hours))
		    {	
		?>
		    <span id="top_contact_hours"><i class="fa fa-clock-o"></i><?php echo esc_html($starto_menu_contact_hours); ?></span>
		<?php
		    }
		?>
		<?php
		    //Display top contact info
		    $starto_menu_contact_number = get_theme_mod('starto_menu_contact_number');
		    
		    if(!empty($starto_menu_contact_number))
		    {
		?>
		    <span id="top_contact_number"><a href="tel:<?php echo esc_attr($starto_menu_contact_number); ?>"><i class="fa fa-phone"></i><?php echo esc_html($starto_menu_contact_number); ?></a></span>
		<?php
		    }
		?>
    </div>
    	
    <?php
    	//Display Top Menu
    	if ( has_nav_menu( 'top-menu' ) ) 
		{
		    wp_nav_menu( 
		        	array( 
		        		'menu_id'			=> 'top-menu',
		        		'menu_class'		=> 'top_nav',
		        		'theme_location' 	=> 'top-menu',
		        	) 
		    ); 
		}
    ?>
    <br class="clear"/>
    </div>
</div>
<?php
    }
?>
<!-- End top bar -->

<?php
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
	
	//Check if Woocommerce is installed	
	if(class_exists('Woocommerce') && starto_is_woocommerce_page())
	{
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		$page_menu_transparent = get_post_meta($shop_page_id, 'page_menu_transparent', true);
	}
	
	if(is_search() OR is_404() OR is_archive() OR is_category() OR is_tag() OR is_home())
	{
	    $page_menu_transparent = 0;
	}
	
	$starto_homepage_style = starto_get_homepage_style();
	if($starto_homepage_style == 'fullscreen')
	{
	    $page_menu_transparent = 1;
	}
?>
<div class="top-menu-bar <?php if(!empty($page_menu_transparent)) { ?>hasbg<?php } ?>">
    <div class="standard-wrapper">
    	<!-- Begin logo -->
    	<div id="logo-wrapper">
    	
    	<?php
    	    //get custom logo
    	    $starto_retina_logo = get_theme_mod('starto_retina_logo', starto_get_demo_logo('starto_retina_logo'));

    	    if(!empty($starto_retina_logo))
    	    {	
    	    	//Get image width and height
		    	$image_id = starto_get_image_id($starto_retina_logo);
		    	
		    	if(!empty($image_id) && is_numeric($image_id))
		    	{
		    		$obj_image = wp_get_attachment_image_src($image_id, 'original');
		    		
		    		$image_width = 0;
			    	$image_height = 0;
			    	
			    	if(isset($obj_image[1]))
			    	{
			    		$image_width = intval($obj_image[1]/2);
			    	}
			    	if(isset($obj_image[2]))
			    	{
			    		$image_height = intval($obj_image[2]/2);
			    	}
		    	}
		    	else if(!is_numeric($image_id))
			    {
				    $image_width = 1;
			    	$image_height = 1;
			    }
		    	else
		    	{
			    	$image_width = 0;
			    	$image_height = 0;
		    	}
    	?>
    	<div id="logo_normal" class="logo-container">
    		<div class="logo-alignment">
	    	    <a id="custom_logo" class="logo-wrapper <?php if(!empty($page_menu_transparent)) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo esc_url(home_url('/')); ?>">
	    	    	<?php
						if($image_width > 1 && $image_height > 1)
						{
					?>
					<img src="<?php echo esc_url($starto_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
						}
						else if($image_width == 1 && $image_height == 1 && $starto_retina_logo != starto_get_demo_logo('starto_retina_logo'))
						{
					?>
	    	    	<img src="<?php echo esc_url($starto_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" class="custom-logo-auto-resize"/>
	    	    	<?php 
		    	    	}
						else
						{
					?>
	    	    	<img src="<?php echo esc_url($starto_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="91" height="21"/>
	    	    	<?php 
		    	    	}
		    	    ?>
	    	    </a>
    		</div>
    	</div>
    	<?php
    	    }
    	?>
    	
    	<?php
    		//get custom logo transparent
    	    $starto_retina_transparent_logo = get_theme_mod('starto_retina_transparent_logo', starto_get_demo_logo('starto_retina_transparent_logo'));

    	    if(!empty($starto_retina_transparent_logo))
    	    {
    	    	//Get image width and height
		    	$image_id = starto_get_image_id($starto_retina_transparent_logo);
		    	
		    	if(!empty($image_id) && is_numeric($image_id))
		    	{
			    	$obj_image = wp_get_attachment_image_src($image_id, 'original');
			    	$image_width = 0;
			    	$image_height = 0;
			    	
			    	if(isset($obj_image[1]))
			    	{
			    		$image_width = intval($obj_image[1]/2);
			    	}
			    	if(isset($obj_image[2]))
			    	{
			    		$image_height = intval($obj_image[2]/2);
			    	}
			    }
			    else if(!is_numeric($image_id))
			    {
				    $image_width = 1;
			    	$image_height = 1;
			    }
			    else
		    	{
			    	$image_width = 0;
			    	$image_height = 0;
		    	}
    	?>
    	<div id="logo_transparent" class="logo-container">
    		<div class="logo-alignment">
	    	    <a id="custom_logo_transparent" class="logo-wrapper <?php if(empty($page_menu_transparent)) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo esc_url(home_url('/')); ?>">
	    	    	<?php
						if($image_width > 1 && $image_height > 1)
						{
					?>
					<img src="<?php echo esc_url($starto_retina_transparent_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
						}
						else if($image_width == 1 && $image_height == 1)
						{
					?>
	    	    	<img src="<?php echo esc_url($starto_retina_transparent_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" style="width:50%;height:auto;"/>
	    	    	<?php 
		    	    	}
						else
						{
					?>
	    	    	<img src="<?php echo esc_url($starto_retina_transparent_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="75" height="51"/>
	    	    	<?php 
		    	    	}
		    	    ?>
	    	    </a>
    		</div>
    	</div>
    	<?php
    	    }
    	?>
    	<!-- End logo -->
    	
        <div id="menu-wrapper">
	        <div id="nav-wrapper">
	        	<div class="nav-wrapper-inner">
	        		<div id="menu-border-wrapper">
	        			<?php 	
	        				//Check if has custom menu
	        				if(is_object($post) && $post->post_type == 'page')
	    					{
	    						$page_menu = get_post_meta($current_page_id, 'page_menu', true);
	    					}
	        			
	        				if(empty($page_menu))
	    					{
	    						if ( has_nav_menu( 'primary-menu' ) ) 
	    						{
	    		    			    wp_nav_menu( 
	    		    			        	array( 
	    		    			        		'menu_id'			=> 'main_menu',
	    		    			        		'menu_class'		=> 'nav',
	    		    			        		'theme_location' 	=> 'primary-menu',
	    		    			        		'walker' => new starto_walker(),
	    		    			        	) 
	    		    			    ); 
	    		    			}
	    	    			}
	    	    			else
	    				    {
	    				     	if( $page_menu && is_nav_menu( $page_menu ) ) {  
	    						    wp_nav_menu( 
	    						        array(
	    						            'menu' => $page_menu,
	    						            'walker' => new starto_walker(),
	    						            'menu_id'			=> 'main_menu',
	    		    			        	'menu_class'		=> 'nav',
	    						        )
	    						    );
	    						}
	    				    }
	        			?>
	        		</div>
	        	</div>
	        </div>
	        <!-- End main nav -->
        </div>
        
        <!-- Begin right corner buttons -->
        <div id="logo_right_wrapper">
			<div id="logo-right-wrapper">
			
			<?php
				//Check if display client icon
				$starto_menu_show_client = get_theme_mod('starto_menu_show_client', true);
				
				//Check if login module is activated
				$zm_ajax_login_register_activated = function_exists('zm_alr_init');
				
				if($zm_ajax_login_register_activated && !empty($starto_menu_show_client) && !is_user_logged_in())
				{
			?>
			<div class="menu-client-wrapper">
			    <a class="client_login_link" href="<?php echo esc_js('javascript:;'); ?>" title="<?php esc_attr_e('Client Login', 'starto' ); ?>"><span class="ti-lock"></span><?php esc_html_e('Client Login', 'starto' ); ?></a>
			</div>
			<?php
				}
				else if(is_user_logged_in() && !empty($starto_menu_show_client) && $zm_ajax_login_register_activated)
				{
					$current_user = wp_get_current_user();
					$user_homepage = get_the_author_meta('user_homepage', $current_user->ID);
					
					if(!empty($user_homepage))
					{
						$user_home_url = get_permalink($user_homepage);
					}
					else
					{
						$user_home_url = home_url();
					}
			?>
			<div class="menu-client-wrapper">
			    <span class="ti-user"></span><a href="<?php echo esc_url($user_home_url); ?>"><?php echo esc_html($current_user->display_name); ?></a>&nbsp;(<a class="user-logout-link" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php esc_attr_e('Logout', 'starto' ); ?>"><?php esc_html_e('Logout', 'starto' ); ?></a>)
			</div>
			<?php
				}
			?>
			
			<?php
				//Check if display cart icon
			    $starto_menu_show_cart = get_theme_mod('starto_menu_show_cart');
			   
				if (class_exists('Woocommerce') && !empty($starto_menu_show_cart)) {
			    //Check if display cart in header
			
			    $woocommerce = starto_get_woocommerce();
			    $cart_url = wc_get_cart_url();
			    $cart_counter = $woocommerce->cart->cart_contents_count;
			?>
			<div class="menu-cart-wrapper">
			    <div class="cart-counter"><?php echo esc_html($cart-counter); ?></div>
			    <a href="<?php echo esc_url($cart_url); ?>" title="<?php esc_attr_e('View Cart', 'starto' ); ?>"><span class="ti-shopping-cart"></span></a>
			</div>
			<?php
			}
			?>
			 
			 <!-- Begin side menu -->
			 <?php
			  	if ( has_nav_menu( 'side-menu' ) OR has_nav_menu( 'primary-menu' ) )
			  	{
			 ?>
		     	<a href="<?php echo esc_js('javascript:;'); ?>" id="mobile-nav-icon"><span class="ti-menu"></span></a>
		     <?php
			  	}
			 ?>
			 <!-- End side menu -->
			</div>
		</div>
		<!-- End right corner buttons -->
        
    	</div>
		</div>
    </div>
</div>
