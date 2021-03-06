<?php

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

if( ! function_exists('add_classes_on_li') ):
  function add_classes_on_li($classes, $item, $args) {
    // write_log($classes);
    if($args->menu_id == 'header-menu'):
      $class_str = 'nav-item navigation__item navigation__item__header navbar_navigation__item__header';
      $class_str .= ($item->post_title == 'search') ? ' link_search-form_opener' : '';
      $class_str .= in_array('current-menu-item', $item->classes, true) ? ' current-menu-item' : '';
      $classes = array($class_str);
    endif;
    if($args->menu_id == 'footer-menu-one' || $args->menu_id == 'footer-menu-two'):
      $classes = array('nav-item navigation__item navigation__item__footer');
    endif;
    return $classes;
  }
endif;
add_filter('nav_menu_css_class','add_classes_on_li',1,3);

if( ! function_exists('add_menuclass') ):
  function add_menuclass($ulclass) {
     return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
  }
endif;
add_filter('wp_nav_menu','add_menuclass');

function get_post_icon_class($post = null) {
  if ( empty( $post )  ) {
    global $post;
  } else {
    $post = get_post($post);
  }

  $icon_class;
  if($post->post_type == 'artist' || $post->post_type == 'city') {
    $icon_class = 'icon icon-travel-white';
  } else {
    $post_categories = wp_get_post_categories( $post->ID );
    if( !empty ( $post_categories ) ) {
      $category = get_category($post_categories[0]);
      $icon_class = 'icon icon-'.$category->slug.'-white';
    } else {
      $icon_class = 'icon icon-travel-white';
    }
  }
  return $icon_class;
}

function get_category_type_title($post = null) {
  if ( empty( $post )  ) {
    global $post;
  } else {
    $post = get_post($post);
  }

  $category_type;
  if( $post->post_type == 'city' ) {
    $category_type = 'travel guide';
  } elseif ( $post->post_type == 'artist' ) {
    $category_type = 'artist guide';
  } elseif ($post->post_type == 'location') {
    $location_terms = get_the_terms( $post, 'location_types' );
    $category_type = (!empty($location_terms)) ? $location_terms[0]->name : '';
  } else {
    $post_categories = wp_get_post_categories( $post->ID );
    $category = get_category($post_categories[0]);
    if($category->slug == 'uncategorized') {
      $category_type = 'editorial';
    } else {
      $category_type = $category->slug;
    }
  }
  return $category_type;
}

function get_category_type_subject($post = null) {
  if ( empty( $post )  ) {
    global $post;
  } else {
    $post = get_post($post);
  }

  $subject = '';
  if($post->post_type == 'city') {
    $subject = $post->post_title;
  }
  elseif ($post->post_type == 'artist') {
    $artist_city = get_field('artist_city', $post->ID)[0];
    $subject = $artist_city->post_title;
  }
  else {
    $primary_term = get_field('primary_tag', $post->ID);
    if( $primary_term ) {
      $subject = $primary_term->name;
    } else {
      $tag_terms = wp_get_post_terms($post->ID);
      if(!empty($tag_terms)) {
        $first_term = $tag_terms[0];
        $subject = $first_term->name;
      }
    }
  }
  return $subject;
}

function get_card_title($post = null) {
  if ( empty( $post )  ) {
    global $post;
  } else {
    $post = get_post($post);
  }

  $title = '';
  if( $post->post_type == 'post' ) {
    $title = $post->post_title;
  } else {
    $title = get_field( 'excerpt_title', $post->ID );
  }

  if ( empty ( $title ) ) {
    $title = get_the_title( $post );
  }
  return $title;
}

function get_card_excerpt($post = null, $length = '60') {
  if ( empty( $post )  ) {
    global $post;
  } else {
    $post = get_post($post);
  }

  $excerpt = get_the_excerpt();
  //for some reason &hellip; keeps showing up on empty excerpts, get the post content
  if ($excerpt === '&hellip;') {
    $excerpt = wp_strip_all_tags( $post->post_content );
    write_log($excerpt);
  }

  $line=$excerpt;
  if ( preg_match( '/^.{1,'.$length.'}\b/s', $excerpt, $match ) ) {
      $line=trim( $match[0] );
      $line .= ( strlen( $excerpt ) > $length ) ? '...' : '';
  }
  return strip_tags( $line );
}

function get_social_links($post = null) {
  if( empty( $post ) ) {
    global $post;
  } else {
    $post = get_post($post);
  }

  $shares = [];
  //facebook share url
  $shares['facebook'] = get_the_permalink();
  $shares['twitter'] = 'https://twitter.com/intent/tweet?text='.urlencode(get_the_title()).'&url='.urlencode(get_the_permalink());
  $shares['tumblr'] = 'http://www.tumblr.com/widgets/share/tool?canonicalUrl='.urlencode(get_the_permalink());

  return $shares;
}

function add_billboard_class() {
  $billboard_class = 'billboard';
  if(get_field('show_alternate_editorial_layout')) {
    $billboard_class = 'billboard-two';
  }
 echo $billboard_class;
}

function wpb_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

/*
* Callback function to filter the MCE settings
*/

function cc_mce_before_init_insert_formats( $init_array ) {

// Define the style_formats array

	$style_formats = array(
/*
* Each array child is a format with it's own settings
* Notice that each array has title, block, classes, and wrapper arguments
* Title is the label which will be visible in Formats menu
* Block defines whether it is a span, div, selector, or inline style
* Classes allows you to define CSS classes
* Wrapper whether or not to add a new block-level element around any selected elements
*/
		array(
			'title' => 'Call Out Block',
			'block' => 'div',
			'classes' => 'about_call_out',
			'wrapper' => true,
		),
    array(
			'title' => 'Outline Button',
			'block' => 'div',
			'classes' => 'button button--outline',
			'wrapper' => true,
		),
    array(
			'title' => 'Small Outline Button',
			'block' => 'div',
			'classes' => 'button button--outline button--small',
			'wrapper' => true,
		),
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'cc_mce_before_init_insert_formats' );

add_action( 'pre_get_posts', 'cc_category_archives' );
function cc_category_archives( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_tax( 'location_types') )  {
    $query->set( 'posts_per_page', -1 );
    $query->set( 'nopaging', true );
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'location_city');
    $query->set( 'order', 'asc' );
    $cat_city = get_query_var('cat_city');
    if($cat_city) {
      $meta_query = array(
        array(
          'key' => 'location_city',
          'value' => '"'.$cat_city.'"',
          'compare' => 'LIKE'
        )
      );
      $query->set('meta_query', $meta_query);
    }
  } elseif( !is_admin() && $query->is_main_query() && is_post_type_archive( ['city', 'artist'] ) ) {
    $query->set( 'posts_per_page', 12 );
    $query->set( 'orderby', 'title' );
    $query->set( 'order', 'asc' );
  } elseif( !is_admin() && $query->is_main_query() && $query->is_home() ) {
    $idObj = get_category_by_slug('reserved');
    $id = $idObj->term_id;
    $query->set('category__not_in', [$id]);
  } elseif( !is_admin() && is_search() ) {
    $idObj = get_category_by_slug('reserved');
    $id = $idObj->term_id;
    $query->set('category__not_in', [$id]);
  }

  if ( !is_admin() && $query->is_main_query() && is_post_type_archive() ) {
  }
}

function cc_archive_title() {
  $title = '';
    if ( is_category() ) {
      $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
      $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
      $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
      $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
      $title = single_term_title( '', false );
    } elseif ( is_page( ['terms-conditions','privacy-policy'] ) ) {
      $title = get_the_title();
    } elseif ( is_search() ) {
      $title = 'Search';
    }

    return $title;
}

function cc_gallery_shortcode( $output = '', $atts, $instance ) {
	$return = $output; // fallback

	// retrieve content of your own gallery function
  $gallery_id = 'gallery-'.$instance;
  $return = '<div id="'.$gallery_id.'" class="gallery cc-gallery">';
  $posts = get_posts(array('include' => $atts['ids'],'post_type' => 'attachment'));
  foreach($posts as $galleryPost) {
    $caption = wp_strip_all_tags( $galleryPost->post_excerpt );
    $return .= '<div class="cc-gallery-item">';
    $return .= '<a href="'.wp_get_attachment_image_src($galleryPost->ID, 'full')[0].'" data-fancybox="'.$gallery_id.'" data-caption="'.$caption.'">';
    $return .= '<img src="'.wp_get_attachment_image_src($galleryPost->ID, 'thumbnail')[0].'" class="img-fluid" data-media="(min-width: 400px)" alt="'.$caption.'" />';
    $return .= '</a></div>';
  }
  $return .= '</div>';
	return $return;
}

add_filter( 'post_gallery', 'cc_gallery_shortcode', 10, 3 );

function debug_var($var) {
  $var_dump = '';
   if(isset($var)) {
      $var_dump .= "<pre>";
      $var_dump .= var_dump($var);
      $var_dump .= "</pre>";
   } else {
      $var_dump .= "Variable doesn't exist!";
   }
   return $var_dump;
}
// (.?.+?)(?:/([0-9]+))?/?$	pagename=$matches[1]&page=$matches[2]

function cc_background_image_filter() {
  return 'linear-gradient(-180deg, rgb(0,0,0) 0%, rgba(0,0,0,0.00) 40%), linear-gradient(rgba(109,114,163,0.80) 0%, rgba(109,114,163,0.80) 100%),linear-gradient(rgba(55,23,34,0.10) 0%, rgba(55,23,34,0.10) 100%)';
}

function cc_travel_background_image_filter() {
  return 'linear-gradient(-180deg, rgb(0,0,0) 0%, rgba(0,0,0,0.00) 30%),linear-gradient(rgba(109,114,163,0.80) 0%, rgba(109,114,163,0.80) 100%), linear-gradient(rgba(55,23,34,0.10) 0%, rgba(55,23,34,0.10) 100%)';
}

function add_query_vars_filter( $vars ){
  $vars[] = "cat_city";
  $vars[] = "cat_artist";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

//removing the 'read more' link from event posts
function cc_modify_event_read_more_link() {
  global $post;
  if($post->post_type == 'event') {
    return '...';
  }
}
add_filter( 'excerpt_more', 'cc_modify_event_read_more_link' );

function cc_modify_event_excerpt_length() {
  global $post;
  if($post->post_type == 'event') {
    return 20;
  }
}
add_filter( 'excerpt_length', 'cc_modify_event_excerpt_length' );

function cc_wrap_img_media( $content ) {
  $caption_pattern = '/<figure [^>]+><img [^>]*><figcaption [^>]+>.*<\/figcaption><\/figure>/i';

  // A regular expression of what to look for.
  $pattern = '/(<img([^>]*)>)/i';
  // possible pattern for wrapping iframes for youtubes etc.
  // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
  $replacement = '<div class="cc-img-media-wrapper">$1</div>';

  // run preg_replace() on the $content
  $content = preg_replace( $pattern, $replacement, $content );

  // return the processed content
  return $content;
}

add_filter( 'the_content', 'cc_wrap_img_media', 20, 1 );

function cc_wrap_iframe( $content ) {
  //
  $pattern = '/(<iframe[^>]+>.*?<\/iframe>)/i';
  $replacement = '<div class="cc-iframe-wrapper">$1</div>';
  $content = preg_replace( $pattern, $replacement, $content );
  return $content;
}

add_filter( 'the_content', 'cc_wrap_iframe', 20, 1 );

add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

function cleaner_caption( $output, $attr, $content ) {
	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption <div>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figurecaption class="wp-caption-text">' . $attr['caption'] . '</figurecaption>';

	/* Close the caption </div>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;
}

//* Remove Query String from Static Resources
function remove_css_js_ver( $src ) {
  if( strpos( $src, '?ver=' ) )
  $src = remove_query_arg( 'ver', $src );
  return $src;
  }
  add_filter( 'style_loader_src', 'remove_css_js_ver', 10, 2 );
  add_filter( 'script_loader_src', 'remove_css_js_ver', 10, 2 );
