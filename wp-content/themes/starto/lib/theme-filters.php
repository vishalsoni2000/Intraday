<?php
	
//Remove one click demo import plugin from admin menus
function starto_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'Demo Import' , 'starto' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Content' , 'starto' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'tg-one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'starto_plugin_page_setup' );

function starto_menu_page_removing() {
    remove_submenu_page( 'themes.php', 'tg-one-click-demo-import' );
}
add_action( 'admin_menu', 'starto_menu_page_removing', 99 );

$is_verified_envato_purchase_code = false;

//Get verified purchase code data
$pp_verified_envato_starto = get_option("pp_verified_envato_starto");
if(!empty($pp_verified_envato_starto))
{
	$is_verified_envato_purchase_code = true;
}

if($is_verified_envato_purchase_code)
{
	function starto_import_files() {
	  return array(
	    array(
	      'import_file_name'             => 'Demo 1',
	      'local_import_file'            => trailingslashit( get_template_directory() ) . 'data/demos/demo1/demo.xml',
	      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'data/demos/demo1/demo.json',
	      'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'data/demos/demo1/demo.dat',
	      'preview_url'                  => 'https://themes.themegoods.com/starto/',
	    ),
	  );
	}
	add_filter( 'pt-ocdi/import_files', 'starto_import_files' );
	
	function starto_confirmation_dialog_options ( $options ) {
		return array_merge( $options, array(
			'width'       => 300,
			'dialogClass' => 'wp-dialog',
			'resizable'   => false,
			'height'      => 'auto',
			'modal'       => true,
		) );
	}
	add_filter( 'pt-ocdi/confirmation_dialog_options', 'starto_confirmation_dialog_options', 10, 1 );
	
	function starto_after_import( $selected_import ) {
		switch($selected_import['import_file_name'])
		{
			case 'Demo 1':
				// Assign menus to their locations.
				$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
			
				set_theme_mod( 'nav_menu_locations', array(
						'primary-menu' => $main_menu->term_id,
						'side-menu' => $main_menu->term_id,
					)
				);
				
			break;
			
			default:
				wp_delete_nav_menu('Main Menu');
			break;
		}
		
		// Assign front page
		$front_page_id = get_page_by_title( 'Home 1' );
		
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		
		// Assign Woocommerce related page
		$shop_page_id = get_page_by_title( 'Shop' );
		update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
		
		$cart_page_id = get_page_by_title( 'Cart' );
		update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
		
		$checkout_page_id = get_page_by_title( 'Checkout' );
		update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
		
		$myaccount_page_id = get_page_by_title( 'My account' );
		update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
		
		//Install Default Fonts
		remove_theme_mod('starto_custom_fonts');
		$default_custom_fonts = array(
			0 => array(
				'font_name' => 	'CircularStd',
				'font_url' 	=>	get_template_directory_uri().'/fonts/CircularStd-Book.woff',
				'font_fallback'	=> 'sans-serif',
				'font_weight' => 400,
				'font_style' => 'normal',
			),
			1 => array(
				'font_name' => 	'CircularStd',
				'font_url' 	=>	get_template_directory_uri().'/fonts/CircularStd-Bold.woff',
				'font_fallback'	=> 'sans-serif',
				'font_weight' => 700,
				'font_style' => 'normal',
			)
		);
		set_theme_mod( 'starto_custom_fonts', $default_custom_fonts );
		
		// 'Hello World!' post
	    wp_delete_post( 4, true );
	
	    // 'Sample page' page
	    wp_delete_post( 5, true );
	    
	    //Set permalink
	    global $wp_rewrite;
		$wp_rewrite->set_permalink_structure('/%postname%/');
		
		//Update all Elementor URLs
		starto_elementor_replace_urls('https://themes.themegoods.com/starto', home_url());
	}
	add_action( 'pt-ocdi/after_import', 'starto_after_import' );
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
}

//Disable Elementor getting started
add_action( 'admin_init', function() {
	if ( did_action( 'elementor/loaded' ) ) {
		remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
	}
}, 1 );
	
add_filter( 'the_password_form', 'starto_password_form' );
function starto_password_form() {
    $post = starto_get_wp_post();
    
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    
    $return_html = '<div class="protected-post-header"><h1>' . esc_html($post->post_title) . '</h1></div>';
    $return_html.= '<form class="protected-post-form" action="' .wp_login_url(). '?action=postpass" method="post">';
    $return_html.= '<div class="protected-post-text">'.esc_html__( "This content is password protected. To view it please enter your password below:", 'starto'  ).'</div><input name="post_password" id="' . $label . '" type="password" size="40" />';
    
    $return_html.= '<input type="submit" name="Submit" class="button" value="' . esc_html__( "Authenticate", 'starto' ) . '" />';
    $return_html.= '</form>';
    
    return $return_html;
}
	
if ( ! function_exists( 'starto_theme_kirki_update_url' ) ) {
    function starto_theme_kirki_update_url( $config ) {
        $config['url_path'] = get_template_directory_uri() . '/modules/kirki/';
        return $config;
    }
}
add_filter( 'kirki/config', 'starto_theme_kirki_update_url' );

add_action( 'customize_register', function( $wp_customize ) {
	/**
	 * The custom control class
	 */
	class Kirki_Controls_Title_Control extends Kirki_Control_Base {
		public $type = 'title';
		public function render_content() { 
			echo esc_html($this->label);
		}
	}
	// Register our custom control with Kirki
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['title'] = 'Kirki_Controls_Title_Control';
		return $controls;
	} );

} );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function starto_tag_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'starto_tag_pingback_header' );


function starto_tag_cloud_filter($args = array()) {
   $args['smallest'] = 12;
   $args['largest'] = 12;
   $args['unit'] = 'px';
   return $args;
}

add_filter('widget_tag_cloud_args', 'starto_tag_cloud_filter', 90);

//Customise Widget Title Code
add_filter( 'dynamic_sidebar_params', 'starto_wrap_widget_titles', 1 );
function starto_wrap_widget_titles( array $params ) 
{
	$widget =& $params[0];
	$widget['before_title'] = '<h2 class="widgettitle"><span>';
	$widget['after_title'] = '</span></h2>';
	
	return $params;
}

//Control post excerpt length
function starto_custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'starto_custom_excerpt_length', 200 );


function starto_theme_queue_js(){
  if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
  }
}
add_action('get_header', 'starto_theme_queue_js');

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 300,
        'height' => 300,
        'crop' => 0,
    );
} );

function starto_add_meta_tags() {
    $post = starto_get_wp_post();
    
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    
    //Check if responsive layout is enabled
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
	
	//meta for phone number link on mobile
	echo '<meta name="format-detection" content="telephone=no">';
}
add_action( 'wp_head', 'starto_add_meta_tags' , 1 );

add_filter('redirect_canonical','custom_disable_redirect_canonical');
function custom_disable_redirect_canonical($redirect_url) {if (is_paged() && is_singular()) $redirect_url = false; return $redirect_url; }

function starto_body_class_names($classes) 
{
	$post = starto_get_wp_post();
	
	if(isset($post->ID))
	{
		//Check if boxed layout is enable
		$page_boxed_layout = get_post_meta($post->ID, 'page_boxed_layout', true);
		if(!empty($page_boxed_layout))
		{
			$classes[] = esc_attr('boxed-layout');
		}
		
		//Get Page Menu Transparent Option
		$page_menu_transparent = get_post_meta($post->ID, 'page_menu_transparent', true);
		if(!empty($page_menu_transparent))
		{
			$classes[] = esc_attr('menu-transparent');
		}
	}
	
	//if password protected
	if(post_password_required() && is_page())
	{
	   	$classes[] = esc_attr('password-protected');
	}
	
	//Get lightbox color scheme
	$starto_lightbox_color_scheme = get_theme_mod('starto_lightbox_color_scheme', 'black');
	
	if(!empty($starto_lightbox_color_scheme))
	{
		$classes[] = esc_attr('lightbox-'.$starto_lightbox_color_scheme);
	}
	
	//Get sidemenu on desktop class
	$starto_sidemenu = get_theme_mod('starto_sidemenu', false);

	if(!empty($starto_sidemenu))
	{
		$classes[] = esc_attr('sidemenu-desktop-disabled');
	}
	
	//Get main menu layout
	$starto_menu_layout = starto_menu_layout();
	if(!empty($starto_menu_layout))
	{
		$classes[] = esc_attr($starto_menu_layout);
	}
	
	//Get fotoer reveal class
	$starto_footer_reveal = get_theme_mod('starto_footer_reveal', false);
	if(!empty($starto_footer_reveal))
	{
		$classes[] = esc_attr('footer-reveal');
	}
	
	if(is_page() && !comments_open($post->ID) && !class_exists('\\Elementor\\Plugin'))
	{
		$classes[] = esc_attr('comment-close');
	}
	
	//Get single course template
	if(is_single() && is_object($post))
	{
		$starto_course_template = starto_get_single_course_template($post->ID);
		$classes[] = esc_attr('tg-single-course-'.$starto_course_template);
	}
	
	//Get current user
	$current_user_id = get_current_user_id();

	if(!empty($current_user_id) && is_object($post) && function_exists('learn_press_is_enrolled_course'))
	{
		$is_enrolled = learn_press_is_enrolled_course($post->ID, $current_user_id);
		if($is_enrolled)
		{
			$classes[] = esc_attr('is-enrolled');
		}
	}

	return $classes;
}

//Now add test class to the filter
add_filter('body_class','starto_body_class_names');

add_filter('upload_mimes', 'starto_add_custom_upload_mimes');
function starto_add_custom_upload_mimes($existing_mimes) 
{
  	$existing_mimes['woff'] = 'application/x-font-woff';
  	return $existing_mimes;
}

add_action('init','starto_shop_sorting_remove');
function starto_shop_sorting_remove() {
	$starto_shop_filter_sorting = get_theme_mod('starto_shop_filter_sorting', true);
	
	if(empty($starto_shop_filter_sorting))
	{
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 30 );
		
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}
}

add_action( 'admin_enqueue_scripts', 'starto_admin_pointers_header' );

function starto_admin_pointers_header() {
   if ( starto_admin_pointers_check() ) {
      add_action( 'admin_print_footer_scripts', 'starto_admin_pointers_footer' );

      wp_enqueue_script( 'wp-pointer' );
      wp_enqueue_style( 'wp-pointer' );
   }
}

function starto_admin_pointers_check() {
   $admin_pointers = starto_admin_pointers();
   foreach ( $admin_pointers as $pointer => $array ) {
      if ( $array['active'] )
         return true;
   }
}

function starto_admin_pointers_footer() {
   $admin_pointers = starto_admin_pointers();
?>
<script type="text/javascript">
/* <![CDATA[ */
( function($) {
   <?php
   foreach ( $admin_pointers as $pointer => $array ) {
      if ( $array['active'] ) {
         ?>
         $( '<?php echo esc_js($array['anchor_id']); ?>' ).pointer( {
            content: '<?php echo wp_kses_post($array['content']); ?>',
            position: {
            edge: '<?php echo esc_js($array['edge']); ?>',
            align: '<?php echo esc_js($array['align']); ?>'
         },
            close: function() {
               $.post( ajaxurl, {
                  pointer: '<?php echo esc_js($pointer); ?>',
                  action: 'dismiss-wp-pointer'
               } );
            }
         } ).pointer( 'open' );
         <?php
      }
   }
   ?>
} )(jQuery);
/* ]]> */
</script>
   <?php
}

function starto_admin_pointers() {
   $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
   $prefix = 'starto_admin_pointer';
   
   //Page help pointers
   $elementor_builder_content = '<h3>Page Builder</h3>';
   $elementor_builder_content .= '<p>Basically you can use WordPress visual editor to create page content but theme also has another way to create page content. By using Elementor Page Builder, you would be ale to drag&drop each content block without coding knowledge. Click here to enable Elementor.</p>';
   
   $page_options_content = '<h3>Page Options</h3>';
   $page_options_content .= '<p>You can customise various options for this page including menu styling, page templates etc.</p>';
   
   $page_featured_image_content = '<h3>Page Featured Image</h3>';
   $page_featured_image_content .= '<p>Upload or select featured image for this page to displays it as background header.</p>';
   
   //Post help pointers
   $post_options_content = '<h3>Post Options</h3>';
   $post_options_content .= '<p>You can customise various options for this post including its layout and featured content type.</p>';
   
   $post_featured_image_content = '<h3>Post Featured Image (*Required)</h3>';
   $post_featured_image_content .= '<p>Upload or select featured image for this post to displays it as post image on blog, archive, category, tag and search pages.</p>';

   $starto_pointer_arr = array(   
   	  //Page help pointers
      $prefix . '_elementor_builder' => array(
         'content' => $elementor_builder_content,
         'anchor_id' => '#elementor-switch-mode-button .elementor-switch-mode-off',
         'edge' => 'top',
         'align' => 'left',
         'active' => ( ! in_array( $prefix . '_elementor_builder', $dismissed ) )
      ),
      
      $prefix . '_page_options' => array(
         'content' => $page_options_content,
         'anchor_id' => 'body.post-type-page #page_option_page_menu_transparent',
         'edge' => 'top',
         'align' => 'left',
         'active' => ( ! in_array( $prefix . '_page_options', $dismissed ) )
      ),
      
      $prefix . '_page_featured_image' => array(
         'content' => $page_featured_image_content,
         'anchor_id' => 'body.post-type-page #set-post-thumbnail',
         'edge' => 'top',
         'align' => 'left',
         'active' => ( ! in_array( $prefix . '_page_featured_image', $dismissed ) )
      ),
      
      //Post help pointers
      $prefix . '_post_options' => array(
         'content' => $post_options_content,
         'anchor_id' => 'body.post-type-post #post-option-post-layout',
         'edge' => 'top',
         'align' => 'left',
         'active' => ( ! in_array( $prefix . '_post_options', $dismissed ) )
      ),
      
      $prefix . '_post_featured_image' => array(
         'content' => $post_featured_image_content,
         'anchor_id' => 'body.post-type-post #set-post-thumbnail',
         'edge' => 'top',
         'align' => 'left',
         'active' => ( ! in_array( $prefix . '_post_featured_image', $dismissed ) )
      ),
   );

   return $starto_pointer_arr;
}

remove_action( 'wp_head', 'rest_output_link_header', 10);    
remove_action( 'template_redirect', 'rest_output_link_header', 11);

if(STARTO_THEMEDEMO)
{
	add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
	add_action( 'elementor/frontend/after_enqueue_styles', function() { wp_dequeue_style( 'elementor-icons' ); } );
}

add_filter('wp_list_categories', 'starto_add_span_cat_count');

function starto_add_span_cat_count($links) {
	$links = str_replace('</a> (', '</a> <span class="cat-count">', $links);
	$links = str_replace(')', '</span>', $links);
	return $links;
}

add_filter('get_archives_link', 'starto_add_span_archive_count');

function starto_add_span_archive_count($links) {
	$links = str_replace('</a>&nbsp;(', '</a> <span class="archive-count">', $links);
	$links = str_replace(')', '</span>', $links);
	return $links;
}

if( is_admin() ){
	add_action( 'wp_default_scripts', 'starto_default_custom_scripts' );
	function starto_default_custom_scripts( $scripts ){
		$scripts->add( 'wp-color-picker', "/wp-admin/js/color-picker.js", array( 'iris' ), false, 1 );
		did_action( 'init' ) && $scripts->localize(
			'wp-color-picker',
			'wpColorPickerL10n',
			array(
				'clear'            => __( 'Clear' ),
				'clearAriaLabel'   => __( 'Clear color' ),
				'defaultString'    => __( 'Default' ),
				'defaultAriaLabel' => __( 'Select default color' ),
				'pick'             => __( 'Select Color' ),
				'defaultLabel'     => __( 'Color value' ),
			)
		);
	}
}
?>