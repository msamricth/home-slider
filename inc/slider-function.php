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

function hps_function($type='hps_function') { ?>
<div id="homepage-slider" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <?php
            $mypost = array( 'post_type' => 'hps_images', );
            $loop = new WP_Query( $mypost );
        while ( $loop->have_posts() ) : $loop->the_post();
            if ( has_post_thumbnail() ) {
                $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
            }
            if($loop->post_content=="") :
                $caption = '';
            else : 
                $caption = the_content();
            endif; ?>

            <div class="item <?php post_class(); ?>" id="post-<?php the_ID(); ?>">
                <div class="featured-img" style="background: url('<?php echo $feat_image_url ?>') no-repeat">
                     
                <?php
                // Find connected pages
                $connected = new WP_Query( array(
                    'connected_type' => 'slider_url',
                    'connected_items' => $post,
                    'nopaging' => true
                ) );
                while ( $connected->have_posts() ) : $connected->the_post();
                    if($caption =="") :
                    $caption =  the_excerpt();
                    else :
                    endif; ?>
                        <div class="row">
                                <div class="carousel-caption col-md-4 col-sm-5 col-xs-8 col-xs-offset-2 main-caption">
                                    <?php echo $caption; ?>
                                    <a href="<?php the_permalink(); ?>">Read more</a>
                                </div>
                            <?php endwhile;  wp_reset_postdata(); ?>
                                <div class="hidden-xs col-md-7 col-md-offset-1 col-sm-offset-0">
                                    <?php
                                    // Find connected pages
                                    $relates = new WP_Query( array(
                                        'connected_type' => 'connected_slider_posts',
                                        'connected_items' => $post,
                                        'nopaging' => true
                                    ) );
                                    while ( $connected->have_posts() ) : $connected->the_post(); ?>
                                        <div class="row">
                                            <div class="col-md-12 caption post-relationship-<?php echo $post->p2p_id; ?>">
                                                <?php the_excerpt(); ?>
                                                <a href="<?php the_permalink(); ?>">Read more</a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>          

                                    <?php endwhile; wp_reset_postdata(); ?>
                                </div>
                        </div>
                    </div>
            </div>
        <?php endwhile; ?>     
    </div>
  <!-- Controls -->
  <a class="left carousel-control" href="#corefood-homepage-slider" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#corefood-homepage-slider" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php wp_reset_query(); 
} ?>