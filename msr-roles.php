<?php

function msr_roles_on_activation() {
	$admin = get_role( 'administrator' );
	$capabilities = array( 'edit_erotisi', 'read_erotisi', 'delete_erotisi', 'edit_erotiseis', 'edit_others_erotiseis', 'publish_erotiseis', 'read_private_erotiseis', 'edit_diagonisma', 'read_diagonisma', 'delete_diagonisma', 'edit_diagonismata', 'edit_others_diagonismata', 'publish_diagonismata', 'read_private_diagonismata', );
	foreach( $capabilities as $capability ) {
		$admin->add_cap( $capability );
	}
	remove_role( 'kathigitis' );
	add_role( 'kathigitis', 'Teacher', 
		array(
			'read' => true,
			'edit_erotisi'			 => true,
			'read_erotisi'			 => true,
			'delete_erotisi'		 => true,
			'edit_erotiseis'		 => true,
			'edit_others_erotiseis'	 => true,
			'publish_erotiseis'		 => true,
			'read_private_erotiseis' => true,
			'edit_diagonisma'			 => true,
			'read_diagonisma'			 => true,
			'delete_diagonisma'			 => true,
			'edit_diagonismata'			 => true,
			'edit_others_diagonismata'	 => true,
			'publish_diagonismata'		 => true,
			'read_private_diagonismata'	 => true,
		)
	);
}