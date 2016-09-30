<?php

namespace Chamber;

class SocialButton
{
	public $socialMedia = [];

	public $name;

	public $url;

	public $template;

	public function __construct()
	{
		add_filter( 'the_content', [&$this, 'render']);
	}

	/**
	 * Render a share link.
	 * 
	 * @param  array  $socialMedia  An associative array with `$name`/`$value` pairs
	 * @return mixed
	 */
	public static function render(array $socialMedia = [])
	{
		$social = collect($socialMedia);

		return $social->each(function ($arr) {
			collect($arr)->map(function ($items) {
				collect($items);
			});
		})->map(function ($item) {
			return self::template($item['name'], $item['url']);
		});
	}

	public static function template($name, $url)
	{
		$template = '';

		$target = $name !== 'email' ? 'target="_blank"' : '';

		$template = '<a class="button" m-Button="share ' . $name . '" href="' . $url .'"'. $target .'aria-label="Share on ' . title_case($name) . '"><span class="icon" m-Icon="' . $name . ' medium has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-' . $name . '"></use></svg></span>' . title_case($name) .'</a>';

		return print_r($template);
	}
}