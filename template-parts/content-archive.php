<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lull
 */

?>

<article class="article-card" id="post-<?php the_ID(); ?>  <?php post_class(); ?>>

	<?php if ('post' === get_post_type()):?>
		<?php if (has_post_thumbnail()): ?>
			<a href="<?php the_permalink(); ?>" class="article-thumbnail-link">
				<?php the_post_thumbnail('full', ['class' => 'article-thumbnail']); ?>
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
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->