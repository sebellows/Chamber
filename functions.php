<?php

namespace Chamber\Theme;

use Chamber\Theme\Theme;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	require __DIR__ . '/vendor/autoload.php';

global $chamber_theme;

$chamber_theme = Theme::getInstance();
// dd($chamber_theme);
$chamber_theme->boot();

// dd(chamber('bootstrap'));
