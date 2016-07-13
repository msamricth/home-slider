<?php
/*
    Plugin Name: Core Foods Custom slider plugin
    Description: Simple implementation of a Core Foods Custom slider into WordPress
    Author: Emmelia Talarico
    Author URI: http://zbraservices.com
    Version: 1.5
    License: unlicense
*/


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

add_action( 'admin_init', 'p2p_install' );
function p2p_install() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'posts-to-posts/posts-to-posts.php' ) ) {
        add_action( 'admin_notices', 'cantcontinue' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function cantcontinue(){
?><div class="error"><p>Sorry, but Home page slider requires the <a href="https://wordpress.org/plugins/posts-to-posts/">Posts to Posts Plugin</a> to be installed and active.</p></div><?php
}



add_action( 'init', 'hps_image' );

function hps_image() {
    register_post_type( 'hps_images',
		array(
			'labels' => array(
				'name' => __( 'Home Slider' ),
				'singular_name' => __( 'Home Slider' ),
				'add_new' => __( 'Add New slide' ),
				'add_new_item' => __( 'Add New slide' ),
				'edit_item' => __( 'Edit slide' ),
				'new_item' => __( 'Add New slide' )
			),
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'menu_position' => 5,
		    'taxonomies' => array( '' ),
            'has_archive' => true
        )
	);
    add_theme_support( 'post-thumbnails' );
    add_shortcode('hps-shortcode', 'hps_function');
}
add_action( 'admin_init', 'urlpost' );

function urlpost() {
    add_meta_box( 'url_to_post',
        'Url to featured slider post',
        'display_url_to_post',
        'hps_images', 'normal', 'high'
    );
}
function display_url_to_post( $hps_image ) {
    $post_url_link = intval( get_post_meta( $hps_image->ID, 'post_url_link', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 150px">Url for slide to be linked to</td>
            <td><input type="text" size="80" name="post_url_link" value="ex: a url to the main post" /></td>
        </tr>
    </table>
    <?php
}


add_action( 'save_post', 'add_slider_post_url_fields', 10, 2 );

function add_slider_post_url_fields( $hps_image_id, $hps_image ) {
    if ( $hps_image->post_type == 'hps_images' ) {
        if ( isset( $_POST['post_url_link'] ) && $_POST['post_url_link'] != '' ) {
            update_post_meta( $hps_image_id, 'post_url_link', $_POST['post_url_link'] );
        }
    }
}

require_once dirname( __FILE__ ) .'/inc/includes.php';
?>