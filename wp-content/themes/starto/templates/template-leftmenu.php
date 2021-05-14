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