<?php
namespace MyReadingTime\Inc;

defined( 'ABSPATH' ) || exit;

class JLTMA_MRT_Hooks {

	public function __construct() {		
		add_filter( 'the_content', [ $this, 'jltma_mrt_before_content' ]);



		// $rt_before_content = $this->rt_convert_boolean( $rt_reading_time_options['before_content'] );

		// if ( isset( $rt_before_content ) && true === $rt_before_content ) {
		// 	add_filter( 'the_content', array( $this, 'rt_add_reading_time_before_content' ) );
		// }

		// $rt_after_content = $this->rt_convert_boolean( $rt_reading_time_options['before_excerpt'] );

		// if ( isset( $rt_after_content ) && true === $rt_after_content ) {
		// 	add_filter( 'get_the_excerpt', array( $this, 'rt_add_reading_time_before_excerpt' ), 1000 );
		// }


	}

	function jltma_mrt_before_content( $content ) {
		
		$main_content 		= $content;
		$mrt_post_id        = get_the_ID();

		jltma_mrt_reading_time( $mrt_post_id );

		$mrt_label            			= jltma_mrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', MRT_TD ) );
		$mrt_time_in_mins          		= jltma_mrt_options( 'mrt_time_in_mins', 'jltma_mrt_settings', esc_html__('mins', MRT_TD ) );
		$mrt_time_in_min 				= jltma_mrt_options( 'mrt_time_in_min', 'jltma_mrt_settings', esc_html__('min', MRT_TD ) );


		if ( in_array( 'get_the_excerpt', $GLOBALS['wp_current_filter'], true ) ) {
			return $content;
		}
		

		// $mrt_obj = new MyReadingTime();
		// print_r($mrt_obj);
		
		$calculated_times = \MyReadingTime::jltma_mrt_times( MyReadingTime::mrt, $atts['mrt_time_in_min'], $atts['mrt_time_in_mins'] );

		$content  = '<span class="jltma-mrt">
					<span class="mrt-label mrt-prefix">' . wp_kses( $mrt_label, MyReadingTime::mrt_attr ) . '</span> 
					<span class="mrt-time"> ' . esc_html( MyReadingTime::mrt ) . '</span> 
					<span class="mrt-label mrt-postfix">' . wp_kses( $calculated_times, MyReadingTime::mrt_attr ) . '</span>
				</span>';
		$content .= $original_content;
		return $content;		

		// $mrt_before_content = jltma_mrt_options( 'mrt_before_content', 'jltma_mrt_settings' );
		// print_r($mrt_before_content);
	}

	
}

new JLTMA_MRT_Hooks();