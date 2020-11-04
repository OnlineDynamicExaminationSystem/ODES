<?php

	/*
		Register Post type Question
	*/

function msr_erotisi() {
	$labels = array(
		'name'               => 'Questions',
		'singular_name'      => 'Question',
		'add_new'            => 'New Question',
		'add_new_item'       => 'Add Question',
		'edit_item'          => 'Edit Question',
		'new_item'           => 'New Question',
		'all_items'          => 'All Questions',
		'view_item'          => 'View Question',
		'search_items'       => 'Search',
		'not_found'          => 'No questions were found',
		'not_found_in_trash' => 'No questions were found in the bucket', 
		'parent_item_colon'  => '',
		'menu_name'          => 'Questions'
	);
	$args = array(
		'labels'			  => $labels,
		'description'		  => 'Questions',
		'public'			  => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'show_ui'			  => true,
		'show_in_nav_menus'	  => true,
		'show_in_menu'		  => true,
		'menu_position'		  => 20,
		'menu_icon'			  => 'dashicons-editor-ul',
		'supports'			  => array( 'title', 'editor', 'revisions'),
		'has_archive' 		  => false,
		'rewrite'			  => array( 'slug' => 'erotisi' , 'with_front' => true ),
		'capability_type'	  => 'erotiseis',
		'capabilities'		  => array(
			'edit_post'			 => 'edit_erotisi',
			'read_post'			 => 'read_erotisi',
			'delete_post'		 => 'read_erotisi',
			'edit_posts'		 => 'edit_erotiseis',
			'edit_others_posts'	 => 'edit_others_erotiseis',
			'publish_posts'		 => 'publish_erotiseis',
			'read_private_posts' => 'read_private_erotiseis',
			'create_posts'		 => 'edit_erotiseis',
		),
	);
	register_post_type( 'erotisi', $args );	
}
add_action( 'init', 'msr_erotisi' );

function msr_erotisi_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['erotisi'] = array(
		0 => '', 
		1 => sprintf( __('The entry was updated. <a href="%s">Visit</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Updated'),
		3 => __('Deleted.'),
		4 => __('The entry was updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Entry restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('The entry was updated. <a href="%s">Visit</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('The entry was saved.'),
		8 => sprintf( __('The entry was saved. <a target="_blank" href="%s">Preview</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Entry scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('The draft was updated. <a target="_blank" href="%s">Preview</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'msr_erotisi_updated_messages' );

	/*
		Register Custom Taxonomy Categories of Questions
	*/

function msr_erotiseis_cat() {
	$labels = array(
		'name'              => 'Categories of Questions',
		'singular_name'     => 'Category',
		'search_items'      => 'Search',
		'all_items'         => 'All Categories of Questions',
		'parent_item'       => 'Parent Category',
		'parent_item_colon' => 'Parent Category:',
		'edit_item'         => 'Edit', 
		'update_item'       => 'Update',
		'add_new_item'      => 'Add Category',
		'new_item_name'     => 'New Category',
		'menu_name'         => 'Categories',
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'erotiseis-cat', 'with_front' => false ),
		'show_admin_column' => true,
		'show_ui' => true
	);
	register_taxonomy( 'erotiseis_cat', 'erotisi', $args );
}
add_action( 'init', 'msr_erotiseis_cat', 0 );

	/*
		Meta boxes
	*/

function msr_erotiseis_apanmeta() {
	add_meta_box (
		'msr_erotiseis_apanmeta',
		'Options',
		'msr_erotiseis_apanmeta_cb',
		'erotisi',
		'normal',
		'high'
	);
}

add_action( 'add_meta_boxes', 'msr_erotiseis_apanmeta' );

function msr_erotiseis_apanmeta_cb ( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'msr_erotiseis_apanmeta_nonce' );
	$stored_meta = get_post_meta( $post->ID );
?>
	<p><label for="msr-erotiseis-type" class="selectit">Question type:</label><br />
	Multiple <input type="radio" name="msr-erotiseis-type" value="multiple" <?php if( $stored_meta['msr-erotiseis-type'][0] == 'multiple' ) { echo 'checked="checked"'; } ?> class="msr-erotiseis-type" />
	<span style="margin-left:10px;">Description <input type="radio" name="msr-erotiseis-type" value="anaptiksis" <?php if( $stored_meta['msr-erotiseis-type'][0] == 'anaptiksis' ) { echo 'checked="checked"'; } ?> class="msr-erotiseis-type" /></span></p>
	<div class="epiloges-multiple" style="display:none;">
		<table class="msr-erotiseis-apant">
			<tr>
				<td><label for="msr-erotiseis-apanta">Answer A:</label></td>
				<td><textarea name="msr-erotiseis-apanta" id="msr-erotiseis-apanta" class="large-text" rows="5"><?php if ( isset ( $stored_meta['msr-erotiseis-apanta'][0] ) ) echo $stored_meta['msr-erotiseis-apanta'][0]; ?></textarea></td>
			</tr>
			<tr>
				<td><label for="msr-erotiseis-apantb">Answer B:</label></td>
				<td><textarea name="msr-erotiseis-apantb" id="msr-erotiseis-apantb" class="large-text" rows="5"><?php if ( isset ( $stored_meta['msr-erotiseis-apantb'][0] ) ) echo $stored_meta['msr-erotiseis-apantb'][0]; ?></textarea></td>
			</tr>
			<tr>
				<td><label for="msr-erotiseis-apantc">Answer C:</label></td>
				<td><textarea name="msr-erotiseis-apantc" id="msr-erotiseis-apantc" class="large-text" rows="5"><?php if ( isset ( $stored_meta['msr-erotiseis-apantc'][0] ) ) echo $stored_meta['msr-erotiseis-apantc'][0]; ?></textarea></td>
			</tr>
			<tr>
				<td><label for="msr-erotiseis-apantd">Answer D:</label></td>
				<td><textarea name="msr-erotiseis-apantd" id="msr-erotiseis-apantd" class="large-text" rows="5"><?php if ( isset ( $stored_meta['msr-erotiseis-apantd'][0] ) ) echo $stored_meta['msr-erotiseis-apantd'][0]; ?></textarea></td>
			</tr>
		</table>	
		<div class="option_item">
			<h4><label for="msr-erotiseis-apantsosti">Choose the right answer:</label>
			<select id="msr-erotiseis-apantsosti" name="msr-erotiseis-apantsosti">
					<option value="" <?php if ( empty ( $stored_meta['msr-erotiseis-apantsosti'] ) ) selected( $stored_meta['msr-erotiseis-apantsosti'][0], '' ); ?>> </option>
					<option value="apanta" <?php if ( isset ( $stored_meta['msr-erotiseis-apantsosti'] ) ) selected( $stored_meta['msr-erotiseis-apantsosti'][0], 'apanta' ); ?>>A</option> 
					<option value="apantb" <?php if ( isset ( $stored_meta['msr-erotiseis-apantsosti'] ) ) selected( $stored_meta['msr-erotiseis-apantsosti'][0], 'apantb' ); ?>>Β</option> 
					<option value="apantc" <?php if ( isset ( $stored_meta['msr-erotiseis-apantsosti'] ) ) selected( $stored_meta['msr-erotiseis-apantsosti'][0], 'apantc' ); ?>>C</option> 
					<option value="apantd" <?php if ( isset ( $stored_meta['msr-erotiseis-apantsosti'] ) ) selected( $stored_meta['msr-erotiseis-apantsosti'][0], 'apantd' ); ?>>D</option> 
			</select></h4>
		</div>
	</div>
	<script>
		jQuery(document).ready(function(){
			jQuery(".msr-erotiseis-type").click(function(){
				if (jQuery('input[name=msr-erotiseis-type]:checked').val() == "multiple" ) {
					jQuery(".msr-erotiseis-multiple").slideDown("fast");
					jQuery(".epiloges-multiple").css("display","block");
				} else {
					jQuery(".msr-erotiseis-multiple").slideUp("fast");
					jQuery(".epiloges-multiple").css("display","none");
				}
			});
			if (jQuery('input[name=msr-erotiseis-type]:checked').val() == "multiple" ) {
				jQuery(".msr-erotiseis-multiple").slideDown("fast");
				jQuery(".epiloges-multiple").css("display","block");
			} else {
				jQuery(".msr-erotiseis-multiple").slideUp("fast");
				jQuery(".epiloges-multiple").css("display","none");
			}
		});
	</script>
<?php 
}

function msr_erotiseis_apanmeta_save ( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'msr_erotiseis_apanmeta_nonce' ] ) && wp_verify_nonce( $_POST[ 'msr_erotiseis_apanmeta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	if( isset( $_POST[ 'msr-erotiseis-apanta' ] ) ) {
		update_post_meta( $post_id, 'msr-erotiseis-apanta', $_POST[ 'msr-erotiseis-apanta' ] );
	}	
	if( isset( $_POST[ 'msr-erotiseis-apantb' ] ) ) {
		update_post_meta( $post_id, 'msr-erotiseis-apantb', $_POST[ 'msr-erotiseis-apantb' ] );
	}	
	if( isset( $_POST[ 'msr-erotiseis-apantc' ] ) ) {
		update_post_meta( $post_id, 'msr-erotiseis-apantc', $_POST[ 'msr-erotiseis-apantc' ] );
	}	
	if( isset( $_POST[ 'msr-erotiseis-apantd' ] ) ) {
		update_post_meta( $post_id, 'msr-erotiseis-apantd', $_POST[ 'msr-erotiseis-apantd' ] );
	}	
	if( isset( $_POST[ 'msr-erotiseis-apantsosti' ] ) ) {
		update_post_meta( $post_id, 'msr-erotiseis-apantsosti', $_POST[ 'msr-erotiseis-apantsosti' ] );
	}
	if( isset( $_POST[ 'msr-erotiseis-type' ] ) ) {
		update_post_meta( $post_id, 'msr-erotiseis-type', $_POST[ 'msr-erotiseis-type' ] );
	}
}

add_action( 'save_post', 'msr_erotiseis_apanmeta_save' );

	/*
		Show messages
	*/

function msr_erotiseis_apanmeta_errors( $messages ) {
	// https://wisdmlabs.com/blog/display-custom-message-wordpress-admin-panel/
	global $post;
	$stored_meta = get_post_meta( $post->ID );
	if( $stored_meta['msr-erotiseis-type'][0] != 'multiple' && $stored_meta['msr-erotiseis-type'][0] != 'anaptiksis' ){
		foreach( $messages['erotisi'] as $key => $message ) {
			$messages['erotisi'][$key] = $message.'</div><div id="message" class="error notice is-dismissible"><p style="font-weight:600;">CAUTION: You have not selected a type of question</p></div>';
		}
	}
	return $messages;
}

add_filter( 'post_updated_messages', 'msr_erotiseis_apanmeta_errors' );

	/*
		Columns in the Control Panel
	*/

function msr_erotiseis_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Question',
		'msr-erotiseis-type' => 'Question type',
		'erotiseis_cat' => 'Category',
		'date' => 'Date',
	);

	return $columns;
}

add_filter( 'manage_edit-erotisi_columns', 'msr_erotiseis_columns' );

function msr_erotiseis_columns_manage( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'msr-erotiseis-type' :

			$stored_meta = get_post_meta( $post_id, 'msr-erotiseis-type', true );
			if( $stored_meta == 'anaptiksis' ) { $stored_meta = 'Decription'; }
			if( $stored_meta == 'multiple' ) { $stored_meta = 'Multiple'; }

			if ( empty( $stored_meta ) )
				echo '-';

			else
				echo $stored_meta;

			break;

		case 'erotiseis_cat' :

			$terms = get_the_terms( $post_id, 'erotiseis_cat' );

			if ( !empty( $terms ) ) {

				$out = array();

				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'erotiseis_cat' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'erotiseis_cat', 'display' ) )
					);
				}

				echo join( ', ', $out );
			}

			else {
				echo 'Without Category';
			}

			break;

		default :
			break;
	}
}

add_action( 'manage_erotisi_posts_custom_column', 'msr_erotiseis_columns_manage', 10, 2 );