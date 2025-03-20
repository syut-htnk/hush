<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lull
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- meta -->
	<?php
	global $meta_post_data;
	$og_url = get_permalink();
	$og_title = get_the_title();
	$og_description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 55, '...');
	$og_image = has_post_thumbnail() ? get_the_post_thumbnail_url($meta_post_data, 'full') : 'Default Image Path';
	$og_site_name = get_bloginfo('name');
	?>

	<meta property="og:url" content="<?php echo esc_url($og_url); ?>" />
	<meta property="og:title" content="<?php echo esc_attr($og_title); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:description" content="<?php echo esc_attr($og_description); ?>" />
	<meta property="og:image" content="<?php echo esc_url($og_image); ?>" />
	<meta property="og:site_name" content="<?php echo esc_attr($og_site_name); ?>" />
	<meta property="og:locale" content="ja_JP" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="" />
	<meta property="fb:app_id" content="" />
	<!-- /meta -->

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-0FP0W7WDLL"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());

		gtag('config', 'G-0FP0W7WDLL');
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'lull'); ?></a>

		<header id="masthead" class="site-header">
			<div class="site-branding">
				<a href="/" title="PUROAM">
					<!-- <span>P</span>
					<span>U</span>
					<span>R</span>
					<span>O</span>
					<span>A</span>
					<span>M</span> -->
					puroam
				</a>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"
					aria-label="Menu-Toggle-Button">
					<span></span>
					<span></span>
					<span></span>
				</button>

				<nav id="header-menu-sp-wrapper" class="header-menu-wrapper">
					<h4 class="header-sp-title">Contents</h4>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header-menu-mobile',
							// 'container'      => 'nav',
							// 'container_id'   => 'header-menu-sp-wrapper',
							// 'container_class' => 'header-menu-wrapper',
							'fallback_cb' => '',
							//'items_wrap'     => '<div class="header-menu-sp-wrapper-inner">%3$s</div>',
						)
					);
					?>

					<h4 class="header-sp-title">Search</h4>
					<div class="nav-sp-search">
						<?php get_search_form(); ?>
					</div>
					<!-- <h4 class="header-sp-title">Categories</h4>
					<ul class="header-category-list">
						<?php wp_list_categories(
							array(
								'orderby' => 'name',       // Order categories by name
								'order' => 'ASC',        // Order categories ascendingly
								'show_count' => 0,            // Do not display the number of posts in each category
								'hide_empty' => 1,            // Hide categories with no posts
								'title_li' => '',           // Remove the list title
							)
						);
						?>
					</ul> -->
					<!-- <h4 class="header-sp-title">Tags</h4>
					<ul class="header-tag-list">
						<?php
						$tags = get_tags([
							'orderby' => 'name',
							'order' => 'ASC',
							'hide_empty' => true,
						]);

						foreach ($tags as $tag) {
							echo '<a href="' . get_tag_link($tag->term_id) . '">#' . $tag->name . '</a>';
						}
						?>
					</ul> -->
				</nav>

				<div id="header-menu-pc-wrapper" class="header-menu-wrapper">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header-menu',
							'container' => 'nav',
							'container_id' => '',
							'container_class' => '',
							'fallback_cb' => '',
						)
					);
					?>

					<div class="header-search-icon">
						<button id="search-toggle" aria-label="Search">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round">
								<circle cx="11" cy="11" r="8"></circle>
								<line x1="22" y1="22" x2="16.65" y2="16.65"></line>
							</svg>
						</button>
						<div id="search-overlay" class="search-overlay">
							<div class="search-overlay-content">
								<div class="search-overlay-header">
									<button id="search-close" class="search-close" aria-label="Close search">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="2 2 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<line x1="2" y1="2" x2="20" y2="20"></line>
											<line x1="20" y1="2" x2="2" y2="20"></line>
										</svg>
									</button>
									<h3><?php esc_html_e('Search', 'lull'); ?></h3>
								</div>
								<div class="search-overlay-tags">
									<?php
									// カスタムタグクラウド（ハッシュタグ付き）
									$tags = get_tags(array(
										'number' => 20,
										'orderby' => 'count',
										'order' => 'DESC',
									));

									if ($tags) {
										foreach ($tags as $tag) {
											echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
										}
									}
									?>
								</div>
								<?php get_search_form(); ?>
								<p>Esc to close.</p>
							</div>
						</div>
					</div>


					<!-- <script>
						document.addEventListener('DOMContentLoaded', function () {
							const body = document.body;
							const searchToggle = document.getElementById('search-toggle');
							const searchOverlay = document.getElementById('search-overlay');
							const searchClose = document.getElementById('search-close');

							searchToggle.addEventListener('click', function () {
								searchOverlay.classList.add('active');
								document.querySelector('.search-field').focus();
								document.body.style.overflow = 'hidden';
								body.classList.add( 'no-scroll' );
							});

							searchClose.addEventListener('click', function () {
								searchOverlay.classList.remove('active');
								document.body.style.overflow = '';
							});

							document.addEventListener('keydown', function (e) {
								if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
									searchOverlay.classList.remove('active');
									document.body.style.overflow = '';
								}
							});
						});
					</script> -->
				</div>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->