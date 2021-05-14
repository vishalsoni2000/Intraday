<?php
// Change page title for Shop Archive page
add_filter( 'wp_title', 'starto_title_for_shop' );
function starto_title_for_shop( $title )
{
  if ( is_shop() ) {
    return esc_html__('Shop', 'starto' );
  }
  return $title;
}

//Change number of products per page
add_filter( 'loop_shop_per_page', 'starto_shop_per_page', 20 );
function starto_shop_per_page()
{
	$starto_shop_items = get_theme_mod('starto_shop_items', 16);
	return $starto_shop_items;
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'starto_loop_columns');
if (!function_exists('starto_loop_columns')) {
	function starto_loop_columns() {
		return 3; // 3 products per row
	}
}

/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 
add_filter( 'woocommerce_output_related_products_args', 'starto_related_products_args' );

function starto_related_products_args( $args ) 
{
  	//Check if display related products
	$starto_shop_related_products = get_theme_mod('starto_shop_related_products', true);
	
	if(!empty($starto_shop_related_products))
	{
		$args['posts_per_page'] = 4; // 4 related products
		$args['columns'] = 4; // arranged in 2 columns
	}
	else
	{
		$args['posts_per_page'] = 0;
	}
	
	return $args;
}
?>