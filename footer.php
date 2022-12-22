	</div><!-- #content -->
	<?php  
	$footer_logo = get_field("footer_logo","option");
  $footer_widget = get_field("footer_widget","option");
  $footer_partners = get_field("footer_partners","option");
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrapper">
			<div class="flexwrap">
				<?php if ($footer_logo) { ?>
					<div id="footer-logo" class="flexcol left">
            <?php if ($footer_logo) { ?>
              <img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>">
            <?php } ?>
					</div>
				<?php } ?>

        <?php if ($footer_widget) { $widgetCount = count($footer_widget); ?>
          <div id="footer-widgets" class="flexcol right widget-<?php echo $widgetCount ?>">
            <?php foreach ($footer_widget as $w) { ?>
              <?php if ($w['content']) { ?>
              <div class="widget"><?php echo $w['content'] ?></div>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
			</div>

      <div class="bottom">
        <div class="bcol">

          <?php if ($footer_partners) { ?>
            <div id="footer-partners" class="footer-partners">
              <?php foreach ($footer_partners as $p) { 
                $p_logo = $p['logo'];
                $p_link = $p['website'];
                ?>
                <?php if ($p_logo) { ?>

                  <?php if ($p_link) { ?>
                  <a href="<?php echo $p_link ?>" target="_blank"><img src="<?php echo $p_logo['url'] ?>" alt="<?php echo $p_logo['title'] ?>"></a>  
                  <?php } else { ?>
                  <img src="<?php echo $p_logo['url'] ?>" alt="<?php echo $p_logo['title'] ?>">
                  <?php } ?>

                <?php } ?>
              <?php } ?>
            </div>
          <?php } ?>

          <div class="copyright">
            &copy; <?php echo date('Y') ?> <?php echo get_bloginfo('name') ?>
          </div>
          
        </div>
      </div>
		</div>
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<div id="loaderDiv"> <div class="loaderInline"> <div class="sk-chase"> <div class="sk-chase-dot"></div> <div class="sk-chase-dot"></div> <div class="sk-chase-dot"></div> <div class="sk-chase-dot"></div> <div class="sk-chase-dot"></div> <div class="sk-chase-dot"></div> </div> </div> </div>
<?php wp_footer(); ?>
</body>
</html>
