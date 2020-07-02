<?php
namespace MyReadingTime;

defined( 'ABSPATH' ) || exit;

class JLTMA_My_Reading_Time {

	private static $_instance = null;


    public function __construct(){
		$this->jltma_mrt_include_files();
	}


	public function jltma_mrt_include_files(){
		
		include( MRT_DIR . '/inc/fa-icons.php');
		include( MRT_DIR . '/inc/functions.php');

		// Admin Settings
		include( MRT_DIR . '/admin/class.settings-api.php');
		include( MRT_DIR . '/admin/my-reading-time-settings.php');
	}

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}