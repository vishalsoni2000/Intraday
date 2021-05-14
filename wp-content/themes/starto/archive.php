<?php
/**
 * The main template file for display archive page.
 *
 * @package WordPress
*/

//Get archive page layout setting
$starto_blog_archive_layout = get_theme_mod('starto_blog_archive_layout', 'blog-r');
get_template_part($starto_blog_archive_layout);
?>