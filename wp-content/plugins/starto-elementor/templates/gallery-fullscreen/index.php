<?php
	$widget_id = $this->get_id();
	$images = $this->get_settings('gallery');
	
	if(!empty($images))
	{
		//Get all settings
		$settings = $this->get_settings();
		$timer_arr = $this->get_settings('timer');
		$timer = intval($timer_arr['size']) * 1000;
		
		$background_color = $this->get_settings('background_color');
?>
<div class="swiper-container fullscreen-gallery-wrapper">
	<div class="fullscreen-gallery" <?php if($settings['autoplay'] == 'yes') { ?>data-autoplay="<?php echo esc_attr($timer); ?>"<?php } ?> data-effect="<?php echo esc_attr($settings['effect']); ?>" data-speed="<?php echo esc_attr($settings['transition_speed']['size']); ?>">
		<div class="swiper-wrapper">
<?php
		$counter = 0;
	
		foreach ( $images as $image ) 
		{	
			$image_id = starto_get_image_id($image['url']);
			
			//Get slideshow content
	        $image_title = '';
	        $image_caption = '';
	        $image_desc = '';
	        
	        $image_title = get_the_title($image_id);
			$image_caption = get_post_field('post_excerpt', $image_id);
			$image_description = get_post_field('post_content', $image_id);
?>
		<div class="swiper-slide" style="background-image:url(<?php echo esc_url($image['url']); ?>);background-size:<?php echo esc_attr($settings['size']); ?>" <?php if($settings['autoplay'] == 'yes') { ?>data-swiper-autoplay="<?php echo esc_attr($timer); ?>"<?php } ?>>
			<?php
				if(!empty($settings['slideshow_content']))
				{
			?>
				<div class="gallery-fullscreen-content">
				<?php
					if(!empty($image_caption) && in_array('caption', $settings['slideshow_content']))
					{
				?>
					<div class="gallery-fullscreen-caption"><?php echo esc_html($image_caption); ?></div>
				<?php
					}
				
					if(!empty($image_title) && in_array('title', $settings['slideshow_content']))
					{
				?>
					<div class="gallery-fullscreen-title"><?php echo esc_html($image_title); ?></div>
				<?php
					}
					
					if(!empty($image_description) && in_array('description', $settings['slideshow_content']))
					{
				?>
					<div class="gallery-fullscreen-description"><?php echo esc_html($image_description); ?></div>
				<?php
					}
				?>
				</div>
			<?php
				}
			?>
		</div>
<?php
			$counter++;
			
			$navigation_color = $this->get_settings('navigation_color');
		}
?>
		</div>
		<!-- Add Arrows -->
        <div class="swiper-button-next swiper-button-white <?php echo esc_attr($settings['show_navigation']); ?>"><span class="ti-angle-right" style="color:<?php echo esc_attr($navigation_color); ?>"></span></div>
        <div class="swiper-button-prev swiper-button-white <?php echo esc_attr($settings['show_navigation']); ?>"><span class="ti-angle-left" style="color:<?php echo esc_attr($navigation_color); ?>"></span></div>
	</div>
	<div class="gallery_thumbs" style="display: none;">
      <div class="swiper-wrapper" style="display: none;">
         <div class="swiper-slide" style="display: none;"></div>
      </div>
   </div>
</div>
<?php
	}
?>