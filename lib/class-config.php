<?php

namespace Chamber\Theme;

use Illuminate\Support\Arr;

/**
 * Grabs settings from the chamber.config.php file.
 *
 * @package chamber
 */

class Config implements \ArrayAccess
{

    /**
     * All of the configuration config.
     *
     * @var array
     */
    protected $config = null;


    /**
     * Create a new configuration repository.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getConfig();
    }

    /**
     * Create a new configuration repository.
     *
     * @param  array  $config
     * @return void
     */
    public function getConfig()
    {
        if (is_null($this->config))
        {
            $this->config = file_exists("{$this->getRootPath()}/chamber.config.php")
                ? require "{$this->getRootPath()}/chamber.config.php"
                : [];
        }

        return $this->config;
    }

    protected function getRootPath()
    {
        return get_template_directory();
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->config, $key);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($this->config, $innerKey, $innerValue);
            }
        } else {
            Arr::set($this->config, $key, $value);
        }
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key);
        array_unshift($array, $value);
        $this->set($key, $array);
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function push($key, $value)
    {
        $array = $this->get($key);
        $array[] = $value;
        $this->set($key, $array);
    }

    /**
     * Get all of the configuration config for the application.
     *
     * @return array
     */
    public function all()
    {
        return $this->config;
    }

    /**
     * Determine if the given configuration option exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a configuration option.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset a configuration option.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }

}
