<?php

if(!class_exists('WP_Radio')) {

	class WP_Radio {

		private static $_instance;

		public function __construct() {

		}

		public static function get_instance() {
			if ( ! isset( self::$_this ) ) {
				self::$_instance = new self;
			}
			return self::$_instance;
		}

	}

	require_once( WPR_DIR . '/classes/class.admin.php' );
	require_once( WPR_DIR . '/classes/class.template.php' );

}

?>