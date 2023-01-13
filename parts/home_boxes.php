<?php if( $home_boxes = get_field('home_boxes') ) { ?>

<div class="home-boxes grid">
  <?php foreach ($home_boxes as $hb) { 
    $is_highlight = ( isset($hb['highlight']) && $hb['highlight']=='yes' ) ? true : '';
    $buttonLink = ( isset($hb['button']['url']) && $hb['button']['url'] ) ? $hb['button']['url'] : '';
    $buttonText = ( isset($hb['button']['title']) && $hb['button']['title'] ) ? $hb['button']['title'] : '';
    $buttonTarget = ( isset($hb['button']['target']) && $hb['button']['target'] ) ? $hb['button']['target'] : '_self';
  ?>
  <div class="item<?php echo ($is_highlight) ? ' highlighted':'' ?>">
    <div class="inner">

      <?php if ($hb['title'] || $hb['text']) { ?>
      <div class="titlediv">
        <?php if ($hb['title']) { ?>
        <h4><?php echo $hb['title'] ?></h4> 
        <?php } ?>

        <?php if (!$buttonLink) { ?>
          <?php if ($hb['text']) { ?>
          <h5><?php echo $hb['text'] ?></h5> 
          <?php } ?>
        <?php } ?>

      </div>
      <?php } ?>

      <?php if ($buttonText && $buttonLink) { ?>
      <div class="button"><a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="button"><?php echo $buttonText?></a></div> 
      <?php } ?>
    </div>
  </div>  
  <?php } ?>
</div>

<?php } ?>