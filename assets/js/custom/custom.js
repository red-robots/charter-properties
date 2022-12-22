/**
 *	Custom jQuery Scripts
 *	Developed by: Lisa DeBona
 *  Date Modified: 09.23.2021
 */


jQuery(document).ready(function ($) {

  /* MENU TOGGLE */
  $('#menu-toggle').on('click',function(e){
    e.preventDefault();
    $(this).toggleClass('open');
    $('body').toggleClass('mobile-menu-open');
  });

  mobileHomeLink();
  $(window).on('orientationchange resize',function(){
    mobileHomeLink();
  });
  function mobileHomeLink() {
    if( $(window).width() < 961 ) {
      if( $('#site-navigation ul.menu li.homelink').length==0 ) {
        $('#site-navigation ul.menu').prepend('<li class="homelink"><a href="'+siteURL+'" aria-label="Homepage"><i class="fa fa-home" aria-hidden="true"></i></a></li>');
      }
    } else {
      if( $('#site-navigation ul.menu li.homelink').length ) {
        $('#site-navigation ul.menu li.homelink').remove();
      }
    }
  }


  new WOW().init();


  $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { 
            return false;
          } else {
            $target.attr('tabindex','-1'); 
            $target.focus(); 
          };
        });
      }
    }
  });


  $('[data-fancybox]').fancybox({
    protect: true
  });

  // const swiper = new Swiper('.swiper', {
  //   effect: 'fade',
  //   autoplay: {
  //    delay: 5000,
  //   },
  //   loop: true,
  //   pagination: {
  //     el: '.swiper-pagination',
  //     clickable: true
  //   },
  //   navigation: {
  //     nextEl: '.swiper-button-next',
  //     prevEl: '.swiper-button-prev',
  //   },
  // });

  /* Slideshow */
  var swiper = new Swiper('.slideshow', {
    effect: 'fade', /* "slide", "fade", "cube", "coverflow" or "flip" */
    loop: true,
    noSwiping: true,
    simulateTouch : true,
    speed: 1000,
    autoplay: {
      delay: 4000,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });


  /* Homepage Tabs */
  if( $('.home--tabs').length ) {
    $('.home--tabs .tabText').each(function(){
      $(this).appendTo('.home-tabs-content');
    });

    $('.tabTitle a').on('click',function(e){
      e.preventDefault();

      $('.tabTitle.active').removeClass('active');
      $(this).parents('.tabTitle').toggleClass('active');
      var id = $(this).parents('.tabTitle').attr('id');

      $('.tabText.active').removeClass('active');
      $('.tabText.'+id).addClass('active');
    });

    $('.home-tabs-arrows a').on('click',function(e){
      e.preventDefault();
      var pos = $(this).attr('data-pos');
      var count = $('.tabTitle').length;
      var last = 'homeTab'+count;
      var offset = 'homeTab'+(count-1);
      var currentId = $('.tabTitle.active').attr('id');

      if( $(this).hasClass('disabled') ) {
        
      } else {
        
        if(pos=='next') {

          /* Enable previous arrow */
          $('.home-tabs-arrows a.prev.disabled').removeClass('disabled');

          $('#'+currentId+'.tabTitle').next().addClass('active');
          $('#'+currentId+'.tabTitle').next().prev().removeClass('active');

          $('.'+currentId+'.tabText').next().addClass('active');
          $('.'+currentId+'.tabText').next().prev().removeClass('active');

          if(currentId==offset) {
            $('.home-tabs-arrows a.next').addClass('disabled');
          } 
          else if(currentId==last) {
            $('#'+last+'.tabTitle').addClass('active');
          }
        } else {
          /* previous */
          if(currentId=='homeTab2' || currentId=='homeTab1') {
            $('#homeTab1.tabTitle').addClass('active');
            $('#homeTab2.tabTitle').removeClass('active');
            $('.home-tabs-arrows a.prev').addClass('disabled');
            $('.home-tabs-arrows a.next').removeClass('disabled');

            $('.homeTab1.tabText').addClass('active');
            $('.homeTab2.tabText').removeClass('active');

          } else {
            $('#'+currentId+'.tabTitle').removeClass('active');
            $('#'+currentId+'.tabTitle').prev().addClass('active');
            $('.'+currentId+'.tabText').removeClass('active');
            $('.'+currentId+'.tabText').prev().addClass('active');

            $('.home-tabs-arrows a.prev').removeClass('disabled');
            $('.home-tabs-arrows a.next').removeClass('disabled');
          }
        }
      }
    });
  }



}); 