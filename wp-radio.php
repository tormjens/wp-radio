<?php

/*
Plugin Name: WordPress Radio
Plugin URI: https://github.com/tormjens/wp-radio
Description: A plugin for radio stations.
Version: 0.1
Author: Tor Morten Jensen
Author URI: http://tormorten.no
*/

/**
 * Copyright (c) 2014 Tor Morten Jensen. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

// Constants
define('WPR_SLUG', 'wp-radio');
define('WPR_DIR', dirname(__FILE__));
define('WPR_URL', plugins_url( '', __FILE ));
define('WPR_REQUIRE_WP', '3.8');
define('WPR_REQUIRE_PHP', '5.0');

/**
 * Checks if the system requirements are met
 * @author Ian Dunn <ian@iandunn.name>
 * @return bool True if system requirements are met, false if not
 */

function wpr_requirements_met() {
	global $wp_version;

	// check if the current PHP version is satisfying
	if ( version_compare( PHP_VERSION, WPR_REQUIRE_PHP, '<' ) ) {
		return false;
	}

	// check if the current WordPress version is satisfying
	if ( version_compare( $wp_version, WPR_REQUIRE_WP, '<' ) ) {
		return false;
	}

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 * @author Ian Dunn <ian@iandunn.name>
 */

function wpr_requirements_error() {
	global $wp_version;

	require_once( WPR_DIR . '/views/requirements-error.php' );
}

/*
 * Check requirements and load main class
 */

if ( wpr_requirements_met() ) {
	require_once( dirname( __FILE__ ) . '/classes/class.wp-radio.php' );

	if ( class_exists( 'WP_Radio' ) ) {
		$GLOBALS['WPR'] = WP_Radio::get_instance();
		register_activation_hook(   __FILE__, array( $GLOBALS['WPR'], 'activate' ) );
		register_deactivation_hook( __FILE__, array( $GLOBALS['WPR'], 'deactivate' ) );
	}
} else {
	add_action( 'admin_notices', 'wpr_requirements_error' );
}

?>