<?php
/**
 * Template Name: Sitemap
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full maxwidth-template <?php echo $has_banner ?>">
  <main id="main" class="site-main wrapper-small" role="main">
    <?php while ( have_posts() ) : the_post(); ?>

      <?php if (empty($banner )) { ?>
      <header class="entry-title"><h1 class="page-title"><span><?php the_title(); ?></span></h1></header>
      <?php } ?>
      
      
      <?php if ( get_the_content() ) { ?>
      <section class="entry-content"><?php the_content(); ?></section>
      <?php } ?>

      <?php if ( has_nav_menu('sitemap') ) { ?>
      <div id="sitemap-wrap">
        <?php wp_nav_menu( array( 'theme_location' => 'sitemap', 'menu_id' => 'sitemap','container_class'=>'sitemap-links') ); ?>
      </div>
      <?php } ?>

    <?php endwhile; ?>  
  </main>
</div>

<?php
get_footer();
