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
							<?php
							$categories = get_the_category();
							if (!empty($categories)) {
								foreach ($categories as $category) {
									echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
								}
							}
							?>
						</div>
						<!-- </button> -->
						<h2 class="slide-title"><?php the_title(); ?></h2>
						<button class="slide-read-more">
							<a href="<?php the_permalink(); ?>">もっと読む</a>
						</button>
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
		<section id="latest-contents-wrapper" class="front-section">
			<h2 class="section-title">Latest Posts</h2>
			<div class="article-grid">
				<?php
				$args = array(
					'post_status' => 'publish',
					'posts_per_page' => 12,
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
									<?php
									$categories = get_the_category();
									if (!empty($categories)) {
										foreach ($categories as $category) {
											echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
										}
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
<button class="view-all-posts">
    <?php
    // サイトの投稿アーカイブURLを生成
    $archive_link = archive_url(); // デフォルトのアーカイブURLを取得

    // リンクを表示
    echo '<a href="' . esc_url( $archive_link ) . '" class="archive-link">すべての投稿を見る</a>';
    ?>
</button>
		</section>

		<hr class="section-divider">

		<?php
			// カテゴリーIDの配列
			$category_ids = array(1, 23, 52); // 例として1, 2, 3を指定

			foreach ($category_ids as $cat_id) {
				$args = array(
					'post_status'        => 'publish',
					'posts_per_page'     => 1,
					'ignore_sticky_posts'=> 1,
					'cat'                => $cat_id, // カテゴリーIDを指定
				);
				$query = new WP_Query( $args );

				if ( $query->have_posts() ) :
			?>
				<section id="category-<?php echo $cat_id; ?>-contents-wrapper" class="front-section categories-contents-wrapper">
					<h2 class="section-title"><?php echo get_cat_name($cat_id); ?></h2>
					<div class="grid-wrapper">
						<div class="article-grid-1">
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>
								<article class="article-card">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>" class="article-thumbnail-link">
											<?php the_post_thumbnail('large', ['class' => 'article-thumbnail']); ?>
										</a>
									<?php endif; ?>
									<div class="article-meta">
										<div class="article-category">
											<?php
											$categories = get_the_category();
											if ( ! empty( $categories ) ) {
												foreach ( $categories as $category ) {
													echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
												}
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
							$query = new WP_Query( $args );
							if ( $query->have_posts() ) :
								while ( $query->have_posts() ) : $query->the_post();
							?>
									<article class="article-card-sub">
										<div class="article-meta">
											<div class="article-category">
												<?php
												$categories = get_the_category();
												if ( ! empty( $categories ) ) {
													foreach ( $categories as $category ) {
														echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
													}
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
										<?php if ( has_post_thumbnail() ) : ?>
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
				</section>
				<hr class="section-divider">
			<?php
				else :
					echo '<p>投稿が見つかりませんでした。</p>';
				endif;
			}
		?>


	</main>
	<?php get_sidebar(); ?>
</div>

<!-- <?php the_posts_navigation(); ?> -->



<?php
get_footer();