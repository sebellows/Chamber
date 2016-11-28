<?php

namespace Chamber\Theme;

use Pimple\Container;
use Chamber\Theme\Wrapper;

class Bootstrap
{

    /**
     * Directory path to the theme folder.
     *
     * @var string
     */
    public $dirPath = '';

    /**
     * Directory URI to the theme folder.
     *
     * @var string
     */
    public $dirURI = '';

    /**
     * The theme's public asset folder.
     *
     * @var string
     */
    public $assetPath = '';

    /**
     * Register the menus.
     *
     * @var mixed
     */
    protected $menus;

    /**
     * Register the menus.
     *
     * @var mixed
     */
    protected $sidebars;

    /**
     * Container instance.
     *
     * @var \Pimple\Container
     */
    protected $container;

    /**
     * Container instance.
     *
     * @var \Pimple\Container
     */
    protected $parent;

    protected $fontsURL;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->dirPath   = trailingslashit( get_template_directory()     );
        $this->dirURI    = trailingslashit( get_template_directory_uri() );
        $this->assetPath = trailingslashit( get_template_directory_uri() . '/public' );
        $this->menus = new Menu;
        $this->sidebars = new Sidebar;
        $this->fontsURL = $this->fontsURL();
    }

    /**
     * Boot the, uh... bootstrap.
     * 
     * @return void
     */
    public function boot()
    {
        // $this->setPaths();
        $this->setupActions();
        $this->setupTheme();
        $this->registerSidebars();
    }

    public function setTemplateFilter()
    {
        // Use theme wrapper
        add_filter('template_include', [ $this, 'setTemplate' ], 109);
    }

    /**
     * Sets up initial actions.
     *
     * @access private
     * @return void
     */
    private function setupActions()
    {
        require_once( trailingslashit( get_template_directory() ) . 'lib/hybrid-core/hybrid.php' );
        new \Hybrid();

        # Theme setup.
        add_action('after_setup_theme', [ $this, 'setupTheme'] );
        # JavaScript detection.
        add_action( 'wp_head', [ $this, 'detectJavaScript' ], 0 );
        # Register menus.
        add_action( 'init', [ $this, 'registerMenus' ] );
        # Register image sizes.
        add_action( 'init', [ $this, 'registerImageSizes' ] );
        # Register scripts, styles, and fonts.
        add_action( 'wp_enqueue_scripts',    [ $this, 'registerScripts' ], 100 );
        // Move scripts to footer
        add_action('wp_enqueue_scripts', [ $this, 'scriptsToFooter' ]);
        # Register scripts and styles used in Admin (not edit.php).
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdminScript' ] );
        // Load Modernizr.js in the head
        add_action('wp_head', [$this, 'modernizrToHead'], 99);
    }

    /**
     * The theme setup function.
     *
     * @return void
     */
    public function setupTheme()
    {
        # Enable post thumbnails
        # http://codex.wordpress.org/Post_Thumbnails
        add_theme_support('post-thumbnails');
        # Breadcrumbs.
        add_theme_support( 'breadcrumb-trail' );
        # Template hierarchy.
        add_theme_support( 'hybrid-core-template-hierarchy' );
        # The best thumbnail/image script ever.
        add_theme_support( 'get-the-image' );
        # Nicer [gallery] shortcode implementation.
        add_theme_support( 'cleaner-gallery' );
        # Automatically add feed links to `<head>`.
        add_theme_support( 'automatic-feed-links' );
        # Chamber-CMS plugin supports Blade templating language
        add_theme_support('blade-templates');
        # Enable plugins to manage the document title
        # http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
        add_theme_support('title-tag');
        # Post formats.
        # http://codex.wordpress.org/Post_Formats
        add_theme_support('post-formats', [
            'aside',
            'audio',
            'gallery',
            'image',
            'quote',
            'video'
        ]);
        # Enable HTML5 markup support
        # http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
        add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ] );
        # Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support( 'customize-selective-refresh-widgets' );
    }

    /**
     * Handles JavaScript detection.
     *
     * Adds a `js` class to the root `<html>` element when JavaScript is detected.
     *
     * @since Twenty Seventeen 1.0
     */
    public function detectJavaScript()
    {
        echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    }

    /**
     * Registers nav menus.
     *
     * @return mixed
     */
    public function registerMenus()
    {
        return $this->menus->register();
    }

    /**
     * Registers sidebars.
     *
     * @return mixed
     */
    public function registerSidebars()
    {
        // $this->sidebars = new Sidebar;
        return $this->sidebars->register();
    }

    /**
     * Registers image sizes.
     * 
     * @link http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
     * @link http://codex.wordpress.org/Function_Reference/add_image_size
     *
     * @return void
     */
    public function registerImageSizes()
    {
        # Update the default `medium_large` image size
        update_option( 'medium_large', 960, 540, true ); // 3:2

        # Square sizes
        # @see small screen duplo blocks, galleries, gallery stripes
        add_image_size( 'vignette', 240, 240, true ); // 1:1
        # @see small screen duplo blocks, galleries, gallery stripes
        add_image_size( 'small', 480, 480, false ); // 1:1

        # Module-specific sizes
        # @see Isotope/Masonry/cards on small devices
        add_image_size( 'card-small', 360, 240, true ); // 3:2
        # @see Isotope/Masonry/cards on larger devices
        add_image_size( 'card-large', 480, 360, true ); // 3:2

        # Landscape sizes.
        set_post_thumbnail_size( 1024, 682, true ); // 3:2
        # @see single-block duplo, dynamic whitesheet
        add_image_size( 'fullwidth', 1600, 900, true ); // ~3:2
    }

    /**
     * Registers scripts/styles.
     *
     * @return void
     */
    public function registerScripts()
    {
        # Register styles.
        wp_enqueue_style( __NAMESPACE__ . '\\fonts_url', $this->fontsURL, [], null );
        // wp_enqueue_style( 'chamber/theme/fonts', fontsURL(), [], null );
        wp_enqueue_style('chamber/theme/css', get_template_directory_uri() . '/public/css/app.css');
        wp_enqueue_style('chamber/theme/vendor/css', get_template_directory_uri() . '/public/css/vendor.css');

        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_enqueue_script('chamber/theme/js/foundation', get_template_directory_uri() . '/public/js/foundation.js', ['jquery'], null, true);
        wp_enqueue_script('chamber/theme/js/vendor', get_template_directory_uri() . '/public/js/vendor.js', ['jquery'], null, true);
        wp_enqueue_script('chamber/theme/js/app', get_template_directory_uri() . '/public/js/app.js', ['jquery'], null, true);

        # Isotope.js
        if ( is_archive() ) {
            wp_enqueue_script( 'chamber/theme/js/isotope', get_template_directory_uri() . '/public/js/isotope.pkgd.js' );
        }
    }

    /**
     * Enqueue custom styles in the WordPress admin, excluding edit.php.
     *
     * @param int $hook Hook suffix for the current admin page.
     */
    function enqueueAdminScript()
    {
        wp_register_style( 'chamber/theme/admin/css', $this->assetPath . 'css/chamber-admin.css');
        wp_enqueue_style( 'chamber/theme/admin/css' );
    }

    /**
     * Moves all scripts to wp_footer.
     *
     * @author roots.io <https://github.com/roots/soil>
     */
    public function scriptsToFooter()
    {
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        remove_action('wp_head', 'wp_enqueue_scripts', 1);
    }

    public function modernizrToHead()
    {
        echo '<script src="' . get_template_directory_uri() . '/public/js/modernizr.js"></script>';
    }

    /**
     * Register Google fonts.
     *
     * @return string Google fonts URL for the theme.
     */
    protected function fontsURL()
    {
        $fontsURL = '';
        $fonts     = [];

        $fonts[] = 'Roboto:400italic,700italic,400,700';
        $fonts[] = 'Roboto Slab:400,700';

        $fontsURL = add_query_arg(
            [ 'family' => urlencode( implode( '|', $fonts ) ) ],
            'https://fonts.googleapis.com/css'
        );

        return $fontsURL;
    }

    /**
     * Sets the IoC Container.
     *
     * @param \Pimple\Container $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Gets the IoC Container.
     *
     * @return \Pimple\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

}