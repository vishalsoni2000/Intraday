<?php
/**
 * The main template file for display tag page.
 *
 * @package WordPress
*/
	
//Get tag page layout setting
$starto_blog_tag_layout = get_theme_mod('starto_blog_tag_layout', 'blog-r');
get_template_part($starto_blog_tag_layout);
?>