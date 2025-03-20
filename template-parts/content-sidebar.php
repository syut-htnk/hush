<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lull
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="post-wrapper">

        <?php lull_post_thumbnail_link(); // サムネイルを表示 ?>

        <header class="entry-header">
            <?php
                the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
            if ( 'post' === get_post_type() ) :
            ?>
                <div class="entry-meta">
                    <?php
                    lull_posted_on();
                    //lull_posted_by();
                    ?>
                </div><!-- .entry-meta -->

                <div class="entry-tags">
                <?php 
                    if (get_the_tags()) : // タグがあるか確認
                        foreach (get_the_tags() as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                            <?php echo '#' . esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; 
                    endif; 
                ?>
                </div><!-- .entry-categories -->
            <?php endif; ?>
        </header><!-- .entry-header -->

    </div>
</article><!-- #post-<?php the_ID(); ?> -->
