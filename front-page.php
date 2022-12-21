<?php 
get_header(); 
?>

<div id="primary" class="content-area-full">
<?php while ( have_posts() ) : the_post(); ?>
  <?php if ( get_the_content() ) { ?>
  <div id="intro">
    <?php the_content(); ?>
  </div>
  <?php } ?>
<?php endwhile; ?>	
</div>

<?php
get_footer();