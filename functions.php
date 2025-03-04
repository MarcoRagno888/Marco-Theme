<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'style_css', get_stylesheet_directory_uri() . '/style.css' );
    }

//----------------------------------------------------------------

add_action( 'widgets_init', 'add_widget_support' );
function add_widget_support() {
    register_sidebar( array(
                    'name'          => 'Sidebar',
                    'id'            => 'sidebar',
                    'before_widget' => '<div>',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h2>',
                    'after_title'   => '</h2>',
    ) );
}

//----------------------------------------------------------------

add_action( 'init', 'add_Main_Nav' );
function add_Main_Nav() {
    register_nav_menu('marco-theme', 'Menu' );
  }

//----------------------------------------------------------------

add_action( 'after_setup_theme', 'theme_setup');
function theme_setup() {

    add_theme_support( 'title-tag' );  

}

//----------------------------------------------------------------

add_action( 'after_setup_theme', 'my_theme_setup' );
function my_theme_setup(){
	load_theme_textdomain( 'marco-theme', get_template_directory() . '/languages' );
}

//----------------------------------------------------------------

add_action('after_setup_theme', 'add_theme_support');
if(!function_exists('add_theme_support')) {
    function add_theme_support( $feature, ...$args ) {
        global $_wp_theme_features;

        if ( ! $args ) {
            $args = true;
        }

        switch ( $feature ) {
            case 'post-thumbnails':
                // All post types are already supported.
                if ( true === get_theme_support( 'post-thumbnails' ) ) {
                    return;
                }

                /*
                * Merge post types with any that already declared their support
                * for post thumbnails.
                */
                if ( isset( $args[0] ) && is_array( $args[0] ) && isset( $_wp_theme_features['post-thumbnails'] ) ) {
                    $args[0] = array_unique( array_merge( $_wp_theme_features['post-thumbnails'][0], $args[0] ) );
                }

                break;

            case 'post-formats':
                if ( isset( $args[0] ) && is_array( $args[0] ) ) {
                    $post_formats = get_post_format_slugs();
                    unset( $post_formats['standard'] );

                    $args[0] = array_intersect( $args[0], array_keys( $post_formats ) );
                } else {
                    _doing_it_wrong(
                        "add_theme_support( 'post-formats' )",
                        ( 'You need to pass an array of post formats.' ),
                        '5.6.0'
                    );
                    return false;
                }
                break;

            case 'html5':
                // You can't just pass 'html5', you need to pass an array of types.
                if ( empty( $args[0] ) || ! is_array( $args[0] ) ) {
                    _doing_it_wrong(
                        "add_theme_support( 'html5' )",
                        ( 'You need to pass an array of types.' ),
                        '3.6.1'
                    );

                    if ( ! empty( $args[0] ) && ! is_array( $args[0] ) ) {
                        return false;
                    }

                    // Build an array of types for back-compat.
                    $args = array( 0 => array( 'comment-list', 'comment-form', 'search-form' ) );
                }

                // Calling 'html5' again merges, rather than overwrites.
                if ( isset( $_wp_theme_features['html5'] ) ) {
                    $args[0] = array_merge( $_wp_theme_features['html5'][0], $args[0] );
                }
                break;

            case 'custom-logo':
                if ( true === $args ) {
                    $args = array( 0 => array() );
                }
                $defaults = array(
                    'width'                => null,
                    'height'               => null,
                    'flex-width'           => false,
                    'flex-height'          => false,
                    'header-text'          => '',
                    'unlink-homepage-logo' => false,
                );
                $args[0]  = wp_parse_args( array_intersect_key( $args[0], $defaults ), $defaults );

                // Allow full flexibility if no size is specified.
                if ( is_null( $args[0]['width'] ) && is_null( $args[0]['height'] ) ) {
                    $args[0]['flex-width']  = true;
                    $args[0]['flex-height'] = true;
                }
                break;

            case 'custom-header-uploads':
                return add_theme_support( 'custom-header', array( 'uploads' => true ) );

            case 'custom-header':
                if ( true === $args ) {
                    $args = array( 0 => array() );
                }

                $defaults = array(
                    'default-image'          => '',
                    'random-default'         => false,
                    'width'                  => 0,
                    'height'                 => 0,
                    'flex-height'            => false,
                    'flex-width'             => false,
                    'default-text-color'     => '',
                    'header-text'            => true,
                    'uploads'                => true,
                    'wp-head-callback'       => '',
                    'admin-head-callback'    => '',
                    'admin-preview-callback' => '',
                    'video'                  => false,
                    'video-active-callback'  => 'is_front_page',
                );

                $jit = isset( $args[0]['__jit'] );
                unset( $args[0]['__jit'] );

                /*
                * Merge in data from previous add_theme_support() calls.
                * The first value registered wins. (A child theme is set up first.)
                */
                if ( isset( $_wp_theme_features['custom-header'] ) ) {
                    $args[0] = wp_parse_args( $_wp_theme_features['custom-header'][0], $args[0] );
                }

                /*
                * Load in the defaults at the end, as we need to insure first one wins.
                * This will cause all constants to be defined, as each arg will then be set to the default.
                */
                if ( $jit ) {
                    $args[0] = wp_parse_args( $args[0], $defaults );
                }

                /*
                * If a constant was defined, use that value. Otherwise, define the constant to ensure
                * the constant is always accurate (and is not defined later,  overriding our value).
                * As stated above, the first value wins.
                * Once we get to wp_loaded (just-in-time), define any constants we haven't already.
                * Constants should be avoided. Don't reference them. This is just for backward compatibility.
                */

                if ( defined( add_theme_support( 'custom-header' )  ) ) {
                    $args[0]['header-text'] = ! add_theme_support( 'custom-header' );
                } elseif ( isset( $args[0]['header-text'] ) ) {
                    define( add_theme_support( 'custom-header' ) , empty( $args[0]['header-text'] ) );
                }

                if ( defined( add_theme_support( 'custom-header' )  ) ) {
                    $args[0]['width'] = (int) add_theme_support( 'custom-header' );
                } elseif ( isset( $args[0]['width'] ) ) {
                    define( add_theme_support( 'custom-header' ) , (int) $args[0]['width'] );
                }

                if ( defined( add_theme_support( 'custom-header' ) ) ) {
                    $args[0]['height'] = (int) add_theme_support( 'custom-header' );
                } elseif ( isset( $args[0]['height'] ) ) {
                    define( add_theme_support( 'custom-header' ), (int) $args[0]['height'] );
                }

                if ( defined( add_theme_support( 'custom-header' )  ) ) {
                    $args[0]['default-text-color'] = add_theme_support( 'custom-header' );
                } elseif ( isset( $args[0]['default-text-color'] ) ) {
                    define( add_theme_support( 'custom-header' ) , $args[0]['default-text-color'] );
                }

                if ( defined( add_theme_support( 'custom-header' ) ) ) {
                    $args[0]['default-image'] = add_theme_support( 'custom-header' );
                } elseif ( isset( $args[0]['default-image'] ) ) {
                    define( add_theme_support( 'custom-header' ), $args[0]['default-image'] );
                }

                if ( $jit && ! empty( $args[0]['default-image'] ) ) {
                    $args[0]['random-default'] = false;
                }

                /*
                * If headers are supported, and we still don't have a defined width or height,
                * we have implicit flex sizes.
                */
                if ( $jit ) {
                    if ( empty( $args[0]['width'] ) && empty( $args[0]['flex-width'] ) ) {
                        $args[0]['flex-width'] = true;
                    }
                    if ( empty( $args[0]['height'] ) && empty( $args[0]['flex-height'] ) ) {
                        $args[0]['flex-height'] = true;
                    }
                }

                break;

            case 'custom-background':
                if ( true === $args ) {
                    $args = array( 0 => array() );
                }

                $defaults = array(
                    'default-image'          => '',
                    'default-preset'         => 'default',
                    'default-position-x'     => 'left',
                    'default-position-y'     => 'top',
                    'default-size'           => 'auto',
                    'default-repeat'         => 'repeat',
                    'default-attachment'     => 'scroll',
                    'default-color'          => '',
                    'wp-head-callback'       => '_custom_background_cb',
                    'admin-head-callback'    => '',
                    'admin-preview-callback' => '',
                );

                $jit = isset( $args[0]['__jit'] );
                unset( $args[0]['__jit'] );

                // Merge in data from previous add_theme_support() calls. The first value registered wins.
                if ( isset( $_wp_theme_features['custom-background'] ) ) {
                    $args[0] = wp_parse_args( $_wp_theme_features['custom-background'][0], $args[0] );
                }

                if ( $jit ) {
                    $args[0] = wp_parse_args( $args[0], $defaults );
                }

                if ( defined( add_theme_support( 'custom-background' ) ) ) {
                    $args[0][add_theme_support( 'custom-background' )] = add_theme_support( 'custom-background' );
                } elseif ( isset( $args[0]['default-color'] ) || $jit ) {
                    define( add_theme_support( 'custom-background' ), $args[0]['default-color'] );
                }

                if ( defined( add_theme_support( 'custom-background' )  ) ) {
                    $args[0]['default-image'] = add_theme_support( 'custom-background' );
                } elseif ( isset( $args[0]['default-image'] ) || $jit ) {
                    define( add_theme_support( 'custom-background' ), $args[0]['default-image'] );
                }

                break;

            // Ensure that 'title-tag' is accessible in the admin.
            case 'title-tag':
                // Can be called in functions.php but must happen before wp_loaded, i.e. not in header.php.
                if ( did_action( 'wp_loaded' ) ) {
                    _doing_it_wrong(
                        "add_theme_support( 'title-tag' )",
                        sprintf(
                            /* translators: 1: title-tag, 2: wp_loaded */
                            ( 'Theme support for %1$s should be registered before the %2$s hook.' ),
                            '<code>title-tag</code>',
                            '<code>wp_loaded</code>'
                        ),
                        '4.1.0'
                    );

                    return false;
                }
            case 'align-wide':
                add_theme_support( "custom-logo", $args );

        }

        $_wp_theme_features[ $feature ] = $args;
    }
}

//----------------------------------------------------------------

add_action( 'after_setup_theme', 'wpturbo_setup_theme' );
function wpturbo_setup_theme() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( "wp-block-styles" );
    add_theme_support( "responsive-embeds" );
    add_theme_support( "align-wide" );
}

//----------------------------------------------------------------

add_action( 'init', 'prefix_register_block_styles' );
function prefix_register_block_styles() {
	register_block_style(
		array( 'core/paragraph', 'core/heading' ),
		array(
			'name'         => 'prefix-rounded-corners',
			'label'        => __( 'Rounded corners', 'marco-theme' ),
			'style_handle' => 'prefix-rounded-corners',
		)
	);
}

//----------------------------------------------------------------

add_action(  'wp_enqueue_scripts', 'wpse218049_enqueue_comments_reply' );
function prefix_block_pattern() {
    register_block_pattern( ... );
  }

//----------------------------------------------------------------

add_action( 'init', 'prefix_block_pattern' );
function wpse218049_enqueue_comments_reply() {
    if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
        // Load comment-reply.js (into footer)
        wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );
    }
}

//----------------------------------------------------------------

add_action('after_setup_theme', 'lr_theme_features');
function lr_theme_features() {

    // Add support for block styles.
    add_theme_support( 'wp-block-styles' );
 
    // Enqueue editor styles.
    add_editor_style( 'style.css' );
 
}

?>