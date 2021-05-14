<?php

get_header(); 

?>

<?php while ( have_posts() ) : the_post(); ?>
<div class="main-post-div">
<div class="container">
<div class="single-page-post-heading">
<h1><?php the_title(); ?></h1>
</div>
</div>

<div class="single-post-image">
<img src="<?php echo get_the_post_thumbnail_url(); ?>" />
</div>

<div class="content-here">
<?php  the_content();  ?>
</div>
<div class="comment-section-here"
<?php //comments_template(); ?>
</div>
</div>

<?php endwhile; ?>

<?php

get_footer(); ?>