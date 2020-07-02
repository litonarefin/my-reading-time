<?php
/**
 * Plugin Name: AAA My Reading Time
 * Description: Post/Page Reading Time for WordPress
 * Plugin URI:  https://master-addons.com/
 * Version:     1.0.0
 * Author:      Jewel Theme
 * Author URI:  https://master-addons.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mrt
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit; // No Direct access

$plugin_data = get_file_data(__FILE__, 
	array( 'Version' 		=> 'Version',
		'Plugin Name' 	=> 'Plugin Name'), false);
$plugin_name = $plugin_data['Plugin Name'];
$plugin_version = $plugin_data['Version'];

define('MRT', $plugin_name);
define('MRT_VERSION', $plugin_version);
define('MRT_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ));
define('MRT_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ));
define('MRT_TD', load_plugin_textdomain('mrt'));
define('MRT_ADDON', plugin_dir_path( __FILE__ ) . 'inc/elementor/addon/' );
define('MRT_PRO_URL', 'https://jeweltheme.com/');


// Include Files
require plugin_dir_path( __FILE__ ) . 'class-my-reading-time.php';
add_action( 'plugins_loaded', 'jltma_init' );
function jltma_init(){ \MyReadingTime\JLTMA_My_Reading_Time::get_instance(); }