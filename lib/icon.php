<?php

namespace Chamber\Theme;

class Icon
{

	/**
	 * Set an icon from the chamber-sprite.svg.php spritesheet.
	 * 
	 * @param str     $name     Name of the icon
	 * @param boolean $wrap    	Wrap in a span tag if true
	 * @param str     $viewbox  the viewbox property of the svg
	 */
	public static function set($name, $wrap = false, $viewbox = '0 0 32 32')
	{
		$icon = '';

		if ($wrap = true) {
			$icon = '<span class="icon" m-Icon="'.$name.'"><svg role="presentation" viewbox="' . $viewbox . '"><use xlink:href="#' . $name . '</use></svg></span>';
		}

		else $icon = '<svg class="icon" role="presentation" viewbox="' . $viewbox . '"><use xlink:href="#' . $name . '</use></svg>';

		return $icon;
	}

}
