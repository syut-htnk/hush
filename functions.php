<?php
/**
 * lull functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lull
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lull_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on lull, use a find and replace
	 * to change 'lull' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('lull', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			//'menu-1' => esc_html__( 'Primary', 'lull' ),
			'header-menu-mobile' => esc_html__('header-menu-mobile', 'lull'),
			'header-menu' => esc_html__('header-menu', 'lull'),
			'footer-menu' => esc_html__('footer-menu', 'lull'),
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
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'lull_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lull_content_width()
{
	$GLOBALS['content_width'] = apply_filters('lull_content_width', 640);
}
add_action('after_setup_theme', 'lull_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lull_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'lull'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'lull'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'lull_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function lull_scripts()
{
	//wp_enqueue_style( 'lull-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style('lull-style-destyle', get_template_directory_uri() . '/sass/destyle.min.css', array(), _S_VERSION);

	//swiperのcssは先に読み込む
	wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.css', array(), '1.0.0');
	wp_enqueue_style('lull-style-scss', get_template_directory_uri() . '/sass/style.css', array(), _S_VERSION);
	//wp_style_add_data( 'lull-style', 'rtl', 'replace' );

	wp_enqueue_script('lull-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('lull-indexing', get_template_directory_uri() . '/js/indexing.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'lull_scripts');

/*
 * Enqueue Google Fonts
 */
function lull_enable_google_fonts()
{
	// Define the font URL
	wp_enqueue_style(
		'google-fonts',
		// 'https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@500;700&display=swap',
		// 'https://fonts.googleapis.com/css2?family=Jost:wght@700&family=Zen+Kaku+Gothic+New:wght@500;700&display=swap',
		//'https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@500;700&display=swap',
		'https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;700&family=Zen+Kaku+Gothic+New:wght@500;700&display=swap',
		// 'https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap',
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
function lull_add_swiper_files()
{
	// CSS
	// swiperのcssは lull_scripts() で先に読み込んでおく
	//wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.css', array(), '1.0.0');

	//wp_enqueue_style('swiper-css-style', get_template_directory_uri() . '/css/slider.css', array('swiper-style'), '1.0.0');

	// JS
	/*
	 * load in footer
	 */
	wp_enqueue_script('swiper-script', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.js', array(), '1.0.0', true);
	wp_enqueue_script('swiper-js-script', get_template_directory_uri() . '/js/swiper.js', array('swiper-script'), '1.0.0', true);

	// Enqueue debug script if WP_DEBUG is enabled
	// if ( WP_DEBUG ) {
	// 	wp_enqueue_script( 'debug-script', get_template_directory_uri() . '/js/debug.js', array(), '1.0.0', true );
	// }
	// Add inline script to display message in console
	//wp_add_inline_script( 'swiper-js-script', 'console.log("This message is displayed in the console.");' );
}
add_action('wp_enqueue_scripts', 'lull_add_swiper_files');


function lull_get_breadcrumb()
{
	echo '<div itemscope itemtype="https://schema.org/BreadcrumbList">';
	echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
	echo '<a itemprop="item" href="' . home_url() . '"><span itemprop="name">HOME</span></a>';
	echo '<meta itemprop="position" content="1" />';
	echo '</span>';

	if (is_category() || is_single()) {
		echo ' » ';
		if (is_single()) {
			$categories = get_the_category();
			if ($categories) {
				echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
				echo '<a itemprop="item" href="' . get_category_link($categories[0]->term_id) . '">';
				echo '<span itemprop="name">' . $categories[0]->name . '</span></a>';
				echo '<meta itemprop="position" content="2" />';
				echo '</span> » ';
				echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
				echo '<span itemprop="name" style="display:none;">' . get_the_title() . '</span>';
				echo '<meta itemprop="position" content="3" />';
				echo '</span>';
			}
		} else {
			echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			single_cat_title('<span itemprop="name">', '</span>');
			echo '<meta itemprop="position" content="2" />';
			echo '</span>';
		}
	} elseif (is_page()) {
		echo ' » ';
		echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . get_the_title() . '</span>';
		echo '<meta itemprop="position" content="2" />';
		echo '</span>';
	} elseif (is_search()) {
		echo ' » ';
		echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">Search Results for… ' . get_search_query() . '</span>';
		echo '<meta itemprop="position" content="2" />';
		echo '</span>';
	}
	echo '</div>';
}

// function lull_get_breadcrumb() {
//     echo '<a href="' . home_url() . '">HOME</a>';
//     if (is_category() || is_single()) {
//         echo ' » ';
//         the_category(' • ');
//         if (is_single()) {
//             echo ' » ';
//             the_title();
//         }
//     } elseif (is_page()) {
//         echo ' » ';
//         the_title();
//     } elseif (is_search()) {
//         echo ' » Search Results for… <em>';
//         echo get_search_query();
//         echo '</em>';
//     }
// }

function lull_get_sns_buttons()
{
	// 現在の投稿の URL とタイトルを取得
	$url = urlencode(get_permalink());
	$title = urlencode(get_the_title());

	// テーマディレクトリのURLを取得
	$template_directory = get_template_directory_uri();

	// 各 SNS のボタンを生成
	$html = '<div class="sns-buttons-wrapper">';

	// Twitter
	// $html .= '<button id="twitter-button" class="sns-button" data-url="' . $url . '" data-text="' . $title . '" data-lang="ja">';
	$html .= '<a id="twitter-button" class="sns-button" href="https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url . '" target="_blank" rel="noopener noreferrer">';
	$html .= '<img src="' . $template_directory . '/assets/img/svg/twitter.svg" alt="Twitterでシェア">';
	$html .= '</a>';
	// $html .= '</button>';

	// LINE
	// $html .= '<button id="line-button" class="sns-button" data-url="' . $url . '" data-text="' . $title . '" data-lang="ja">';
	$html .= '<a id="line-button" class="sns-button" href="https://social-plugins.line.me/lineit/share?url=' . $url . '" target="_blank" rel="noopener noreferrer">';
	$html .= '<img src="' . $template_directory . '/assets/img/svg/line.svg" alt="LINEでシェア">';
	$html .= '</a>';
	// $html .= '</button>';

	// Pinterest
	// 必要に応じて有効化
	// $html .= '<a href="https://pinterest.com/pin/create/button/?url=' . $url . '&media=' . $media . '&description=' . $title . '" target="_blank" rel="noopener noreferrer">';
	// $html .= '<img src="' . $template_directory . '/images/pinterest-icon.png" alt="Pinterestでシェア">';
	// $html .= '</a>';

	$html .= '</div>';

	// HTML を出力
	echo $html;
}

/*
 * Add index to single page
 * https://u-web-nana.com/function-table-of-contents/ より引用
 */
function lull_add_index($content)
{
    if (is_single()) {
        // 属性がある場合も考慮した正規表現
        $pattern = '/<h[1-6](?:\s+[^>]*)?>(.+?)<\/h[1-6]>/s';
        preg_match_all($pattern, $content, $elements, PREG_SET_ORDER);

        if (count($elements) >= 1) {
            $toc = '';
            $i = 0;
            $currentlevel = 0;
            $id = 'chapter-';

            foreach ($elements as $element) {
                $id .= $i + 1;
                $regex = '/' . preg_quote($element[0], '/') . '/su';
                $replace_title = preg_replace('/<(h[1-6])(?:\s+[^>]*)?>(.+?)<\/(h[1-6])>/s', '<$1 id="' . $id . '">$2</$3>', $element[0], 1);
                $content = preg_replace($regex, $replace_title, $content, 1);

                if (strpos($element[0], '<h2') !== false) {
                    $level = 1;
                } elseif (strpos($element[0], '<h3') !== false) {
                    $level = 2;
                } elseif (strpos($element[0], '<h4') !== false) {
                    $level = 3;
                } elseif (strpos($element[0], '<h5') !== false) {
                    $level = 4;
                } elseif (strpos($element[0], '<h6') !== false) {
                    $level = 5;
                }

                while ($currentlevel < $level) {
                    if (0 === $currentlevel) {
                        $toc .= '<ul class="index__list">';
                    } else {
                        $toc .= '<ul class="index__list_child">';
                    }
                    $currentlevel++;
                }

                while ($currentlevel > $level) {
                    $toc .= '</li></ul>';
                    $currentlevel--;
                }

                $toc .= '<li class="index__item"><a href="#' . $id . '" class="index__link">' . $element[1] . '</a>';
                $i++;
                $id = 'chapter-';
            } // foreach

            while ($currentlevel > 0) {
                $toc .= '</li></ul>';
                $currentlevel--;
            }

            // インラインCSSを追加して目次の表示を改善
            $inline_css = '<style>
            </style>';

            $index = '<div class="single__index index" id="toc"><div class="index__title">Contents</div>' . $inline_css . $toc . '</div>';
            $h2 = '/<h2.*?>/i';

            if (preg_match($h2, $content, $h2s)) {
                $content = preg_replace($h2, $index . $h2s[0], $content, 1);
            }
        }
    }

    // 最後に <hr> を追加
    $content .= '<hr> <p></p>';

    return $content;
}
add_filter('the_content', 'lull_add_index');

/*
 * Add PR Label
 */

function lull_add_pr_label($content)	// $content には投稿の本文が入る
{
	if (is_single()) {
		$pr_label = '<div class="pr-label" style="position: relative; border: 1px solid #ddd; padding: 24px 20px 20px; margin-bottom: 40px; margin-top: 40px;">
			<div style="position: absolute; top: -12px; left: 20px; background: #FDFDFD; padding: 0 10px; font-size: 14px; color: #666;">注意</div>
			<p style="margin: 0; font-size: 14px; line-height: 1.6;">この記事は広告を含む場合があります。</p>
		</div>';

		// Add before TOC
		$index_marker = '<div class="single__index index" id="toc">';
		if (strpos($content, $index_marker) !== false) {
			$content = str_replace($index_marker, $pr_label . $index_marker, $content);
		}
		else {
			$content = $pr_label . $content;
		}
	}
	return $content;
}
add_filter('the_content', 'lull_add_pr_label');

/*
 * Add Author Box
 */
function lull_add_author_box($content)
{
	if (is_single()) {
		$author_id = get_the_author_meta('ID');
		$author_name = get_the_author_meta('display_name');
		$author_description = get_the_author_meta('description');
		$author_avatar = get_avatar($author_id, 80);
		$twitter_url = 'https://x.com/_puro_zzz';

		$author_box = <<<EOD
		<div class="author-box" style="position: relative; border: 1px solid #ddd; padding: 25px 20px 20px; margin-bottom: 40px; margin-top: 40px;">
			<div style="position: absolute; top: -12px; left: 20px; background: #FDFDFD; padding: 0 10px; font-size: 14px; color: #666;">この記事を書いた人</div>
			<div style="display: flex; align-items: center;">
				<div class="author-box__avatar" style="margin-right: 32px; border-radius: 50%; overflow: hidden;">
					$author_avatar
				</div>
				<div class="author-box__content">
					<h3 class="author-box__name" style="margin: 0 0 8px; font-size: 18px; padding: 0;">$author_name</h3>
					<p class="author-box__description" style="margin: 0; font-size: 14px; line-height: 1.6;">$author_description</p>
					<a href="$twitter_url" style="display: inline-block; margin-right: 16px; font-size: 14px;"> X(Twitter) はこちら</a>
				</div>
			</div>
		</div>
		EOD;

		// Add before TOC
		$index_marker = '<div class="single__index index" id="toc">';
		if (strpos($content, $index_marker) !== false) {
			$content = str_replace($index_marker, $author_box . $index_marker, $content);
		}

		// Add at the end of content
		$content .= $author_box;
	}
	return $content;
}
add_filter('the_content', 'lull_add_author_box');
remove_filter('pre_user_description', 'wp_filter_kses');

/* ---------- プロフィール画像を変更する ---------- */
// home_image_urlを取得する関数
if (!function_exists('get_home_image_url')) {
	function get_home_image_url($user_id)
	{
		if (!$user_id) {
			$user_id = get_the_posts_author_id();
		}
		return esc_html(get_the_author_meta('home_image_url', $user_id));
	}
}

// ユーザー情報追加
add_action('show_user_profile', 'add_avatar_to_user_profile_demo');
add_action('edit_user_profile', 'add_avatar_to_user_profile_demo');
if (!function_exists('add_avatar_to_user_profile_demo')) {
	function add_avatar_to_user_profile_demo($user)
	{
		?>
		<h3>プロフィール画像</h3>
		<table class="form-table">
			<tr>
				<th>
					<label for="avatar">プロフィール画像URL</label>
				</th>
				<td>
					<?php generate_upload_image_tag('home_image_url', get_home_image_url($user->ID)); ?>
					<p class="description">Gravatarよりこちらのプロフィール画像が優先されます。240×240pxの正方形の画像がお勧めです。</p>
				</td>
			</tr>
		</table>
		<?php
	}
}

// 入力した値を保存する
add_action('personal_options_update', 'update_avatar_to_user_profile_demo');
if (!function_exists('update_avatar_to_user_profile_demo')) {
	function update_avatar_to_user_profile_demo($user_id)
	{
		if (current_user_can('edit_user', $user_id)) {
			update_user_meta($user_id, 'home_image_url', $_POST['home_image_url']);
		}
	}
}

// プロフィール画像を変更する
add_filter('get_avatar', 'get_uploaded_user_profile_avatar_demo', 1, 5);
if (!function_exists('get_uploaded_user_profile_avatar_demo')) {
	function get_uploaded_user_profile_avatar_demo($avatar, $id_or_email, $size, $default, $alt)
	{
		if (is_numeric($id_or_email))
			$user_id = (int) $id_or_email;
		elseif (is_string($id_or_email) && ($user = get_user_by('email', $id_or_email)))
			$user_id = $user->ID;
		elseif (is_object($id_or_email) && !empty($id_or_email->user_id))
			$user_id = (int) $id_or_email->user_id;

		if (empty($user_id))
			return $avatar;

		if (get_home_image_url($user_id)) {
			$alt = !empty($alt) ? $alt : get_the_author_meta('display_name', $user_id);
			;
			$author_class = is_author($user_id) ? ' current-author' : '';
			$avatar = "<img alt='" . esc_attr($alt) . "' src='" . esc_url(get_home_image_url($user_id)) . "' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";
		}
		return $avatar;
	}
}

/* ---------- 画像アップローダーの追加 ---------- */
// 画像アップロード用のタグを出力する
function generate_upload_image_tag($name, $value)
{ ?>
	<input name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" />
	<input type="button" name="<?php echo $name; ?>_slect" value="選択" class="button" />
	<input type="button" name="<?php echo $name; ?>_clear" value="クリア" class="button" />
	<div id="<?php echo $name; ?>_thumbnail" class="uploded-thumbnail">
		<?php if ($value): ?>
			<img src="<?php echo $value; ?>" alt="選択中の画像">
		<?php endif ?>
	</div>

	<script type="text/javascript">
		(function ($) {
			var custom_uploader;

			$("input:button[name=<?php echo $name; ?>_slect]").click(function (e) {
				e.preventDefault();

				if (custom_uploader) {
					custom_uploader.open();
					return;
				}

				custom_uploader = wp.media({
					title: "画像を選択してください",
					/* ライブラリの一覧は画像のみにする */
					library: {
						type: "image"
					},
					button: {
						text: "画像の選択"
					},
					/* 選択できる画像は 1 つだけにする */
					multiple: false
				});

				custom_uploader.on("select", function () {
					var images = custom_uploader.state().get("selection");

					/* file の中に選択された画像の各種情報が入っている */
					images.each(function (file) {
						/* テキストフォームと表示されたサムネイル画像があればクリア */
						$("input:text[name=<?php echo $name; ?>]").val("");
						$("#<?php echo $name; ?>_thumbnail").empty();
						/* テキストフォームに画像の URL を表示 */
						$("input:text[name=<?php echo $name; ?>]").val(file.attributes.sizes.full.url);
						/* プレビュー用に選択されたサムネイル画像を表示 */
						$("#<?php echo $name; ?>_thumbnail").append('<img src="' + file.attributes.sizes.full.url + '" />');
					});
				});
				custom_uploader.open();
			});

			/* クリアボタンを押した時の処理 */
			$("input:button[name=<?php echo $name; ?>_clear]").click(function () {
				$("input:text[name=<?php echo $name; ?>]").val("");
				$("#<?php echo $name; ?>_thumbnail").empty();
			});
		})(jQuery);
	</script>
	<?php
}

//メディアアップローダの javascript API
function my_admin_scripts()
{
	wp_enqueue_media();
}
add_action('admin_print_scripts', 'my_admin_scripts');

/*
 * Add noindex meta box
 */
function lull_manage_noindex_meta_box()
{
	add_meta_box(
		'noindex_meta_box',        // ID
		'SEO設定: noindex',        // タイトル
		'lull_noindex_meta_box_cb',// コールバック関数 (メタボックスの内容)
		['post', 'page'],          // 対象投稿タイプ (投稿と固定ページ)
		'side',                    // 表示位置 (サイド)
		'default'                  // 優先度
	);
}
add_action('add_meta_boxes', 'lull_manage_noindex_meta_box');

function lull_noindex_meta_box_cb($post)
{
	$value = get_post_meta($post->ID, '_noindex_meta_key', true); // 既存の値を取得
	// Nonceフィールドを追加
	wp_nonce_field('noindex_meta_action', 'noindex_meta_nonce');
	?>
	<label for="noindex_meta">
		<input type="checkbox" name="noindex_meta" id="noindex_meta" value="1" <?php checked($value, '1'); ?> />
		この投稿をnoindexにする
	</label>
	<?php
}

function lull_save_noindex_meta($post_id)
{
	// Nonce確認
	if (
		!isset($_POST['noindex_meta_nonce']) ||
		!wp_verify_nonce($_POST['noindex_meta_nonce'], 'noindex_meta_action')
	) {
		return;
	}

	// 自動保存の場合は何もしない
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	// 権限を確認
	if (!current_user_can('edit_post', $post_id))
		return;

	// フィールドが送信されている場合に保存、されていなければ削除
	if (isset($_POST['noindex_meta'])) {
		update_post_meta($post_id, '_noindex_meta_key', '1');
	} else {
		delete_post_meta($post_id, '_noindex_meta_key');
	}
}
add_action('save_post', 'lull_save_noindex_meta');

function lull_add_noindex_meta_tag()
{
	if (is_singular()) {
		$noindex = get_post_meta(get_the_ID(), '_noindex_meta_key', true);
		if ($noindex) {
			echo '<meta name="robots" content="noindex">';
		}
	}
}
add_action('wp_head', 'lull_add_noindex_meta_tag');

/*
 * Add description meta box
 */

function lull_manage_meta_boxes()
{
	add_meta_box(
		'meta_boxes',             // ID
		'SEO設定: Meta情報',      // タイトル
		'lull_meta_boxes_cb',     // コールバック関数
		['post', 'page'],         // 対象投稿タイプ
		'side',                   // 表示位置
		'default'                 // 優先度
	);
}
add_action('add_meta_boxes', 'lull_manage_meta_boxes');

function lull_meta_boxes_cb($post)
{
	// 既存の値を取得
	$description = get_post_meta($post->ID, '_meta_description', true);
	$keywords = get_post_meta($post->ID, '_meta_keywords', true);

	// Nonceフィールドを追加
	wp_nonce_field('meta_boxes_action', 'meta_boxes_nonce');

	?>
	<p>
		<label for="meta_description">Meta Description:</label><br>
		<textarea name="meta_description" id="meta_description" rows="3"
			style="width:100%;"><?php echo esc_textarea($description); ?></textarea>
	</p>
	<p>
		<label for="meta_keywords">Meta Keywords:</label><br>
		<input type="text" name="meta_keywords" id="meta_keywords" value="<?php echo esc_attr($keywords); ?>"
			style="width:100%;" />
	</p>
	<?php
}

function lull_save_meta_boxes($post_id)
{
	// Nonce確認
	if (
		!isset($_POST['meta_boxes_nonce']) ||
		!wp_verify_nonce($_POST['meta_boxes_nonce'], 'meta_boxes_action')
	) {
		return;
	}

	// 自動保存の場合は何もしない
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	// 権限を確認
	if (!current_user_can('edit_post', $post_id))
		return;

	// Meta Descriptionを保存
	if (isset($_POST['meta_description'])) {
		update_post_meta($post_id, '_meta_description', sanitize_textarea_field($_POST['meta_description']));
	} else {
		delete_post_meta($post_id, '_meta_description');
	}

	// Meta Keywordsを保存
	if (isset($_POST['meta_keywords'])) {
		update_post_meta($post_id, '_meta_keywords', sanitize_text_field($_POST['meta_keywords']));
	} else {
		delete_post_meta($post_id, '_meta_keywords');
	}
}
add_action('save_post', 'lull_save_meta_boxes');

function lull_add_meta_tags()
{
	if (is_singular()) {
		// Meta Description
		$description = get_post_meta(get_the_ID(), '_meta_description', true);
		if ($description) {
			echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
		}

		// Meta Keywords
		$keywords = get_post_meta(get_the_ID(), '_meta_keywords', true);
		if ($keywords) {
			echo '<meta name="keywords" content="' . esc_attr($keywords) . '">' . "\n";
		}
	}
}
add_action('wp_head', 'lull_add_meta_tags');


/*
 * Register Archive URL
 */

function lull_post_has_archive($args, $post_type)
{
	if ('post' == $post_type) {
		$args['rewrite'] = true;
		$args['has_archive'] = 'archive';
	}
	return $args;
}
add_filter('register_post_type_args', 'lull_post_has_archive', 10, 2);


/*
 * Register Widget Area
 */


function lull_article_widget_init()
{
	// register_sidebar( array(
	// 	'name'=> 'Article Bottom', 
	// 	'id'=> 'article-bottom',
	// 	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	// 	'after_widget' => '</div>',
	// 	'before_title' => '<h4 class="widget-title">',
	// 	'after_title' => '</h4>',
	// ) );
	register_sidebar(
		array(
			'name' => esc_html__('Article Top', 'lull'),
			'id' => 'article-top',
			'description' => esc_html__('Add widgets here.', 'lull'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name' => esc_html__('Article Bottom', 'lull'),
			'id' => 'article-bottom',
			'description' => esc_html__('Add widgets here.', 'lull'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		)
	);
}
add_action('widgets_init', 'lull_article_widget_init');


/*
 * O
 */
function lull_add_fade_effect_script()
{
	?>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			// .fade-effectクラスを持つ要素を取得
			const fadeInElements = document.querySelectorAll(".fade-effect-heading");

			// IntersectionObserverを使用して要素を監視
			const observer = new IntersectionObserver(
				(entries, observer) => {
					entries.forEach((entry) => {
						if (entry.isIntersecting) {
							entry.target.classList.add("effect-active");
							observer.unobserve(entry.target); // 一度だけ実行
						}
					});
				},
				{
					threshold: 1, // 25%表示されたら実行
				}
			);

			// 各要素を監視対象に追加
			fadeInElements.forEach((element) => observer.observe(element));
		});
	</script>
	<?php
}
add_action('wp_footer', 'lull_add_fade_effect_script');


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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

