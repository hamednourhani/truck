<?php
/*
Author: Eddie Machado
URL: http://themble.com/truck/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD truck CORE (if you remove this, the theme will break)
require_once( 'library/truck.php' );
// require_once( 'library/notifications.php' );

//Include and setup custom metaboxes and fields.
if( !class_exists("CMB2") ){
    require_once( dirname(__FILE__)."/library/cmb/init.php" );
}
require_once( 'library/cmb-functions.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
 //require_once( 'library/admin.php' );

/*********************
LAUNCH truck
Let's get everything up and running.
*********************/

function truck_ahoy() {

  //Allow editor style.
  //add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'truck', get_template_directory() . '/languages' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'truck_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'truck_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'truck_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'truck_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'truck_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'truck_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  truck_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'truck_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'truck_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'truck_excerpt_more' );

} /* end truck ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'truck_ahoy' );

add_action( 'after_setup_theme', 'truck_woocommerce_support' );
function truck_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
/************* OEMBED SIZE OPTIONS *************/

// if ( ! isset( $content_width ) ) {
//  $content_width = 640;
// }

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'banner', 1000, 250, array( 'center', 'center' ) );
add_image_size( 'product-thumb', 35, 35, array( 'center', 'center' ) );
add_image_size( 'post-thumb', 150, 150, array( 'center', 'center' ) );

add_filter( 'image_size_names_choose', 'truck_custom_image_sizes' );

function truck_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'banner' => __('1000px by 250px'),
        'product-thumb' => __('50px by 50px'),
        'post-thumb' => __('150px by 150px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/


function truck_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'truck_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function truck_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar',
    'name' => __( 'Sidebar', 'truck' ),
    'description' => __( 'The first (primary) sidebar.', 'truck' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'id' => 'footer-col1',
    'name' => __( 'Footer first col', 'truck' ),
    'description' => __( 'The first footer widget area', 'truck' ),
    'before_widget' => '<aside id="%1$s" class="footer-first footer-col1 widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'id' => 'footer-col2',
    'name' => __( 'Footer 2d col', 'truck' ),
    'description' => __( 'The first footer widget area', 'truck' ),
    'before_widget' => '<aside id="%1$s" class="footer-first footer-col2 widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'id' => 'footer-col3',
    'name' => __( 'Footer 3rd col', 'truck' ),
    'description' => __( 'The first footer widget area', 'truck' ),
    'before_widget' => '<aside id="%1$s" class="footer-first footer-col3 widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  // register_sidebar(array(
  //   'id' => 'footer-col4',
  //   'name' => __( 'Footer 4th Col', 'truck' ),
  //   'description' => __( 'The first footer widget area', 'truck' ),
  //   'before_widget' => '<aside id="%1$s" class="footer-first widget %2$s">',
  //   'after_widget' => '</aside>',
  //   'before_title' => '<h4 class="widgettitle">',
  //   'after_title' => '</h4>',
  // ));
  

  
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function truck_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'truck' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'truck' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'truck' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'truck' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


function truck_pagination(){
  global $wp_query;

    if($wp_query->max_num_pages > 1){
        $big = 999999999; 
        echo /*__('Page : ','truck').*/paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $wp_query->max_num_pages,
          'prev_text'    => __('<i class="fa fa-angle-double-left"></i>','truck'),
          'next_text'    => __('<i class="fa fa-angle-double-right"></i>','truck')
        ) );
      }
}


function truck_SearchFilter($query) {
    if ($query->is_search) {
      $query->set('post_type', array('post','product'));
    }
    return $query;
    }

add_filter('pre_get_posts','truck_SearchFilter');

// Enable support for HTML5 markup.
  add_theme_support( 'html5', array(
    'comment-list',
    'search-form',
    'comment-form'
  ) );



/*---------------Widgets----------------------*/

function truck_get_image_src($src="" , $size=""){
    $path_info = pathinfo($src);
    return $path_info['dirname'].'/'.$path_info['filename'].'-'.$size.'.'.$path_info['extension'];
}

//-----------Menu Walker------------------------




function truck_search_form( $form ) {
  global $post,$wp_query,$wpdb;
   

  if(ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'it'){
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div><label class="screen-reader-text" for="s">' . __( 'Search for:','truck' ) . '</label>
      <input type="text" value="' . get_search_query() . '" name="s" id="s" />
      <input type="submit" value="' .  __( 'Search' ) . '" name="submit" id="submit" />
      <input type="hidden" name="lang" value="'.ICL_LANGUAGE_CODE.'"/>
      </div>
      </form>';
  } else {
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div><label class="screen-reader-text" for="s">' . __( 'Search for:','truck') . '</label>
      <input type="text" value="' . get_search_query() . '" name="s" id="s" />
      <input type="submit" value="' .  __( 'Search' ) . '" name="submit" id="submit" />
      </div>
      </form>';
  }

  return $form;
}
function truck_menu_search_form() {
  global $post,$wp_query,$wpdb;
   

  if(ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'it'){
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' .  __( 'Search' ) . '"/>
        <span name="submit" id="submit" ><i class="fa fa-search"></i></span>
        <input type="hidden" name="lang" value="'.ICL_LANGUAGE_CODE.'"/>
      </div>
      </form>';
  } else {
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' .  __( 'Search' ) . '"/>
        <span name="submit" id="submit" ><i class="fa fa-search"></i></span>
      </div>
      </form>';
  }

  return $form;
}



function truck_excerpt_length( $length ) {
  return 20;
}
add_filter( 'excerpt_length', 'truck_excerpt_length', 999 );



if ( ICL_LANGUAGE_CODE=='en'){ 
  
        remove_filter('the_title', 'ztjalali_persian_num');
        remove_filter('the_content', 'ztjalali_persian_num');
        remove_filter('the_excerpt', 'ztjalali_persian_num');
        remove_filter('comment_text', 'ztjalali_persian_num');
    // change arabic characters
        remove_filter('the_content', 'ztjalali_ch_arabic_to_persian');
        remove_filter('the_title', 'ztjalali_ch_arabic_to_persian');
        remove_filter('the_excerpt', 'ztjalali_ch_arabic_to_persian');
        remove_filter('comment_text', 'ztjalali_ch_arabic_to_persian');
    


}


/*------------------Widgets------------------------------------*/

class contact_info_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'contact_info_widget', 

        // Widget name will appear in UI
        __('Contact Informaion Widget', 'truck'),

        // Widget description
        array( 'description' => __( 'Display Contact Information', 'truck' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $address = $instance['address'];
        $zip = $instance['zip'];
        $telfax = $instance['telfax'];
        $email = $instance['email'];
        $smspanel = $instance['smspanel'];
        
                
        $content = '<main class="widgetbody">';
        $content .='<p><i class="fa fa-map-marker"></i>'.__('Address : ','truck').$address.'</p>';
        $content .='<p><i class="fa fa-fire"></i>'.__('Zip : ','truck').$zip.'</p>';
        $content .='<p><i class="fa fa-fax"></i>'.__('TelFax : ','truck').$telfax.'</p>';
        $content .='<p><i class="fa fa-tablet"></i></i>'.__('Sms Panel : ','truck').$smspanel.'</p>';
        $content .='<p><i class="fa fa-envelope"></i>'.__('Email : ','truck').$email.'</p>';
        $content .= '</main>';
      
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Last Posts', 'truck' );
        }

        if ( isset( $instance[ 'address' ] ) ) {
            $address = $instance[ 'address' ];
        }else {
            $address = "No. ----";
        }

        if ( isset( $instance[ 'zip' ] ) ) {
            $zip = $instance[ 'zip' ];
        }else {
            $zip = "+98 ----";
        }

        if ( isset( $instance[ 'telfax' ] ) ) {
            $telfax = $instance[ 'telfax' ];
        }else {
            $telfax = "+98 ----";
        }

        if ( isset( $instance[ 'email' ] ) ) {
            $email = $instance[ 'email' ];
        }else {
            $email = "info@email.com";
        }

        if ( isset( $instance['smspanel'] ) ) {
           $smspanel = $instance['smspanel'];
        }else {
            $smspanel = '300000000';
        } $smspanel = $instance['smspanel'];
        
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'zip' ); ?>"><?php _e( 'Zip :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'zip' ); ?>" name="<?php echo $this->get_field_name( 'zip' ); ?>" type="text" value="<?php echo esc_attr( $zip ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'telfax' ); ?>"><?php _e( 'TelFax :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'telfax' ); ?>" name="<?php echo $this->get_field_name( 'telfax' ); ?>" type="text" value="<?php echo esc_attr( $telfax ); ?>" />
        </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'smspanel' ); ?>"><?php _e( 'Sms Panel :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'smspanel' ); ?>" name="<?php echo $this->get_field_name( 'smspanel' ); ?>" type="text" value="<?php echo esc_attr( $smspanel ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email Address :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
        </p>
        
        <?php 
    }
      
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
        $instance['zip'] = ( ! empty( $new_instance['zip'] ) ) ? strip_tags( $new_instance['zip'] ) : '';
        $instance['telfax'] = ( ! empty( $new_instance['telfax'] ) ) ? strip_tags( $new_instance['telfax'] ) : '';
        $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
        $instance['smspanel'] = ( ! empty( $new_instance['smspanel'] ) ) ? strip_tags( $new_instance['smspanel'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here

/* DON'T DELETE THIS CLOSING TAG */ 
/*---------------Widgets----------------------*/

// Creating the widget 
class last_products_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'last_products_widget', 

        // Widget name will appear in UI
        __('Last Products Widget', 'truck'),

        // Widget description
        array( 'description' => __( 'Display Last Products', 'truck' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $number = $instance['number'];
        $term = get_term($instance['cat'],'product_cat');

        //var_dump($instance);
        $products = get_posts(array(
            'post_type' => 'product',
            'posts_per_page' => $number,
            'product_cat'         => $term->slug,
            )
        );
       
        $content = '<ul class="widget-list">';
        foreach($products as $product) : setup_postdata( $product );
          $url = get_the_permalink($product->ID);
          $thumb = get_the_post_thumbnail($product->ID,'product-thumb');
          $name = $product->post_title;
          $content .='<li><a href="'.$url.'">'.$thumb.'<span>'.$name.'</span></a><li>';
        endforeach;
        $content .= '</ul>';

      
       

        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Last Products', 'truck' );
        }
        if ( isset( $instance[ 'number' ] ) ) {
            $number = $instance[ 'number' ];
        }else {
            $number = 5;
        }
        if ( isset( $instance[ 'cat' ] ) ) {
            $cat = $instance[ 'cat' ];
        }else {
            $cat ="";
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'product Numbers :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Product Category :','truck' ); ?></label>
           <?php wp_dropdown_categories(array(
                  'name'               => $this->get_field_name( 'cat' ),
                  'id'                 => $this->get_field_id( 'cat' ),
                  'class'              => 'widefat',
                  'taxonomy'           => 'product_cat',
                  'echo'               => '1',
                  'selected'          =>esc_attr( $cat ),
            )); ?>


        </p>
        
        <?php 
    }
      
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
        $instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
        //var_dump($instance);
        return $instance;
    }
} // Class wpb_widget ends here



class last_posts_by_cat_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'last_posts_by_cat_widget', 

        // Widget name will appear in UI
        __('Last Posts By Category Widget', 'truck'),

        // Widget description
        array( 'description' => __( 'Display Last Posts in Category', 'truck' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $number = $instance['number'];
        $cat = get_category($instance['cat']);

      
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => $number,
            'category'         => $cat->term_id,
            )
        );
        
       
        $content = '<ul class="widget-list">';
        foreach($posts as $post) : setup_postdata( $post );
          $url = get_the_permalink($post->ID);
          $thumb = get_the_post_thumbnail($post->ID,'product-thumb');
          $name = $post->post_title;
          $content .='<li><a href="'.$url.'">'.$thumb.'<span>'.$name.'</span></a><li>';
        endforeach;
        $content .= '</ul>';

      
       

        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Last Posts', 'truck' );
        }
        if ( isset( $instance[ 'number' ] ) ) {
            $number = $instance[ 'number' ];
        }else {
            $number = 5;
        }
        if ( isset( $instance[ 'cat' ] ) ) {
            $cat = $instance[ 'cat' ];
        }else {
            $cat = "";
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Post Numbers :','truck' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Post Category :','truck' ); ?></label>
        <?php wp_dropdown_categories(array(
                  'name'               => $this->get_field_name( 'cat' ),
                  'id'                 => $this->get_field_id( 'cat' ),
                  'class'              => 'widefat',
                  'taxonomy'           => 'category',
                  'echo'               => '1',
                  'selected'           => esc_attr($cat ),
            )); ?>
        </p>
        <?php 
    }
      
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
        $instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here


// Register and load the widget
function truck_widget() {
  register_widget( 'last_products_widget' );
  register_widget( 'last_posts_by_cat_widget' );
  register_widget( 'contact_info_widget' );
}
add_action( 'widgets_init', 'truck_widget' );



/*----------------Pharmacy search -----------------------*/
// class Pharmacy {
//       public $name = "";
//       public $hobbies  = "";
//       public $birthdate = "";
//    }
  
//    $p = new Pharmacy();
//    $p->name = "sachin";
//    $p->hobbies  = "sports";
//    $p->birthdate = date('m/d/Y h:i:s a', "8/5/1974 12:20:03 p");
//    $p->birthdate = date('m/d/Y h:i:s a', strtotime("8/5/1974 12:20:03"));

//   json_encode($p);
//   json_decode ($json [,$assoc = false [, $depth = 512 [, $options = 0 ]]])




// $jsonIterator = new RecursiveIteratorIterator(
//     new RecursiveArrayIterator(json_decode($json, TRUE)),
//     RecursiveIteratorIterator::SELF_FIRST);

// foreach ($jsonIterator as $key => $val) {
//     if(is_array($val)) {
//         echo "$key:\n";
//     } else {
//         echo "$key => $val\n";
//     }
// }


// $fruits = array("a" => "lemon", "b" => "orange", array("a" => "apple", "p" => "pear"));

// $iterator = new RecursiveArrayIterator($fruits);

// while ($iterator->valid()) {

//     if ($iterator->hasChildren()) {
//         // print all children
//         foreach ($iterator->getChildren() as $key => $value) {
//             echo $key . ' : ' . $value . "\n";
//         }
//     } else {
//         echo "No children.\n";
//     }

//     $iterator->next();
// }


// $string = file_get_contents("/home/michael/test.json");
// dirname(__FILE__)
// string dirname ( string $path [, int $levels = 1 ] )
// getcwd();
// chdir( $dir );



// function get_file_dir() {
//     global $argv;
//     $dir = dirname(getcwd() . '/' . $argv[0]);
//     $curDir = getcwd();
//     chdir($dir);
//     $dir = getcwd();
//     chdir($curDir);
//     return $dir;
// }
// So you can use it like this:
// include get_file_dir() . '/otherfile.php';
// // or even..
// chdir(get_file_dir());
// include './otherfile.php';


//------------ product order form ----------------
function html_form_code() {

   $posts = get_posts(array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'suppress_filters' => false,
          )
      );
     
//      $product_select = '<select multiple="multiple" class="select-products" name="cf-products[]" >';
//      foreach($posts as $post) : setup_postdata( $post );
//        $name = $post->post_title;
//        $product_select .='<option value="'.$name.'">'.$name.'</option>';
//      endforeach;
//     $product_select .= '</select>';

    $product_table = '<table class="products_list_table"><tbody>';
    $product_table .= '<tr><th>'.__("Product Name","truck").'</th><th>'.__("Order Quantity","truck").'</th></tr>';
    foreach($posts as $post) : setup_postdata( $post );
        $name = $post->post_title;
        $id = $post->ID;
        $product_table .='<tr><td>'.$name.'</td><td><input type="text" name="product_'.$id.'" value="' . ( isset( $_POST["product_".$id] ) ? esc_attr( $_POST["product_".$id] ) : '' ) . '"/></td></tr>';
      endforeach;
     $product_table .= '</tbody></table>';


  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post" class="order-products">';
  echo '<p>';
  echo __('Your Name (required)','truck'). '<br/>';
  echo '<input type="text" name="cf-name"  value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
  echo __('Your Email (required)','truck'). '<br/>';
  echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
   echo __('Your Phone (required)','truck'). '<br/>';
  echo '<input type="text" name="cf-phone" value="' . ( isset( $_POST["cf-phone"] ) ? esc_attr( $_POST["cf-phone"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '</p>';
   echo __('Your Mobile Number (Optional)','truck'). '<br/>';
  echo '<input type="text" name="cf-mobile-phone" value="' . ( isset( $_POST["cf-mobile-phone"] ) ? esc_attr( $_POST["cf-mobile-phone"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '</p>';
   echo __('Your Fax Number (Optional)','truck'). '<br/>';
  echo '<input type="text" name="cf-fax" value="' . ( isset( $_POST["cf-fax"] ) ? esc_attr( $_POST["cf-fax"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
  echo  '<em>'.__('To Order Products Enter the order quantity for each product.','truck'). '</em><br/>';
  echo  $product_table;
  echo '</p>';
  echo '<p>';
  echo  __('More Information (required)','truck'). '<br/>';
  echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
  echo '</p>';
  echo '<p><input type="submit" name="cf-submitted" value="'.__('Order Products','truck').'"></p>';
  echo '</form>';
}


function set_html_content_type() {
  return 'text/html';
}

function deliver_mail() {

  // if the submit button is clicked, send the email
  if ( isset( $_POST['cf-submitted']) && isset( $_POST["cf-email"] ) && isset( $_POST["cf-name"] ) ) {


    // sanitize form values
    $name    = sanitize_text_field( $_POST["cf-name"] );
    $email   = sanitize_email( $_POST["cf-email"] );
    $phone   = sanitize_text_field( $_POST["cf-phone"] );
     $mobile_phone   = sanitize_text_field( $_POST["cf-mobile-phone"] );
      $fax   = sanitize_text_field( $_POST["cf-fax"] );


    
    $products = get_posts(array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'suppress_filters' => false,
          )
      );

    
    $message = "<div style='direction:rtl;text-align:right;'>";
    $message .= "<p>".__('Name : ','truck').$name."</p>"."\r\n";
    $message .= "<p>".__('Phone Number : ','truck').$phone."</p><br />"."\r\n";
    $message .= "<p>".__('Email : ','truck').$email."</p><br />"."\r\n";
    $message .= "<p>".__('Mobile : ','truck').$mobile_phone."</p><br />"."\r\n";
    $message .= "<p>".__('Fax : ','truck').$fax."</p><br />"."\r\n";
    $message .= "<p>".__('Products List : ','truck')."</p><br />"."\r\n";
    foreach($products as $product){
     $product_id = $product->ID;
      if(isset( $_POST['product_'.$product_id] ) && !empty($_POST['product_'.$product_id])){
       $message .= "<p>".__("Product Name : ","truck").$product->post_title."  ";
       $message .= __(" - Quantity : ","truck").sanitize_text_field( $_POST["product_".$product_id] )."</p><br />";
       }
    }

    $message .= "<p>".esc_textarea( $_POST["cf-message"] )."\r\n"."</p></div>";


    // get the blog administrator's email address
    $to = get_option( 'admin_email' );

    $headers = array('From: '.$name.'<'.$email.'>');
    $subject =  __('Order Products','truck');
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );

    //var_dump("to :".$to);
//    var_dump("headers : ".$headers);
//    var_dump("subject : ".$subject);
//    var_dump("message : ".$message);

    // If email has been process for sending, display a success message
    if ( wp_mail( $to, $subject, $message, $headers ) ) {
      echo '<div>';
      echo '<p class="success-message">'.__('Thanks for Ordering Products, We will contact you as soon as posible.','truck'). '</p>';
      echo '</div>';
    } else {
      echo '<p class="failed-message">'.__('An unexpected error occurred','truck').'</p>';
    }

    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

  }
}

function cf_shortcode() {
  ob_start();
  deliver_mail();
  html_form_code();

  return ob_get_clean();
}

add_shortcode( 'product_order_form', 'cf_shortcode' );


/*------------------- Pharmacy search function.----------------------------------------- */

add_action("wp_ajax_truck_request_pharmacies", "truck_request_pharmacies");
add_action("wp_ajax_nopriv_truck_request_pharmacies", "truck_request_pharmacies_approval");

function truck_request_pharmacies() {

global $wp,$wp_query; 

require("phpsqlsearch_dbinfo.php");
// Get parameters from URL
$center_lat = sanitize_text_field($_SERVER["lat"]);
$center_lng = sanitize_text_field($_SERVER["lng"]);
$radius = sanitize_text_field($_SERVER["radius"]);
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$posts = get_posts(array(
      'post_type' => 'pharmacy',
      'posts_per_page' => -1,
      )
  );
     
  
// Search the rows in the markers table
// $query = sprintf("SELECT address, name, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
//   mysql_real_escape_string($center_lat),
//   mysql_real_escape_string($center_lng),
//   mysql_real_escape_string($center_lat),
//   mysql_real_escape_string($radius));

header("Content-type: text/xml");
// Iterate through the rows, adding XML nodes for each
foreach($posts as $post) { 
  setup_postdata( $post );
  
  $address = get_post_meta($post->ID,'_truck_address',1);
  $lat = get_post_meta($post->ID,'_truck_Latitude',1);
  $lng = get_post_meta($post->ID,'_truck_Longitude',1);
  $distance = (3959 * acos( cos( radians($center_lat) ) * cos( radians( $lat ) ) * cos( radians( $lng ) - radians($center_lng) ) + sin( radians($center_lat) ) * sin( radians( $lat ) ) ) );
  
  if($distance < $radius){
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $post->post_title);
    $newnode->setAttribute("address", $address);
    $newnode->setAttribute("lat", $lat);
    $newnode->setAttribute("lng", $lng);
    $newnode->setAttribute("distance", $distance);
  }

}

   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      echo $dom->saveXML();
      
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
   }

   die();

}

function truck_request_pharmacies_approval() {
   echo "You must log in to view";
   die();
}

class Menu_With_Image extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth = '0', $args = array(), $id = '0') {
    global $wp_query;

    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    global $sub_wrapper_before;
    $sub_wrapper_before = "";
    global $sub_wrapper_after;
    $sub_wrapper_after = '';

    if(in_array('mega-menu',$classes)){
      $sub_wrapper_before = '<div class="sub-menu-wrap">';
      $sub_wrapper_after = '</div>';
    }


    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $output .= "\n$indent\n";

    $menu_thumb = "";
    if($item->object == 'product'){
       $menu_thumb = get_the_post_thumbnail($item->object_id , 'product_cat');
       //var_dump($menu_thumb);
    }
    $products = array();
    $sub_content = "";

    if($item->object == 'product_cat'){
        $term = get_term($item->object_id,'product_cat');

//        var_dump($term);
        $products = get_posts(array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'product_cat'         => $term->slug,
            'suppress_filters' => false,

            )
        );
        $sub_content = '<ul class="sub-menu">'.$sub_wrapper_before;
        foreach($products as $product) : setup_postdata( $product );
          //var_dump($product);
          $url = get_the_permalink($product->ID);
          $thumb = get_the_post_thumbnail($product->ID,'product-thumb');
          $name = $product->post_title;
          $sub_content .='<li id="menu-item-'.$product->ID.'" class="menu-item product-item menu-item-type-post_type menu-item-object-product"><a href="'.$url.'">'.$thumb.$name.'</a></li>';
        endforeach;
        $sub_content .= '</ul>';

    }





    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
    $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
    $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
    $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before .$menu_thumb. '<span>'.apply_filters( 'the_title', $item->title, $item->ID ) .'</span>'. $args->link_after;
    //$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
    $item_output .= '</a>';
     //$item_output .= ;
    //show posts of product cat
     $item_output .= $sub_content;

    $item_output .= $args->after;
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    global $sub_wrapper_before;
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        'sub-menu',
        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
        ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
        'menu-depth-' . $display_depth
        );
    $class_names = implode( ' ', $classes );

    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' .$sub_wrapper_before. "\n";
  }

}

?>