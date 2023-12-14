<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

Config::define( 'WP_DEBUG', true );
Config::define( 'WP_DEBUG_DISPLAY', true );

Config::define( 'DISALLOW_INDEXING', true );

Config::define( 'DISALLOW_FILE_MODS', false );
