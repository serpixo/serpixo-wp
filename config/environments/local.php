<?php
/**
 * Configuration overrides for WP_ENV === 'local'
 */

use Roots\WPConfig\Config;

Config::define( 'SAVEQUERIES', true );

Config::define( 'WP_DEBUG', true );
Config::define( 'WP_DEBUG_DISPLAY', true );
Config::define( 'WP_DEBUG_LOG', true );
Config::define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );

Config::define( 'SCRIPT_DEBUG', true );
Config::define( 'DISALLOW_INDEXING', true );

Config::define( 'DISALLOW_FILE_MODS', false );

Config::define( 'FORCE_SSL_LOGIN', false );
Config::define( 'FORCE_SSL_ADMIN', false );

Config::define( 'WP_LOCAL_DEV', true );
