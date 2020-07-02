<?php

	// Render Options data from admin settings
	function jltma_mrt_options( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}

		return $default;
	}



	/**
	 * Adds additional reading time for images
	 *
	 * Calculate additional reading time added by images in posts. Based on calculations by Medium. https://blog.medium.com/read-time-and-you-bc2048ab620c
	 */
	function mrt_for_images_count( $total_images, $wpm ) {
		$additional_time = 0;
		for ( $i = 1; $i <= $total_images; $i++ ) {
			if ( $i >= 10 ) {
				$additional_time += 3 * (int) $wpm / 60;
			} else {
				$additional_time += ( 12 - ( $i - 1 ) ) * (int) $wpm / 60;
			}
		}
		return $additional_time;
	}



	function jltma_mrt_reading_time( $mrt_post_id ) {

		// $content = get_post_field( 'post_content', $post->ID );
		
		// $readingtime = ceil($word_count / 200);

		// if ($readingtime == 1) {
		// 	$timer = esc_html__(' min', 'quote');
		// } else {
		// 	$timer = esc_html__(' mins', 'quote');
		// }

		// $totalreadingtime = $readingtime . $timer;
		// return $totalreadingtime;



		$mrt_content       = get_post_field( 'post_content', $mrt_post_id );
		$image_count 	   = substr_count( strtolower( $mrt_content ), '<img ' );
		$word_count 	   = str_word_count( strip_tags( $mrt_content ) );
		// $word_count 	  = count( preg_split( '/\s+/', $mrt_content ) );

		// Options
		$mrt_shortcodes_include 	= jltma_mrt_options( 'mrt_shortcodes_include', 'jltma_mrt_settings', 'on' );
		$mrt_exclude_images 		= jltma_mrt_options( 'mrt_exclude_images', 'jltma_mrt_settings', 'on' );
		$mrt_words_per_min 			= jltma_mrt_options( 'mrt_words_per_min', 'jltma_mrt_settings', '200' );
		


		// echo $mrt_shortcodes_include;
		// echo $mrt_exclude_images;
		// echo $mrt_words_per_min;
		// // print_r($jltma_mrt);
		// die();


		if ( isset( $mrt_shortcodes_include ) && $mrt_shortcodes_include == "on" ) {
			$mrt_content = strip_shortcodes( $mrt_content );
		}

		$mrt_content = wp_strip_all_tags( $mrt_content );

		if ( isset( $mrt_exclude_images ) && $mrt_exclude_images =="on") {
			$count_images_words 		 = mrt_for_images_count( $image_count, $mrt_words_per_min );
			$word_count                 += $count_images_words;

		}

		$word_count = apply_filters( 'mrt_word_count', $word_count );

		$jltma_mrt = $word_count / $mrt_words_per_min;


		// If the reading time is 0 then return it as < 1 instead of 0.
		if ( 1 > $jltma_mrt ) {
			$jltma_mrt = __( '< 1', MRT_TD );
		} else {
			$jltma_mrt = ceil( $jltma_mrt );
		}

		return $jltma_mrt;
	}

