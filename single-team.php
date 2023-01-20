<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); ?>
<div class="back-topbar">
  <div class="wrapper">
    <div class="inner">
      <a href="<?php echo get_permalink(17); ?>" class="back-button"><span class="arrow"></span>Back to Leadership</a> 
    </div>
  </div>
</div>

<div id="primary" class="content-area-full content-default single-team-page">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

      <?php  
      $job_title = get_field('job_title');
      $photo = get_field('photo');
      ?>
      <div class="wrapper">
  			<div class="titlediv">
          <h1 class="page-title"><?php the_title(); ?></h1> 
          <?php if ($job_title) { ?>
          <div class="jobtitle"><?php echo $job_title ?></div> 
          <?php } ?>
        </div>

  			<div class="entry-content <?php echo ($photo) ? 'hasphoto':'nophoto'; ?>">
          <?php if ($photo) { ?>
          <figure>
            <img src="<?php echo $photo['url'] ?>" alt="<?php echo $photo['title'] ?>">
          </figure>  
          <?php } ?>
          <div class="details">
            <?php the_content(); ?>
          </div>
  			</div>
      </div>

    <?php endwhile; ?>


      <?php if( have_rows('accordion') ) { ?>
      <div class="fullwidth-blue">
        <div class="arrow-top"></div>
        <div class="innerwrap">
          <div class="wrapper infotabs">
            <div class="tabs">
              <?php $i=1; while( have_rows('accordion') ) : the_row(); 
                $heading = get_sub_field('heading');
                $is_active = ($i==1) ? ' active':'';
                ?>
                <div class="tab<?php echo $is_active ?>"><a href="javascript:void(0)" data-tab="#tab_<?php echo $i?>"><span><?php echo $heading; ?></span></a></div>
              <?php $i++; endwhile; ?>
            </div>

            <div class="tabcontent">
              <?php $j=1; while( have_rows('accordion') ) : the_row(); 
                $is_text_active = ($j==1) ? ' active':''; 
                $is_text_active_title = ($j==1) ? ' show':''; 
                $heading = get_sub_field('heading');
                $content = get_sub_field('content');
                ?>
                <h3 data-rel="#tab_<?php echo $j?>" class="tab-title tab_<?php echo $j?>_title<?php echo $is_text_active_title?>"><?php echo $heading ?></h3>
                <div id="tab_<?php echo $j?>" class="tabtext<?php echo $is_text_active; ?>">
                  <?php echo $content; ?>    
                </div>
              <?php $j++; endwhile; ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

		

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
