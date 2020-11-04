<?php
if( isset( $_POST['start'] ) ) {
	global $wpdb;
	$wpdb->show_errors = TRUE;
	$table_name = $wpdb->prefix . 'msr_elearn_results';
	$data = array(
		'diagonisma_id' => $_POST['diagonisma_id'],
		'first_name' => $_POST['first_name'],
		'second_name' => $_POST['second_name'],
		'etos_spoudon' => $_POST['etos_spoudon'],
		'am' => $_POST['am'],
		'tmima' => $_POST['tmima'],
		'status' => $_POST['status'],
		'answers' => $_POST['answers_hidden'],
		'time_submitted' => date('Y-m-d H:i:s'),
	);
	$saved_ok = $wpdb->insert( $table_name, $data, '%s' );
	$mysql_insert_id = $wpdb->insert_id;
	if( $saved_ok ) {
			$saved_ok = 'ok';
			$status = 'open';
	}
}
if( isset( $_POST['finalize'] ) ) {
	global $wpdb;
	$wpdb->show_errors = TRUE;
	$table_name = $wpdb->prefix . 'msr_elearn_results';
	$results_id = $_POST['results_id'];
	$wpdb->msr_elearn_results = $wpdb->prefix . 'msr_elearn_results';
	$wpdb_result = $wpdb->get_row("SELECT * FROM $wpdb->msr_elearn_results where result_id = $results_id");
	$result_strip = stripslashes_deep( $wpdb_result->answers );
	$result_unserialize = unserialize( $result_strip );
	foreach( $result_unserialize as $key => $value ) {
		foreach( $value as $k => $v ) {
			$value['apantisi'] = $_POST['erotisi'.$value['erotisi_id']];
		}
		$answers[] = $value;
	}
	$answers_serialize = serialize( $answers );
	$data = array(
		'answers' => $answers_serialize,
		'time_submitted' => date('Y-m-d H:i:s'),
		'status' => $_POST['status'],
	);
	$finalized_ok = $wpdb->update( $table_name, $data, array( 'result_id' => $results_id ), '%s' );
	if( $finalized_ok ) {
		$status = 'finalized';
	}
}
get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) { the_post();
				$stored_meta = get_post_meta( $post->ID );
				$diagonisma_id = get_the_ID();
				$katigoria_id = $stored_meta['msr-katigoria-diag'][0];
				$katigoria = get_term ( $katigoria_id, 'erotiseis_cat' );
				$num_erotiseon = $stored_meta['msr-pollaplis-num-diag'][0] + $stored_meta['msr-anaptiksis-num-diag'][0];
				$num_pollaplis = $stored_meta['msr-pollaplis-num-diag'][0];
				$num_anaptiksis = $stored_meta['msr-anaptiksis-num-diag'][0];
				$var_total = $stored_meta['msr-pollaplis-var-diag'][0] + $stored_meta['msr-anaptiksis-var-diag'][0];
				$var_anaptiksis = $stored_meta['msr-anaptiksis-var-diag'][0] * $stored_meta['msr-vathm-diag'][0] / $var_total;
				$var_anaptiksis_each = $var_anaptiksis / $num_anaptiksis;
				$var_anaptiksis_each = number_format( $var_anaptiksis_each, 2 );
				$var_anaptiksis = number_format( $var_anaptiksis, 2 );
				$var_pollaplis = $stored_meta['msr-pollaplis-var-diag'][0] * $stored_meta['msr-vathm-diag'][0] / $var_total;
				$var_pollaplis_each = $var_pollaplis / $num_pollaplis;
				$var_pollaplis_each = number_format( $var_pollaplis_each, 2 );
				$var_pollaplis = number_format( $var_pollaplis, 2 );
				if( $stored_meta['msr-random-diag'][0] == 'no' ) {
					$tyxaio = 'ID';
				} else {
					$tyxaio = 'rand';
				}
			?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?><?php echo 'status: '.$status; ?></h1>
					</header><!-- .entry-header -->				
				</article>
				<div class="entry-content">
				<?php
				if( $status == 'open' ) {
					include( 'content-diagonisma-2.php' );
				} else {
					include( 'content-diagonisma-1.php' );
				}
				?>
				</div><!-- .entry-content -->

			<?php 
			} // end of the loop.	?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>