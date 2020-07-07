<?php
namespace MyReadingTime\Inc;
use MyReadingTime\JLTMA_My_Reading_Time;

defined( 'ABSPATH' ) || exit;

class JLTMA_MRT_Hooks {

	public function __construct() {		

		$this->jltma_mrt_init();
		
		$this->jltma_mrt_scripts();

	}


	public function jltma_mrt_scripts(){
		$mrt_enable_progress 	= jltma_mrt_options( 'mrt_enable_progress', 'jltma_mrt_onscroll', 'on' );
		if( $mrt_enable_progress =="on" ){
			add_action( 'wp_enqueue_scripts', [$this, 'jltma_mrt_assets'] );
		}
		
	}
	

	public function jltma_mrt_assets(){
		wp_enqueue_style( 'mrt-pagescroll-indicator', MRT_URL . '/assets/css/pageScrollIndicator.css' );
		wp_enqueue_script( 'mrt-pagescroll-indicator', MRT_URL . '/assets/js/pageScrollIndicator.js', array('jquery'), MRT_VERSION, true );

		
		$mrt_bg_color 			= jltma_mrt_options( 'mrt_bg_color', 'jltma_mrt_onscroll', '#2c3e50' );
		$mrt_progress_color 	= jltma_mrt_options( 'mrt_progress_color', 'jltma_mrt_onscroll', '#007bff' );
		$mrt_progress_height 	= jltma_mrt_options( 'mrt_progress_height', 'jltma_mrt_onscroll', '5' );
		
		$jltma_mrt_custom_css = "";

		if( $mrt_bg_color !="" && $mrt_progress_color !="" ){
	        $jltma_mrt_custom_css .= "
	            .ma-el-page-scroll-indicator{ background: {$mrt_bg_color};}
	            .ma-el-scroll-indicator{ background: {$mrt_progress_color};}
	            .ma-el-page-scroll-indicator, .ma-el-scroll-indicator{ height: {$mrt_progress_height}px;}";
		}

        wp_add_inline_style( 'mrt-pagescroll-indicator', $jltma_mrt_custom_css );
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
		
		$calculated_times = JLTMA_My_Reading_Time::jltma_mrt_times( $jltma_mrt, $mrt_time_in_min, $mrt_time_in_mins );

		// Label Alignment before/after
		$mrt_label_position  = jltma_mrt_options( 'mrt_label_position', 'jltma_mrt_settings', 'before' );
		
		if( $mrt_label_position == "before"){
			$mrt_contents = '<span class="mrt-label">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span> <span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span>';
		}elseif ($mrt_label_position == "after") {
			$mrt_contents = '<span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span> <span class="mrt-label"> ' . wp_kses( $mrt_label, $jltma_mrt ) . '</span>';
		}

		$content  = '<span class="jltma-mrt">' . $mrt_contents . '</span>';

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


		$calculated_times = JLTMA_My_Reading_Time::jltma_mrt_times( $jltma_mrt, $mrt_time_in_min, $mrt_time_in_mins );


		// Label Alignment before/after
		$mrt_label_position  = jltma_mrt_options( 'mrt_label_position', 'jltma_mrt_settings', 'before' );
		
		if( $mrt_label_position == "before"){
			$mrt_contents = '<span class="mrt-label">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span> <span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span>';
		}elseif ($mrt_label_position == "after") {
			$mrt_contents = '<span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span> <span class="mrt-label"> ' . wp_kses( $mrt_label, $jltma_mrt ) . '</span>';
		}

		
		$content  = '<span class="jltma-mrt" style="display: block;">' . $mrt_contents . '</span> ';

		$content .= $main_content;

		return $content;
	}




	
}

new JLTMA_MRT_Hooks();