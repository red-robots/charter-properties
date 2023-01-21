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

  /* Timeline */
  var swiper = new Swiper("#timeline", {
    effect: 'slide', /* "fade", "slide", "cube", "coverflow" or "flip" */
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

  /* Testimonials */
  var testimonials_swiper = new Swiper(".testimonials-swiper", {
    effect: 'fade', 
    loop: true,
    speed: 4000,
    autoplay: {
      delay: 4000,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper_next",
      prevEl: ".swiper_prev",
    },
  });


  /* Home Carousel */
  communitiesCarousel();
  function communitiesCarousel() {
    var communitiesCount = $('#carousel-communities .item').length;
    if(communitiesCount>3) {
      $('#carousel-communities').owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        responsiveClass:true,
        responsive:{
          0:{
              items:1
          },
          600:{
              items:3
          },
          1000:{
              items:4
          }
        }
      });
    } 
    else {
      $('#carousel-communities').owlCarousel({
        loop:false,
        margin:0,
        nav:false,
        items: 4
      });
    }
  }
  

  /* Communities Carousel */
  $(document).on('click','#customCommunitiesNav a',function(){
    var action = $(this).attr('data-action');
    $('.carousel-communities-wrap ' + action).trigger('click');
  });

  /* Communities Tab */
  $(document).on('click','.bottom-post-terms .termInfo a',function(e){
    e.preventDefault();
    var action = $(this).attr('data-action');
    var termid = $(this).attr('data-termid');
    var termslug = $(this).attr('data-slug');
    var parent = $(this).parent();
    $('.bottom-post-terms .termInfo').not(parent).removeClass('active');
    $(this).parent().addClass('active');
    var type = $(this).text().trim();
    
    // $.ajax({
    //   url:frontajax.jsonUrl+'/top?exclude='+excludeIds
    // }).done(function(response){
    // });
    $.get(siteURL + '/wp-json/wp/v2/query/?termslug='+termslug+'&type='+type,function(data){
      if(data) {
        //var htmlData = $.parseHTML(data);
        $('#communities_data').html(data);
        communitiesCarousel();
      }
    });
  });


  /* TESTIMONIALS CAROUSEL */
  // var testimonials = $('#testimonials-carousel')
  // testimonials.owlCarousel({
  //   loop: true,
  //   items: 1,
  //   autoplay: true,
  //   autoplaySpeed: 4000,
  //   smartSpeed: 4000,
  //   center: true,
  //   nav: true,
  //   dots:false
  // });

  // testimonials.on('changed.owl.carousel', function(event) {
  //   var author = $('.owl-item.active').find('.author').text();
  // });

  // $('.testimonialNav a').on('click',function(e){
  //   e.preventDefault();
  //   var action = $(this).attr('data-action');
  //   $('#testimonials-carousel ' + action).trigger('click');
  // });

  if( $('.bottom-post-terms .termTab').length ) {
    if($('.bottom-post-terms .termTab').length==1) {
      $('.bottom-post-terms').addClass('full');
    }
  }

  /* Banner bottom text */
  adjustBannerText();
  $(window).on('resize orientationchange',function(){
    adjustBannerText();
  });

  function adjustBannerText() {
    if( $('.banner-sm-text').length ) {
      var bannerHeight = $('.banner-sm-text').height() / 2;
      $('.banner-sm-text').css('bottom','-'+bannerHeight+'px');
    }
  }

 
  //$('.partteam').appendTo('.teamfeeds .flexwrap');
  $('.part-team h2').appendTo('#ctaBoxTeam');
  $('.part-team .wp-element-button').appendTo('#ctaBoxTeam');

  /* Tabs */
  $('.tabs .tab a').on('click',function(e){
    e.preventDefault();
    var target = $(this).parent();
    var tab = $(this).attr('data-tab');
    $('.tabs .tab').not(target).removeClass('active');
    target.addClass('active');

    $('.tabtext').not(tab).removeClass('active');
    $('.tabtext'+tab).addClass('active');

    var tabClass = tab.replace('#','.');
    $('.tab-title').not(tabClass+"_title").removeClass('show');
    $('.tab-title'+tabClass+"_title").addClass('show');
  });

  $(document).on('click','.tab-title',function(e){
    var target = $(this).next();
    $('.tab-title').not(this).removeClass('show');
    $(this).addClass('show');
    $('.tabtext').not(target).slideUp();
    target.slideToggle();
    target.toggleClass('active');


    var tab = $(this).attr('data-rel');
    $('.tabs .tab').removeClass('active');
    $('.tabs .tab a[data-tab="'+tab+'"]').parent().addClass('active');
  });

  if( $('.gform_wrapper [name="gform_unique_id"]').length ) {
    $('.gform_wrapper [name="gform_unique_id"]').parent().addClass('hidden-fields');
  }

}); 