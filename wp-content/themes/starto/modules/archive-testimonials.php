<?php
get_header();
if(have_posts()) : while(have_posts()) : the_post();
    the_content();
endwhile; endif;
get_footer();
?>


<!--
if(have_posts()) : while(have_posts()) : the_post();
    echo '<a href="'. get_the_permalink() .'">';
    the_title(); 
        echo '</a>';
    echo '<div class="entry-content">';
    the_content();
    echo '</div>';
endwhile; endif;-->
