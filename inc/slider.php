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
?>



<div id="homepage-slider" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <?php
            $loop = new WP_Query( array(
                'post_type' => 'hps_images'
            ) );
            /* p2p_type( 'slider_url' )->each_connected( $loop, array(), 'slideurl' ); */
            p2p_type( 'connected_slider_posts' )->each_connected( $loop, array(), 'connectedposts' );
            global $post;
            $sliderurl = $post->slideurl;
            $connectpost = $post->connectedposts;
            while ( $loop->have_posts() ) : $loop->the_post();
            if ( has_post_thumbnail() ) {
                $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
            } 
            $post_url = get_post_meta( get_the_ID(), 'post_url_link', true );
             if ($post_url == '')
             {
                 $slide_url = get_permalink();
             } else {
                 $slide_url = $post_url;
             } 
            /*if($loop->post_content=="") :
                $caption = '';
            else : 
                $caption = the_content();
            endif; */ ?>

            <div class="item <?php post_class(); ?>" id="post-<?php the_ID(); ?>">
                <div class="featured-img" style="background: url('<?php echo $feat_image_url ?>') no-repeat">
                    <div class="container">
                        <div class="row">
                                <div class="primary-caption col-md-4 col-sm-5 col-xs-8 col-xs-offset-2 col-md-offset-0">
                                    
                                      <?php 
                                /*        foreach ( $sliderurl as $post ) : setup_postdata( $post ); ?>
                                       <?php if($caption =="") :
                                            $caption =  the_excerpt();
                                         else :
                                        endif; */
                                    ?>
                                    <h3><?php the_title(); ?></h3>
                                    <?php the_content(); ?>
                                    <a class="btn btn-lg btn-primary" href="<?php echo $post_url; ?>">Read more</a>
                                         <?php /* endforeach; */ ?>
                                </div>
                                <div class="hidden-xs secondary-caption col-md-7 col-md-offset-1 col-sm-offset-0">
                                    <?php foreach ( $post->connectedposts as $post ) : setup_postdata( $post ); ?>
                                        <div class="panel panel-primary caption post-relationship-<?php echo $post->p2p_id; ?>">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><?php the_title(); ?></h3>
                                            </div>
                                            <div class="panel-body">
                                                 <?php the_excerpt(); ?>
                                                 <a class="btn btn-info btn-sm pull-right" href="<?php the_permalink(); ?>">Read more</a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>          

                                    <?php endforeach;  wp_reset_postdata(); ?>
                                </div>
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
<?php wp_reset_query(); ?>