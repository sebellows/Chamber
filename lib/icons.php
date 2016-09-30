<?php

namespace Chamber\Icons;

function set($icon, $viewbox)
{
	$viewbox = $viewbox ? !is_null($viewbox) : '0 0 24 24';

	return '<svg class="icon" role="presentation" viewbox="' . $viewbox . '"><use xlink:href="#' . $icon . '</use></svg>';
}
