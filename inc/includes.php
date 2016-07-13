<?php

/**
 * This is free and unencumbered software released into the public domain.

 * Anyone is free to copy, modify, publish, use, compile, sell, or
 * distribute this software, either in source code form or as a compiled
 * binary, for any purpose, commercial or non-commercial, and by any
 * means.
*/

/**
 * In jurisdictions that recognize copyright laws, the author or authors
 * of this software dedicate any and all copyright interest in the
 * software to the public domain. We make this dedication for the benefit
 * of the public at large and to the detriment of our heirs and
 * successors. We intend this dedication to be an overt act of
 * relinquishment in perpetuity of all present and future rights to this
 * software under copyright law.
*/

/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
*/

/**
 * For more information, please refer to <http://unlicense.org>
*/
/* well add this back when I can figure out the invalid arguement issue 
function url_to_slide() {
    p2p_register_connection_type( array(
        'name' => 'slider_url',
        'from' => 'hps_images',
        'to' => 'post',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'title' => 'Connect Post for this slide to pull content from.(left caption box, 1 max)'
    ) );
}
add_action( 'p2p_init', 'url_to_slide' );
*/
function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'connected_slider_posts',
        'from' => 'hps_images',
        'to' => 'post',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'title' => 'Add Connecting posts to slider here (right caption box, 3 max)'
    ) );
}
add_action( 'p2p_init', 'my_connection_types' );
function post_relationship_script( $hook ) {  
  
    global $post;  


    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {  
        if ( 'hps_images' === $post->post_type ) {       
           // un silence this if using in main plugin directory wp_enqueue_script( 'post-relationship', plugin_dir_path . '/assets/js/post-relationship.js' ); 
            wp_enqueue_script( 'post-relationship', get_template_directory_uri() . '/plugin/home-slider/assets/js/post-relationship.js' ); //for roots theme//
        }  
    }  
}  
add_action( 'admin_enqueue_scripts', 'post_relationship_script', 10, 1 );  



add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'hps_images' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( '/slider.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/slider.php';
            }
        }
    }
    return $template_path;
}
require_once dirname( __FILE__ ) .'/slider-function.php'; //for widgets and shortcode
require_once dirname( __FILE__ ) .'/widget.php'; //for widgets and shortcode
 // un silence this if you're using a theme that doesn't use bootstrap(http://getbootstrap.com/ ftw!) 
//function slider_scripts() {
//    wp_register_style( 'bootstrap', plugin_dir_path . '/assets/css/bootstrap.min.css' );
//    wp_register_style( 'bootstrap-theme', plugin_dir_path . '/assets/css/bootstrap-theme.min.css' );
      
//    wp_enqueue_style('bootstrap');
//    wp_enqueue_style('bootstrap-theme');
//    wp_register_script('bootstrap', plugin_dir_path . '/assets/js/bootstrap.min.js', false, null, false);
//    wp_enqueue_script('bootstrap',array('jquery'));
//}
//add_action('wp_enqueue_scripts', 'slider_scripts', 100);
//Unsilence if using this in the main plugin file
//wp_register_style( 'style', dirname( __FILE__ ) .'/style.css' ); 
//wp_enqueue_style('style');