<?php

namespace Chamber\Theme;

use Hybrid;
use Pimple\Container;

/**
 * Singleton class for launching the theme and setup configuration.
 * 
 * @package    Chamber Theme
 * @author     Sean Bellows
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class Theme extends Container {

    /**
     * Instance of the theme container.
     * 
     * @var \Pimple\Container
     */
    protected static $instance;

    /**
     * Directory path to the theme folder.
     *
     * @var string
     */
    public $rootPath = '';

    /**
     * Directory URI to the theme folder.
     *
     * @var string
     */
    public $rootURI = '';

    /**
     * The theme's public asset folder.
     *
     * @var string
     */
    public $assetPath = '';

    /**
     * Constructor.
     */
    public function __construct() {
        $this->rootPath = $this->getRootPath();
        $this->rootURI = $this->getRootURI();
        $this->assetPath = $this->getAssetPath();
    }

    /**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Container;
            self::$instance[ 'embedded' ] = function () {
                return new static;
            };
        }

        return self::$instance[ 'embedded' ];
    }

    /**
     * The theme root path.
     *
     * @access private
     * @return void
     */
    public function getRootPath()
    {
        return trailingslashit( get_template_directory() );
    }

    /**
     * The theme root URI.
     *
     * @access private
     * @return void
     */
    public function getRootURI()
    {
        return trailingslashit( get_template_directory_uri() );
    }

    /**
     * The theme public asset path.
     *
     * @access private
     * @return void
     */
    public function getAssetPath()
    {
        return trailingslashit( get_template_directory_uri() . '/public' );
    }

    /**
     * Check if the object requires a dependency.
     * 
     * @param  string   $class The dependency to check for
     * @return integer  number of parameters
     */
    function requiresDependency($class, $hasDependency = FALSE) {
        $parameters = 0;
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ( $constructor !== null ) {
            $parameters = $constructor->getNumberOfParameters();
        }

        if ($parameters > 0) {
            $hasDependency = TRUE;
        }
    }

    /**
     * Get an object's required dependency.
     * 
     * @param  string $class The dependency to check for
     * @return integer  number of parameters
     */
    function getDependencies($class) {
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ( $constructor !== null ) {
            return $constructor->getParameters();
        }
    }

    /**
     * Boot the theme.
     * 
     * @return void
     */
    public function boot()
    {
        $this->registerAliasesToClasses();
        $this->load();

        add_filter('template', function ($stylesheet) {
            return basename($stylesheet);
        });

        add_action('after_switch_theme', function () {
            $stylesheet = get_option('template');
            if (basename($stylesheet) !== 'templates') {
                update_option('template', $stylesheet . '/templates');
            }
        });
    }

    /**
     * Return an array of aliases and class names.
     * 
     * @return array
     */
    public function getAliases()
    {
        $classes = [
            'bootstrap'          => 'Bootstrap',
            'config'             => 'Config',
            'helper'             => 'Helper',
            'extras'             => 'Extras',
            // 'wrapper'            => 'Wrapper',
            'menu'               => 'Menu',
            'sidebar'            => 'Sidebar',
            'contact'            => 'Contact',
            'metabox'            => 'MetaBox',
            'custom-header'      => 'CustomHeader',
            'customizer'         => 'Customizer',
            'shortcodes'         => 'Shortcodes',
            'clean-up'           => 'CleanUp',
            'custom-header'      => 'CustomHeader',
            'customizer'         => 'Customizer',
            'disable-trackbacks' => 'DisableTrackbacks',
            'jquery-cdn'         => 'JqueryCDN',
            'nav-walker'         => 'NavWalker',
            'nice-search'        => 'NiceSearch',
            'relative-urls'      => 'RelativeURLs'
        ];

        return $classes;
    }

    /**
     * Register an alias to a class name and set as a value in 
     * the container array.
     * 
     * @return [type] [description]
     */
    public function registerAliasesToClasses()
    {
        $classes = $this->getAliases();

        foreach ( $classes as $key => $class ) {
            if ( !isset( $this[$key] ) ) {
                $this[$key] = function () use ( $class ) {
                    $className = __NAMESPACE__ . '\\' . $class;

                    return new $className();
                };
            }
        }
    }

    /**
     * Load the bootstrap class and then the modules.
     *
     * NOTE: the Bootstrap instance has to load first!
     * @see https://core.trac.wordpress.org/ticket/27428
     * 
     * @return void
     */
    public function load() {
        // $this->bootHybrid();
        // $this['hybrid-chamber'];
        $this['bootstrap'];
        require_once( $this->rootPath . 'lib/class-wrapper.php' );

        add_action( 'after_setup_theme', [ $this, 'bootModules' ], 0 );
    }

    /**
     * Unload the the modules.
     * 
     * @return void
     */
    public function unload() {
        remove_action( 'after_setup_theme', [ $this, 'bootModules' ], 0 );
    }

    /**
     * Boot the other class instances.
     * 
     * @return void
     */
    public function bootModules() {
        $classes = $this->getAliases();

        foreach( $classes as $key => $value )
        {
            if ( isset( $this[$key] ) )
            {
                if ( method_exists( $this[$key], 'boot' ) )
                {
                    $this[$key]->boot();
                }
            }
        }
    }

}
