<?php

namespace Chamber\Theme;

/**
 * Theme color scheme that is used by the ACF Restrict Color Picker plugin.
 *
 * @package chamber
 */

class Color
{
	public static function set($color)
	{
		$colors = [
			'paper'          => '#fefefe',
			'neutral light'  => '#cfd8dc',
			'neutral medium' => '#45555c',
			'neutral dark'   => '#263238',
			'alert'          => '#ec5840',
			'success'        => '#3adb76',
			'warning'        => '#ffae00',
			'primary'        => '#005f96',
			'brand'          => '#0f4466',
			'brand light'    => '#009dd7',
			'brand medium'   => '#005f96',
			'brand dark'     => '#003355',
			'cvb'            => '#eb6b23',
			'development'    => '#84c256',
			'education'      => '#4a54aa',
			'members'        => '#438fc7',
			'shared'         => '#a71930'
		];

		return collect($colors)->search($color);
	}
}
