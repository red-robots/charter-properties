<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bellaworks
 */

$title = get_field("title404","option");
$content = get_field("content404","option");
get_header(); ?>

<div id="primary" class="content-area default-template page404">
  <main id="main" class="site-main">

    <header class="entry-title">
      <div class="wrapper">
        <div class="small-title">404 ERROR</div>
        <h1 class="page-title"><span><?php esc_html_e( 'Page Not Found!', 'bellaworks' ); ?> <!-- <span class="smiley"> ¯\_(ツ)_/¯ </span> --></span></h1>
      </div>
    </header>

    <section class="entry-content content404">
      <div class="wrapper">
        <div class="innerText">
          <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below.', 'bellaworks' ); ?></p>
          <div id="sitemap-wrap">
            <?php wp_nav_menu( array( 'theme_location' => 'sitemap', 'menu_id' => 'sitemap','container_class'=>'sitemap-links') ); ?>
          </div>
        </div>
      </div>
    </section>

  </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();