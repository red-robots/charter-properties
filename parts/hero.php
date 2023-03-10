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

    <?php 

      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logoImg = ($custom_logo_id) ? wp_get_attachment_image_src($custom_logo_id,'large') : '';
      $videoLink = get_field('youtube_url');
      $caption = get_field('video_caption');
      $video_thumbnail = get_field('video_thumbnail');
      $thumbnail = ($video_thumbnail) ? $video_thumbnail['url'] : '';

      /* YOUTUBE */
      if ( $youtubeId = extractYoutubeId( $videoLink ) ) { 
        $thumbnail = "https://i3.ytimg.com/vi/".$youtubeId."/maxresdefault.jpg";
        if($video_thumbnail) {
          $thumbnail = $video_thumbnail['url'];
        } 
        ?>
      <div class="video-outer-wrap">
        <div class="video-wrapper">
          <div class="video-frame">
            <div class="mobile-hero" style="background-image:url('<?php echo $thumbnail ?>')"></div>
            <img src="<?php echo $thumbnail ?>" alt="" class="thumbnail">
            <div id="player"></div>
            <?php if ($caption) { ?>
            <div id="video-caption" class="video-caption animated">
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

    <?php } else { ?>

      <?php if ($videoLink &&  (strpos($videoLink, 'vimeo.com') !== false) ) { 
        $vimeoID = (int) substr(parse_url($videoLink, PHP_URL_PATH), 1);
        ?>
        <div id="vimeoVIDEO" class="video-outer-wrap">
          <div class="video-wrapper">
            <div class="video-frame">
              <?php if ($thumbnail) { ?>
              <div class="mobile-hero" style="background-image:url('<?php echo $thumbnail ?>')"></div>
              <img src="<?php echo $thumbnail ?>" alt="" class="thumbnail">
              <?php } ?>
              <div id="player">
                <iframe id="vimeo-iframe" src="https://player.vimeo.com/video/<?php echo $vimeoID ?>?h=09ea2b7748&autoplay=1&loop=0&muted=1&sidedock=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              </div>
              <?php if ($caption) { ?>
              <div id="video-caption" class="video-caption">
                <div id="video-hero-text" class="inner animated fadeInUp"><?php echo $caption ?></div>
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
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script>
          var iframe = document.querySelector('#vimeo-iframe');
          var player = new Vimeo.Player(iframe);

          player.on('play', function() {
            //iframe.src = "https://player.vimeo.com/video/<?php echo $vimeoID ?>?h=09ea2b7748&autoplay=1&loop=0&muted=1&sidedock=0";
            <?php if ($caption) { ?>
              videoCaption = document.getElementById('video-hero-text');
              setTimeout(function(){
                videoCaption.classList.remove('fadeInUp');
                videoCaption.classList.add('fadeOut');
              },1500);
            <?php } ?>
          });

          player.on('ended', function() {
            //document.getElementById('video-logo').classList.add("reveal");
            setTimeout(function(){
              iframe.src = "https://player.vimeo.com/video/<?php echo $vimeoID ?>?h=09ea2b7748&autoplay=1&loop=1&muted=1&sidedock=0";
              <?php if ($caption) { ?>
                videoCaption.classList.remove('fadeOut');
                videoCaption.classList.add('fadeInUp');
              <?php } ?>
            },100);
            setTimeout(function(){
              videoCaption.classList.remove('fadeInUp');
              videoCaption.classList.add('fadeOut');
            },3800);
          });

          
      </script>
      <?php } ?>

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
