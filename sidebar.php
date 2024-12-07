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
	<section class="widget widget_recomended">
	<h4 class="widget-title">Recomended Posts</h4>
	<?php
		// 表示したい投稿IDを配列で指定
		$include_ids = [1011, 993, 1148];

		// カスタムクエリを作成
		$args = [
			'post__in'       => $include_ids, // 指定したIDのみ取得
			'post_type'      => 'post',       // 投稿タイプ（例: post, page）
			'orderby'        => 'post__in',   // 配列の順序で取得
			'posts_per_page' => -1,           // 全て取得
		];
		$query = new WP_Query($args);

		if ($query->have_posts()) :
			while ($query->have_posts()) :
				$query->the_post();
				//echo '<p>Post ID: ' . get_the_ID() . '</p>';
				get_template_part( 'template-parts/content-sidebar', get_post_type() );
			endwhile;
			wp_reset_postdata();

		else :
			echo '<p>No posts found.</p>';
		endif;
	?>
	</section>

	<!-- Categories -->
	<section class="widget widget_categories">
		<h4 class="widget-title">Categories</h4>
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
