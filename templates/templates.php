<?php 
function msr_page_templates( $template_path ) {
	global $post, $options;
	$diagonismatapageID = get_option( 'msr_diagonismata_page' );
	
	if ( get_the_ID() == $diagonismatapageID ){
		if( is_page() & file_exists(plugin_dir_path( __FILE__ ) . 'page-diagonismata.php') ) {
			return plugin_dir_path( __FILE__ ) . 'page-diagonismata.php';
		}
	}
	
	return $template_path;
}

add_filter('template_include', 'msr_page_templates');

function msr_single_templates( $single_template ) {
	global $post;
	
	if( file_exists(plugin_dir_path( __FILE__ ) . 'single-diagonisma.php') ) {
		return plugin_dir_path( __FILE__ ) . 'single-diagonisma.php';
	}
	
	return $single_template;
}

add_filter( 'single_template', 'msr_single_templates' );