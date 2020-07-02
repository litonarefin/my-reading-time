<?php
namespace MyReadingTime\Inc;

defined( 'ABSPATH' ) || exit;

class JLTMA_MRT_Shortcode {

	public function __construct() {		
		add_shortcode( 'my_reading_time', array( $this, 'jltma_mrt_shortcode' ) );
	}


	public function jltma_mrt_shortcode( $atts, $content = null ){

		$atts = shortcode_atts(
			array(
				'mrt_label'        		=> '',
				'mrt_time_in_mins'     	=> '',
				'mrt_time_in_min' 	   	=> '',
				'post_id'          		=> '',
			), $atts, 'my_reading_time' );

		$mrt_post_id = $atts['post_id'] && ( get_post_status( $atts['post_id'] ) ) ? $atts['post_id'] : get_the_ID();

		jltma_mrt_reading_time( $mrt_post_id );

		$mrt_label = jltma_mrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', MRT_TD ) );
		print_r($mrt_label);
		
		$calculated_times = MyReadingTime::jltma_mrt_times( MyReadingTime::mrt, $atts['mrt_time_in_min'], $atts['mrt_time_in_mins'] );

		return '<span class="jltma-mrt">
					<span class="mrt-label mrt-prefix">' . wp_kses( $mrt_label, MyReadingTime::mrt_attr ) . '</span> 
					<span class="mrt-time"> ' . esc_html( MyReadingTime::mrt ) . '</span> 
					<span class="mrt-label mrt-postfix">' . wp_kses( $calculated_times, MyReadingTime::mrt_attr ) . '</span>
				</span>';
	}

	
}

new JLTMA_MRT_Shortcode();