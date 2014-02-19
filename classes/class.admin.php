<?php

if(!class_exists('WPR_Admin') && class_exists('WP_Radio')) {

	if(!class_exists('WP_AdminMenuSection'))
		require_once WPR_DIR . '/assets/vendor/class.admin.menu.php';

	if(!class_exists('CMB_Meta_Box'))
		require_once WPR_DIR . '/assets/vendor/Custom-Meta-Boxes/custom-meta-boxes.php';

	class WPR_Admin {

		public function __construct() {

			add_action( 'init', array($this, 'posttypes') );
			add_action( 'admin_menu', array($this, 'admin_menu') );
			add_filter( 'cmb_meta_boxes', array($this, 'fields') );

		}

		/*
		 * Post Type Functions
		 */

		/**
		 * Intialize all the post types needed for the plugin
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function posttypes() {

			self::cpt_shows();
			self::cpt_hosts();

		}

		/**
		 * Add the "Shows" Post Type
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function cpt_shows() {
			
			$labels = array(
				'name'                => __('Shows', WPR_SLUG),
				'singular_name'       => __('Show', WPR_SLUG),
				'menu_name'           => __('Shows', WPR_SLUG),
				'parent_item_colon'   => __('Parent Show:', WPR_SLUG),
				'all_items'           => __('All Shows', WPR_SLUG),
				'view_item'           => __('View Show', WPR_SLUG),
				'add_new_item'        => __('Add New Show', WPR_SLUG),
				'add_new'             => __('New Show', WPR_SLUG),
				'edit_item'           => __('Edit Show', WPR_SLUG),
				'update_item'         => __('Update Show', WPR_SLUG),
				'search_items'        => __('Search Shows', WPR_SLUG),
				'not_found'           => __('No Shows Found!', WPR_SLUG),
				'not_found_in_trash'  => __('No Shows Found in Trash', WPR_SLUG),
			);
			
			$args = array(
				'description'         => 'Description.',
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'          => array(),
				'hierarchical'        => true,
				'public'              => true,
				'has_archive'         => _x('shows', 'Shows Archive Slug', WPR_SLUG),
				'rewrite' 			  => array( 'slug' => _x('show', 'Shows Single Slug', WPR_SLUG), 'with_front' => false ),
				'capability_type'     => 'post',
			);
			
			register_post_type( 'shows', $args );
			
		}

		/**
		 * Add the "Hosts" Post Type
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function cpt_hosts() {
			
			$labels = array(
				'name'                => __('Hosts', WPR_SLUG),
				'singular_name'       => __('Host', WPR_SLUG),
				'menu_name'           => __('Hosts', WPR_SLUG),
				'parent_item_colon'   => __('Parent Host:', WPR_SLUG),
				'all_items'           => __('All Hosts', WPR_SLUG),
				'view_item'           => __('View Host', WPR_SLUG),
				'add_new_item'        => __('Add New Host', WPR_SLUG),
				'add_new'             => __('New Host', WPR_SLUG),
				'edit_item'           => __('Edit Host', WPR_SLUG),
				'update_item'         => __('Update Host', WPR_SLUG),
				'search_items'        => __('Search Hosts', WPR_SLUG),
				'not_found'           => __('No Hosts Found!', WPR_SLUG),
				'not_found_in_trash'  => __('No Hosts Found in Trash', WPR_SLUG),
			);
			
			$args = array(
				'description'         => 'Description.',
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'          => array(),
				'hierarchical'        => true,
				'public'              => true,
				'has_archive'         => _x('hosts', 'Hosts Archive Slug', WPR_SLUG),
				'rewrite' 			  => array( 'slug' => _x('host', 'Hosts Single Slug', WPR_SLUG), 'with_front' => false ),
				'capability_type'     => 'post',
			);
			
			register_post_type( 'hosts', $args );

		}

		/*
		 * Admin Menu Functions
		 */

		/** 
		 * Main Admin Menu Function
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function admin_menu() {

			$plugin_page = WPR_SLUG; 

		    add_menu_page(
		        'WordPress Radio',
		        'WP-Radio',
		        'edit_pages',
		        $plugin_page,
		        array($this, 'admin_main'),
		        'dashicons-format-status',
		        0
		    );

		    // Add a submenu item
		    add_submenu_page( $plugin_page, __('Schedule', WPR_SLUG), __('Schedule', WPR_SLUG), 'manage_options', WPR_SLUG . '_schedule', array($this, 'admin_schedule') );

		    // add a separator
		    add_submenu_page( $plugin_page, 'wp-menu-separator', '', 'read', WPR_SLUG . '_schedule', '' );

		    // the post types to move
		    $cpts = array('shows', 'hosts');

		    foreach($cpts as $key => $cpt) {
		    	$edit = "edit.php?post_type={$cpt}";
		    	$add = "post-new.php?post_type={$cpt}";
    			copy_admin_menu_item( $plugin_page, $edit );
    			copy_admin_menu_item( $plugin_page, $edit, $add );
    			remove_admin_menu_section( $edit );
		    	// add a separator if not on last cpt
		    	if($key != max(array_keys($cpts)))
		    		add_submenu_page( $plugin_page, 'wp-menu-separator', '', 'read', $add, '' );
		    }
		}

		/** 
		 * Main Admin Page
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function admin_main() {
			
		}

		/** 
		 * Schedule Admin Page
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function admin_schedule() {

		}

		/** 
		 * Custom Fields
		 * @author Tor Morten Jensen (tormorten@tormorten.no)
		 */

		public function fields(array $meta) {

			// Fields for "Shows"
			$fields = array(
				array( 'id' => 'show_start', 'name' => __('Show starts', WPR_SLUG), 'desc' => __('The date & time the show starts', WPR_SLUG), 'type' => 'datetime_unix', 'cols' => 6, 'default' => time() ),
				array( 'id' => 'show_duration_hours', 'name' => __('Duration (hours)', WPR_SLUG), 'desc' => __('The duration of the show (hours)', WPR_SLUG), 'type' => 'text_small', 'cols' => 3 ),
				array( 'id' => 'show_duration_minutes', 'name' => __('Duration (minutes)', WPR_SLUG), 'desc' => __('The duration of the show (minutes)', WPR_SLUG), 'type' => 'text_small', 'cols' => 3 ),
				array( 'id' => 'show_host', 'name' => __('Host', WPR_SLUG), 'desc' => __('The host of the show', WPR_SLUG), 'type' => 'post_select', 'query' => array('post_type' => 'hosts', 'numberposts' => -1, 'posts_per_page' => -1), 'use_ajax' => true, 'cols' => 6 ),
				array( 
					'id' => 'show_recurring',
					'name' => __('Repeat Show', WPR_SLUG),
					'desc' => __('The interval the show is to be repeated', WPR_SLUG),
					'type' => 'select',
					'options' => array(
						'weekly' => __('Weekly', WPR_SLUG),
						'weekly-odd' => __('Weekly (odd)', WPR_SLUG),
						'weekly-even' => __('Weekly (even)', WPR_SLUG),
						'monthly' => __('Monthly', WPR_SLUG),
						'yearly' => __('Yearly', WPR_SLUG),
						'never' => __('Never', WPR_SLUG),
					),
					'default' => 'never',
					'cols' => 6
				)
			);

			$meta[] = array(
				'title' => __('Show Information', WPR_SLUG),
				'pages' => 'shows',
				'fields' => $fields
			);

			return $meta;

		}

	}

	new WPR_Admin;

}