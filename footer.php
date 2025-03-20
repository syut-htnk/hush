<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lull
 */
?>

<div>
<footer id="colophon" class="footer">
    <div class="footer-wrapper">

        <section class="footer-wrapper-left">
            <h4 class="title">Categories</h4>
            <ul>
                <?php wp_list_categories([
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hide_empty' => 1,
                    'title_li'   => '',
                ]); ?>
            </ul>
        </section>

        <section class="footer-wrapper-center">
            <h4 class="title">Tags</h4>
            <div class="tags">
                <?php
                $tags = get_tags([
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hide_empty' => true,
                ]);

                foreach ($tags as $tag) {
                    echo '<a href="' . get_tag_link($tag->term_id) . '">#' . $tag->name . '</a>';
                }
                ?>
            </div>
        </section>

        <section class="footer-wrapper-right">
            <h4 class="title">Contents</h4>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer-menu',
                'container'      => 'nav',
                'container_id'   => 'footer-menu-wrapper',
                'menu_class'     => 'footer-menu',
            ]);
            ?>
        </section>

        <section class="footer-wrapper-bottom">
            <p>&copy; 2024 puroam.com All rights reserved.</p>
        </section>

    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>