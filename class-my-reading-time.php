<?php
namespace MyReadingTime;

defined( 'ABSPATH' ) || exit;

class JLTMA_My_Reading_Time {

	private static $_instance = null;

	public $mrt;
	
	// Allowed HTML Tags
	public static $mrt_attr = [
		'strong' => [],
		'br'     => [],
		'b'      => [],
		'em'     => []
	];

    public function __construct(){
		$this->jltma_mrt_include_files();
	}


	public function jltma_mrt_include_files(){
		
		include( MRT_DIR . '/inc/fa-icons.php');
		include( MRT_DIR . '/inc/functions.php');
		include( MRT_DIR . '/inc/hooks.php');
		include( MRT_DIR . '/inc/shortcodes.php');

		// Admin Settings
		include( MRT_DIR . '/admin/class.settings-api.php');
		include( MRT_DIR . '/admin/my-reading-time-settings.php');


	}


	// My Reading Times Filter
	public static function jltma_mrt_times($time, $single, $plugral ) {
		if ( $time > 1 ) {
			$mrt_in_times = $plugral;
		} else {
			$mrt_in_times = $single;
		}

		$mrt_in_times = apply_filters( 'mrt_edit_times', $mrt_in_times, $time, $single, $plugral );

		return $mrt_in_times;
	}


    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}