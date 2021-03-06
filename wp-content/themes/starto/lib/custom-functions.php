<?php
/**
* Setup blog pagination function
**/
function starto_pagination($pages = '', $range = 4, $class = '')
{
	 $showitems = ($range * 2)+1;
	 
	 $paged = starto_get_paged();
	 if(empty($paged)) $paged = 1;
	 
	 if($pages == '')
	 {
	 $wp_query = starto_get_wp_query();
	 $pages = $wp_query->max_num_pages;
	 if(!$pages)
	 {
	 $pages = 1;
	 }
	 }
	 
	 if(1 != $pages)
	 {
	 echo "<div class=\"pagination ".esc_attr($class)."\">";
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".esc_url(get_pagenum_link(1))."'>&laquo;</a>";
	 if($paged > 1 && $showitems < $pages) echo "<a href='".esc_url(get_pagenum_link($paged - 1))."'>&lsaquo;</a>";
	 
	 for ($i=1; $i <= $pages; $i++)
	 {
		 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		 {
			 if($paged == $i)
			 {
				 echo "<span class=\"current\">".$i."</span>";
			 }
			 else
			 {
				 echo "<a href='".esc_url(get_pagenum_link($i))."' class=\"inactive\">".$i."</a>";
			 }
		 }
	 }
	 
	 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".esc_url(get_pagenum_link($paged + 1))."\">&rsaquo;</a>";
	 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".esc_url(get_pagenum_link($pages))."'> &raquo;</a>";
	 echo "</div>";
	 }
}

function starto_get_review($post_id = '', $rating_field = '')
{
	$rating_arr = array();
	if(!empty($post_id) && !empty($rating_field))
	{
		$args = array(
			'status' => 'approve',
			'post_id' => $post_id, // use post_id, not post_ID
		);
		$comments = get_comments($args);
		$count_comments = count($comments);
		$rating_avg = 0;
		$rating_points = 0;
		
		if(!empty($comments) && is_array($comments))
		{
			foreach($comments as $comment)
			{
				$rating = get_comment_meta( $comment->comment_ID, $rating_field, true );
				$rating_points += $rating;
			}
			
			$rating_avg = $rating_points/$count_comments;
		}
		
		$rating_arr = array(
			'average'	=> $rating_avg,
			'points'	=> $rating_points,
			'count'		=> $count_comments,
		);
		
		return $rating_arr;
	}
	else
	{
		return $rating_arr = array(
			'average'	=> 0,
			'points'	=> 0,
			'count'		=> 0,
		);
	}
}

function starto_get_comment_time( $comment_id = 0 ){
    return sprintf( 
        _x( '%s ago', 'Human-readable time', 'starto' ), 
        human_time_diff( 
            get_comment-date( 'U', $comment_id ), 
            current_time( 'timestamp' ) 
        ) 
    );
}
    
/**
*	Setup comment style
**/
function starto_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; 
?>
   
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<?php
		$has_avatar = get_avatar($comment,$size='60',$default='' );
		
		if($has_avatar != '')
		{
		?>
		<div class="gravatar">
         	<?php echo get_avatar($comment,$size='60',$default='' ); ?>
      	</div>
      	<?php
      	}
      	?>
      
      	<div class="right <?php if($has_avatar == '') { ?>fullwidth<?php } ?>">
			<?php if ($comment->comment_approved == '0') : ?>
         		<em><?php echo esc_html_e('(Your comment is awaiting moderation.)', 'starto') ?></em>
         		<br />
      		<?php endif; ?>
			
			<?php
				if(!empty($comment->comment_author_url))
				{
			?>
					<a href="<?php echo esc_url($comment->comment_author_url); ?>"><h7><?php echo esc_html($comment->comment_author); ?></h7></a>
			<?php
				}
				else
				{
			?>
					<h7><?php echo esc_html($comment->comment_author); ?></h7>
			<?php
				}
			?>
			
			<div class="comment-date"><?php echo date_i18n(STARTO_THEMEDATEFORMAT, strtotime($comment->comment_date)); ?> <?php echo esc_html_e('at', 'starto') ?> <?php echo date_i18n(STARTO_THEMETIMEFORMAT, strtotime($comment->comment_date)); ?></div>
			<?php 
      			if($depth < 3)
      			{
      		?>
      			<?php comment_reply_link(array_merge( $args, array('depth' => $depth,
'reply_text' =>  __('Reply', 'starto'), 'login_text' => __('Login to Reply', 'starto'), 'max_depth' => $args['max_depth']))) ?>
			<?php
				}
			?>
			<div class="comment_text"/>
      			<?php ' '.comment_text() ?>
	  		</div>
      	</div>
    </div>
    <?php 
        if($depth == 1)
        {
    ?>
    <br class="clear"/>
    <?php
    	}
    ?>
<?php
}

// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function starto_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}


/**
*	Setup recent posts widget
**/
function starto_posts($sort = 'recent', $items = 3, $echo = TRUE, $show_thumb = TRUE) 
{
	$return_html = '';
	
	if($sort == 'recent')
	{
		$args = array(
			'numberposts' => $items,
			'order' => 'DESC',
			'orderby' => 'date',
			'post_type' => 'post',
			'post_status' => 'publish',
			'suppress_filters' => 0,
		);
		$posts = get_posts($args);
		$title = esc_html__('Recent Posts', 'starto');
	}
	
	if(!empty($posts))
	{
		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="posts blog ';
		
		if($show_thumb)
		{
			$return_html.= 'withthumb ';
		}
		
		$return_html.= '">';
		
		$count_post = count($posts);

			foreach($posts as $post)
			{
				$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true);
				$return_html.= '<li>';
				
				if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'thumbnail'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					
					$return_html.= '<div class="post-circle-thumb"><a href="'.esc_url(get_permalink($post->ID)).'"><img src="'.esc_url($image_url[0]).'" alt="'.esc_attr($post->post_title).'" /></a></div>';
				}
				
				$return_html.= '<a href="'.esc_url(get_permalink($post->ID)).'">'.$post->post_title.'</a><div class="post-attribute">'.date_i18n(STARTO_THEMEDATEFORMAT, get_the_time('U', $post->ID)).'</div>';
				$return_html.= '</li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo stripslashes($return_html);
	}
	else
	{
		return $return_html;
	}
}

function starto_cat_posts($cat_id = '', $items = 5, $echo = TRUE, $show_thumb = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	$category_link = get_category_link($cat_id);
	$count_post = count($posts);
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="posts blog ';
		
		if($show_thumb)
		{
			$return_html.= 'withthumb ';
		}
		
		$return_html.= '">';

			foreach($posts as $key => $post)
			{
				$return_html.= '<li>';
			
				if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'thumbnail'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					
					$return_html.= '<div class="post-circle-thumb"><a href="'.esc_url(get_permalink($post->ID)).'"><img class="alignleft frame post_thumb" src="'.esc_url($image_url[0]).'" alt="'.esc_attr($post->post_title).'" /></a></div>';
				}
				
				$return_html.= '<a href="'.esc_url(get_permalink($post->ID)).'">'.starto_substr($post->post_title, 50).'</a><div class="post-attribute">'.date_i18n(STARTO_THEMEDATEFORMAT, get_the_time('U', $post->ID)).'</div>';
				$return_html.= '</li>';
			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo stripslashes($return_html);
	}
	else
	{
		return $return_html;
	}
}

function starto_image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}


function starto_select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);

    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_q.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );

    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}

function starto_get_excerpt_by_id($post_id)
{
	$the_post = get_post($post_id); //Gets post ID
	if(!empty($the_post->post_excerpt))
	{
		$the_excerpt = $the_post->post_excerpt;
	}
	else
	{
		$the_excerpt = $the_post->post_content;
	}
	
	$excerpt_length = 35; //Sets excerpt length by word count
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
	$words = explode(' ', $the_excerpt, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
	array_pop($words);
	array_push($words, '...');
	$the_excerpt = implode(' ', $words);
	endif;
	$the_excerpt = '<p>' . $the_excerpt . '</p>';
	return $the_excerpt;
}

if(!function_exists('starto_get_image_id'))
{
	function starto_get_image_id($url) 
	{
		$attachment_id = attachment_url_to_postid($url);
		
		if(!empty($attachment_id))
		{
			return $attachment_id;
		}
		else
		{
			return $url;
		}
	}
}

function starto_aasort(&$array, $key) 
{
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

function starto_unserialize_replace( $from = '', $to = '', $data = '', $serialised = false ) 
{
    try {
    	if ( is_string( $data ) && ( $unserialized = @unserialize( $data ) ) !== false ) {
    		$data = starto_unserialize_replace( $from, $to, $unserialized, true );
    	}
    	elseif ( is_array( $data ) ) {
    		$_tmp = array( );
    		foreach ( $data as $key => $value ) {
    			$_tmp[ $key ] = starto_unserialize_replace( $from, $to, $value, false );
    		}
    		$data = $_tmp;
    		unset( $_tmp );
    	}
    	else {
    		if ( is_string( $data ) )
    			$data = str_replace( $from, $to, $data );
    	}
    	if ( $serialised )
    		return serialize( $data );
    } catch( Exception $error ) {
    }
    return $data;
}

function starto_get_first_title_word($title) {
	return $title;
}

function starto_menu_layout() {
	$starto_menu_layout = get_theme_mod('starto_menu_layout', 'leftalign');
	
	return $starto_menu_layout;
}

/**
* starto_is_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*
* @access public
* @return bool
*/
function starto_is_woocommerce_page() 
{
	if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
	        return true;
	}
	$woocommerce_keys   =   array ( "woocommerce_shop_page_id") ;
	foreach ( $woocommerce_keys as $wc_page_id ) {
	        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
	                return true ;
	        }
	}
	return false;
}

function starto_check_system()
{
	$has_error = 0;
	$return_html = '<div class="system-status-wrapper">';
	
	$return_html.= '<h4>'.esc_html__('System Status', 'starto' ).'</h4><br/>';

	//Get max_execution_time
	$max_execution_time = ini_get('max_execution_time');
	$max_execution_time_class = '';
	$max_execution_time_text = '';
	if($max_execution_time < 180)
	{
		$max_execution_time_class = 'theme-setting-error';
		$has_error = 1;
		$max_execution_time_text = '*RECOMMENDED 180';
	}
	$return_html.= '<div class="'.$max_execution_time_class.'">max_execution_time: '.$max_execution_time.' '.$max_execution_time_text.'</div>';
	
	//Get memory_limit
	$memory_limit = ini_get('memory_limit');
	$memory_limit_class = '';
	$memory_limit_text = '';
	if(intval($memory_limit) < 128)
	{
		$memory_limit_class = 'theme-setting-error';
		$has_error = 1;
		$memory_limit_text = '*RECOMMENDED 128M';
	}
	$return_html.= '<div class="'.$memory_limit_class.'">memory_limit: '.$memory_limit.' '.$memory_limit_text.'</div>';
	
	//Get post_max_size
	$post_max_size = ini_get('post_max_size');
	$post_max_size_class = '';
	$post_max_size_text = '';
	if(intval($post_max_size) < 32)
	{
		$post_max_size_class = 'theme-setting-error';
		$has_error = 1;
		$post_max_size_text = '*RECOMMENDED 32M';
	}
	$return_html.= '<div class="'.$post_max_size_class.'">post_max_size: '.$post_max_size.' '.$post_max_size_text.'</div>';
	
	//Get upload_max_filesize
	$upload_max_filesize = ini_get('upload_max_filesize');
	$upload_max_filesize_class = '';
	$upload_max_filesize_text = '';
	if(intval($upload_max_filesize) < 32)
	{
		$upload_max_filesize_class = 'theme-setting-error';
		$has_error = 1;
		$upload_max_filesize_text = '*RECOMMENDED 32M';
	}
	$return_html.= '<div class="'.$upload_max_filesize_class.'">upload_max_filesize: '.$upload_max_filesize.' '.$upload_max_filesize_text.'</div>';
	
	//Get max_input_vars
	$max_input_vars = ini_get('max_input_vars');
	$max_input_vars_class = '';
	$max_input_vars_text = '';
	if(intval($max_input_vars) < 2000)
	{
		$max_input_vars_class = 'theme-setting-error';
		$has_error = 1;
		$max_input_vars_text = '*RECOMMENDED 2000';
	}
	$return_html.= '<div class="'.$max_input_vars_class.'">max_input_vars: '.$max_input_vars.' '.$max_input_vars_text.'</div>';
	
	if(!empty($has_error))
	{
		$return_html.= '<br/><hr/>';
		$return_html.= esc_html__('We are sorry, the demo data could not import properly. It most likely due to PHP configurations on your server. Please fix configuration in System Status which are reported in', 'starto' );
		$return_html.= '<span class="theme-setting-error">';
		$return_html.= esc_html__('RED', 'starto' );
		$return_html.= '</span>';
	}
	
	$return_html.= '</div>' ;
	
	return $return_html;
}

function starto_available_widgets() 
{
	$wp_registered_widget_controls = starto_get_registered_widget_controls();

	$widget_controls = $wp_registered_widget_controls;

	$available_widgets = array();

	foreach ( $widget_controls as $widget ) {

		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

		}

	}

	return $available_widgets;
}

function starto_set_map_api()
{
	//Get Google Map API Key
	$pp_googlemap_api_key = get_option('pp_googlemap_api_key');
	
	if(empty($pp_googlemap_api_key))
	{
		wp_enqueue_script('starto-google-maps', '//maps.googleapis.com/maps/api/js', false, '', true);
	}
	else
	{
		wp_enqueue_script('starto-google-maps', '//maps.googleapis.com/maps/api/js?key='.$pp_googlemap_api_key, false, '', true);
	}
}

function starto_get_demo_logo($logo_name = 'starto_retina_logo')
{
	$logo_url = '';
	
	switch($logo_name)
	{
		case 'starto_retina_logo':
			$logo_url = get_site_url().'/wp-content/themes/starto/images/logo@2x.png';
		break;
		
		case 'starto_retina_transparent_logo':
			$logo_url = get_site_url().'/wp-content/themes/starto/images/logo@2x_white.png';
		break;
	}
	
	return $logo_url;
}

function starto_get_demo_url($path = '')
{
	$demo_url = 'https://themes.themegoods.com/starto/demo/'.$path;
	return $demo_url;
}

function starto_themegoods_action() 
{
	if(defined('THEMEGOODS') && THEMEGOODS)
	{
		update_option("pp_verified_envato_starto", true);
		update_option("pp_envato_personal_token", '[ThemeGoods Activation]');
	}
}

function starto_get_elementor_content($starto_content_default = '')
{
	if (class_exists("\\Elementor\\Plugin")) {
        $pluginElementor = \Elementor\Plugin::instance();
        $contentElementor = $pluginElementor->frontend->get_builder_content($starto_content_default);
        return $contentElementor;
    }
    else
    {
	    return '';
    }
}

function starto_starts_with($haystack, $needle) 
{
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function starto_post_has( $type, $post_id ) 
{
	$comments = get_comments('status=approve&type=' . $type . '&post_id=' . $post_id );
	$comments = separate_comments( $comments );
	 
	return 0 < count( $comments[ $type ] );
}

function starto_get_course_duration_string($post_id = '')
{
	$course_duration_string = '';
	
	if(!empty($post_id))
	{
		$course_duration = get_post_meta($post_id, '_lp_duration', true);
		
		$course_duration_arr = explode(" ", $course_duration);
					
		$duration_int = 0;
		$duration_type = esc_html__('weeks', 'starto' );
		if(isset($course_duration_arr[0]))
		{
			$duration_int = intval($course_duration_arr[0]);
			
			if(isset($course_duration_arr[1]))
			{
				$is_plural = false;
				if($duration_int > 1)
				{
					$is_plural = true;
				}
				
				switch($course_duration_arr[1])
				{
					case 'week':
					case 'weeks':
					default:
						if($is_plural)
						{
							$duration_type = esc_html__('weeks', 'starto' );
						}
						else
						{
							$duration_type = esc_html__('week', 'starto' );
						}
					break;
					
					case 'day':
					case 'days':
						if($is_plural)
						{
							$duration_type = esc_html__('days', 'starto' );
						}
						else
						{
							$duration_type = esc_html__('day', 'starto' );
						}
					break;
					
					case 'hour':
					case 'hours':
						if($is_plural)
						{
							$duration_type = esc_html__('hours', 'starto' );
						}
						else
						{
							$duration_type = esc_html__('hour', 'starto' );
						}
					break;
					
					case 'minute':
					case 'minutes':
						if($is_plural)
						{
							$duration_type = esc_html__('minutes', 'starto' );
						}
						else
						{
							$duration_type = esc_html__('minute', 'starto' );
						}
					break;
				}
			}
			
			$course_duration_string = $duration_int.'&nbsp;'.$duration_type;
		}
	}
	
	return $course_duration_string;
}

function starto_get_single_course_template($post_id = '')
{
	//Get single course template
	$starto_course_template = get_theme_mod('starto_course_template', 1);
	
	//Get single course template option
	$course_lp_course_template = get_post_meta($post_id, '_lp_course_template', true);
	if(!empty($course_lp_course_template))
	{
		$starto_course_template = $course_lp_course_template;
	}
	
	return $starto_course_template;
}

if(!function_exists('starto_get_lazy_img_attr'))
{
	function starto_get_lazy_img_attr()
	{
		$starto_enable_lazy_loading = get_theme_mod('starto_enable_lazy_loading', true);
		$return_attr = array('class' => '','source' => 'src');
		
		if(!empty($starto_enable_lazy_loading))
		{
			$return_attr = array('class' => 'lazy','source' => 'data-src');
		}
		
		return $return_attr;
	}
}
	
if(!function_exists('starto_get_blank_img_attr'))
{
	function starto_get_blank_img_attr()
	{
		$starto_enable_lazy_loading = get_theme_mod('starto_enable_lazy_loading', true);
		$return_attr = '';
		
		if(!empty($starto_enable_lazy_loading))
		{
			$return_attr = 'src=""';
		}
		
		return $return_attr;
	}
}

if(!function_exists('starto_get_post_format_icon'))
{
	function starto_get_post_format_icon($post_id = '')
	{
		$return_html = '';
		
		if(!empty($post_id))
		{
			$post_format = get_post_format($post_id);
			
			if($post_format == 'video' && has_post_thumbnail($post_id, 'large'))
			{
				$return_html = '<div class="post-type-icon"><span class="ti-control-play"></span></div>';	
			}
		}
		
		return $return_html;
	}
}

function starto_write_log($log)  
{
    if (true === WP_DEBUG) 
    {
        if ( is_array($log) || is_object($log) ) 
        {
            error_log(print_r($log, true));
        } else 
        {
            error_log($log);
        }
    }
}

function starto_elementor_replace_urls( $from, $to ) {
	$from = trim( $from );
	$to = trim( $to );
	
	$is_valid_urls = ( filter_var( $from, FILTER_VALIDATE_URL ) && filter_var( $to, FILTER_VALIDATE_URL ) );
	
	if ( $from != $to && $is_valid_urls) {
		$wpdb = starto_get_wpdb();
	}
	
	$rows_affected = $wpdb->query(
			"UPDATE {$wpdb->postmeta} " .
			"SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from ) . "', '" . str_replace( '/', '\\\/', $to ) . "') " .
			"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			
	return $rows_affected;
}
?>