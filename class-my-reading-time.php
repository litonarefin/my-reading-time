<?php
namespace MyReadingTime;

defined( 'ABSPATH' ) || exit;

class JLTMA_My_Reading_Time {

	private static $_instance = null;


    public function __construct(){
		$this->jltma_mrt_include_files();
        // add_action('admin_footer', [$this, 'jltma_header_footer_modal_view']);
	}


	public function jltma_mrt_include_files(){
		
		include( MRT_DIR . '/admin/class.settings-api.php');

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