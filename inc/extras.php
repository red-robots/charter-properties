<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
   global $post;
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }
    if(is_page() && $post) {
      $classes[] = $post->post_name;
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

function shortenText2($text, $max = 50, $append = '…') {
  if (strlen($text) <= $max) return $text;
  $return = substr($text, 0, $max);
  if (strpos($text, ' ') === false) return $return . $append;
  return preg_replace('/\w+$/', '', $return) . $append;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function get_social_media() {
    $options = get_field("social_media","option");
    $icons = social_icons();
    $list = array();
    if($options) {
        foreach($options as $i=>$opt) {
            if( isset($opt['social_media_link']) && $opt['social_media_link'] ) {
                $url = $opt['social_media_link'];
                $parts = parse_url($url);
                $host = ( isset($parts['host']) && $parts['host'] ) ? $parts['host'] : '';
                if($host) {
                    foreach($icons as $type=>$icon) {
                        if (strpos($host, $type) !== false) {
                            $list[$i] = array('url'=>$url,'icon'=>$icon,'type'=>$type);
                        }
                    }
                }
            }
        }
    }

    return ($list) ? $list : '';
}

// function get_social_links() {
//     $social_types = social_icons();
//     $social = array();
//     foreach($social_types as $k=>$icon) {
//         if( $value = get_field($k,'option') ) {
//             $social[$k] = array('link'=>$value,'icon'=>$icon);
//         }
//     }
//     return $social;
// }

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fab fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'  => 'fab fa-vimeo',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}

function get_images_dir($fileName=null) {
    return get_bloginfo('template_url') . '/images/' . $fileName;
}

/* Remove richtext editor on specific page */
function remove_pages_editor(){
    global $wpdb;
    $post_id = ( isset($_GET['post']) && $_GET['post'] ) ? $_GET['post'] : '';
    $disable_editor = array();
    if($post_id) {        
        $page_ids_disable = get_field("disable_editor_on_pages","option");
        if( $page_ids_disable && in_array($post_id,$page_ids_disable) ) {
            remove_post_type_support( 'page', 'editor' );
        }
    }
}   
add_action( 'init', 'remove_pages_editor' );


function has_job_list() {
  global $wpdb;
  $result = $wpdb->get_row( "SELECT ID FROM $wpdb->posts WHERE post_type = 'careers' AND post_status='publish' LIMIT 1" );
  return ($result) ? true : false;
}


function page_has_hero() {
  $banner = get_field("banner");
  if( is_tax('divisions') ) {
    $banner = get_field("divisions_main_photo","option");
  }
  if( is_singular('project') ) {
    $parent_id = get_page_id_by_template('page-projects');
    $banner = get_field("banner",$parent_id);
  }
  if( is_front_page() || is_home() ) {
    $banner = true;
  }
  return ($banner) ? true : false;
}

// add_menu_page(
//   'Divisions', // Page Title
//   'Divisions', // Menu Title
//   'manage_options', // Capabiliy
//   './edit-tags.php?taxonomy=divisions&post_type=team', // Menu_slug
//   '', // function
//   'dashicons-location-alt', // icon_url
//   26   // position
// );

/* Add richtext editor to category description */
// remove the html filtering
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );

// $taxonomy_edit_form_fields
add_filter('divisions_edit_form_fields', 'cat_description');
function cat_description($tag)
{
    ?>
        <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
                <td>
                <?php
                  $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
                  wp_editor(wp_kses_post($tag->description , ENT_QUOTES, 'UTF-8'), 'cat_description', $settings);
                ?>
                <br />
                <span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
                </td>
            </tr>
        </table>
    <?php
}

add_action('admin_head', 'remove_default_category_description');
function remove_default_category_description()
{
  global $current_screen;
  $currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  if ( $current_screen->id == 'edit-divisions' )
  {
  ?>
      <script type="text/javascript">
      jQuery(function($) {
          $('textarea#description').closest('tr.form-field').remove();
      });
      </script>
  <?php
  }
  if( isset($_GET['taxonomy']) && $_GET['taxonomy']=='divisions' && (strpos($currentLink, 'edit-tags') !== false) ) { ?>
    <style type="text/css">
      body.taxonomy-divisions .term-description-wrap, 
      body.taxonomy-divisions #acf-term-fields {
        display: none!important;
      }
    </style>
  <?php
  }
}

/* Remove description column in the wp table list */
add_filter('manage_edit-divisions_columns', function ( $columns ) {
  if( isset( $columns['description'] ) )
      unset( $columns['description'] );   
  return $columns;
} );


/* ACF CUSTOM OPTIONS TABS */
if( function_exists('acf_add_options_page') ) {
  acf_add_options_sub_page(array(
    'page_title'  => 'Divisions Options',
    'menu_title'  => 'Divisions Options',
    'parent_slug' => 'edit.php?post_type=team'
  ));
  // acf_add_options_sub_page(array(
  //   'page_title'  => 'Projects Options',
  //   'menu_title'  => 'Options',
  //   'parent_slug' => 'edit.php?post_type=project'
  // ));
}


/* SAVE ACF */
// add_action('acf/save_post', 'my_acf_save_post');
// function my_acf_save_post( $post_id ) {
//   global $wpdb;

//   $prefix = $wpdb->prefix;
//   $table1 = $prefix . 'wpgmza';
//   $table2 = $prefix . 'wpgmza_markers_has_categories';
//   $marker_id = '';
//   $lat_long_strs = '';
//   $lat = '';
//   $long = '';
//   $lastid = '';

//   $latlong = get_field("latlong",$post_id);
//   $lat_long_strs = ($latlong) ? preg_replace("/\s+/", "", $latlong) : '';
//   if( $lat_long_strs ) {
//     $parts = explode(",",$lat_long_strs);
//     $lat = ( isset($parts[0]) ) ? $parts[0] : '';
//     $long = ( isset($parts[1]) ) ? $parts[1] : '';
//     $query = "SELECT id FROM $table1 WHERE lat='".$lat."' AND lng='".$long."'";
//     $result = $wpdb->get_row($query);
//     $marker_id = ($result) ? $result->id : '';
//   }

//   /* If exists update entry */
//   $default_map_id = 1;
//   $terms = get_the_terms($post_id,'location-type');
//   $icon_value = '';
//   $post_title = get_the_title($post_id);

//   if( $marker_id ) {

//     $arg = array(
//       'map_id'    => $default_map_id,
//       'address'   => $lat_long_strs,
//       'icon'      => $icon_value,
//       'lat'       => $lat,
//       'lng'       => $long,
//       'title'     => $post_title,
//       'approved'  => 1,
//       'retina'    => 1
//     );
    

//     //$wpdb->update('table_name', array('id'=>$id, 'title'=>$title, 'message'=>$message), array('id'=>$id));

//   } else {

//     /* If not exists insert entry */
//     $term_count = ($terms) ? count($terms) : 0;
//     if($term_count>1) {
//       $icon['url'] = get_template_directory_uri() . '/images/markers/marker_all.png';
//       $icon['retina'] = false;
//       $icon_value = @json_encode($icon);
//     }
//     else if($term_count==1) {
//       $cat = $terms[0]->slug;
//       if($cat=='facilities') {
//         $icon['url'] = get_template_directory_uri() . '/images/markers/marker_facility.png';
//         $icon['retina'] = false;
//         $icon_value = @json_encode($icon);
//       }
//       else if($cat=='offices') {
//         $icon['url'] = get_template_directory_uri() . '/images/markers/marker_office.png';
//         $icon['retina'] = false;
//         $icon_value = @json_encode($icon);
//       }
//     }

//     $arg = array(
//       'map_id'    => $default_map_id,
//       'address'   => $lat_long_strs,
//       'icon'      => $icon_value,
//       'lat'       => $lat,
//       'lng'       => $long,
//       'title'     => $post_title,
//       'approved'  => 1,
//       'retina'    => 1
//     );

//     $wpdb->insert($table1,$arg);
//     $lastid = $wpdb->insert_id;
//     if($lastid) {

//       if( $terms ) {
//         foreach($terms as $term) {
//           $term_id = $term->name;
//           $map_cat_id = get_map_category_id($term_id);
//           if($map_cat_id) {
//             $map_arg = array(
//               'marker_id'   => $lastid,
//               'category_id' => $map_cat_id
//             );
//             $wpdb->insert($table2,$map_arg);
//           }
//         }
//       }
//     }

//   }
  
// }

// function get_map_marker_data($address) {
//   global $wpdb;
//   $prefix = $wpdb->prefix;
//   $table1 = $prefix . 'wpgmza';
//   if( empty($title) ) return '';
//   $result = $wpdb->get_row( "SELECT id FROM $table1 WHERE address = '".$address."'" );
//   return ($result) ? $result->id : '';
// }

// function get_map_category_id($catName) {
//   global $wpdb;
//   if( empty($catName) ) return '';
//   $prefix = $wpdb->prefix;
//   $table2 = $prefix . 'wpgmza_categories';
//   $result = $wpdb->get_row( "SELECT id FROM $table2 WHERE category_name = '".$catName."'" );
//   return ($result) ? $result->id : '';
// }


function getProtectedValue($obj, $name) {
  $array = (array)$obj;
  $prefix = chr(0).'*'.chr(0);
  return $array[$prefix.$name];
}

add_action('admin_enqueue_scripts', 'bellaworks_admin_style');
function bellaworks_admin_style() {
  wp_enqueue_style('admin-dashicons', get_template_directory_uri().'/css/dashicons.min.css');
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}


add_shortcode( 'home_boxes', 'home_boxes_shortcode_func' );
function home_boxes_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'numcol'=>3
  ), $atts );
  $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  //include( locate_template('parts/team_feeds.php') );
  get_template_part('parts/home_boxes',null,$a);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'approach', 'approach_shortcode_func' );
function approach_shortcode_func( $atts ) {
  $output = '';
  ob_start();
  get_template_part('parts/home_approach');
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'icon_email', 'icon_email_shortcode_func' );
function icon_email_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'value'=>''
  ), $atts );
  $emailadd = ($a['value']) ? $a['value'] : '';
  $output = '';
  if($emailadd) {
    ob_start(); ?>
    <a href="mailto:<?php echo antispambot($emailadd,1) ?>" aria-label="Email Address" class="email-icon"><i class="fa fa-envelope-o"></i></a>
    <?php 
    $output = ob_get_contents();
    ob_end_clean();
  }
  return $output;
}



add_shortcode( 'timeline', 'timeline_shortcode_func' );
function timeline_shortcode_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'value'=>''
  // ), $atts );
  //$emailadd = ($a['value']) ? $a['value'] : '';
  $output = '';
  ob_start(); 
  if( $timeline = get_field('timeline') ) { ?>
  <div class="timelineWrap">
    <div class="timeline-swiper wrapper">
      <div id="timeline" class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ($timeline as $e) { 
            $large = $e['year'];
            $small = $e['text'];
            $photo = $e['image'];
            ?>
            <div class="swiper-slide"><div class="inner"><div class="text"> <div class="wrap"> <?php if ($large) { ?> <div class="large-text"><?php echo $large ?></div> <?php } ?> <?php if ($small) { ?> <div class="small-text"><?php echo $small ?></div> <?php } ?> </div> </div> <?php if ($photo) { ?><figure class="photo"><span style="background-image:url('<?php echo $photo['url'] ?>')"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/helper-portrait.png" alt="" class="helper"><img src="<?php echo $photo['url'] ?>" alt="<?php echo $photo['title'] ?>" class="actual"></span></figure><?php } ?></div></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php if ( count($timeline)>1 ) { ?>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
    <?php } ?>
  </div>
  <?php } ?>
  <?php 
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'our_communities', 'our_communities_shortcode_func' );
function our_communities_shortcode_func( $atts ) {
  global $post;
  $post_id = $post->ID;
  $default_perpage = 10;
  $a = shortcode_atts( array(
    'perpage'=>$default_perpage
  ), $atts );
  $perpage = ($a['perpage']) ? $a['perpage'] : $default_perpage;
  $post_type = 'communities';
  $taxonomy = 'community-status';
  $current_term = (isset($_GET['term']) && $_GET['term']) ? $_GET['term'] : 'current';
  $paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
  $args = array(
    'posts_per_page'    => $perpage,
    'post_type'         => $post_type,
    'paged'             => $paged,
    'post_status'       => 'publish',
    'tax_query' => array(
      array(
        'taxonomy'=> $taxonomy, 
        'field'   => 'slug',
        'terms'   => $current_term
      )
    )
  );
  $entries = new WP_Query($args); 
  $output = '';
  ob_start();
  if ( $entries->have_posts() ) { ?>
  <section id="our-communities" class="communities-feeds">
    <div class="arrowdiv"><a href="#our-communities" class="arrdown" aria-label="Explore Our Communities"></a></div>
    <div class="blocks-wrapper">
      <?php $i=1; while ( $entries->have_posts() ) : $entries->the_post(); 
        $placeholder = THEMEURI . 'images/image-not-available.jpg';
        //$location = get_field('location');
        $main_photo = get_field('main_photo');
        $button = get_field('view_button');
        $link = ( $button && isset($button['url']) && $button['url'] ) ? $button['url'] : '';
        $linkText = ( $button && isset($button['title']) && $button['title'] ) ? $button['title'] : '';
        $linkTarget = ( $button && isset($button['target']) && $button['target'] ) ? $button['target'] : '_self';
        $has_photo = ($main_photo) ? 'has_photo':'no_photo';
        $columnClass = ($main_photo && get_the_content()) ? ' half':' full';
        $loop = ( $i % 2 == 0 ) ? ' even':' odd';
        $term = get_the_terms(get_the_ID(),'community-location');
        $location = '';
        if($term) {
          // $termID = $term[0]->term_id;
          $location = $term[0]->name;
        }
        ?>
        <div class="block <?php echo $has_photo.$columnClass.$loop ?>">
          <div class="inner">
            <figure class="photo">
              <?php if ($main_photo) { ?>
              <span class="image" style="background-image:url('<?php echo $main_photo['url'] ?>')"><img src="<?php echo $placeholder ?>" alt="" aria-hidden="true"></span>
              <?php } else { ?>
                <img src="<?php echo $placeholder ?>" alt="" aria-hidden="true">
              <?php } ?>
              <?php if ( $linkText && $link ) { ?><div class="more-button"><a href="<?php echo $link ?>" target="<?php echo $linkTarget ?>" class="viewbtn"><?php echo $linkText ?></a></div><?php } ?>
            </figure>
            <div class="info">
              <div class="titlewrap">
                <h3 class="name"><?php the_title(); ?></h4>
                <?php if ($location) { ?><div class="location"><?php echo $location ?></div><?php } ?>
              </div>
              <?php if ( get_the_content() ||  $linkText && $link ) { ?>
              <div class="textwrap">
                <?php if ( get_the_content() ) { ?><div class="text"><?php the_content(); ?></div><?php } ?>
              </div>  
              <?php } ?>
            </div>
          </div>
        </div>
      <?php $i++; endwhile;  ?>
    </div>

    <?php 
      $total_pages = $entries->max_num_pages;
      if ($total_pages > 1){ ?>
      <div id="pagination" class="pagination">
        <?php
          $pagination = array(
          'base' => @add_query_arg('pg','%#%'),
          'format' => '?paged=%#%',
          'current' => $paged,
          'total' => $total_pages,
          'prev_text' => __( '&laquo;', 'bellaworks' ),
          'next_text' => __( '&raquo;', 'bellaworks' ),
          'type' => 'plain'
          );
          echo paginate_links($pagination);
        ?>
      </div>
      <?php } ?>
    </div>
  </section>
<?php }
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
}


add_shortcode( 'communities_tabs', 'communities_tabs_shortcode_func' );
function communities_tabs_shortcode_func( $atts ) {
    $post_type = 'communities';
    $taxonomy = 'community-status'; 
    $stats = array('past','future');
    $terms = get_terms([
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
    ]);
    $output = '';
    $current_term = (isset($_GET['tab']) && $_GET['tab']) ? $_GET['tab'] : 'past';
    $communityType = '';
    ob_start();
    if($terms) {  $count = count($terms); ?>
    <div class="bottom-post-terms-wrap wrapper sm">
      <div class="bottom-post-terms count-<?php echo $count?>">
      <?php $i=1; foreach($terms as $term) {
        $termSlug = $term->slug;
        $termName = $term->name;
        $termID = $term->term_id;
        $termLink = get_term_link($term, $taxonomy);
        $is_active = ($i==1) ? ' active':'';
        if($termSlug==$current_term) {
          $communityType = $termName.' Communities';
        }
        if( in_array($termSlug,$stats) ) { ?>
        <div class="termInfo termTab<?php echo $is_active ?>">
          <a href="javascript:void(0)" data-termid="<?php echo $termID ?>" data-slug="<?php echo $termSlug ?>"><?php echo $termName ?> Communities</a>
        </div>
        <?php $i++; }
      } ?>
      </div>
    </div>   
    <?php } ?>

    <?php 
    //CAROUSEL  
    echo '<div class="carousel-communities-wrap"><div id="communities_data" class="wrapper">' . get_communities_data($current_term,$post_type,$taxonomy,$communityType) . '</div><div id="customCommunitiesNav"><a href="javascript:void(0)" data-action=".owl-prev" class="customNav previous"><span></span></a><a href="javascript:void(0)" data-action=".owl-next" class="customNav next"><span></span></a></div></div>';
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function get_communities_data($term_slug,$post_type,$taxonomy,$communityType) {
  $output = '';
  $items = query_communities_terms($term_slug,$post_type,$taxonomy);
  $locationItems = array();
  $totalUnits = 0;
  ob_start();
  if($items) {
    foreach($items as $e) {
      $postid = $e->ID;
      $term = get_the_terms($postid,'community-location');
      if($term) {
        $termID = $term[0]->term_id;
        $termName = $term[0]->name;
        $termSlug = $term[0]->slug;
        $locationItems[$termID] = $termName;
      }
      $units = get_field('total_units',$postid);
      $unitNum = ($units) ? $units : 0;
      $totalUnits += $unitNum;
    }
  }
  $countStats = ($items) ? count($items) : '0';
  //$locationCount = ($locationItems) ? count($locationItems) : '0';
  $locationCount = ($items) ? count($items) : '0';
  $countUnits = ($totalUnits>0) ? number_format($totalUnits) : '0';
  if($items) { ?>
    <div class="communities-tab-info"> <span class="first"><?php echo $communityType; ?>: <strong><?php echo $countStats; ?></strong></span><span>Locations: <strong><?php echo $locationCount; ?></strong></span><span>Total Units: <strong><?php echo $countUnits; ?></strong></span> </div> <div id="carousel-communities" class="owl-carousel owl-theme"> <?php foreach ($items as $e) { $postid = $e->ID; $title = $e->post_title; $units = get_field('total_units',$postid); $term = get_the_terms($postid,'community-location'); $termName = ''; if($term) { $termID = $term[0]->term_id; $termName = $term[0]->name; $termSlug = $term[0]->slug; $locationItems[$termID] = $termName; } $unit_terms = ($units && $units>1) ? $units.' units' : $units.' unit'; ?> <div class="item term-<?php echo $term_slug ?>"> <div class="inside"> <h4><?php echo $title; ?></h4> <?php if ($termName) { ?> <div class="location"><?php echo $termName ?></div> <?php } ?> <?php if ($units) { ?> <div class="units"><?php echo $unit_terms ?></div> <?php } ?> </div> </div> <?php } ?> </div>
  <?php }
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
}


function query_communities_terms($termSlug,$post_type,$taxonomy) {
  global $wpdb;
  $query = "SELECT p.ID, p.post_title, term.term_id, term.name AS term_name 
            FROM ".$wpdb->prefix."posts p," .$wpdb->prefix."term_taxonomy tax,".$wpdb->prefix."terms term,".$wpdb->prefix."term_relationships rel 
            WHERE tax.taxonomy='".$taxonomy."' 
            AND tax.term_id=term.term_id
            AND term.term_id=rel.term_taxonomy_id
            AND term.slug='".$termSlug."'
            AND p.ID=rel.object_id
            AND p.post_status='publish' AND p.post_type='".$post_type."'";

  $result = $wpdb->get_results($query);
  return ($result) ? $result : '';
}


// function query_communities_locations($object_id) {
//   global $wpdb;
//   $query = "SELECT p.ID, p.post_title, term.term_id, term.name AS term_name 
//             FROM ".$wpdb->prefix."post p,".$wpdb->prefix."term_relationships rel,".$wpdb->prefix."terms term
//             WHERE p.ID=rel.object_id AND term.term_id=rel.term_taxonomy_id";
// }


function myfunc_register_rest_fields(){
  register_rest_route( 'wp/v2', '/query/', array(
    'methods' => 'GET',
    'callback' => 'get_communities_listing'
  ));
}
add_action('rest_api_init','myfunc_register_rest_fields');

function get_communities_listing(WP_REST_Request $request) {
  global $wpdb;
  $termSlug = $request->get_param( 'termslug' );
  $communityType = $request->get_param( 'type' );
  $post_type = 'communities';
  $taxonomy = 'community-status'; 
  $output = '';
  ob_start();
  echo get_communities_data($termSlug,$post_type,$taxonomy,$communityType);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'testimonial_feeds', 'testimonial_feeds_shortcode_func' );
function testimonial_feeds_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'type'=>null
  ), $atts );
  
  $output = '';
  ob_start();
  //get_template_part('parts/testimonial_feeds',true,$a);
  include( locate_template('parts/testimonial_feeds.php') );
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'team_feeds', 'team_feeds_shortcode_func' );
function team_feeds_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'numcol'=>3
  ), $atts );
  $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  get_template_part('parts/team_feeds',null,$a);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

