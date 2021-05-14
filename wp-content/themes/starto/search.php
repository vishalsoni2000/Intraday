<?php
/**
 * The main template file for display blog page.
 *
 * @package WordPress
*/

get_header(); 

//Include custom header feature
get_template_part("/templates/template-header");
?>

<?php
$page_sidebar = 'Search Sidebar';
?>

<!-- Begin content -->
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner-wrapper">

    			<div class="sidebar-content <?php if(!have_posts() OR !is_active_sidebar('search-sidebar')) { ?>fullwidth<?php } ?>">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-wrapper">
	    
	    <div class="post-content-wrapper">
			<div class="post-header-wrapper">
				<div class="post-header">
			    	<div class="post-header_title">
				    	<h5><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
			    	</div>
			    </div>
			    
			    <?php
			    	$starto_blog_display_full = get_theme_mod('starto_blog_display_full', false);
			    	
			    	if(!empty($starto_blog_display_full))
			    	{
			    		the_content();
			    	}
			    	else
			    	{
			    		the_excerpt();
			    	}
			    ?>
			    <div class="post-button-wrapper">
			    	<a class="readmore" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html_e('Read More', 'starto' ); ?><span class="ti-angle-right"></span></a>
			    </div>
			</div>
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->

<?php endwhile; endif; ?>

		<?php
			//Hide page title if doesn't have any results
			if(!have_posts())
			{
		?>
			<h1><?php esc_html_e('Nothing Found', 'starto' ); ?></h1>
    	
	    	<div class="search-form-wrapper">
		    	<?php esc_html_e( "Sorry, but nothing matched your search terms. Please try again with some different keywords.", 'starto' ); ?>
		    	<br/><br/>
		    	
	    		<form class="searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		    		<p class="input-wrapper">
			    		<input type="text" class="input-effect field searchform-s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e('Type to search...', 'starto' ); ?>">
						<input type="submit" value="<?php esc_attr_e('Search', 'starto' ); ?>"/>
		    		</p>
			    </form>
    		</div>
		<?php
			}	
		?>

    	<?php
		    if($wp_query->max_num_pages > 1)
		    {
		    	if (function_exists("starto_pagination")) 
		    	{
		    	    starto_pagination($wp_query->max_num_pages);
		    	}
		    	else
		    	{
		    	?>
		    	    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
		    	<?php
		    	}
		    ?>
		    <div class="pagination-detail">
		     	<?php
		     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		     	?>
		     	<?php esc_html_e('Page', 'starto' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'starto' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
		     </div>
		     <?php
		     }
		?>
    	</div>
    	
    		<div class="sidebar-wrapper">
    		
    			<div class="sidebar_top"></div>
    		
    			<div class="sidebar">
    			
    				<div class="content">
    			
    					<ul class="sidebar-widget">
    					<?php dynamic_sidebar($page_sidebar); ?>
    					</ul>
    				
    				</div>
    		
    			</div>
    			<br class="clear"/>
    	
    			<div class="sidebar_bottom"></div>
    		</div>
    	</div>
    	
    </div>
    <!-- End main content -->
    </div>
	
</div>
</div>
<?php get_footer(); ?>