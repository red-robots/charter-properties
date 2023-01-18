<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	wp_enqueue_style( 'bellaworks-style', get_stylesheet_uri() );
  wp_enqueue_style( 'swiper-style', 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css' );

	wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, '3.5.1', false);
		wp_enqueue_script('jquery');

	 wp_enqueue_script( 
			'jquery-migrate','https://code.jquery.com/jquery-migrate-1.4.1.min.js', 
			array(), '20200713', 
			false 
		);

	wp_enqueue_script( 
			'vimeo-player', 
			'https://player.vimeo.com/api/player.js', 
			array(), '2.12.2', 
			true 
		);

 //  wp_enqueue_script( 
 //      'bellaworks-fancybox', 
 //      get_template_directory_uri() . '/assets/js/vendor/fancybox.js', 
 //      array(), '20200101', 
 //      true 
 //    );
  
	// wp_enqueue_script( 
	// 		'bellaworks-carousel', 
	// 		get_template_directory_uri() . '/assets/js/vendor/owl.carousel.min.js', 
	// 		array(), '20200101', 
	// 		true 
	// 	);

 //  wp_enqueue_script( 
 //      'bellaworks-swiper', 
 //      get_template_directory_uri() . '/assets/js/vendor/swiper.js', 
 //      array(), '20200101', 
 //      true 
 //    );

	// wp_enqueue_script( 
	// 		'bellaworks-boostrap', 
 //      get_template_directory_uri() . '/assets/js/vendor/bootstrap.bundle.min.js', 
 //      array(), '20200101', 
 //      true 
	// 	);

  // wp_enqueue_script( 
  //     'bellaworks-blocks', 
  //     get_template_directory_uri() . '/assets/js/vendor.min.js', 
  //     array(), '20220202', 
  //     true 
  //   );

  wp_enqueue_script( 
      'bellaworks-cplugin', 
      get_template_directory_uri() . '/assets/js/plugins.min.js', 
      array(), '20220202', 
      true 
    );

  
  wp_enqueue_script( 
      'hero-sliders', 
      'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js', 
      array(), '20221101', 
      true 
    );

	wp_enqueue_script( 
			'bellaworks-custom', 
			get_template_directory_uri() . '/assets/js/custom/custom.js', 
			array(), '20200713', 
			true 
		);

	wp_localize_script( 'bellaworks-custom', 'frontajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	
	wp_enqueue_script( 
		'font-awesome', 
		'https://use.fontawesome.com/8f931eabc1.js', 
		array(), '20180424', 
		true 
	);



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );




