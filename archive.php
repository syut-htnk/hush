<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lull
 */

get_header();
?>

<div id="contents-wrapper" class="contents-wrapper in-archive-page">

	<header class="page-header">
		<?php
		$archive_title = get_the_archive_title();
		$archive_title = strip_tags($archive_title);
		$clean_title = preg_replace('/^.*?:\s/', '', $archive_title); // 「カテゴリー：」を削除
		?>
		<h1 class="page-title"><?php echo esc_html($clean_title); ?></h1>
		<?php
		the_archive_description('<div class="archive-description">', '</div>');
		?>
	</header><!-- .page-header -->

	<main id="primary" class="site-main is-archive-page">
		<section id="category-contents-wrapper" class="">
			<!-- <h2 class="section-title">Latest Posts</h2> -->
			<div class="article-grid">
				<?php if (have_posts()): ?>
					<?php
					/* Start the Loop */
					while (have_posts()):
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part('template-parts/content-archive', get_post_type());

					endwhile;

				else:

					get_template_part('template-parts/content', 'none');

				endif;
				?>
			</div>

			<?php the_posts_pagination(
				array(
					'mid_size' => 3,
				)
			)?>

		</section>
	</main><!-- #main -->
	<?php get_sidebar(); ?>
</div><!-- #contents-wrapper -->

<!-- <?php the_posts_navigation(); ?> -->



<?php
get_footer();
