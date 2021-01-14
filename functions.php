<?php
//Theme setup
function kurtcms_setup()
{
	global $content_width;
	if (! isset($content_width)) {
		$content_width = 800;
	}

	//Custom logo
	add_theme_support(
		'custom-logo',
		array(
			'height'               => 100,
			'width'                => 100,
			'flex-width'           => true,
			'flex-height'          => true,
			'unlink-homepage-logo' => false,
		)
	);

	//Automatic feed
	add_theme_support('automatic-feed-links');

	//Title tag
	add_theme_support( 'title-tag' );

	//Featured images
	add_theme_support('post-thumbnails');

	//Widgets refresh
	add_theme_support( 'customize-selective-refresh-widgets' );

	//Block styles
	add_theme_support( 'wp-block-styles' );

	//Wide alignment
	add_theme_support( 'align-wide' );

	//Editor styles
	add_theme_support( 'editor-styles' );

	//Responsive embeds
	add_theme_support( 'responsive-embeds' );

	//Custom background
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'fff',
		)
	);

	//Jetpack infinite scroll
	add_theme_support('infinite-scroll', array(
		'type'						=>		'scroll',
		'footer_widgets' 	=>		false,
		'container'				=>		'posts',
		'wrapper'					=>		false,
		'render'					=>		false,
		'posts_per_page'	=>		12,
	));

	//Add menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'kurtcms' ),
			'social'  => __( 'Social', 'kurtcms' ),
		)
	);

	//Loading translation if any
	load_theme_textdomain('kurtcms', get_template_directory() . '/languages');

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if (is_readable($locale_file)) {
		require_once($locale_file);
	}
}
add_action('after_setup_theme', 'kurtcms_setup');

//Register and enqueue Javascripts
function kurtcms_load_javascript_files()
{
	if (!is_admin()) {
		wp_enqueue_script('masonry');
		wp_enqueue_script('kurtcms_global', get_template_directory_uri().'/js/global.js', array('jquery'), '', true);
	}
}
add_action('wp_enqueue_scripts', 'kurtcms_load_javascript_files');

//Register and enqueue styles
function kurtcms_load_style()
{
	if (!is_admin()) {
		wp_enqueue_style('kurtcms_googlefonts', '//fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic');
		wp_enqueue_style('kurtcms_sociallogos', get_stylesheet_directory_uri() . '/icon-font/social-logos.css');
		wp_enqueue_style('kurtcms_genericonsneue', get_stylesheet_directory_uri() . '/icon-font/genericons-neue.min.css');
		wp_enqueue_style('kurtcms_style', get_stylesheet_uri());
	}
}
add_action('wp_print_styles', 'kurtcms_load_style');

//Custom login logo URL
function login_logo_url($url)
{
	return get_site_url();
}
add_filter('login_headerurl', 'login_logo_url');

// Custom widget
function kurtcms_sidebar_reg()
{
	register_sidebar(array(
		'name' => __('Sidebar', 'kurtcms'),
		'id' => 'sidebar',
		'description' => __('Widgets in this area will be shown in the sidebar.', 'kurtcms'),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget' => '</div><div class="clear"></div></div>'
	));
}
add_action('widgets_init', 'kurtcms_sidebar_reg');

//Custom title
function kurtcms_wp_title($title, $sep)
{
	global $paged, $page;

	if (is_feed()) {
		return $title;
	}

	$title .= get_bloginfo('name');

	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page())) {
		$title = "$title &mdash; $site_description";
	}

	return $title;
}
add_filter('wp_title', 'kurtcms_wp_title', 10, 2);

//Custom excerpt length
function kurtcms_custom_excerpt_length($length)
{
	return 55;
}
add_filter('excerpt_length', 'kurtcms_custom_excerpt_length');

//Custom excerpt ellipsis
function kurtcms_new_excerpt_more($more)
{
	return '...';
}
add_filter('excerpt_more', 'kurtcms_new_excerpt_more');

//Diable image scaling
add_filter( 'big_image_size_threshold', '__return_false' );

//Read time function
if (! function_exists('kurtcms_readtime')) :
	function kurtcms_readtime()
	{
		$wordcount = get_post_field( 'post_content', $post->ID );
    $readtime = "&mdash;&nbsp;" .
			round(str_word_count(strip_tags($wordcount)) / 200) . __(' Minute Read', 'kurtcms');
    echo $readtime;
}
endif;

//Comment function
if (! function_exists('kurtcms_comment')) :
	function kurtcms_comment($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		switch ($comment->comment_type) :
			case 'pingback':
			case 'trackback':
			?>
			<li <?php comment_class(); ?> id="comment-
				<?php comment_ID(); ?>">
				<?php _e('Pingback:', 'kurtcms'); ?>
				<?php comment_author_link(); ?>
				<?php edit_comment_link(__('Edit', 'kurtcms'), '<span class="edit-link">', '</span>'); ?>
			</li>
			<?php
			break;
			default:
			global $post; ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment">
					<div class="comment-header">
						<?php echo get_avatar($comment, 160); ?>
						<div class="comment-header-inner">
							<h4><?php echo get_comment_author_link(); ?></h4>
							<div class="comment-meta">
								<a class="comment-date-link" href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>" title="<?php echo get_comment_date() . ' at ' . get_comment_time(); ?>">
									<?php echo get_comment_date(get_option('date_format')) ?>
								</a>
							</div>
						</div>
					</div>
					<div class="comment-content post-content">
						<?php comment_text(); ?>
					</div>
					<div class="comment-actions">
						<?php if ('0' == $comment->comment_approved) : ?>
							<p class="comment-awaiting-moderation fright">
								<?php _e('Your comment is awaiting moderation.', 'kurtcms'); ?>
							</p>
						<?php endif; ?>
						<div class="fleft">
							<?php
							comment_reply_link(
								array(
									'reply_text'	=>	__('Reply', 'kurtcms'),
									'depth'				=>	$depth,
									'max_depth'		=>	$args['max_depth'],
									'before'			=>	'',
									'after'				=>	''
								)
							); ?>
							<?php edit_comment_link(__('Edit', 'kurtcms'), '<span class="sep">/</span>', ''); ?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<?php
			break;
		endswitch;
	}
endif;
?>
