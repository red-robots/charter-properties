<?php if ( is_front_page() || is_home() ) { 
  $banner = get_field('banner');
  $count = ($banner) ? count($banner) : 0; 
  $slideshow = ($banner && count($banner)>1) ? 'slideshow':'static';
  if( have_rows('banner') ) { ?>
  <div id="home-banner" class="banner <?php echo $slideshow ?>">
    <div class="wrapper">
      <div class="swiper">
        <div class="swiper-wrapper">
        <?php while( have_rows('banner') ) { the_row(); 
          $image = get_sub_field('image');
          $text = get_sub_field('text');
          ?>
          <div class="swiper-slide slide">
            <?php if ($image) { ?>
            <div class="slideImage" style="background-image:url('<?php echo $image['url'] ?>')"></div>
            <?php } ?>

            <?php if ($text) { ?>
            <div class="caption">
              <div class="text"><?php echo $text ?></div>
            </div>
            <?php } ?>
          </div>
        <?php } ?>
        </div>
      </div>
      <?php if ($count>1) { ?>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      <?php } ?>
    </div>
  </div>
  <?php } ?>

<?php } ?>