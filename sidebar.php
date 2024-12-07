<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lull
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>

	<!-- Recommended Posts -->
	<section class="widget widget_recent_entries">
		<h2 class="widget-title">Recommended Posts</h2>
		<ul>
			<?php
			$recommended_posts = new WP_Query( array(
				'posts_per_page' => 5,
				'orderby' => 'rand'
			) );

			if ( $recommended_posts->have_posts() ) {
				while ( $recommended_posts->have_posts() ) {
					$recommended_posts->the_post();
					?>
					<li>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
					<?php
				}
			}
			wp_reset_postdata();
			?>
		</ul>
	</section>

	<!-- Categories -->
	<section class="widget widget_categories">
		<h2 class="widget-title">Categories</h2>
		<ul>
			<?php
			$categories = get_categories( array(
				'orderby' => 'name',
				'order'   => 'ASC'
			) );

			foreach( $categories as $category ) {
				$category_link = sprintf(
					'<a href="%1$s" alt="%2$s">%3$s</a>',
					esc_url( get_category_link( $category->term_id ) ),
					esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
					esc_html( $category->name )
				);

				echo '<li>' . sprintf( esc_html__( '%s' ), $category_link ) . '</li>';
			}
			?>
		</ul>
	</section>
</aside><!-- #secondary -->
