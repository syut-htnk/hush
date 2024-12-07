<?php
/**
 * lull functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lull
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lull_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on lull, use a find and replace
		* to change 'lull' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'lull', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			//'menu-1' => esc_html__( 'Primary', 'lull' ),
			'header-menu-mobile' => esc_html__( 'header-menu-mobile', 'lull' ),
			'header-menu' => esc_html__( 'header-menu', 'lull' ),
			'footer-menu' => esc_html__( 'footer-menu', 'lull' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'lull_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'lull_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lull_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lull_content_width', 640 );
}
add_action( 'after_setup_theme', 'lull_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lull_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'lull' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'lull' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'lull_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lull_scripts() {
	//wp_enqueue_style( 'lull-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'lull-style-destyle', get_template_directory_uri() . '/sass/destyle.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'lull-style-scss', get_template_directory_uri() . '/sass/style.css', array(), _S_VERSION );
	//wp_style_add_data( 'lull-style', 'rtl', 'replace' );

	wp_enqueue_script( 'lull-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lull_scripts' );

/*
 * Enqueue Google Fonts
 */
function lull_enable_google_fonts() {
	// Define the font URL
	wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@500;700&display=swap',
		//'https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@500;700&display=swap',
        [],
        null
    );

    // Preload Google Fonts
    add_filter('style_loader_tag', function ($html, $handle) {
        if ('google-fonts' === $handle) {
            // Preload
            $html = str_replace("rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html);
        }
        return $html;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'lull_enable_google_fonts');

/*
 * Enqueue swiper files
 */
function lull_add_swiper_files() {
	// CSS
	wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.css', array(), '1.0.0');
	//wp_enqueue_style('swiper-css-style', get_template_directory_uri() . '/css/slider.css', array('swiper-style'), '1.0.0');

	// JS
	/*
		* load in footer
		*/
	wp_enqueue_script( 'swiper-script', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.js', array(), '1.0.0', true);
	wp_enqueue_script( 'swiper-js-script', get_template_directory_uri() . '/js/swiper.js', array('swiper-script'), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'lull_add_swiper_files' );

function lull_get_breadcrumb() {
    echo '<a href="' . home_url() . '" rel="nofollow">HOME</a>';
    if (is_category() || is_single()) {
        echo ' » ';
        the_category(' • ');
        if (is_single()) {
            echo ' » ';
            the_title();
        }
    } elseif (is_page()) {
        echo ' » ';
        the_title();
    } elseif (is_search()) {
        echo ' » Search Results for… <em>';
        echo get_search_query();
        echo '</em>';
    }
}

function lull_get_sns_buttons() {
    // 現在の投稿の URL とタイトルを取得
    $url   = urlencode(get_permalink());
    $title = urlencode(get_the_title());

    // テーマディレクトリのURLを取得
    $template_directory = get_template_directory_uri();

    // 各 SNS のボタンを生成
    $html = '<div class="sns-buttons-wrapper">';

    // Twitter
	//$html .= '<button id="twitter-button" class="sns-button" data-url="' . $url . '" data-text="' . $title . '" data-lang="ja">';
    $html .= '<a id="twitter-button" class="sns-button" href="https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url . '" target="_blank" rel="noopener noreferrer">';
    $html .= '<img src="' . $template_directory . '/assets/img/svg/twitter.svg" alt="Twitterでシェア">';
    $html .= '</a>';
	//$html .= '</button>';

    // LINE
	//$html .= '<button id="line-button" class="sns-button" data-url="' . $url . '" data-text="' . $title . '" data-lang="ja">';
    $html .= '<a id="line-button" class="sns-button" href="https://social-plugins.line.me/lineit/share?url=' . $url . '" target="_blank" rel="noopener noreferrer">';
    $html .= '<img src="' . $template_directory . '/assets/img/svg/line.svg" alt="LINEでシェア">';
    $html .= '</a>';
	//$html .= '</button>';

    // Pinterest
    // 必要に応じて有効化
    // $html .= '<a href="https://pinterest.com/pin/create/button/?url=' . $url . '&media=' . $media . '&description=' . $title . '" target="_blank" rel="noopener noreferrer">';
    // $html .= '<img src="' . $template_directory . '/images/pinterest-icon.png" alt="Pinterestでシェア">';
    // $html .= '</a>';

    $html .= '</div>';

    // HTML を出力
    echo $html;
}



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

