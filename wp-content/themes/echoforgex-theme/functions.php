<?php
/**
 * EchoForgeX Theme Functions
 *
 * Child theme for GeneratePress
 *
 * @package EchoForgeX
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent and child theme styles
 */
function echoforgex_enqueue_styles() {
    // Parent theme style
    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme('generatepress')->get('Version')
    );

    // Child theme style
    wp_enqueue_style(
        'echoforgex-style',
        get_stylesheet_uri(),
        array('generatepress-style'),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'echoforgex_enqueue_styles');

/**
 * Enqueue Google Fonts (Inter)
 */
function echoforgex_enqueue_fonts() {
    wp_enqueue_style(
        'echoforgex-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'echoforgex_enqueue_fonts');

/**
 * Enqueue custom scripts
 */
function echoforgex_enqueue_scripts() {
    // Main theme script
    wp_enqueue_script(
        'echoforgex-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'echoforgex_enqueue_scripts');

/**
 * Add theme support
 */
function echoforgex_theme_support() {
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Add support for wide and full alignment
    add_theme_support('align-wide');

    // Custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'echoforgex_theme_support');

/**
 * Register navigation menus
 */
function echoforgex_register_menus() {
    register_nav_menus(array(
        'primary'    => __('Primary Menu', 'echoforgex'),
        'footer'     => __('Footer Menu', 'echoforgex'),
        'footer-legal' => __('Footer Legal Menu', 'echoforgex'),
    ));
}
add_action('init', 'echoforgex_register_menus');

/**
 * Register widget areas
 */
function echoforgex_widgets_init() {
    register_sidebar(array(
        'name'          => __('Blog Sidebar', 'echoforgex'),
        'id'            => 'blog-sidebar',
        'description'   => __('Widgets in this area will appear in the blog sidebar.', 'echoforgex'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 1', 'echoforgex'),
        'id'            => 'footer-1',
        'description'   => __('First footer widget area.', 'echoforgex'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 2', 'echoforgex'),
        'id'            => 'footer-2',
        'description'   => __('Second footer widget area.', 'echoforgex'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 3', 'echoforgex'),
        'id'            => 'footer-3',
        'description'   => __('Third footer widget area.', 'echoforgex'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'echoforgex_widgets_init');

/**
 * Add reading time to posts
 *
 * @param int $post_id Post ID
 * @return string Reading time text
 */
function echoforgex_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assuming 200 words per minute

    if ($reading_time < 1) {
        $reading_time = 1;
    }

    return sprintf(
        _n('%d min read', '%d min read', $reading_time, 'echoforgex'),
        $reading_time
    );
}

/**
 * Customize excerpt length
 */
function echoforgex_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'echoforgex_excerpt_length');

/**
 * Customize excerpt more text
 */
function echoforgex_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'echoforgex_excerpt_more');

/**
 * Add custom image sizes
 */
function echoforgex_image_sizes() {
    add_image_size('blog-card', 600, 338, true);  // 16:9 ratio
    add_image_size('blog-featured', 1200, 675, true);  // 16:9 ratio
    add_image_size('author-avatar', 160, 160, true);  // Square
}
add_action('after_setup_theme', 'echoforgex_image_sizes');

/**
 * Add custom body classes
 */
function echoforgex_body_classes($classes) {
    // Add dark-theme class
    $classes[] = 'dark-theme';

    // Add page-specific classes
    if (is_front_page()) {
        $classes[] = 'page-home';
    }

    if (is_page('contact')) {
        $classes[] = 'page-contact';
    }

    if (is_singular('post')) {
        $classes[] = 'single-blog-post';
    }

    return $classes;
}
add_filter('body_class', 'echoforgex_body_classes');

/**
 * Disable Gutenberg block library CSS on front-end (optional - for performance)
 * Uncomment if not using Gutenberg blocks
 */
// function echoforgex_disable_block_css() {
//     wp_dequeue_style('wp-block-library');
//     wp_dequeue_style('wp-block-library-theme');
// }
// add_action('wp_enqueue_scripts', 'echoforgex_disable_block_css', 100);

/**
 * Add defer attribute to scripts for performance
 */
function echoforgex_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array('echoforgex-main');

    if (in_array($handle, $defer_scripts)) {
        return '<script src="' . esc_url($src) . '" defer></script>' . "\n";
    }

    return $tag;
}
add_filter('script_loader_tag', 'echoforgex_defer_scripts', 10, 3);

/**
 * Newsletter form shortcode
 * Usage: [echoforgex_newsletter]
 */
function echoforgex_newsletter_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Stay in the Loop',
        'text' => 'Get updates on our products and AI insights.',
    ), $atts, 'echoforgex_newsletter');

    ob_start();
    ?>
    <div class="newsletter-section">
        <h3><?php echo esc_html($atts['title']); ?></h3>
        <p><?php echo esc_html($atts['text']); ?></p>
        <form class="newsletter-form" action="#" method="POST">
            <input type="text" name="first_name" placeholder="First name">
            <input type="email" name="email" placeholder="Email address" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
        <p style="font-size: 0.875rem; margin-top: 1rem; opacity: 0.8;">
            We respect your privacy. Unsubscribe anytime.
        </p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('echoforgex_newsletter', 'echoforgex_newsletter_shortcode');

/**
 * Coming soon badge shortcode
 * Usage: [coming_soon]
 */
function echoforgex_coming_soon_shortcode() {
    return '<span class="badge-coming-soon">Coming Soon</span>';
}
add_shortcode('coming_soon', 'echoforgex_coming_soon_shortcode');

/**
 * Customize login page logo
 */
function echoforgex_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');

    if ($logo_url) {
        ?>
        <style type="text/css">
            #login h1 a {
                background-image: url(<?php echo esc_url($logo_url); ?>);
                background-size: contain;
                width: 200px;
                height: 60px;
            }
        </style>
        <?php
    }
}
add_action('login_enqueue_scripts', 'echoforgex_login_logo');

/**
 * Change login page logo URL
 */
function echoforgex_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'echoforgex_login_logo_url');

/**
 * Change login page logo title
 */
function echoforgex_login_logo_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'echoforgex_login_logo_title');
