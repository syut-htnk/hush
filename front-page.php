<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lull
 */

get_header();
?>

<!-- Slider main container -->
<div class="swiper swiper-primary">
	<div class="swiper-wrapper">
		<?php
		$args = array(
			'post_status' => 'publish',
			'posts_per_page' => 5,
		);
		$query = new WP_Query($args);

		if ($query->have_posts()):
			while ($query->have_posts()):
				$query->the_post();
				?>
				<div class="swiper-slide">
					<?php if (has_post_thumbnail()): ?>
						<!-- <a class="slide-image-wrapper" href="<?php the_permalink(); ?>"> -->
						<div class="slide-image-wrapper">
							<?php the_post_thumbnail('large', ['class' => 'slide-image']); ?>
							<!-- </a> -->
						</div>
					<?php endif; ?>
					<div class="slide-content">
						<!-- category -->
						<!-- <button class="slide-category"> -->
						<div class="slide-category">
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
								echo implode(' ', $links);
							}
							?>
						</div>
						<!-- </button> -->
						<h2 class="slide-title"><?php the_title(); ?></h2>
						<a class="slide-read-more" href="<?php the_permalink(); ?>">もっと読む</a>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		else:
			?>
			<div class="swiper-slide">
				<p>投稿が見つかりませんでした。</p>
			</div>
		<?php endif; ?>
	</div>

	<div class="swiper-pagination"></div>
	<div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>
</div>

<!-- <hr class="section-divider"> -->

<div id="contents-wrapper" class="layout-wrapper is-front-page">
	<main id="primary" class="site-main is-front-page">

		<!-- 新規投稿のセクション -->

		<section id="latest-contents-wrapper" class="front-section">
			<h2 class="section-title fade-effect-heading">Latest Posts</h2>
			<div class="article-grid">
				<?php
				$args = array(
					'post_status' => 'publish',
					'posts_per_page' => 3,
					'ignore_sticky_posts' => 1,
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
										echo implode(' ', $links);
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
			<div class="view-all-posts-wrapper">
				<a class="view-all-posts-button" href="<?php echo esc_url(home_url('/archive/')); ?>">全ての記事を見る</a>
			</div>
		</section>

		<!-- 新規投稿のセクションここまで -->

		<!-- 固定投稿のセクション -->

		<section id="pinned-contents-wrapper" class="front-section">
			<!-- <h2 class="section-title fade-effect-heading">Pinned Posts</h2> -->
			<!-- <div class="article-grid"> -->
				<?php
				// 固定投稿のIDを配列に指定（任意のIDに置き換えてください）
				$fixed_posts = array(297);
				$args = array(
					'post_status' => 'publish',
					'posts_per_page' => 1,           // 表示する投稿数を2件に設定
					'post__in' => $fixed_posts,  // 固定投稿IDでフィルター
					'orderby' => 'post__in',    // 指定した順番に表示
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
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				else:
					?>
					<p>投稿が見つかりませんでした。</p>
				<?php endif; ?>
			<!-- </div> -->
		</section>

		<!-- 固定投稿のセクションここまで -->

		<!-- 人気投稿のセクション -->

		<section id="popular-contents-wrapper" class="front-section">
			<h2 class="section-title fade-effect-heading">Popular Posts</h2>
			<div class="article-grid">
				<?php
				$count = 1;

				if (function_exists('sga_ranking_get_date')) {
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
										echo implode(' ', $links);
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
						if ($count > 6) {
							break;
						}
					}
					wp_reset_postdata();
				}
				?>
			</div>
			<div class="view-all-posts-wrapper">
				<a class="view-all-posts-button" href="<?php echo esc_url(home_url('/archive/')); ?>">他の記事も見る</a>
			</div>
		</section>

		<!-- 人気投稿のセクションここまで -->

		<hr class="section-divider">

		<!-- カテゴリー毎のセクション -->
		<?php
		// カテゴリーIDの配列
		$category_ids = array(2, 23, 52); // 例として1, 2, 3を指定
		
		foreach ($category_ids as $cat_id) {
			$args = array(
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'ignore_sticky_posts' => 1,
				'cat' => $cat_id, // カテゴリーIDを指定
			);
			$query = new WP_Query($args);

			if ($query->have_posts()):
				?>
				<section id="category-<?php echo $cat_id; ?>-contents-wrapper"
					class="front-section categories-contents-wrapper">
					<!-- <h2 class="section-title"></h2> -->
					<h2 class="section-title fade-effect-heading"><?php echo get_cat_name($cat_id); ?></h2>
					<div class="grid-wrapper">
						<div class="article-grid-1">
							<?php while ($query->have_posts()):
								$query->the_post(); ?>
								<article class="article-card">
									<?php if (has_post_thumbnail()): ?>
										<a href="<?php the_permalink(); ?>" class="article-thumbnail-link">
											<?php the_post_thumbnail('large', ['class' => 'article-thumbnail']); ?>
										</a>
									<?php endif; ?>
									<div class="article-meta">
										<div class="article-category">
											<!-- <?php
											// $categories = get_the_category();
											// if ( ! empty( $categories ) ) {
											// 	foreach ( $categories as $category ) {
											// 		echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
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
												echo implode(' ', $links);
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
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>
						<div class="article-grid-2">
							<?php
							$args['posts_per_page'] = 4; // 2列目の記事数を変更
							$query = new WP_Query($args);
							if ($query->have_posts()):
								while ($query->have_posts()):
									$query->the_post();
									?>
									<article class="article-card-sub">
										<div class="article-meta">
											<div class="article-category">
												<!-- <?php
												// $categories = get_the_category();
												// if ( ! empty( $categories ) ) {
												// 	foreach ( $categories as $category ) {
												// 		echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
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
													echo implode(' ', $links);
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
										<?php if (has_post_thumbnail()): ?>
											<a href="<?php the_permalink(); ?>" class="article-thumbnail-link">
												<?php the_post_thumbnail('medium', ['class' => 'article-thumbnail']); ?>
											</a>
										<?php endif; ?>
									</article>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div>
					<div class="view-all-posts-wrapper">
						<a class="view-all-posts-button" href="<?php echo esc_url(get_category_link($cat_id)); ?>">全ての記事を見る</a>
					</div>
				</section>
				<hr class="section-divider">
				<?php
			else:
				echo '<p>投稿が見つかりませんでした。</p>';
			endif;
		}
		?>
		<!-- カテゴリー毎のセクションここまで -->


	</main>
	<?php get_sidebar(); ?>
</div>

<!-- <?php the_posts_navigation(); ?> -->



<?php
get_footer();