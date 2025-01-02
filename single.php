<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package lull
 */

get_header();
?>

<div id="contents-wrapper" class="contents-wrapper is-single-page">

	<?php if (is_active_sidebar('article-top')): ?>
		<?php dynamic_sidebar('article-top'); ?>
	<?php endif; ?>

	<main id="primary" class="site-main is-single-page">

		<?php
		while (have_posts()):
			the_post();

			get_template_part('template-parts/content-page', get_post_type());

			// the_post_navigation(
			// 	array(
			// 		'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'lull' ) . '</span> <span class="nav-title">%title</span>',
			// 		'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'lull' ) . '</span> <span class="nav-title">%title</span>',
			// 	)
			// );
		
			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()):
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		<!-- Related Posts -->
		<section id="related-contents-wrapper" class="single-section">
			<h2 class="section-title">Related Posts</h2>
			<div class="article-grid">
				<?php

				$catkwds = array();

				if (has_category()) {

					$cats = get_the_category();

					foreach ($cats as $cat) {
						$catkwds[] = $cat->term_id;
					}

				}

				$args = array(
					'post_type' => 'post',
					'posts_per_page' => '4',
					'post__not_in' => array($post->ID),
					'category__in' => $catkwds,
					'orderby' => 'rand'
				);
				$query = new WP_Query($args);

				if ($query->have_posts()):
					while ($query->have_posts()):
						$query->the_post();
						?>
						<article class="article-card">
							<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" class="article-thumbnail-link">
									<?php the_post_thumbnail('medium', ['class' => 'article-thumbnail']); ?>
								</a>
							<?php endif; ?>
							<div class="article-meta">
								<div class="article-category">
									<!-- <?php
									// $categories = get_the_category();
									// if (!empty($categories)) {
									// 	foreach ($categories as $category) {
									// 		echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
									// 	}
									// }
									?> -->
									<?php
									$categories = get_the_category();
									if (!empty($categories)) {
										$links = array();
										foreach ($categories as $category) {
											$links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
										}
										echo implode('・', $links);
									}
									?>
								</div>
								<h3 class="article-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<!-- <p class="article-date"><?php the_time('Y年n月j日'); ?></p> -->
								<div class="article-tags">
									<?php
									// endwhile;
									// endif;
									$tags = get_the_tags();
									if ($tags) {
										foreach ($tags as $tag) {
											echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link">#' . esc_html($tag->name) . '</a> ';
										}
									}
									?>
								</div>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				else:
					?>
					<p>投稿が見つかりませんでした。</p>
				<?php endif; ?>
			</div>
		</section>

		<!-- Related Posts -->
		<section id="popular-contents-wrapper" class="single-section">
			<h2 class="section-title">Popular Posts</h2>
			<div class="article-grid">
				<?php
				$count = 1;

				if(function_exists('sga_ranking_get_date')) {
					$popular_posts = sga_ranking_get_date();
					foreach ($popular_posts as $post) {
						setup_postdata($post);
						?>
						<article class="article-card">
							<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" class="article-thumbnail-link">
									<?php the_post_thumbnail('medium', ['class' => 'article-thumbnail']); ?>
								</a>
							<?php endif; ?>
							<div class="article-meta">
								<div class="article-category">
									<?php
									$categories = get_the_category();
									if (!empty($categories)) {
										$links = array();
										foreach ($categories as $category) {
											$links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
										}
										echo implode('・', $links);
									}
									?>
								</div>
								<h3 class="article-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="article-tags">
									<?php
									$tags = get_the_tags();
									if ($tags) {
										foreach ($tags as $tag) {
											echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link">#' . esc_html($tag->name) . '</a> ';
										}
									}
									?>
								</div>
							</div>
						</article>
						<?php
						$count++;
						if ($count > 4) {
							break;
						}
					}
					wp_reset_postdata();
				}
				?>
			</div>
			<!-- </div> -->
		</section>

	</main><!-- #main -->

	<?php if (is_active_sidebar('article-bottom')): ?>
		<?php dynamic_sidebar('article-bottom'); ?>
	<?php endif; ?>


	<?php get_sidebar(); ?>
</div><!-- #contents-wrapper -->

<?php
// the_post_navigation(
// 	array(
// 		'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'lull' ) . '</span> <span class="nav-title">%title</span>',
// 		'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'lull' ) . '</span> <span class="nav-title">%title</span>',
// 	)
// ); 
?>
<?php
get_footer();
