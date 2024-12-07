<div?php
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

	<footer id="colophon" class="site-footer">
		<!-- <div class="site-info"> -->
			<!-- <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'lull' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				//printf( esc_html__( 'Proudly powered by %s', 'lull' ), 'WordPress' );
				?>
			</a> -->
			<!-- <span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'lull' ), 'lull', '<a href="https://github.com/syut-htnk">Shuto Hatanaka</a>' );
				?>
		</div> -->
		<!-- .site-info -->

		<div class="footer-contents-wrapper">

		<section class="footer-left">
			<h4 class="footer-title">Categories</h4>
			<ul class="footer-category-list">
				<?php wp_list_categories(
					array(
						'orderby'    => 'name',       // Order categories by name
						'order'      => 'ASC',        // Order categories ascendingly
						'show_count' => 0,            // Do not display the number of posts in each category
						'hide_empty' => 1,            // Hide categories with no posts
						'title_li'   => '',           // Remove the list title
					)); 
				?>
			</ul>
		</section>

		<section class="footer-center">
			<h4 class="footer-title">Tags</h4>
			<div class="footer-tag-list">
				<?php
				$tags = get_tags(array(
					'orderby'    => 'name',       // Order tags by name
					'order'      => 'ASC',        // Order tags ascendingly
					'hide_empty' => true,         // Hide tags with no posts
				));

				if ($tags) :
					foreach ($tags as $tag) :
						// Create a link to the tag archive page
						echo '<a href="' . get_tag_link($tag->term_id) . '">' . "#" . $tag->name . '</a>';
					endforeach;
				endif;
				?>
			</div>
		</section>

		<section class="footer-right">
			<h4 class="footer-title">Contents</h4>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'container'      => 'nav',
					'container_id'   => 'footer-menu-wrapper',
					'menu_class'     => 'footer-menu',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			?>
		</section>

		<section class="footer-bottom">
			<p>&copy; 2024 puroam.com All rights reserved. </p>
		</section>

		</div>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
