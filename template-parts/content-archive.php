<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lull
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
	// カテゴリーをサムネイルの上に表示
	if ( 'post' === get_post_type() ) :
		?>
		<div class="entry-categories">
			<?php the_category( ', ' ); // カテゴリーを表示（カンマ区切り） ?>
		</div><!-- .entry-categories -->
	<?php endif; ?>

	<?php lull_post_thumbnail(); // サムネイルを表示 ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				lull_posted_on();
				//lull_posted_by();
				?>
			</div><!-- .entry-meta -->

			<div class="entry-tags">
			<?php 
				if (get_the_tags()) : // タグがあるか確認
					foreach (get_the_tags() as $tag) : ?>
						<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
						<?php echo '#' . esc_html($tag->name); ?>
						</a>
					<?php endforeach; 
				endif; 
			?>
			</div><!-- .entry-categories -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		// コンテンツやページリンク関連のコードはコメントアウトされたまま保持
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<!-- <?php lull_entry_footer(); ?> -->
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
