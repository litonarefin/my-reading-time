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
 * Calculate additional reading time added by images in posts. Based on calculations by Medium.  
 * https://blog.medium.com/read-time-and-you-bc2048ab620c
 */
function jltma_mrt_for_images_count( $total_images, $wpm ) {

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


// Calculate Reading time
function jltma_mrt_reading_time( $mrt_post_id ) {

	$mrt_content       = get_post_field( 'post_content', $mrt_post_id );
	$image_count 	   = substr_count( strtolower( $mrt_content ), '<img ' );
	$word_count 	  = count( preg_split( '/\s+/', $mrt_content ) );

	// Options
	$mrt_shortcodes_include 	= jltma_mrt_options( 'mrt_shortcodes_include', 'jltma_mrt_settings', 'on' );
	$mrt_exclude_images 		= jltma_mrt_options( 'mrt_exclude_images', 'jltma_mrt_settings', 'on' );
	$mrt_words_per_min 			= jltma_mrt_options( 'mrt_words_per_min', 'jltma_mrt_settings', '200' );
	

	if ( isset( $mrt_shortcodes_include ) && $mrt_shortcodes_include == "on" ) {
		$mrt_content = strip_shortcodes( $mrt_content );
	}

	$mrt_content = wp_strip_all_tags( $mrt_content );

	if ( isset( $mrt_exclude_images ) && $mrt_exclude_images =="on") {
		$count_images_words 		 = jltma_mrt_for_images_count( $image_count, $mrt_words_per_min );
		$word_count                 += $count_images_words;

	}

	$word_count = apply_filters( 'mrt_word_count', $word_count );
	$jltma_mrt = $word_count / $mrt_words_per_min;


	// If the reading time is 0 then return it as < 1 instead of 0.
	if ( 1 > $jltma_mrt ) {
		$jltma_mrt = esc_html__( '< 1', MRT_TD );
	} else {
		$jltma_mrt = ceil( $jltma_mrt );
	}

	return $jltma_mrt;
}



add_action('wp_head', 'litonarefin_head');
function litonarefin_head(){ ?>

	<style>
		.ma-el-page-scroll-indicator {
		    width: 100%;
		    height: 5px;
		    background: red;
		    position: fixed;
		    top: 0;
		    right: 0;
		    left: 0;
		    z-index: 9999;
		}
		.logged-in.admin-bar .ma-el-page-scroll-indicator{
		    top:32px;
		}
		.ma-el-scroll-indicator {
		    width: 0%;
		    height: 5px;
		    background: #007bff;
		}
	</style>

<?php }

add_action('wp_footer', 'litonarefin');
function litonarefin(){ ?>
	<script>
		// var $ = jQuery.noConflict();
		jQuery(document).ready(function() {
			// "use strict";

			var currentState = document.body.scrollTop || document.documentElement.scrollTop;
	            var pageHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
	            var scrollStatePercentage = (currentState / pageHeight) * 100;
	            document.querySelector(".ma-el-page-scroll-indicator > .ma-el-scroll-indicator").style.width = scrollStatePercentage + "%";

		});

	</script>
<?php }