<?php
get_header();

echo '<section class="banner-part">'.
    '<div class="container">'.
    	'<h1>The Testimonial</h1>'.            
    '</div>'.
'</section>';

echo '<section class="testimonial-listing">'.
    '<div class="container">';

if(have_posts()) : while(have_posts()) : the_post();

echo '<div class="single-testimonial" style="background-image: url('. get_the_post_thumbnail_url() .');">'.
'<div class="content-part">'.
    '<h5><a href="'. get_the_permalink() .'">'. get_the_title() . '</a></h5>'.
    
    '<div class="post-button-wrapper">'.
    	'<a class="continue-reading" href="'. get_the_permalink() .'">Continue Reading<span></span></a>'.
    '</div>'.    
'</div></div>';
endwhile; endif;
echo '</div></section>';


get_footer();
?>