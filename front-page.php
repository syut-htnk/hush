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
        'posts_per_page' => 10,
      );
      $query = new WP_Query( $args ); 

      if ( $query->have_posts() ) : 
        while ( $query->have_posts() ) : 
          $query->the_post(); 
    ?>
      <div class="swiper-slide">
        <?php if ( has_post_thumbnail() ) : ?>
          <!-- <a class="slide-image-wrapper" href="<?php the_permalink(); ?>"> -->
			<div class="slide-image-wrapper">
			<!-- <div class="slide-image">
				<?php the_post_thumbnail()?>
			</div> -->
			<?php the_post_thumbnail('', ['class' => 'slide-image']); ?>
          <!-- </a> -->
		  </div>
        <?php endif; ?>
        <div class="slide-content">
		  <!-- category -->
		  <!-- <button class="slide-category"> -->
		<div class="slide-category">
		  <?php
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
				}
				}
			?>
		</div>
		  <!-- </button> -->
          <h2 class="slide-title"><?php the_title(); ?></h2>
		  <button class="slide-read-more">
			  <a href="<?php the_permalink(); ?>">Read More</a>
		  </button>
        </div>
      </div>
    <?php 
        endwhile; 
        wp_reset_postdata(); 
      else : 
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




<div id="contents-wrapper" class="contents-wrapper in-front-page">
	<main id="primary" class="site-main in-front-page">

		<!-- <section id="front-overview-wrapper">

		</section> -->

		<section id="latest-contents-wrapper" class="front-contents-wrapper">
			<h2 class="front-contents-title">最新の記事</h2>
			<div class="front-contents">
				<?php
				$args = array(
					'post_status' => 'publish',
					'posts_per_page' => 5,
					//固定記事は除外
					'ignore_sticky_posts' => 1,
				);
				$query = new WP_Query( $args );

				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post();
				?>
						<article class="front-content">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail(); ?>
								</a>
							<?php endif; ?>
							<h3 class="front-content-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="front-content-date"><?php the_time( 'Y年n月j日' ); ?></p>
						</article>
				<?php
					endwhile;
					wp_reset_postdata(); // クエリのリセット
				?>
				<?php else : ?>
					<p>投稿が見つかりませんでした。</p>
				<?php endif; ?>
			</div>
		</section>

		<section id="popular-contents-wrapper" class="front-contents-wrapper">

		</section>

		<section id="pinned-contents-wrapper" class="front-contents-wrapper">

		</section>

		<section id="category-contents-wrapper" class="front-contents-wrapper">

		</section>

		<!-- <?php
		// if ( have_posts() ) :

		// 	if ( is_home() && ! is_front_page() ) :
		// 		?>
		// 		<header>
		// 			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		// 		</header>
		// 		<?php
		// 	endif;

		// 	/* Start the Loop */
		// 	while ( have_posts() ) :
		// 		the_post();

		// 		/*
		// 		* Include the Post-Type-specific template for the content.
		// 		* If you want to override this in a child theme, then include a file
		// 		* called content-___.php (where ___ is the Post Type name) and that will be used instead.
		// 		*/
		// 		get_template_part( 'template-parts/content-archive', get_post_type() );

		// 	endwhile;

		// 	//the_posts_navigation();

		// else :

		// 	get_template_part( 'template-parts/content', 'none' );

		// endif;
		?>

		<div class="pagination">
			<?php the_posts_pagination(
				array(
					'mid_size'  => 5,
					'prev_text' => __( '<<', 'lull' ),
					'next_text' => __( '>>', 'lull' ),
				)
			); ?>
		</div> -->

	</main><!-- #main -->
	<?php get_sidebar(); ?>
</div>

<!-- <?php the_posts_navigation(); ?> -->



<?php
get_footer();
