<?php
$args = array(
  'posts_per_page'    => 15,
  'post_type'         => 'testimonial',
  'post_status'       => 'publish',
  'orderby'           => 'date',
  'order'             => 'DESC'    
);
$entries = new WP_Query($args); 
if ( $entries->have_posts() ) { ?>
<div class="wrapper">
  <div id="testimonials-carousel" class="testimonials-swiper">
    <div class="swiper-wrapper">
      <?php while ( $entries->have_posts() ) : $entries->the_post(); ?>
      <div class="swiper-slide testimonial">
        <div class="inner">
          <?php the_content(); ?>
          <div class="author">
            <div class="testimonialNav customNav">
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