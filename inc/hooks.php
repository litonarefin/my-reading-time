<?php
namespace MyReadingTime\Inc;
use MyReadingTime\JLTMA_My_Reading_Time;

defined( 'ABSPATH' ) || exit;

class JLTMA_MRT_Hooks {

	public function __construct() {		

		$this->jltma_mrt_init();

		add_action( 'wp_enqueue_scripts', [$this, 'jltma_mrt_assets'] );

	}

	public function jltma_mrt_assets(){
		wp_enqueue_style( 'mrt-pagescroll-indicator', MRT_URL . '/assets/css/pageScrollIndicator.css' );
		wp_enqueue_script( 'mrt-pagescroll-indicator', MRT_URL . '/assets/js/pageScrollIndicator.js' );
	}


	public function jltma_mrt_init(){

		$mrt_shortcodes_include 	= jltma_mrt_options( 'mrt_shortcodes_include', 'jltma_mrt_settings', 'on' );
		$mrt_exclude_images 		= jltma_mrt_options( 'mrt_exclude_images', 'jltma_mrt_settings', 'on' );
		$mrt_words_per_min 			= jltma_mrt_options( 'mrt_words_per_min', 'jltma_mrt_settings', '200' );
		
		$mrt_before_content 	    = jltma_mrt_options( 'mrt_before_content', 'jltma_mrt_settings', 'on' );
		$mrt_before_excerpt 	    = jltma_mrt_options( 'mrt_before_excerpt', 'jltma_mrt_settings', 'on' );
		
		if( isset($mrt_before_content) && $mrt_before_content == "on"){
			add_filter( 'the_content', [ $this, 'jltma_mrt_before_content' ]);	
		}

		if( isset($mrt_before_excerpt) && $mrt_before_excerpt == "on"){
			add_filter( 'get_the_excerpt', array( $this, 'jltma_mrt_before_excerpt' ), 1000 );
		}

	}



	public function jltma_mrt_before_content( $content ) {
		
		$main_content 	  = $content;
		$mrt_post_id      = get_the_ID();

		$jltma_mrt 		  = jltma_mrt_reading_time( $mrt_post_id );

		$mrt_label        = jltma_mrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', MRT_TD ) );
		$mrt_time_in_mins = jltma_mrt_options( 'mrt_time_in_mins', 'jltma_mrt_settings', esc_html__('mins', MRT_TD ) );
		$mrt_time_in_min  = jltma_mrt_options( 'mrt_time_in_min', 'jltma_mrt_settings', esc_html__('min', MRT_TD ) );


		if ( in_array( 'get_the_excerpt', $GLOBALS['wp_current_filter'], true ) ) {
			return $content;
		}
		
		$calculated_times = JLTMA_My_Reading_Time::jltma_mrt_times( $jltma_mrt, $mrt_time_in_min, $mrt_time_in_min );


		$content  = '<span class="jltma-mrt">
						<span class="mrt-label mrt-prefix">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span> 
						<span class="mrt-time"> ' . esc_html( $jltma_mrt ) . '</span> 
						<span class="mrt-label mrt-postfix">' . wp_kses( $calculated_times, $jltma_mrt ) . '</span>
					</span>';
		$content  .= '<div class="ma-el-page-scroll-indicator"><div class="ma-el-scroll-indicator"></div></div>';					

		$content .= $main_content;

		return $content;
	}



	public function jltma_mrt_before_excerpt( $content ){

		$main_content 	  = $content;
		$mrt_post_id      = get_the_ID();

		$jltma_mrt 		  = jltma_mrt_reading_time( $mrt_post_id );

		$mrt_label        = jltma_mrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', MRT_TD ) );
		$mrt_time_in_mins = jltma_mrt_options( 'mrt_time_in_mins', 'jltma_mrt_settings', esc_html__('mins', MRT_TD ) );
		$mrt_time_in_min  = jltma_mrt_options( 'mrt_time_in_min', 'jltma_mrt_settings', esc_html__('min', MRT_TD ) );


		$calculated_times = JLTMA_My_Reading_Time::jltma_mrt_times( $jltma_mrt, $mrt_time_in_min, $mrt_time_in_min );

		$content  = '<span class="jltma-mrt" style="display: block;">
						<span class="mrt-label mrt-prefix">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span>
						<span class="mrt-time">' . esc_html( $jltma_mrt ) . '</span>
						<span class="mrt-label mrt-postfix">' . wp_kses( $calculated_times, $jltma_mrt ) . '</span>
					</span> ';

		$content .= $main_content;

		return $content;
	}




	
}

new JLTMA_MRT_Hooks();