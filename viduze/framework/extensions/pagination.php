<?php 
   if ( ! function_exists( 'my_pagination' ) ) :
	
	function pagination() {
		global $wp_query;
    	$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'prev_next'    => false,
			'type'    => 'list',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
			
		) );
	}	
endif;

