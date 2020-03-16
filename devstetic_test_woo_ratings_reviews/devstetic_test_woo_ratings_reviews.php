<?php
/*
Plugin Name: Test WooCommerce Ratings and Reviews
Description: Adds test rating and review count to WooCommerce Products for Development purposes
Version: 1.0.0
Author: Devstetic
*/

function devstetic_get_all_products(  ) {
    $ps = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => '-1'
    ) );

    $arr = array();

    while($ps->have_posts()){
      $ps->the_post();
      $arr[] = get_the_ID();
    }

    return $arr;
}

function devstetic_float_rand($Min, $Max, $round=0){
  //validate input
  if ($min > $Max) { $min=$Max; $max=$Min; }
        else { $min=$Min; $max=$Max; }
  $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
  if($round > 0)
    $randomfloat = round($randomfloat,$round);

  return $randomfloat;
}

add_action('admin_init','devstetic_reviews_edit');

function devstetic_reviews_edit(){
  $products = devstetic_get_all_products();  

  foreach ($products as $key => $value) {
    $randcount = wp_rand( 50, 200 );
    $randrating = devstetic_float_rand(4.5,5,1);
    update_post_meta( $value, '_wc_average_rating', $randrating );
    update_post_meta( $value, '_wc_review_count', $randcount );
    update_post_meta( $value, '_wc_rating_count', $randcount );
  }
}