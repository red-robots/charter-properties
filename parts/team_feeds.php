<?php
$args = array(
	'posts_per_page'   => -1,
	'post_type'        => 'team',
	'post_status'      => 'publish'
);
$team = new WP_Query($args);
if ( $team->have_posts() ) { ?>
<div class="wrapper teamfeeds">
	<div class="flexwrap">
			<?php while ( $team->have_posts() ) : $team->the_post();
			$id = get_the_ID();
			$photo = get_field('photo'); 
			$jobtitle = get_field('job_title'); 
      //$division = get_the_terms($id,'divisions'); 
			// $phone = get_field("phone");
			// $staff_name = get_the_title();
			// $pagelink = get_permalink();
			// $hasphoto = ($photo) ? 'hasImage':'noImage';
			// $style = ($photo) ? ' style="background-image:url('.$photo['url'].')"':'';
			// $division_name = ($division) ? $division[0]->name : '';
			// $linkedin = get_field("linkedin");
			// $enable_link = true;
      $stylePhoto = ($photo) ? ' style="background-image:url('.$photo['url'].')"' : '';
			?>
			<div class="team <?php echo ($photo) ? 'hasphoto':'nophoto'; ?>">
        <div class="inner">
          <a href="<?php echo get_the_permalink() ?>"> <figure<?php echo $stylePhoto ?>> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/portrait.png" alt=""> </figure> <div class="info"> <h4><?php echo get_the_title() ?></h4> <?php if ($jobtitle) { ?><div class="jobtitle"><?php echo $jobtitle ?></div><?php } ?> </div> <div class="slideBtn">Learn More</div> </a>
        </div>
      </div>
			<?php endwhile; wp_reset_postdata(); ?>
      <div class="team other-info">
        <div class="inner" id="ctaBoxTeam"></div>
      </div>
	</div>
</div>
<?php } ?>