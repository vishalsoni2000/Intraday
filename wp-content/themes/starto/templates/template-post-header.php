<?php
/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

$starto_topbar = starto_get_topbar();
$starto_screen_class = starto_get_screen_class();
$starto_page_content_class = starto_get_page_content_class();

$pp_page_bg = '';

//Check if display blog featured content
$starto_blog_feat_content = get_theme_mod('starto_blog_feat_content', true);

//Check if hide post featured
$hide_featured_image = get_post_meta($post->ID, 'hide_featured_image', true);
if(!empty($hide_featured_image))
{
	$starto_blog_feat_content = 0;
}

//Get page featured image
if(has_post_thumbnail($current_page_id, 'original') && !empty($starto_blog_feat_content))
{
    $image_id = get_post_thumbnail_id($current_page_id); 
    $image_thumb = wp_get_attachment_image_src($image_id, 'original', true);
    
    if(isset($image_thumb[0]) && !empty($image_thumb[0]))
    {
    	$pp_page_bg = $image_thumb[0];
    }
}
?>

<div id="page-header" class="<?php if(!empty($pp_page_bg)) { ?>has-featured<?php } ?><?php if(!empty($starto_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($starto_screen_class)) { echo esc_attr($starto_screen_class); } ?> <?php if(!empty($starto_page_content_class)) { echo esc_attr($starto_page_content_class); } ?>">
	<div class="page-title-wrapper">
		<div class="standard-wrapper">
			<div class="page-title-inner">
				<?php
					$starto_page_title_font_alignment = get_theme_mod('starto_blog_title_font_alignment', 'center');	
				?>
				<div class="page-title-content title_align_<?php echo esc_attr($starto_page_title_font_alignment); ?>">
					<?php
						//Get blog categories
						$starto_blog_cat = get_theme_mod('starto_blog_cat', true);
						if(!empty($starto_blog_cat))
						{
					?>
					<div class="post-detail single-post">
				    	<span class="post-info-cat smoove" data-move-y="102%">
							<?php
							   //Get Post's Categories
							   $post_categories = wp_get_post_categories($post->ID);
							   
							   $count_categories = count($post_categories);
							   $i = 0;
							   
							   if(!empty($post_categories))
							   {
							      	foreach($post_categories as $key => $c)
							      	{
							      		$cat = get_category( $c );
							?>
							      	<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
							<?php
								   		if(++$i != $count_categories) 
								   		{
								   			echo '&nbsp;&middot;&nbsp;';
								   		}
							      	}
							   }
							?>
				    	</span>
				 	</div>
				 	<?php
					 	}
					?>
					<h1 <?php if(!empty($pp_page_bg) && !empty($starto_topbar)) { ?>class="withtopbar"<?php } ?>><span class="smoove" data-move-y="102%"><?php the_title(); ?></span></h1>
						
					<?php
					    $starto_blog_display_author = get_theme_mod('starto_blog_display_author', true);
					    
					    if($starto_blog_display_author)
					    {
					?>
					<div class="post-author">
					    <div class="gravatar smoove" data-scale="0" data-move-y="102%"><?php echo get_avatar( get_the_author_meta('email', $post->post_author), 200 ); ?></div>
					    <div class="post-author-detail">
					     	<span class="post-author-name-before"><span class="post-author-name smoove" data-move-y="102%"><h6><?php echo get_the_author_meta('display_name', $post->post_author); ?></h6></span></span>
					     	
					     	<?php
								//Get blog categories
								$starto_blog_date = get_theme_mod('starto_blog_date', true);
								if(!empty($starto_blog_date))
								{
							?>
					     		<span class="post-published-date-before"><span class="post-published-date smoove" data-move-y="102%"><?php echo date_i18n(STARTO_THEMEDATEFORMAT, get_the_time('U')); ?></span></span>
					     	<?php
								}
							?>
					    </div>
					</div>
					<?php
					    }
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if(!empty($pp_page_bg)) { ?>
	<div id="post-featured-header" style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"></div>
<?php } ?>

<!-- Begin content -->
<div id="page-content-wrapper" class="blog-wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($starto_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($starto_page_content_class)) { echo esc_attr($starto_page_content_class); } ?>">
<?php
	//Check if custom post type plugin is installed	
	$starto_custom_post = ABSPATH . '/wp-content/plugins/starto-custom-post/starto-custom-post.php';
	
	$starto_custom_post_activated = file_exists($starto_custom_post);
	
	if($starto_custom_post_activated)
	{
		include_once( ABSPATH . '/wp-content/plugins/starto-custom-post/templates/template-share.php');
	}
?>