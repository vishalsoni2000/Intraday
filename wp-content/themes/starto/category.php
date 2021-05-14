<?php
/**
 * The main template file for display category page.
 *
 * @package WordPress
*/
	
//Get category page layout setting
$starto_blog_category_layout = get_theme_mod('starto_blog_category_layout', 'blog-r');
get_template_part($starto_blog_category_layout);
?>