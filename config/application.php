<?php

use Roots\WPConfig\Config;
use function Env\env;

/**
 * Directory containing all of the site's files
 *
 * @var string
 */
$root_dir = dirname( __DIR__ );

/**
 * Document Root
 *
 * @var string
 */
$webroot_dir = $root_dir . '/web';

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

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
if ( env( 'WP_ENV' ) ) {
	define( 'WP_ENV', env( 'WP_ENV' ) );
} else {
	define( 'WP_ENV', 'production' );
}

/**
 * URLs
 */
Config::define( 'WP_HOME', env( 'WP_HOME' ) );
Config::define( 'WP_SITEURL', env( 'WP_SITEURL' ) );

/**
 * Custom Content Directory
 */
Config::define( 'CONTENT_DIR', '/app' );
Config::define( 'WP_CONTENT_DIR', $webroot_dir . Config::get( 'CONTENT_DIR' ) );
Config::define( 'WP_CONTENT_URL', Config::get( 'WP_HOME' ) . Config::get( 'CONTENT_DIR' ) );

/**
 * DB settings
 */
Config::define( 'DB_NAME', env( 'DB_NAME' ) );
Config::define( 'DB_USER', env( 'DB_USER' ) );
Config::define( 'DB_PASSWORD', env( 'DB_PASSWORD' ) );
if ( env( 'DB_HOST' ) ) {
	Config::define( 'DB_HOST', env( 'DB_HOST' ) );
} else {
	Config::define( 'DB_HOST', 'localhost' );
}
Config::define( 'DB_CHARSET', 'utf8mb4' );
Config::define( 'DB_COLLATE', '' );
if ( env( 'DB_PREFIX' ) ) {
	// @codingStandardsIgnoreStart
	$table_prefix = env( 'DB_PREFIX' );
	// @codingStandardsIgnoreEnd
} else {
	// @codingStandardsIgnoreStart
	$table_prefix = 'ms_';
	// @codingStandardsIgnoreEnd
}

if ( env( 'DATABASE_URL' ) ) {
	$dsn = (object) parse_url( env( 'DATABASE_URL' ) );

	Config::define( 'DB_NAME', substr( $dsn->path, 1 ) );
	Config::define( 'DB_USER', $dsn->user );
	Config::define( 'DB_PASSWORD', $dsn->pass ?? null );
	Config::define( 'DB_HOST', isset( $dsn->port ) ? "$dsn->host:$dsn->port" : $dsn->host );
}

/**
 * Authentication Unique Keys and Salts
 */
Config::define( 'AUTH_KEY', env( 'AUTH_KEY' ) );
Config::define( 'SECURE_AUTH_KEY', env( 'SECURE_AUTH_KEY' ) );
Config::define( 'LOGGED_IN_KEY', env( 'LOGGED_IN_KEY' ) );
Config::define( 'NONCE_KEY', env( 'NONCE_KEY' ) );
Config::define( 'AUTH_SALT', env( 'AUTH_SALT' ) );
Config::define( 'SECURE_AUTH_SALT', env( 'SECURE_AUTH_SALT' ) );
Config::define( 'LOGGED_IN_SALT', env( 'LOGGED_IN_SALT' ) );
Config::define( 'NONCE_SALT', env( 'NONCE_SALT' ) );


/**
 * Custom Settings
 */
Config::define( 'WP_CACHE_KEY_SALT', env( 'WP_CACHE_KEY_SALT' ) );
Config::define( 'COOKIE_DOMAIN', env( 'COOKIE_DOMAIN' ) );

Config::define( 'ENFORCE_GZIP', true );
Config::define( 'CONCATENATE_SCRIPTS', false );
Config::define( 'COMPRESS_SCRIPTS', true );
Config::define( 'COMPRESS_CSS', true );

Config::define( 'WP_MEMORY_LIMIT', '512M' );
Config::define( 'WP_MAX_MEMORY_LIMIT', '512M' );

Config::define( 'FORCE_SSL_LOGIN', true );
Config::define( 'FORCE_SSL_ADMIN', true );

Config::define( 'MEDIA_TRASH', false );
Config::define( 'AUTOSAVE_INTERVAL', 900 );
Config::define( 'WP_POST_REVISIONS', 14 );
Config::define( 'EMPTY_TRASH_DAYS', 7 );

Config::define( 'DISABLE_WP_CRON', true );

Config::define( 'AUTOMATIC_UPDATER_DISABLED', true );
Config::define( 'WP_AUTO_UPDATE_CORE', false );

Config::define( 'FS_CHMOD_FILE', 0644 );
Config::define( 'FS_CHMOD_DIR', 0755 );
Config::define( 'FS_METHOD', 'direct' );
Config::define( 'DISALLOW_FILE_EDIT', true );
Config::define( 'DISALLOW_FILE_MODS', true );


/**
 * Debugging Settings
 */
Config::define( 'WP_DEBUG_DISPLAY', false );
Config::define( 'SCRIPT_DEBUG', false );

/**
 * Allow WordPress to detect HTTPS when used behind a reverse proxy or a load balancer
 * See https://codex.wordpress.org/Function_Reference/is_ssl#Notes
 */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
	$_SERVER['HTTPS'] = 'on';
}

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if ( file_exists( $env_config ) ) {
	require_once __DIR__ . '/environments/' . WP_ENV . '.php';
}

Config::apply();

/**
 * Bootstrap WordPress
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', $webroot_dir . '/wp/' );
}
