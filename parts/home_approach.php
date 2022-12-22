<?php if( $tabs = get_field('home_tabs') ) { ?>
<div class="home--approach">
  <div class="home--tabs">
    <?php $i=1; foreach ($tabs as $tab) { 
      $title = $tab['title'];
      $icon = $tab['icon'];
      $text = $tab['text']; 
      if($title && $text) { ?>
      <div id="homeTab<?php echo $i?>" class="tabTitle <?php echo ($i==1) ? 'active':''; ?>">
        <div class="title">
          <a href="javascript:void(0)" class="wrap"><?php if ($icon) { ?><img src="<?php echo $icon['url'] ?>" alt=""><?php } ?><?php if ($title) { ?><span class="t1"><?php echo $title ?></span><?php } ?></a>
        </div><div class="tabText homeTab<?php echo $i?><?php echo ($i==1) ? ' active':''; ?>"><div class="inner"><?php echo $text ?></div></div>
      </div>
      <?php $i++; } ?>
    <?php } ?>
  </div>
  <div class="home-tabs-content"></div>
  <div class="home-tabs-arrows">
    <a href="javascript:void(0)" data-pos="previous" class="prev disabled"><span>Prev</span></a><a href="javascript:void(0)" data-pos="next" class="next"><span>next</span></a>
  </div>
</div>
<?php } ?>