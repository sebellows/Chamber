<?php

namespace Chamber\Theme;

class Loader {

    protected static $modules = [];
    protected $options = [];

    public static function init($module, $options = []) {
        if (!isset(self::$modules[$module])) {
            self::$modules[$module] = new static((array) $options);
        }
        return self::$modules[$module];
    }

    public static function getByFile($file) {
        if (file_exists($file) || file_exists(__DIR__ . '/modules/' . $file)) {
            return self::get('chamber-' . basename($file, '.php'));
        }
        return [];
    }

    public static function get($module) {
        if (isset(self::$modules[$module])) {
            return self::$modules[$module]->options;
        }
        if (substr($module, 0, 5) !== 'chamber-') {
            return self::get('chamber-' . $module);
        }
        return [];
    }

    protected function __construct($options) {
        $this->set($options);
    }

    public function set($options) {
        $this->options = $options;
    }
}

require_once __DIR__ . '/utils.php';

function load_modules() {
    global $_wp_theme_features;
    foreach (glob(__DIR__ . '/modules/*.php') as $file) {
        $feature = 'chamber-' . basename($file, '.php');
        if (isset($_wp_theme_features[$feature])) {
            Loader::init($feature, $_wp_theme_features[$feature]);
            require_once $file;
        }
    }
}
add_action('after_setup_theme', __NAMESPACE__ . '\\load_modules', 100);
