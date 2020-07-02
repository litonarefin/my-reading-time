<?php

	//My Estimated time for reading
	function jltma_mrt_reading_time() {
	  global $post;
	  $content = get_post_field( 'post_content', $post->ID );
	  $word_count = str_word_count( strip_tags( $content ) );
	  $readingtime = ceil($word_count / 200);

	  if ($readingtime == 1) {
	    $timer = esc_html__(' min', 'quote');
	  } else {
	    $timer = esc_html__(' mins', 'quote');
	  }
	  $totalreadingtime = $readingtime . $timer;
	  return $totalreadingtime;
	}
