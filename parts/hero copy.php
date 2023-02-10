<?php if ( is_front_page() || is_home() ) { 
  $hero_type = get_field('hero_type');
  if($hero_type=='banner') {
    $banner = get_field('banner');
    $count = ($banner) ? count($banner) : 0; 
    $slideshow = ($banner && count($banner)>1) ? 'slideshow':'static';
    if( have_rows('banner') ) { ?>
    <div id="home-banner" class="banner-wrapper">
      <div class="wrapper">
        <div class="banner swiper <?php echo $slideshow ?>">

          <div class="swiper-wrapper">
            <?php while( have_rows('banner') ) { the_row(); 
              $image = get_sub_field('image');
              $text = get_sub_field('text'); ?>
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
          <?php if ($count>1) { ?>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          <?php } ?>

        </div>

        <div class="scrolldown"><a href="#intro" id="scrolldown" class="fadeInDown wow"><span>Scroll Down</span></a></div>
      </div>
    </div>
    <?php } ?>
  <?php } else { ?>

    <?php if ( $youtubeId = extractYoutubeId( get_field('youtube_url') ) ) { 
      $thumbnail = "https://i3.ytimg.com/vi/".$youtubeId."/maxresdefault.jpg";
      $caption = get_field('video_caption');
      $video_thumbnail = get_field('video_thumbnail');
      if($video_thumbnail) {
        $thumbnail = $video_thumbnail['url'];
      }

      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logoImg = ($custom_logo_id) ? wp_get_attachment_image_src($custom_logo_id,'large') : '';

      ?>
      <div class="video-outer-wrap">
        <div class="video-wrapper">
          <div class="video-frame">
            <!-- <div class="video-cover"></div> -->
            <div class="mobile-hero" style="background-image:url('<?php echo $thumbnail ?>')"></div>
            <img src="<?php echo $thumbnail ?>" alt="" class="thumbnail">
            <div id="player"></div>
            <!-- <iframe id="home-intro-view" width="560" height="315" src="https://www.youtube.com/embed/<?php //echo $youtubeId ?>?controls=0&autoplay=1&mute=1&rel=0" title="YouTube video player" frameborder="0" allowfullscreen></iframe> -->
            <?php if ($caption) { ?>
            <div id="video-caption" class="video-caption">
              <div class="inner animated fadeInUp"><?php echo $caption ?></div>
            </div>  
            <?php } ?>
            <?php if ( $logoImg ) { ?>
            <div id="video-logo" class="video-logo">
              <span><img src="<?php echo $logoImg[0] ?>" alt="<?php echo get_bloginfo('name') ?>"></span>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="scrolldown"><a href="#intro" id="scrolldown" class="fadeInDown wow"><span>Scroll Down</span></a></div>
      </div>
      <script src="https://www.youtube.com/iframe_api"></script>
      <script>
        var player;
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
              height: '390',
              width: '640',
              videoId: '<?php echo $youtubeId ?>',
              playerVars: {
                autoplay: 1,
                loop: 1,
                mute:1,
                rel:0,
                controls: 0,
                showinfo: 0
              },
              events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
              }
            });
        }

        // autoplay video
        function onPlayerReady(event) {
            event.target.playVideo();
            setTimeout(fadeOutText, 950);
        }

        // when video ends
        function onPlayerStateChange(event) {        
            if(event.data === 0) {            
              setTimeout(revealLogo, 900);
            }
        }

        function revealLogo() {
          document.getElementById('video-logo').classList.add("reveal");
        }

        function fadeOutText() {
          var playerId = document.getElementById('video-caption');
          playerId.classList.add("animated");
          playerId.classList.add("fadeOut");
        }
    </script>

    <?php } ?>

  <?php } ?>

<?php } else { ?>

  <?php if ( $banner = get_field('banner') ) {
    global $post; 
    $subtext = get_field('banner_text');
    $page_title = get_the_title();
    $postName = (isset($post->post_name) && $post->post_name) ? $post->post_name : '';
    if($postName=='our-communities') {
      $current_term = (isset($_GET['term']) && $_GET['term']) ? ucwords($_GET['term']) : '';
      if($current_term) {
        $page_title = $current_term . ' Communities';
      }
    }
  ?>
  <div class="subpage-banner">
    <div class="wrapper">
      <div class="banner-image" style="background-image:url(<?php echo $banner['url'] ?>)"></div>
      <div class="banner-text">
        <h1 class="hero-title"><?php echo $page_title; ?></h1>
      </div>
      <?php if ($subtext) { ?>
      <div class="banner-sm-text">
        <div class="wrapper"><?php echo $subtext ?></div>
      </div>  
      <?php } ?>
    </div>
  </div> 
  <?php } ?>

<?php } ?>
