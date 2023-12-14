<?php

require_once dirname( __DIR__ ) . '/vendor/composer/autoload.php';

use Roots\WPConfig\Config;
use function Env\env;

/**
 * Directory containing all of the site's files
 *
 * @var string
 */
$root_dir = dirname( __DIR__ );

/**
 * Use Dotenv to set required environment variables and load .env file in root
 * .env.local will override .env if it exists
 */
$env_files = file_exists( $root_dir . '/.env.local' )
		? array( '.env', '.env.local' )
		: array( '.env' );

$dotenv = Dotenv\Dotenv::createUnsafeImmutable( $root_dir, $env_files, false );

if ( file_exists( $root_dir . '/.env' ) ) {
	$dotenv->load();
	$dotenv->required( array( 'WP_HOME', 'WP_SITEURL' ) );
	if ( ! env( 'DATABASE_URL' ) ) {
		$dotenv->required( array( 'DB_NAME', 'DB_USER', 'DB_PASSWORD' ) );
	}
}

Config::define( 'WFWAF_STORAGE_ENGINE', 'mysqli' );
Config::define( 'WFWAF_DB_NAME', env( 'DB_NAME' ) );
Config::define( 'WFWAF_DB_USER', env( 'DB_USER' ) );
Config::define( 'WFWAF_DB_PASSWORD', env( 'DB_PASSWORD' ) );
if ( env( 'DB_HOST' ) ) {
	Config::define( 'WFWAF_DB_HOST', env( 'DB_HOST' ) );
} else {
	Config::define( 'WFWAF_DB_HOST', 'localhost' );
}
Config::define( 'WFWAF_DB_CHARSET', 'utf8mb4' );
if ( env( 'DB_PREFIX' ) ) {
	Config::define( 'WFWAF_TABLE_PREFIX', env( 'DB_PREFIX' ) );
} else {
	Config::define( 'WFWAF_TABLE_PREFIX', 'ms_' );
}

Config::apply();

if ( file_exists( __DIR__ . '/app/plugins/wordfence/waf/bootstrap.php' ) ) {
	define( 'WFWAF_LOG_PATH', __DIR__ . '/../../../../tmp/wflogs' );
	include_once __DIR__ . '/app/plugins/wordfence/waf/bootstrap.php';
}
