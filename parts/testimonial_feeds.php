<?php
$category = (isset($a['type']) && $a['type']) ? $a['type'] : '';
$args = array(
  'posts_per_page'    => 15,
  'post_type'         => 'testimonial',
  'post_status'       => 'publish',
  'orderby'           => 'date',
  'order'             => 'DESC'    
);
if($category) {
  $args['tax_query'] = array(
    array(
      'taxonomy'  => 'testimonial-types', 
      'field'   => 'slug',
      'terms'   => array($category) 
    )
  );
} else {
  $args['tax_query'] = array(
    array(
      'taxonomy'  => 'testimonial-types', 
      'field'   => 'slug',
      'terms'   => array('resident') 
    )
  );
}

$entries = new WP_Query($args); 
if ( $entries->have_posts() ) { 
  $count = $entries->found_posts; 
  $slide_id = ($count>1) ?  'testimonials-carousel':'testimonials-static';
?>
<div class="wrapper">
  <div id="<?php echo $slide_id ?>" class="testimonials-swiper total-items-<?php echo $count ?>">
    <div class="swiper-wrapper">
      <?php while ( $entries->have_posts() ) : $entries->the_post(); ?>
      <div class="swiper-slide testimonial">
        <div class="inner">
          <?php the_content(); ?>
          <div class="author">
            <div class="testimonialNav customNav found-<?php echo $count ?>">
              <span><?php the_title(); ?></span><a href="javascript:void(0)" class="swiper_prev prev" data-action=".owl-prev"></a><a href="javascript:void(0)" class="swiper_next next" data-action=".owl-next"></a>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile;  ?>
    </div>
  </div>
</div>
<?php } ?>