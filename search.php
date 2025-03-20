<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package lull
 */

get_header();
?>

<div id="contents-wrapper" class="contents-wrapper is-archive-page">

	<header class="page-header">
		<h1 class="page-title">
			<?php
			/* translators: %s: search query. */
			printf(esc_html__('Search Results for: %s', 'lull'), '<span>' . get_search_query() . '</span>');
			?>
		</h1>
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
			) ?>

		</section>
	</main><!-- #main -->
	<?php get_sidebar(); ?>
</div><!-- #contents-wrapper -->

<!-- <?php the_posts_navigation(); ?> -->



<?php
get_footer();
