<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

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

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );








/**
 * B.R.Online用カスタム
 */
date_default_timezone_set('Asia/Tokyo');



/**
 * 表示カウントアップ
 * @param unknown $postId	：投稿ID
 */
function postViewCountUp( $postId ) {
	$meta_key = 'view_count';

	$count = get_post_meta( $postId, $meta_key, true ) ;

	if( $count == '' ) {
		// データがないは初期値として 1 を設定
		//delete_post_meta( $postId, $meta_key );
		add_post_meta( $postId, $meta_key, '1' );

	} else {
		update_post_meta( $postId, $meta_key, ++$count);
	}
}



// 記事へ画像挿入時のサイズタグ自動挿入をしないようにする
function remove_image_attribute( $html ){
	$html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
	return $html;
}
add_filter( 'image_send_to_editor', 'remove_image_attribute', 10 );
add_filter( 'post_thumbnail_html', 'remove_image_attribute', 10 );




/**
 * B.R.ONLINE 記事一覧の取得
 * @param array $params
 * 	パラメータは未設定の場合、defaultが適用されます
 * 	ショップでの絞り込みはタグで行います。
 * 		$params["per_page"]		= １ページの表示レコード数 default:12
 * 		$params["page"] 		= 取得ページ default:1
 * 		$params["in_id"] 		= 取得IDをカンマ区切りで設定、本パラメータが設定されている場合、以下条件は無視されます。
 * 									ソートはカンマ区切りで並んでいる順になります。
 *
 * 		$params["type"]			= 投稿タイプ "feature|editorschoice|stylesnap|news" default:"post"　複数の場合はカンマ区切り
 * 		$params["user"]			= 投稿ユーザーID default:""(全ユーザー対象)　複数の場合はカンマ区切り
 * 		$params["tag"]			= タグ名 default:""(全タグ対象)　複数の場合はカンマ区切り
 * 		$params["word"]			= キーワード default:""　複数の場合はスペース区切り
 * 		$params["pr"]			= PRフラグ 0|1 default:""
 * 		$params["pickup"]		= PICKUPフラグ 0|1 default:""　PICK UP=1の場合、表示順はPICK UP表示順の昇順($params["order"]は無視されます)
 * 		$params["global"]		= グローバル表示フラグ 0|1 default:""　1のとき、flg_noglobal=1のものも取得してくる
 * 		$params["from_date"]	= 取得開始投稿日 "YYYY-MM-DD" default:""
 * 		$params["to_date"]		= 取得終了投稿日 "YYYY-MM-DD" default:""
 * 		$params["serise"]		= シリーズ default:""(全シリーズ対象)　複数不可
 * 		$params["not_id"]		= 除外投稿ID　複数不可
 * 		$params["order"]		= 表示順 "rank" default:""(新着順)
 * 		$params["order_dir"]	= 表示順方向 "asc|desc" default:"desc"(降順)
 *
 *
 * @return array $arrResult
 * 		$arrResult["arrPosts"] 		= 取得データ配列
 * 		$arrResult["recordNum"]		= 今回取得レコード数
 * 		$arrResult["maxRecordNum"]	= 最大取得レコード数
 * 		$arrResult["pageNum"]		= 現在ページ
 * 		$arrResult["maxPageNum"]	= 最大ページ数
 */
function get_br_posts( $params = array() ) {
	global $wpdb;

	/*
	echo "<pre>";
	print_r($params);
	echo "</pre>";
	*/

	// デフォルト設定
	$post_per_page = 12;	// １ページの表示レコード数
	$page = 1;				// 取得ページ
	$post_type = "post";	// 投稿タイプ
	$order_dir = "desc";	// ソート方向

	// １ページの表示レコード数
	if( isset($params['per_page'])) {
		$post_per_page = $params['per_page'];
	}

	// 取得ページ
	if( isset($params['page'])) {
		$page = $params['page'];
	}

	// 投稿タイプ
	if( isset($params['type']) ) {
		$post_type = $params['type'];
	}

	// ソート方向
	if( isset($params['order_dir']) ) {
		$order_dir = $params['order_dir'];
	}


	$arrBindValue = array();

	$sql  = "SELECT SQL_CALC_FOUND_ROWS ";
	$sql .= " p.*, pm1.meta_value AS view_count ";
	$sql .= " ,pm2.meta_value AS title2 ";
	$sql .= " ,pm3.meta_value AS serise ";
	$sql .= " ,pm4.meta_value AS pr ";
	$sql .= " ,pm5.meta_value AS pickup ";
	$sql .= " ,p2.guid AS thumb_url ";

	$sql .= " ,um1.meta_value AS last_name ";
	$sql .= " ,um2.meta_value AS first_name ";
	$sql .= " ,um3.meta_value AS nickname ";
	$sql .= " ,um4.meta_value AS flg_shop ";
	$sql .= " ,p5.post_name AS shop_url ";
	$sql .= " ,p5.post_title AS shop_name ";

	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'view_count') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'title2') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm3 ON (p.ID = pm3.post_id AND pm3.meta_key = 'serise') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm4 ON (p.ID = pm4.post_id AND pm4.meta_key = 'flg_pr') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm5 ON (p.ID = pm5.post_id AND pm5.meta_key = 'flg_pickup') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm6 ON (p.ID = pm6.post_id AND pm6.meta_key = 'pickup_disp_no') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm7 ON (p.ID = pm7.post_id AND pm7.meta_key = 'credit') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm8 ON (p.ID = pm8.post_id AND pm8.meta_key = '_thumbnail_id') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm9 ON (p.ID = pm9.post_id AND pm9.meta_key = 'main_image') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm10 ON (p.ID = pm10.post_id AND pm10.meta_key = 'flg_noglobal') ";
	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm8.meta_value = p2.ID) ";	// アイキャッチ画像
	$sql .= " LEFT JOIN $wpdb->posts AS p4 ON (pm9.meta_value = p4.ID) ";	// メイン画像

	$sql .= " LEFT JOIN $wpdb->users AS u ON (p.post_author = u.ID) ";
	$sql .= " LEFT JOIN $wpdb->usermeta AS um1 ON (u.ID = um1.user_id AND um1.meta_key = 'last_name' ) ";
	$sql .= " LEFT JOIN $wpdb->usermeta AS um2 ON (u.ID = um2.user_id AND um2.meta_key = 'first_name' ) ";
	$sql .= " LEFT JOIN $wpdb->usermeta AS um3 ON (u.ID = um3.user_id AND um3.meta_key = 'nickname' ) ";
	$sql .= " LEFT JOIN $wpdb->usermeta AS um4 ON (u.ID = um4.user_id AND um4.meta_key = 'flg_shop' ) ";
	$sql .= " LEFT JOIN $wpdb->usermeta AS um5 ON (u.ID = um5.user_id AND um5.meta_key = 'shop' ) ";
	$sql .= " LEFT JOIN $wpdb->posts AS p5 ON (um5.meta_value = p5.ID) ";	// ショップ情報

	$sql .= " WHERE p.post_status = 'publish' ";

	// 取得ID
	if( isset($params['in_id'])) {
		$sql .= " AND p.ID IN ( ".$params['in_id']." ) ";
		$sql .= " GROUP BY p.ID ";
		$sql .= " ORDER BY FIELD ( p.ID, ".$params['in_id']. " ) ";

	} else {

		// 除外
		if( isset($params['not_id'])) {
			$sql .= " AND p.ID != %d ";
			$arrBindValue[] = $params['not_id'];
		}

		$sql .= " AND ( ";

		// 投稿タイプ
		$arr_post_type = explode(",",  $post_type);
		$str_post_type = "";
		foreach ( $arr_post_type as $type ) {
			if( $str_post_type != "" ) {
				$str_post_type .= " OR ";
			}
			$str_post_type .= " p.post_type = %s ";
			$arrBindValue[] = $type;
		}
		$sql .= " ( ".$str_post_type." ) ";


		// 投稿ユーザー
		if( isset($params['user'])) {
			$arr_post_user = explode(",",  $params["user"]);
			$str_post_user = "";
			foreach ( $arr_post_user as $user_id ) {
				if( $str_post_user != "" ) {
					$str_post_user .= " OR ";
				}
				$str_post_user .= " p.post_author = %d ";
				$arrBindValue[] = $user_id;
			}
			$sql .= " AND ( ".$str_post_user." ) ";
		}


		// 投稿日（開始）
		if( isset($params['from_date'])) {
			$sql .= " AND p.post_date >= %s ";
			$arrBindValue[] = $params['from_date']." 00:00:00";
		}


		// 投稿日（終了）
		if( isset($params['to_date'])) {
			$sql .= " AND p.post_date <= %s ";
			$arrBindValue[] = $params['to_date']." 23:59:59";
		}


		// PRフラグ
		if( isset($params['pr'])) {
			$sql .= " AND pm4.meta_value = %s ";
			$arrBindValue[] = $params['pr'];
		}


		// PICK UPフラグ
		if( isset($params['pickup'])) {
			$sql .= " AND pm5.meta_value = %s ";
			$arrBindValue[] = $params['pickup'];
		}

		// グローバルフラグ（設定されていない場合、グローバル表示フラグが設定されていないものを抽出）
		if( !isset($params['global'])) {
			$sql .= " AND (pm10.meta_value != 1 || pm10.meta_value IS NULL) ";
		}

		// シリーズ
		if( isset($params['serise'])) {
			$sql .= " AND pm3.meta_value = %s ";
			$arrBindValue[] = $params['serise'];
		}


		// タグ
		if( isset($params['tag'])) {
			if( is_array($params['tag'])) {
				$arr_tag = $params['tag'];
			} else {
				$strTag = mb_convert_encoding($params["tag"], 'UTF-8', 'auto');
				$arr_tag = explode(" ",  $strTag);
			}
 			$str_tag = "";
			foreach ( $arr_tag as $tag ) {
				if( $str_tag != "" ) {
					//$str_tag .= " OR ";
					$str_tag .= " AND ";
				}

				$str_tag .= " EXISTS ( ";
				$str_tag .= "	SELECT * FROM $wpdb->term_relationships AS tr ";
				$str_tag .= "	LEFT JOIN $wpdb->terms AS t ON tr.term_taxonomy_id = t.term_id ";
				$str_tag .= "	WHERE tr.object_id = p.ID AND t.name = %s ";
				$str_tag .= " ) ";

				$arrBindValue[] = $tag;
			}
			$sql .= " AND ( ".$str_tag." ) ";
		}


		// キーワード
		if( isset($params['word'])) {
			$strWord = mb_convert_encoding($params["word"], 'UTF-8', 'auto');
			$strWord = mb_ereg_replace("　", " ", $strWord);
			$arr_words = explode(" ",  $strWord);
			$str_words = "";
			foreach ( $arr_words as $word ) {
				if( $str_words != "" ) {
					$str_words .= " OR ";
				}
				$str_words .= " ( ";
				$str_words .= " 	p.post_title LIKE %s ";			// タイトル
				$str_words .= " 	OR p.post_content LIKE %s ";	// 本文
				$str_words .= " 	OR pm2.meta_value LIKE %s ";	// サブタイトル
				$str_words .= " 	OR pm7.meta_value LIKE %s ";	// クレジット
				$str_words .= " 	OR p2.post_title LIKE %s ";		// アイキャッチ画像
				$str_words .= " 	OR p4.post_title LIKE %s ";		// メイン画像
				$str_words .= " 	OR EXISTS ( ";					// タグ名
				$str_words .= "			SELECT * FROM $wpdb->term_relationships AS tr ";
				$str_words .= "			LEFT JOIN $wpdb->terms AS t ON tr.term_taxonomy_id = t.term_id ";
				$str_words .= "			WHERE tr.object_id = p.ID AND t.name LIKE %s ";
				$str_words .= " 	) ";
				$str_words .= " 	OR EXISTS ( ";					// 挿入画像（WPのメディアで記事と関連づいているもの１つのみ）
				$str_words .= "			SELECT * FROM $wpdb->posts AS p3 ";
				$str_words .= "			WHERE p3.post_type = 'attachment' AND p3.post_parent = p.ID AND p3.post_title LIKE %s ";
				$str_words .= " 	) ";
				$str_words .= " 	OR EXISTS ( ";					// 本文２ページ目以降のタイトルと本文
				$str_words .= "			SELECT * FROM $wpdb->postmeta AS pm_inner ";
				$str_words .= "			WHERE pm_inner.post_id = p.ID AND pm_inner.meta_key LIKE 'inner_page_%' AND pm_inner.meta_value LIKE %s ";
				$str_words .= " 	) ";
				$str_words .= " ) ";

				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
				$arrBindValue[] = "%".$word."%";
			}
			$sql .= " AND ( ".$str_words." ) ";
		}

		$sql .= " ) ";


		// 記事IDでグループ化
		$sql .= " GROUP BY p.ID ";


		// ソート条件
		$sql .= " ORDER BY ";
		if( isset($params['pickup']) && $params['pickup'] == "1" ) {
			// PICK UP表示順
			$order =  " LPAD(pm6.meta_value, 6, 0) ASC, p.post_date ".$order_dir;
		} else {
			// PICK UP以外
			$order = " p.post_date ".$order_dir;
			if( isset($params['order'])) {
				if( $params['order'] == 'rank') {
					$order =  " LPAD(pm1.meta_value, 6, 0) ".$order_dir.",".$order;
				}
			}
		}
		$sql .= $order;
	}

	// 取得ページ
	$offset = ($page -1) * $post_per_page;
	$sql  .= " LIMIT ".$offset.", ".$post_per_page;

/*
	echo "<br/>".$sql;
	echo "<pre>";
//	print_r($arrBindValue);
	echo "</pre>";
*/

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	//echo "<br/>".$query;
	$results = $wpdb->get_results( $query, ARRAY_A );
	$count = $wpdb->num_rows;

	// LIMIT無しでのレコード数取得
	$maxCount = $wpdb->get_var( "SELECT FOUND_ROWS()" );


	// 戻り値加工
	foreach ( $results as &$row ) {
		// 本文のHTMLタグを除去して80文字を返す
		$row['content_excerpt'] = mb_substr(wp_strip_all_tags( $row['post_content'] ), 0, 80);
	}


	// 戻り値設定
	$arrResult = array();
	$arrResult["arrPosts"] = $results;
	$arrResult["recordNum"] = $count;
	$arrResult["maxRecordNum"] = $maxCount;
	$arrResult["pageNum"] = $page;
	$arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

	return $arrResult;
}



/**
 * B.R.ONLINE ユーザー一覧の取得
 * @param array $params
 * 	パラメータは未設定の場合、defaultが適用されます
 * 	管理者（ユーザーレベル=10）以外を取得します
 * 		$params["per_page"]		= １ページの表示レコード数 default:12
 * 		$params["page"] 		= 取得ページ default:1
 * 		$params["shop"] 		= ショップアカウント 0|1 default:""(全アカウント)
 * 		$params["shop_url"] 	= ショップURL default:""　複数不可
 * 		$params["word"] 		= キーワード default:""　複数の場合はスペース区切り
 *		$params["blogmember"]	= ブログメンバー一覧時 1
 *
 * @return array $arrResult
 * 		$arrResult["arrPosts"] 		= 取得データ配列
 * 		$arrResult["recordNum"]		= 今回取得レコード数
 * 		$arrResult["maxRecordNum"]	= 最大取得レコード数
 * 		$arrResult["pageNum"]		= 現在ページ
 * 		$arrResult["maxPageNum"]	= 最大ページ数
 */
function get_br_users( $params = array() ) {
	global $wpdb;

	// デフォルト設定
	$post_per_page = 12;	// １ページの表示レコード数
	$page = 1;				// 取得ページ


	// １ページの表示レコード数
	if( isset($params['per_page'])) {
		$post_per_page = $params['per_page'];
	}

	// 取得ページ
	if( isset($params['page'])) {
		$page = $params['page'];
	}


	$arrBindValue = array();

	$sql  = "SELECT SQL_CALC_FOUND_ROWS ";
	$sql .= " u.* ";
	$sql .= " ,u2.post_title AS shop_name ";
	$sql .= " ,u2.post_name AS shop_url ";
	$sql .= " ,um2.meta_value AS nickname ";
	$sql .= " ,um3.meta_value AS first_name ";
	$sql .= " ,um4.meta_value AS last_name ";
	$sql .= " ,COALESCE(um5.meta_value, '0') AS flg_shop ";
	$sql .= " ,um6.meta_value AS name_en ";
	$sql .= " ,um7.meta_value AS list_degree ";
	$sql .= " ,u3.guid AS image_url ";
	$sql .= " ,p.ID AS last_id ";
	$sql .= " ,p.post_date AS last_date ";

	$sql .= "FROM $wpdb->users AS u ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um1 ON (u.ID = um1.user_id AND um1.meta_key = 'shop' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um2 ON (u.ID = um2.user_id AND um2.meta_key = 'nickname' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um3 ON (u.ID = um3.user_id AND um3.meta_key = 'first_name' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um4 ON (u.ID = um4.user_id AND um4.meta_key = 'last_name' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um5 ON (u.ID = um5.user_id AND um5.meta_key = 'flg_shop' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um6 ON (u.ID = um6.user_id AND um6.meta_key = 'name_en' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um7 ON (u.ID = um7.user_id AND um7.meta_key = 'list_degree' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um8 ON (u.ID = um8.user_id AND um8.meta_key = 'wp_user_avatar' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um9 ON (u.ID = um9.user_id AND um9.meta_key = 'wp_user_level' ) ";
	$sql .= "LEFT JOIN $wpdb->posts AS u2 ON (um1.meta_value = u2.ID) ";	// ショップ情報
	$sql .= "LEFT JOIN $wpdb->posts AS u3 ON (um8.meta_value = u3.ID) ";	// 画像情報

	$sql .= "LEFT JOIN ( ";		// 最新記事と、その投稿ID
	$sql .= "	SELECT last_post1.ID, last_post1.post_date, last_post1.post_author ";
	$sql .= "	FROM $wpdb->posts AS last_post1 ";
	$sql .= "	INNER JOIN ( ";
	$sql .= "		SELECT post_author, max(post_date) AS max_date ";
	$sql .= "		FROM $wpdb->posts ";
	$sql .= " 		WHERE post_status = 'publish' ";
	if( isset($params['blogmember'])) {
		$sql .= "		AND post_type IN ('post') ";
	} else {
		$sql .= "		AND post_type IN ('post', 'feature', 'editorschoice', 'stylesnap', 'news') ";
	}
	$sql .= "		GROUP BY post_author ";
	$sql .= "	) AS last_post2 ON ( last_post1.post_author = last_post2.post_author AND last_post1.post_date = last_post2.max_date ) ";
	$sql .= " 	WHERE last_post1.post_status = 'publish' ";
	$sql .= ") AS p ON (u.ID = p.post_author ) ";

	$sql .= " WHERE u.user_status = 0 ";
	$sql .= " AND um9.meta_value != 10 ";		// 管理者以外

	// ショップアカウントフラグ
	if( isset($params['shop'])) {
		$sql .= " AND um5.meta_value = %s ";
		$arrBindValue[] = $params['shop'];
	}

	// ショップURL
	if( isset($params['shop_url'])) {
		$sql .= " AND u2.post_name = %s ";
		$arrBindValue[] = $params['shop_url'];
	}


	// キーワード
	if( isset($params['word'])) {
		$strWord = mb_convert_encoding($params["word"], 'UTF-8', 'auto');
		$strWord = mb_ereg_replace("　", " ", $strWord);
		$arr_words = explode(" ",  $strWord);
		$str_words = "";
		foreach ( $arr_words as $word ) {
			if( $str_words != "" ) {
				$str_words .= " OR ";
			}
			$str_words .= " ( ";
			$str_words .= " 	u2.post_title LIKE %s ";		// ショップ名
			$str_words .= " 	OR um2.meta_value LIKE %s ";	// ニックネーム
			$str_words .= " 	OR um3.meta_value LIKE %s ";	// 名
			$str_words .= " 	OR um4.meta_value LIKE %s ";	// 姓
			$str_words .= " ) ";

			$arrBindValue[] = "%".$word."%";
			$arrBindValue[] = "%".$word."%";
			$arrBindValue[] = "%".$word."%";
			$arrBindValue[] = "%".$word."%";
		}
		$sql .= " AND ( ".$str_words." ) ";
	}


	// ソート条件
	$sql .= " ORDER BY display_name ASC ";

	// 取得ページ
	$offset = ($page -1) * $post_per_page;
	$sql  .= " LIMIT ".$offset.", ".$post_per_page;

/*
	echo "<br/>".$sql;
	echo "<pre>";
	print_r($arrBindValue);
	echo "</pre>";
*/

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	//echo "<br/>".$query;
	$results = $wpdb->get_results( $query, ARRAY_A );
	$count = $wpdb->num_rows;

	// LIMIT無しでのレコード数取得
	$maxCount = $wpdb->get_var( "SELECT FOUND_ROWS()" );

/*
	echo "<pre>";
	print_r($results);
	echo "</pre>";
*/

	// 戻り値設定
	$arrResult = array();
	$arrResult["arrUsers"] = $results;
	$arrResult["recordNum"] = $count;
	$arrResult["maxRecordNum"] = $maxCount;
	$arrResult["pageNum"] = $page;
	$arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

	return $arrResult;
}



/**
 * BLOG LIST（記事一覧）の取得
 *
 * @param number $per_page		１ページの表示件数
 * @param number $page			取得ページ
 * @param string $shop_name		ショップ名（タグ名）
 * @param string $user_id		ユーザーID（複数の場合はカンマ区切り）
 * @return array				取得結果
 */

function get_blog_article_list( $per_page = 12, $page = 1, $shop_name = "", $user_id = "" ) {
	$params = array();
	$params['per_page'] = $per_page;
	$params['page'] = $page;
	if( $shop_name != "" ) {
		$params["tag"] = $shop_name;
	}
	if( $user_id != "" ) {
		$params["user"] = $user_id;
	}

	return get_br_posts($params);
}


/**
 * BLOG 詳細ページの関連ブログ
 *
 * @param number $user_id	取得するブログの投稿者ID
 * @param number $page		取得ページ
 * @return array			取得結果
 */

function get_blog_related_list( $user_id, $per_page = 3, $page = 1 ) {
	$params = array();
	$params['user'] = $user_id;
	$params['per_page'] = $per_page;
	$params['page'] = $page;

	return get_br_posts($params);
}


/**
 * BLOG LIST（著者一覧）ページの著者　取得
 *
 * @return array		取得結果
 */
function get_blog_member_list() {
	$params = array();
	$params['per_page'] = 9999;		// 全件取得
	$params["blogmember"] = 1;		// 著者一覧

	return get_br_users($params);
}


/**
 * ユーザー情報を取得
 *
 * @param string $shop_url		ショップURL
 * @param number $flg_shop		ショップアカウントフラグ
 * @return array				取得結果
 */
function get_shop_user_list( $shop_url = "", $flg_shop = "") {
	$params = array();
	$params['per_page'] = 9999;		// 全件取得
	if( $flg_shop != "" ) {
		$params['shop'] = $flg_shop;
	}
	if( $shop_url != "" ) {
		$params['shop_url'] = $shop_url;
	}

	return get_br_users($params);
}











/**
 * PICK UPの取得
 *
 * @return array		取得結果
 */
function get_pickup() {
	$params = array();
	$params['type'] = "feature";
	$params['pickup'] = 1;

	return get_br_posts($params);
}



/**
 * Attention（最新ニュース）の取得
 *
 * @return array		取得結果
 */
function get_attention() {
	return get_news_list( 999, 1, 1 );
}



/**
 * FEATURE一覧の取得
 *
 * @param number $per_page		１ページの表示件数
 * @param number $page			取得ページ
 * @param string $order			表示順
 * @param string $shop_name		ショップ名（タグ名）
 * @param string $user_id		ユーザーID（複数の場合はカンマ区切り）
 * @param number $global		グローバル表示有無
 *
 * @return array				取得結果
 */
function get_feature_list( $per_page = 12, $page = 1, $order = "", $shop_name = "", $user_id = "", $global = 0) {
	$params = array();
	$params['type'] = "feature";
	$params['page'] = $page;
	$params['per_page'] = $per_page;
	$params['order'] = $order;
	if( $shop_name != "" ) {
		$params["tag"] = $shop_name;	// ショップ名はタグで検索
	}
	if( $user_id != "" ) {
		$params["user"] = $user_id;
	}
	if( $global != 0 ) {
		$params["global"] = $global;
	}

	return get_br_posts($params);
}


/**
 * FEATURE 関連記事一覧の取得
 * 	１．同一シリーズ
 *  ２．タグ上位４つが全て含まれているもの
 *
 * @param string $serise	シリーズ
 * @param string $tag		タグ（カンマ区切り）
 * @param number $per_page	１ページの表示件数
 * @param number $page		取得ページ
 * @param number $global	グローバル表示有無
 *
 * @return array			取得結果
 */
function get_feature_related_list( $serise, $tag, $per_page = 12, $page = 1, $global = 0) {
	$arrIds = array();

	// 同一シリーズの記事IDを取得
	$params = array();
	$params['type'] = "feature";
	$params['serise'] = $serise;
	$params['per_page'] = 999;
	if( $global != 0 ) {
		$params["global"] = $global;
	}

	$resultSeries = get_br_posts($params);
	foreach ( $resultSeries["arrPosts"] as $post ) {
		if( !in_array($post["ID"], $arrIds)) {
			$arrIds[] = $post["ID"];
		}
	}

	/*
	echo "<pre>";
	print_r($arrIds);
	echo "</pre>";
	*/

	// タグ上位３つが全て含まれているものの記事IDを取得
	$params = array();
	$params['type'] = "feature";
	$params['tag'] = $tag;
	$params['per_page'] = 999;

	$resultTags = get_br_posts($params);
	foreach ( $resultTags["arrPosts"] as $post ) {
		if( !in_array($post["ID"], $arrIds)) {
			$arrIds[] = $post["ID"];
		}
	}

	/*
	echo "<pre>";
	print_r($arrIds);
	echo "</pre>";
	*/

	// 取得したIDで一覧を取得
	$params = array();
	$params['per_page'] = 3;
	$params['page'] = $page;
	$params['in_id'] = implode( ",", $arrIds);

	return get_br_posts($params);
}



/**
 * STYLE SNAP一覧の取得
 *
 * @param number $per_page		１ページの表示件数
 * @param number $page			取得ページ
 * @param string $shop_name		ショップ名（タグ名）
 * @param string $user_id		ユーザーID（複数の場合はカンマ区切り）
 * @return array				取得結果
 */
function get_style_snap_list( $per_page = 30, $page = 1, $shop_name = "", $user_id = "" ) {
	$params = array();
	$params['type'] = "stylesnap";
	$params['page'] = $page;
	$params['per_page'] = $per_page;
	if( $shop_name != "" ) {
		$params["tag"] = $shop_name;	// ショップ名はタグで検索
	}
	if( $user_id != "" ) {
		$params["user"] = $user_id;
	}

	return get_br_posts($params);
}


/**
 * STYLE SNAPの関連記事取得
 * 		$post_per_page			= １ページの表示レコード数
 * 		$page 					= 取得ページ
 * 		$user_id				= ユーザーID（複数の場合はカンマ区切り）
 *
 * @return array		取得結果
 */
function get_style_snap_related_list( $per_page = 5, $page = 1, $user_id = "" ) {
	$params = array();
	$params['type'] = "stylesnap";
	$params['page'] = $page;
	$params['per_page'] = $per_page;
	if( $user_id != "" ) {
		$params["user"] = $user_id;
	}

	return get_br_posts($params);
}





/**
 * EDITORS CHOICE一覧の取得
 *
 * @param number $per_page		１ページの表示件数
 * @param number $page			取得ページ
 * @param string $shop_name		ショップ名（タグ名）
 * @param string $user_id		ユーザーID（複数の場合はカンマ区切り）
 * @return array				取得結果
 */
function get_editors_choice_list( $per_page = 30, $page = 1, $shop_name = "", $user_id = "" ) {
	$params = array();
	$params['type'] = "editorschoice";
	$params['page'] = $page;
	$params['per_page'] = $per_page;
	if( $shop_name != "" ) {
		$params["tag"] = $shop_name;
	}
	if( $user_id != "" ) {
		$params["user"] = $user_id;
	}

	return get_br_posts($params);
}


/**
 * EDITORS CHOICEの関連記事取得
 * @param array $params
 * 		$post_per_page			= １ページの表示レコード数
 * 		$page 					= 取得ページ
 * 		$user_id				= ユーザーID（複数の場合はカンマ区切り）
 *
 * @return array		取得結果
 */
function get_editors_choice_related_list( $per_page = 5, $page = 1, $user_id = "" ) {
	$params = array();
	$params['type'] = "editorschoice";
	$params['page'] = $page;
	$params['per_page'] = $per_page;
	if( $user_id != "" ) {
		$params["user"] = $user_id;
	}

	return get_br_posts($params);
}




/**
 * NEWS一覧の取得
 * @param array $params
 * 		$post_per_page			= １ページの表示レコード数
 * 		$page 					= 取得ページ
 * 		$flg_show_attention 	= Attention表示フラグ 0|1 default:""(全取得)
 *
 * @return array $arrResult
 * 		$arrResult["arrPosts"] 		= 取得データ配列
 * 		$arrResult["recordNum"]		= 今回取得レコード数
 * 		$arrResult["maxRecordNum"]	= 最大取得レコード数
 * 		$arrResult["pageNum"]		= 現在ページ
 * 		$arrResult["maxPageNum"]	= 最大ページ数
 */
function get_news_list( $post_per_page, $page, $flg_show_attention = "") {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT SQL_CALC_FOUND_ROWS ";
	$sql .= " p.*, pm1.meta_value AS flg_show_attention ";
	$sql .= " ,p2.guid AS thumb_url ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'flg_show_attention') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = '_thumbnail_id') ";
	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm2.meta_value = p2.ID) ";	// アイキャッチ画像

	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND p.post_type = 'news' ";

	// Attention表示
	if( $flg_show_attention != "" ) {
		$sql .= " AND pm1.meta_value = %s ";
		$arrBindValue[] = $flg_show_attention;
	}

	$sql .= " ORDER BY p.post_date DESC ";

	// 取得ページ
	$offset = ($page -1) * $post_per_page;
	$sql  .= " LIMIT ".$offset.", ".$post_per_page;

/*
	 echo "<br/>".$sql;
	 echo "<pre>";
	 print_r($arrBindValue);
	 echo "</pre>";
*/

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$results = $wpdb->get_results( $query, ARRAY_A );
	$count = $wpdb->num_rows;

	// LIMIT無しでのレコード数取得
	$maxCount = $wpdb->get_var( "SELECT FOUND_ROWS()" );

	// 戻り値設定
	$arrResult = array();
	$arrResult["arrPosts"] = $results;
	$arrResult["recordNum"] = $count;
	$arrResult["maxRecordNum"] = $maxCount;
	$arrResult["pageNum"] = $page;
	$arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

	return $arrResult;
}


/**
 * 年月からブログの書かれている日付を取得
 *
 * @param unknown $user_id		ユーザーID
 * @param number $y				年
 * @param number $m				月
 * @return mixed[]				日付 => 投稿ID の連想配列
 */
function get_blog_date_list( $user_id, $y = 0, $m = 0) {

	if( $y == 0) {
		$y = date('Y');
	}
	if( $m == 0) {
		$m = date('m');
	}

	$date_first = date('Y-m-d', strtotime('first day of ' . $y.'-'.$m ));
	$date_last = date('Y-m-d', strtotime('last day of ' . $y.'-'.$m));

	$params = array();
	$params['user'] = $user_id;
	$params['from_date'] = $date_first;
	$params['to_date'] = $date_last;
	$params['order_dir'] = "asc";

	$arrData = get_br_posts($params);

	// 戻り値加工（投稿日の配列にする）
	$arrResult = array();
	foreach ( $arrData["arrPosts"] as $post ) {
		$arrResult[date('Y-m-d', strtotime($post["post_date"]))] = $post["ID"];
	}

	return $arrResult;
}



/**
 * ブログページのカレンダーHTMLを取得
 *
 * @param unknown $post_id		現在表示中の記事ID
 * @param unknown $user_id		投稿者ID
 * @param number $y				表示年（省略時当月）
 * @param number $m				表示月（省略時当月）
 * @return string				取得結果（HTML）
 */
function get_blog_calendar_html( $post_id, $user_id, $y = 0, $m = 0 ) {

	if( $y == 0) {
		$y = date('Y');
	}
	if( $m == 0) {
		$m = date('m');
	}

	$arrDate = get_blog_date_list($user_id, $y, $m);

	$date_first = date('Y-m-d', strtotime('first day of ' . $y.'-'.$m ));
	$date_last = date('Y-m-d', strtotime('last day of ' . $y.'-'.$m));
	$date_today = date('Y-m-d');

	$start_week = date( 'w', mktime( 0, 0 , 0, $m, 1, $y));

	$calHtml  = '<div class="box">';
	$calHtml .= '	<div class="head">';
	$calHtml .= '		<div class="prev">';
	$calHtml .= '			<a href="?entry='.$post_id.'&y='.date('Y', strtotime($date_first.'-1 month')).'&m='.date('m', strtotime($date_first.'-1 month')).'">&lt;</a>';
	$calHtml .= '		</div>';
	$calHtml .= '		<div class="month">';
	$calHtml .= '			<span class="month">'.date('Y.m', strtotime($date_first)).'</span>';
	$calHtml .= '		</div>';
	$calHtml .= '		<div class="next">';
	$calHtml .= '			<a href="?entry='.$post_id.'&y='.date('Y', strtotime($date_first.'+1 month')).'&m='.date('m', strtotime($date_first.'+1 month')).'">&gt;</a>';
	$calHtml .= '		</div>';
	$calHtml .= '	</div>';
	$calHtml .= '	<table>';
	$calHtml .= '		<tr><th class="sun">S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th class="sat">S</th>';

	$calHtml .= '		<tr>';
	for( $week = 0; $week < $start_week; $week++ ) {
		$calHtml .= '		<td>&nbsp;</td>';
	}

	$w = 0;
	for( $d = 1; $d <= date('d', strtotime($date_last)); ++$d ) {
		$w = date( 'w',mktime( 0, 0 , 0, $m, $d, $y));
		if((1 < $d) && ($w == 0)) {
			$calHtml .= '<tr>';
		}

		$css = "day";
		switch ( $w ) {
			case 0:
				$css .= " sun";
				break;

			case 6:
				$css .= " sat";
				break;

		}

		$date_target = date('Y-m-d', strtotime($y.'-'.$m.'-'.$d));
		if( $date_today == $date_target) {
			$css .= " today";
		}
		$id = "";
		if( array_key_exists( $date_target, $arrDate )) {
			$id = $arrDate[$date_target];
			$css .= " write";
		}

		$calHtml .= '<td class="'.$css.'">';
		if( $id != "" ) {
			$calHtml .= '<a href="?entry='.$id.'&y='.$y.'&m='.$m.'">';
		}
		$calHtml .= $d;
		if( $id != "" ) {
			$calHtml .= '</a>';
		}
		$calHtml .= '</td>';

		if(( $d < date('d', strtotime($date_last))) && ($w == 6)) {
			$calHtml .= '</tr>';
		}
	}

	for( $week = $w; $week < 6; $week++ ) {
		$calHtml .= '<td>&nbsp;</td>';
	}

	$calHtml .= 		'</tr>';
	$calHtml .= '	</table>';
	$calHtml .= '</div>';

	return $calHtml;
}




/**
 * ブログ検索
 * 	取得対象は　FEATURE, STYLE SNAP, EDITORS CHOICE
 *
 * @param number $page		取得ページ
 * @param string $tag		タグ
 * @param string $word		フリーワード
 * @return array			取得結果
 */
function get_search_article( $page = 1, $tag = "", $word = "" ) {
	$params = array();
	$params['type'] = "feature,stylesnap,editorschoice";
	$params['page'] = $page;
	$params['per_page'] = 20;
	if( $tag!= "" ) {
		$params["tag"] = $tag;
	} else if( $word != "" ) {
		$params["word"] = $word;
	}

	return get_br_posts($params);
}





/**
 * B.R.ONLINE 記事詳細の取得
 * 		記事は $arrResult["content"] に入ります
 * 		１ページ目のときは、WP標準の本文が入り
 * 		２ページ目以降のときは、カスタムフォームで追加した値が入りますので、view側では $arrResult["content"] を出力する
 *
 * @param unknown $post_id		投稿ID
 * @param number $page			内部ページ（FEATUREで使用）
 * @param string $preview		プレビューモード、true の場合、 post_status = 'publish' を条件に付けない
 * 								プレビューモードは詳細表示のみ
 * @return $arrResult			取得結果
 */
function get_br_post( $post_id, $page = 1, $preview = false ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT ";
	$sql .= " p.*, pm1.meta_value AS view_count ";
	$sql .= " ,pm2.meta_value AS title2 ";
	$sql .= " ,pm3.meta_value AS serise ";
	$sql .= " ,pm4.meta_value AS pr ";
	$sql .= " ,pm5.meta_value AS pickup ";
	$sql .= " ,pm7.meta_value AS credit ";
	$sql .= " ,pm10.meta_value AS notice ";
	$sql .= " ,COALESCE(pm11.meta_value, '0') +1 AS inner_page ";

	$sql .= " ,p2.guid AS thumb_url ";
	$sql .= " ,p4.guid AS main_image_url ";
	if( $page == 1 ) {
		$sql .= " ,p.post_content AS content ";
		$sql .= " ,pm14.meta_value AS next_title ";
	} else if( $page > 1 ) {
		$sql .= " ,pm12.meta_value AS content ";
		$sql .= " ,pm13.meta_value AS page_title ";
		$sql .= " ,pm14.meta_value AS next_title ";
	}

	$sql .= " ,u.ID AS user_id ";
	$sql .= " ,um1.meta_value AS last_name ";
	$sql .= " ,um2.meta_value AS first_name ";
	$sql .= " ,um3.meta_value AS nickname ";

	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'view_count') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'title2') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm3 ON (p.ID = pm3.post_id AND pm3.meta_key = 'serise') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm4 ON (p.ID = pm4.post_id AND pm4.meta_key = 'flg_pr') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm5 ON (p.ID = pm5.post_id AND pm5.meta_key = 'flg_pickup') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm6 ON (p.ID = pm6.post_id AND pm6.meta_key = 'pickup_disp_no') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm7 ON (p.ID = pm7.post_id AND pm7.meta_key = 'credit') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm8 ON (p.ID = pm8.post_id AND pm8.meta_key = '_thumbnail_id') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm9 ON (p.ID = pm9.post_id AND pm9.meta_key = 'main_image') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm10 ON (p.ID = pm10.post_id AND pm10.meta_key = 'notice') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm11 ON (p.ID = pm11.post_id AND pm11.meta_key = 'inner_page') ";

	if( $page == 1 ) {
		$sql .= " LEFT JOIN $wpdb->postmeta AS pm14 ON (p.ID = pm14.post_id AND pm14.meta_key = 'inner_page_".($page - 1)."_title') ";
	} else if( $page > 1 ) {
		$sql .= " LEFT JOIN $wpdb->postmeta AS pm12 ON (p.ID = pm12.post_id AND pm12.meta_key = 'inner_page_".($page - 2)."_content') ";
		$sql .= " LEFT JOIN $wpdb->postmeta AS pm13 ON (p.ID = pm13.post_id AND pm13.meta_key = 'inner_page_".($page - 2)."_title') ";
		$sql .= " LEFT JOIN $wpdb->postmeta AS pm14 ON (p.ID = pm14.post_id AND pm14.meta_key = 'inner_page_".($page - 1)."_title') ";
	}

	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm8.meta_value = p2.ID) ";	// アイキャッチ画像
	$sql .= " LEFT JOIN $wpdb->posts AS p4 ON (pm9.meta_value = p4.ID) ";	// メイン画像

	$sql .= " LEFT JOIN $wpdb->users AS u ON (p.post_author = u.ID) ";
	$sql .= " LEFT JOIN $wpdb->usermeta AS um1 ON (u.ID = um1.user_id AND um1.meta_key = 'last_name' ) ";	// last_name
	$sql .= " LEFT JOIN $wpdb->usermeta AS um2 ON (u.ID = um2.user_id AND um2.meta_key = 'first_name' ) ";	// first_name
	$sql .= " LEFT JOIN $wpdb->usermeta AS um3 ON (u.ID = um3.user_id AND um3.meta_key = 'nickname' ) ";	// nickname

	if( $preview ) {
		$sql .= " WHERE p.ID = %d ";
	} else {
		$sql .= " WHERE p.post_status = 'publish' ";
		$sql .= " AND p.ID = %d ";
	}

	$arrBindValue[] = $post_id;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	if( 0 < count($arrResult)) {
		return $arrResult[0];
	} else {
		return false;
	}
}



/**
 * 記事の前後の記事IDとタイトルを取得
 *
 * @param unknown $post_id		記事ID
 * @param string $post_type		投稿タイプ "feature|editorschoice|stylesnap|news" default:"post"
 * @param unknown $user_ids		投稿ユーザーID default:""(全ユーザー対象)　複数の場合はカンマ区切り
 *
 * @return array $arrResult
 * 		$arrResult["prev"]		前の記事、存在しない場合は null
 * 		$arrResult["next"]		後の記事、存在しない場合は null
 */
function get_br_post_prev_next( $post_id, $post_type = 'post', $user_ids = "" ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT ";
	$sql .= " p.* ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";

	$sql .= " AND p.post_type = %s ";
	$arrBindValue[] = $post_type;

	// 投稿ユーザー
	if( $user_ids != "") {
		$arr_post_user = explode(",",  $user_ids);
		$str_post_user = "";
		foreach ( $arr_post_user as $user_id ) {
			if( $str_post_user != "" ) {
				$str_post_user .= " OR ";
			}
			$str_post_user .= " p.post_author = %d ";
			$arrBindValue[] = $user_id;
		}
		$sql .= " AND ( ".$str_post_user." ) ";
	}

	$sql .= " ORDER BY p.post_date DESC ";


	/*
	 echo "<br/>".$sql;
	 echo "<pre>";
	 print_r($arrBindValue);
	 echo "</pre>";
	 */

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$results = $wpdb->get_results( $query, ARRAY_A );

	// 戻り値の設定
	$arrResult = array();
	$arrResult['prev'] = null;
	$arrResult['next'] = null;

	if( 0 < count($results)) {
		foreach ( $results as $num => $row ) {
			if( $row['ID'] == $post_id ) {
				if( 0 < $num ) {
					$arrResult['prev']['ID'] = $results[$num-1]['ID'];
					$arrResult['prev']['post_title'] = $results[$num-1]['post_title'];
				}

				if( $num < count($results)-1) {
					$arrResult['next']['ID'] = $results[$num+1]['ID'];
					$arrResult['next']['post_title'] = $results[$num+1]['post_title'];
				}
			}
		}
	}

	return $arrResult;
}




/**
 * B.R.ONLINE ユーザー詳細の取得
 *
 * @param unknown $user_id		ユーザーID
 * @return $arrResult			取得結果
 */
function get_br_user( $user_id ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT ";
	$sql .= " u.* ";
	$sql .= " ,u2.post_title AS shop_name ";
	$sql .= " ,um2.meta_value AS nickname ";
	$sql .= " ,um3.meta_value AS first_name ";
	$sql .= " ,um4.meta_value AS last_name ";
	$sql .= " ,COALESCE(um5.meta_value, '0') AS flg_shop ";
	$sql .= " ,um6.meta_value AS name_en ";
	$sql .= " ,um7.meta_value AS degree ";
	$sql .= " ,um9.meta_value AS profile ";
	$sql .= " ,u3.guid AS image_url ";
	$sql .= " ,um10.meta_value AS free_area ";
	$sql .= " ,um11.meta_value AS height ";
	$sql .= " ,um12.meta_value AS weight ";

	$sql .= "FROM $wpdb->users AS u ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um1 ON (u.ID = um1.user_id AND um1.meta_key = 'shop' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um2 ON (u.ID = um2.user_id AND um2.meta_key = 'nickname' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um3 ON (u.ID = um3.user_id AND um3.meta_key = 'first_name' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um4 ON (u.ID = um4.user_id AND um4.meta_key = 'last_name' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um5 ON (u.ID = um5.user_id AND um5.meta_key = 'flg_shop' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um6 ON (u.ID = um6.user_id AND um6.meta_key = 'name_en' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um7 ON (u.ID = um7.user_id AND um7.meta_key = 'degree' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um8 ON (u.ID = um8.user_id AND um8.meta_key = 'wp_user_avatar' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um9 ON (u.ID = um9.user_id AND um9.meta_key = 'description' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um10 ON (u.ID = um10.user_id AND um10.meta_key = 'free_area' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um11 ON (u.ID = um11.user_id AND um11.meta_key = 'height' ) ";
	$sql .= "LEFT JOIN $wpdb->usermeta AS um12 ON (u.ID = um12.user_id AND um12.meta_key = 'weight' ) ";
	$sql .= "LEFT JOIN $wpdb->posts AS u2 ON (um1.meta_value = u2.ID) ";	// ショップ情報
	$sql .= "LEFT JOIN $wpdb->posts AS u3 ON (um8.meta_value = u3.ID) ";	// 画像情報

	$sql .= " WHERE u.user_status = 0 ";
	$sql .= " AND u.ID = %d ";

	$arrBindValue[] = $user_id;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	if( 0 < count($arrResult)) {
		return $arrResult[0];
	} else {
		return false;
	}
}



/**
 * BLOG記事の取得
 *
 * @param unknown $post_id		投稿ID
 * @param string $preview		プレビューモード、true|false
 * @return $arrResult			取得結果
 */
function get_blog( $post_id, $preview = false ) {
	return get_br_post( $post_id, 1, $preview );
}


/**
 * FEATURE記事の取得
 *
 * @param unknown $post_id		投稿ID
 * @param number $page			内部ページ
 * @param string $preview		プレビューモード、true|false
 * @return $arrResult			取得結果
 */
function get_feature( $post_id, $page = 1, $preview = false ) {
	return get_br_post( $post_id, $page, $preview );
}


/**
 * STYLE SNAP記事の取得
 *
 * @param unknown $post_id		投稿ID
 * @param string $preview		プレビューモード、true|false
 * @return $arrResult			取得結果
 */
function get_style_snap( $post_id, $preview = false ) {
	global $wpdb;

	// 記事を取得
	$post = get_br_post( $post_id, 1, $preview );

	if( $post == false ) {
		return false;
	}

	$arrBindValue = array();

	$sql  = "SELECT ";
	$sql .= " p1.guid AS image1 ";
	$sql .= " ,p2.guid AS image2 ";
	$sql .= " ,p3.guid AS image3 ";
	$sql .= " ,p4.guid AS image4 ";
	$sql .= " ,p5.guid AS image5 ";
	$sql .= " ,p6.guid AS image6 ";
	$sql .= " ,pm7.meta_value AS movie_url ";
	$sql .= " ,pm8.meta_value AS movie_pos ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'slide1') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'slide2') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm3 ON (p.ID = pm3.post_id AND pm3.meta_key = 'slide3') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm4 ON (p.ID = pm4.post_id AND pm4.meta_key = 'slide4') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm5 ON (p.ID = pm5.post_id AND pm5.meta_key = 'slide5') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm6 ON (p.ID = pm6.post_id AND pm6.meta_key = 'slide6') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm7 ON (p.ID = pm7.post_id AND pm7.meta_key = 'movie') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm8 ON (p.ID = pm8.post_id AND pm8.meta_key = 'movie_pos') ";
	$sql .= " LEFT JOIN $wpdb->posts AS p1 ON (pm1.meta_value = p1.ID) ";
	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm2.meta_value = p2.ID) ";
	$sql .= " LEFT JOIN $wpdb->posts AS p3 ON (pm3.meta_value = p3.ID) ";
	$sql .= " LEFT JOIN $wpdb->posts AS p4 ON (pm4.meta_value = p4.ID) ";
	$sql .= " LEFT JOIN $wpdb->posts AS p5 ON (pm5.meta_value = p5.ID) ";
	$sql .= " LEFT JOIN $wpdb->posts AS p6 ON (pm6.meta_value = p6.ID) ";

	if( $preview ) {
		$sql .= " WHERE p.ID = %d ";
	} else {
		$sql .= " WHERE p.post_status = 'publish' ";
		$sql .= " AND p.ID = %d ";
	}

	$arrBindValue[] = $post_id;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	if( 0 < count($arrResult)) {
		$post["slide"] = $arrResult[0];
	} else {
		$post["slide"] = array();
	}

	return $post;
}


/**
 * EDITORS CHOICE記事の取得
 *
 * @param unknown $post_id		投稿ID
 * @param string $preview		プレビューモード、true|false
 * @return $arrResult			取得結果
 */
function get_editors_choice( $post_id, $preview = false ) {
	return get_br_post( $post_id, 1, $preview );
}


/**
 * NEWS記事の取得
 *
 * @param unknown $post_id		投稿ID
 * @param string $preview		プレビューモード、true|false
 * @return $arrResult			取得結果
 */
function get_news( $post_id, $preview = false ) {
	return get_br_post( $post_id, 1, $preview );
}


/**
 * 広告取得
 *
 * @param unknown $post_id		広告ID（投稿ID）
 */
function get_br_ad( $post_id ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND p.post_type = 'ad' ";
	$sql .= " AND p.ID = %d ";

	$arrBindValue[] = $post_id;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	$ret = "";
	if( 0 < count($arrResult)) {
		$ret = $arrResult[0];
	}
	return $ret;
}



/**
 * ショップ情報の登録
 *
 * @param unknown $shop_name	ショップ名
 * @param unknown $shop_url		ショップURL
 * @return number|boolean		結果　成功：登録ID / 失敗：false
 */
function add_br_shop( $shop_name, $shop_url ) {
	global $wpdb;

	// 登録されていなければ追加
	if( get_br_shop_url($shop_url) != "" ) {
		return false;
	}

	$data = array(
			'post_type' => 'shop',
			'post_title' => $shop_name,
			'post_author' => 1,
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_name' => $shop_url,
	);

	$format = array(
			'%s',
			'%s',
			'%d',
			'%s',
			'%s',
			'%s',
	);

	if( $wpdb->insert( $wpdb->posts, $data, $format )) {
		return $wpdb->insert_id;
	}

	return false;
}


/**
 * ショップ情報削除
 * 		ショップ情報をゴミ箱に入れる
 *
 * @param unknown $shop_name	ショップ名
 * @return boolean				結果　成功：true / 失敗：false
 */
function del_br_shop( $shop_name ) {
	global $wpdb;

	$shop = get_br_shop($shop_name);

	$data = array(
			'post_status' => 'trash',
	);

	$format = array(
			'%s',
	);

	$where = array(
			'ID' => $shop['ID'],
	);

	$where_format = array(
			'%d',
	);

	if ( $wpdb->update( $wpdb->posts, $data, $where, $format, $where_format ) === false ) {
		return false;
	} else {
		return true;
	}
}


/**
 * ショップ情報（投稿タイプ shop）の一覧取得
 * 		ゴミ箱に入っているものは取得されません
 *
 * @return array|object|NULL	取得結果
 */
function get_br_shop_list() {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND p.post_type = 'shop' ";


	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	return $arrResult;
}


/**
 * ショップ情報（投稿タイプ shop）をショップ名で取得
 *
 * @param unknown $shop_name	ショップ名
 * @return string				取得情報
 */
function get_br_shop( $shop_name ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND p.post_type = 'shop' ";
	$sql .= " AND p.post_title = '%s' ";

	$arrBindValue[] = $shop_name;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	$ret = "";
	if( 0 < count($arrResult)) {
		$ret = $arrResult[0];
	}
	return $ret;
}


/**
 * ショップ情報（投稿タイプ shop）をショップURLで取得
 *
 * @param unknown $shop_url		ショップURL
 * @return string				取得結果
 */
function get_br_shop_url( $shop_url ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND p.post_type = 'shop' ";
	$sql .= " AND p.post_name = '%s' ";

	$arrBindValue[] = $shop_url;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	$ret = "";
	if( 0 < count($arrResult)) {
		$ret = $arrResult[0];
	}
	return $ret;
}



/**
 * ブランド情報の登録
 *
 * @param unknown $brand_name	ブランド名
 * @param unknown $brand_code	ブランドコード
 * @param unknown $brand_kana	ブランドカナ名
 * @return number|boolean		結果　成功：登録ID / 失敗：false
 */
function add_br_braand( $brand_name, $brand_code, $brand_kana ) {
	global $wpdb;

	// 登録されていなければ追加
	if( get_br_brand($brand_code) != "" ) {
		return false;
	}

	$data = array(
			'post_type' => 'brand',
			'post_title' => $brand_name,
			'post_author' => 1,
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_name' => 'brand_'.$brand_code,
	);

	$format = array(
			'%s',
			'%s',
			'%d',
			'%s',
			'%s',
			'%s',
	);

	$post_id = "";
	if( $wpdb->insert( $wpdb->posts, $data, $format )) {
		$post_id = $wpdb->insert_id;
	}

	if( $post_id != "" ) {
		// ブランドコードの登録
		$data = array(
				'post_id' => $post_id,
				'meta_key' => 'brand_code',
				'meta_value' => $brand_code,
		);

		$format = array(
				'%d',
				'%s',
				'%s',
		);

		if( !$wpdb->insert( $wpdb->postmeta, $data, $format )) {
			return false;
		}


		// ブランドカナ名の登録
		$data = array(
		'post_id' => $post_id,
		'meta_key' => 'brand_kana',
		'meta_value' => $brand_kana,
		);

		$format = array(
				'%d',
				'%s',
				'%s',
		);

		if( !$wpdb->insert( $wpdb->postmeta, $data, $format )) {
			return false;
		}
	}

	return $post_id;
}


/**
 * ブランド情報削除
 * 		ブランド情報をゴミ箱に入れる
 *
 * @param unknown $brand_code	ブランドコード名
 * @return boolean				結果　成功：true / 失敗：false
 */
function del_br_brand( $brand_name ) {
	global $wpdb;

	$brand = get_br_brand($brand_name);

	$data = array(
			'post_status' => 'trash',
	);

	$format = array(
			'%s',
	);

	$where = array(
			'ID' => $brand['ID'],
	);

	$where_format = array(
			'%d',
	);

	if ( $wpdb->update( $wpdb->posts, $data, $where, $format, $where_format ) === false ) {
		return false;
	} else {
		return true;
	}
}


/**
 * ブランド情報（投稿タイプ brand）の一覧取得
 * 		ゴミ箱に入っているものは取得されません
 *
 * @return array|object|NULL	取得結果
 */
function get_br_brand_list() {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND p.post_type = 'brand' ";


	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	return $arrResult;
}


/**
 * BRAND取得
 *
 * @param unknown $brand_code	ブランドコード
 * @param string $preview		プレビューモード、true の場合、 post_status = 'publish' を条件に付けない
 * 								プレビューモードは詳細表示のみ
 * @return $arrResult			取得結果
 */
function get_br_brand( $brand_code, $preview = false ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " ,pm1.meta_value AS brand_kana ";
	$sql .= " ,p2.guid AS image_url ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'brand_kana') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'brand_img') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm3 ON (p.ID = pm3.post_id AND pm3.meta_key = 'brand_code') ";
	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm2.meta_value = p2.ID) ";	// メイン画像

	$sql .= " WHERE  p.post_type = 'brand' ";
	$sql .= " AND pm3.meta_value = %s ";

	if( !$preview ) {
		$sql .= " AND p.post_status = 'publish' ";
	}

	$arrBindValue[] = $brand_code;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	if( 0 < count($arrResult)) {
		return $arrResult[0];
	} else {
		return false;
	}
}



/**
 * BRAND取得（ブランド名から）
 *
 * @param unknown $brand_name	ブランド名
 * @param string $preview		プレビューモード、true の場合、 post_status = 'publish' を条件に付けない
 * 								プレビューモードは詳細表示のみ
 * @return $arrResult			取得結果
 */
function get_br_brand_name( $brand_name, $preview = false ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " ,pm1.meta_value AS brand_kana ";
	$sql .= " ,pm3.meta_value AS brand_code ";
	$sql .= " ,p2.guid AS image_url ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'brand_kana') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'brand_img') ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm3 ON (p.ID = pm3.post_id AND pm3.meta_key = 'brand_code') ";
	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm2.meta_value = p2.ID) ";	// メイン画像

	$sql .= " WHERE  p.post_type = 'brand' ";
	$sql .= " AND p.post_title = %s ";

	if( !$preview ) {
		$sql .= " AND p.post_status = 'publish' ";
	}

	$arrBindValue[] = $brand_name;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	if( 0 < count($arrResult)) {
		return $arrResult[0];
	} else {
		return false;
	}
}




/**
 * テーマ情報の登録
 *
 * @param unknown $theme_name	テーマ名
 * @param unknown $theme_id		テーマコード
 * @return number|boolean		結果　成功：登録ID / 失敗：false
 */
function add_br_theme( $theme_name, $theme_id ) {
	global $wpdb;

	// 登録されていなければ追加
	if( get_br_theme($theme_id) != "" ) {
		return false;
	}

	$data = array(
			'post_type' => 'brtheme',
			'post_title' => $theme_name,
			'post_author' => 1,
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_name' => 'brand_'.$theme_id,
	);

	$format = array(
			'%s',
			'%s',
			'%d',
			'%s',
			'%s',
			'%s',
	);


	$post_id = "";
	if( $wpdb->insert( $wpdb->posts, $data, $format )) {
		$post_id = $wpdb->insert_id;
	}

	// テーマIDの登録
	$data = array(
	'post_id' => $post_id,
	'meta_key' => 'theme_id',
	'meta_value' => $theme_id,
	);

	$format = array(
			'%d',
			'%s',
			'%s',
	);

	$post_id = "";
	if( !$wpdb->insert( $wpdb->postmeta, $data, $format )) {
		return false;
	}

	return $post_id;
}


/**
 * テーマ情報削除
 * 		テーマ情報をゴミ箱に入れる
 *
 * @param unknown $theme_id		テーマID
 * @return boolean				結果　成功：true / 失敗：false
 */
function del_br_theme( $theme_id ) {
	global $wpdb;

	$theme = get_br_theme($brand_id);

	$data = array(
			'post_status' => 'trash',
	);

	$format = array(
			'%s',
	);

	$where = array(
			'ID' => $theme['ID'],
	);

	$where_format = array(
			'%d',
	);

	if ( $wpdb->update( $wpdb->posts, $data, $where, $format, $where_format ) === false ) {
		return false;
	} else {
		return true;
	}
}


/**
 * THEME取得
 *
 * @param unknown $theme_id		テーマID
 * @param string $preview		プレビューモード、true の場合、 post_status = 'publish' を条件に付けない
 * 								プレビューモードは詳細表示のみ
 * @return $arrResult			取得結果
 */
function get_br_theme( $theme_id, $preview = false ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.* ";
	$sql .= " ,p2.guid AS image_url ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'theme_img') ";
	$sql .= " JOIN $wpdb->postmeta AS pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'theme_id') ";
	$sql .= " LEFT JOIN $wpdb->posts AS p2 ON (pm1.meta_value = p2.ID) ";	// メイン画像

	$sql .= " WHERE  p.post_type = 'brtheme' ";
	$sql .= " AND pm2.meta_value = %s ";

	if( !$preview ) {
		$sql .= " AND p.post_status = 'publish' ";
	}

	$arrBindValue[] = $theme_id;

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$arrResult = $wpdb->get_results( $query, ARRAY_A );

	if( 0 < count($arrResult)) {
		return $arrResult[0];
	} else {
		return false;
	}
}



/**
 * B.R.ONLINE 記事一覧の件数を取得
 * 		ショップ内ページでのメニュー制御で使用
 * 		FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事が対象
 *
 * @param unknown $user_ids		投稿ユーザーID default:""(全ユーザー対象)　複数の場合はカンマ区切り
 *
 * @return array $arrResult		取得結果
 */
function get_article_num( $user_ids = "" ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT p.post_type, count(p.post_type) AS num ";
	$sql .= " FROM $wpdb->posts AS p ";
	$sql .= " WHERE p.post_status = 'publish' ";
	$sql .= " AND ( p.post_type = 'feature' OR p.post_type = 'editorschoice' OR p.post_type = 'stylesnap' OR p.post_type = 'post') ";

	// 投稿ユーザー
	if( $user_ids != "") {
		$arr_post_user = explode(",",  $user_ids);
		$str_post_user = "";
		foreach ( $arr_post_user as $user_id ) {
			if( $str_post_user != "" ) {
				$str_post_user .= " OR ";
			}
			$str_post_user .= " p.post_author = %d ";
			$arrBindValue[] = $user_id;
		}
		$sql .= " AND ( ".$str_post_user." ) ";
	}

	$sql .= " GROUP BY p.post_type ";

	/*
	echo "<br/>".$sql;
	 echo "<pre>";
	 print_r($arrBindValue);
	 echo "</pre>";
	*/

	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$result = $wpdb->get_results( $query, ARRAY_A );

	$arrResult = array();
	foreach ( $result as $row ) {
		$arrResult[$row['post_type']] = $row['num'];
	}

	return $arrResult;
}



/**
 * WP記事のタグを人気順に取得
 *
 * @param string $tag_type		1:投稿記事、2:画像	default:1
 * @return array $result		取得結果
 */
function get_tag_list( $tag_type = 1 ) {
	global $wpdb;

	$arrBindValue = array();

	$sql  = "SELECT a.term_id, b.name, a.count ";
	$sql .= " FROM wp_term_taxonomy AS a ";
	$sql .= " LEFT JOIN wp_terms AS b ON a.term_id = b.term_id ";
	$sql .= " WHERE p.taxonomy = ? ";
	$sql .= " ORDER BY a.count desc, b.name ";

	switch ( $tag_type ) {
		case 1:
			$arrBindValue[] = 'post_tag';
			break;

		case 2:
			$arrBindValue[] = 'attachment_tag';
			break;

		default:
			$arrBindValue[] = 'post_tag';
	}


	// SQL実行
	$query = $wpdb->prepare( $sql, $arrBindValue );
	$result = $wpdb->get_results( $query, ARRAY_A );

	return $result;
}
