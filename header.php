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
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
		global $meta_post_data;
		$og_url = get_permalink();
		$og_title = get_the_title();
		$og_description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 55, '...'); // 記事の抜粋
		$og_image = has_post_thumbnail() ? get_the_post_thumbnail_url($meta_post_data, 'full') : 'Default Image Path'; // アイキャッチ画像またはデフォルト
		$og_site_name = get_bloginfo('name'); // サイト名
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

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'lull' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$lull_description = get_bloginfo( 'description', 'display' );
			if ( $lull_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $lull_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span></span>
				<span></span>
				<span></span>
				<!-- <?php esc_html_e( 'Primary Menu', 'lull' ); ?> -->
			</button>
			<!-- <div class="menu-sp-overlay"></div> -->
			<nav id="header-menu-sp-wrapper" class="header-menu-wrapper">
				<h4 class="header-sp-title">Menu</h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu-mobile',
						// 'container'      => 'nav',
						// 'container_id'   => 'header-menu-sp-wrapper',
						// 'container_class' => 'header-menu-wrapper',
						'fallback_cb'    => '',
						//'items_wrap'     => '<div class="header-menu-sp-wrapper-inner">%3$s</div>',
					)
				);
				?>
				<h4 class="header-sp-title">Categories</h4>
				<ul class="header-category-list">
					<?php wp_list_categories(
						array(
							'orderby'    => 'name',       // Order categories by name
							'order'      => 'ASC',        // Order categories ascendingly
							'show_count' => 0,            // Do not display the number of posts in each category
							'hide_empty' => 1,            // Hide categories with no posts
							'title_li'   => '',           // Remove the list title
						)); 
					?>
				</ul>
			</nav>
			<div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu',
						'container'      => 'nav',
						'container_id'   => 'header-menu-pc-wrapper',
						'container_class' => 'header-menu-wrapper',
						'fallback_cb'    => '',
					)
				);
				?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
