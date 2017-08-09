<?php
/**
 * Your Inspiration Themes
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

$has_thumbnail = ( !yit_image( 'size=blog_bazar&image_scan=' . yit_get_option('blog-show-first-content-image'), false ) || ( ! is_single() && ! yit_get_option( 'blog-show-featured' ) ) || ( is_single() && ! yit_get_option( 'blog-show-featured-single' ) ) ) ? false : true; ?>
<div class="<?php if ( ! $has_thumbnail ) echo 'without ' ?>thumbnail">
        <div class="row">                
            <!-- post meta -->
            <div class="meta group span3">              
                <div>
                    <?php
                    $link = get_permalink();
                
                    if( get_the_title() == '' )
                        { $title = __( '(this post does not have a title)', 'yit' ); }
                    else
                        { $title = get_the_title(); }
                        
                    if ( is_single() )
                        { yit_string( "<h1 class=\"post-title\"><a href=\"$link\">", $title, "</a></h1>" ); } 
                    else
                        { yit_string( "<h2 class=\"post-title\"><a href=\"$link\">", $title, "</a></h2>" ); }
                    ?>
                    
                    <?php if( yit_get_option( 'blog-show-author' ) ) : ?><p class="author"><?php echo yit_get_icon( 'blog-author-icon', true ) ?><span><?php _e( 'Author:', 'yit' ) ?></span> <?php the_author_posts_link() ?></p><?php endif; ?>
                    <?php if( yit_get_option( 'blog-show-date' ) ) : ?><p class="date"><?php echo yit_get_icon( 'blog-date-icon', true ) ?><span><?php _e( 'Date:', 'yit') ?></span> <?php echo get_the_date() ?></p><?php endif; ?>                    
                    
                    <?php edit_post_link( __( 'Edit', 'yit' ), '<p class="edit-link"><i class="icon-pencil"></i>', '</p>' ); ?>
                </div>
                <div>
                    <?php if( yit_get_option( 'blog-show-comments' ) ) : ?><p class="comments"><?php echo yit_get_icon( 'blog-comments-icon', true ) ?><span><?php comments_popup_link( __( '<span>Comments:</span> 0', 'yit' ), __( '<span>Comments:</span> 1', 'yit' ), __( '<span>Comments:</span> %', 'yit' ) ); ?></span></p><?php endif ?>
                </div>
                <div>
                    <?php echo do_shortcode( apply_filters('yit-elegant_blog-socials', '[share icon_type="square" title="' . __( 'Share on', 'yit' ) . '" socials="facebook, twitter, google, pinterest"]' ) ); ?>
                </div>
            </div>
            
            <!-- post title -->
            <div class="the-content span6">
                <div>
                    <?php
                    if( $has_thumbnail ) {
                        if( ( !is_single() || ( get_post_format() != 'video' && get_post_format() != 'gallery' ) ) ) {
                            yit_image( 'size=blog_elegant&class=thumbnail&image_scan=' . yit_get_option('blog-show-first-content-image') );
                        }
                    }
                    ?>
                    
                    <?php if( get_post_format() != '' && !is_single() ) : ?><span class="post-format <?php echo get_post_format() ?>"><?php _e( ucfirst( get_post_format() ), 'yit' ) ?></span><?php endif ?>
                    
                    <?php if( !is_single() ) : ?>
                    <!-- post content -->
                    <div class="the-content"><?php
                        if ( is_category() || is_archive() || is_search() ) {
                            if( is_category() ) {
                                if( yit_get_option( 'posts-categories' ) == 'excerpt' ) : the_excerpt(); else : the_content( yit_get_option( 'readmore-categories' ) ); endif;
                            } elseif( is_archive() ) {
                                if( yit_get_option( 'posts-archives' ) == 'excerpt' ) : the_excerpt(); else : the_content( yit_get_option( 'readmore-archives' ) ); endif;
                            } elseif( is_search() ) {
                                if( yit_get_option( 'posts-searches' ) == 'excerpt' ) : the_excerpt(); else : the_content( yit_get_option( 'readmore-searches' ) ); endif;
                            } 
                        }     
                        else  
                        {
                        	// the_content( yit_get_option('blog-read-more-text') );
                        	if( yit_get_option( 'blog-show-read-more' ) ) {
					            the_content( yit_get_option( 'blog-read-more-text' ) );
					        } else {
					            the_excerpt();
					        }
                        }
                    ?></div>
                    <?php endif ?>
                </div>
            </div>
            
            <?php if( is_single() ) : ?>
                
                <!-- post content -->
                <div class="the-content single group span9"><?php
                    if ( is_category() || is_archive() || is_search() ) {
                        if( is_category() ) {
                            if( yit_get_option( 'posts-categories' ) == 'excerpt' ) : the_excerpt(); else : the_content( yit_get_option( 'readmore-categories' ) ); endif;
                        } elseif( is_archive() ) {
                            if( yit_get_option( 'posts-archives' ) == 'excerpt' ) : the_excerpt(); else : the_content( yit_get_option( 'readmore-archives' ) ); endif;
                        } elseif( is_search() ) {
                            if( yit_get_option( 'posts-searches' ) == 'excerpt' ) : the_excerpt(); else : the_content( yit_get_option( 'readmore-searches' ) ); endif;
                        } 
                    }     
                    else  
                    {
                    	the_content( yit_get_option('blog-read-more-text') );
					}
                          
                    if( yit_get_option( 'blog-show-tags' ) ) : the_tags( '<p class="tags">' . __( 'Tags: ', 'yit' ), ', ', '</p>' ); endif;
                ?></div>        
            <?php endif ?>
        </div>
    </div>