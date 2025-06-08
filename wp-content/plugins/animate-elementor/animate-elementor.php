<?php
/**
 * Plugin Name:       Animate Elementor – Elementor Scroll, 3D and Background Animations
 * Description:       Animate Elementor lets you effortlessly add smooth and stylish scroll animations to your Elementor widgets using the lightweight and powerful AOS (Animate On Scroll) library.
 * Version:           2.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            SpiderWares
 * Author URI:        https://spiderwares.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       animate-elementor
 * Domain Path:       /languages
 */


defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ANELM_FILE' ) ) :
	define( 'ANELM_FILE', __FILE__ ); // Define the plugin file path.
endif;

if ( ! defined( 'ANELM_BASENAME' ) ) :
	define( 'ANELM_BASENAME', plugin_basename( ANELM_FILE ) ); // Define the plugin basename.
endif;

if ( ! defined( 'ANELM_VERSION' ) ) :
	define( 'ANELM_VERSION', '2.0.1' ); // Define the plugin version.
endif;

if ( ! defined( 'ANELM_PATH' ) ) :
	define( 'ANELM_PATH', plugin_dir_path( __FILE__ ) ); // Define the plugin directory path.
endif;

if ( ! defined( 'ANELM_URL' ) ) :
	define( 'ANELM_URL', plugin_dir_url( __FILE__ ) ); // Define the plugin directory URL.
endif;

if ( ! defined( 'ANELM_UPGRADE_URL' ) ) :
	define( 'ANELM_UPGRADE_URL', '#' ); // Define the upgrade URL.
endif;

include_once ANELM_PATH . 'includes/class-anelm.php';
ANELM::instance();