<?php

function msr_elearn_settings_submenu(){
	add_submenu_page( 'msr-elearn-settings', 'elearn-WestMacGR Saved Tests', 'Tests', 'publish_diagonismata', 'msr-elearn-results', 'msr_elearn_results' );
	add_submenu_page( null, 'elearn-WestMacGR Saved Tests', 'Test', 'publish_diagonismata', 'msr-elearn-results-single', 'msr_elearn_results_single' );
	
}

add_action('admin_menu', 'msr_elearn_settings_submenu');

function msr_elearn_results() { 
	global $wpdb;
	$wpdb->msr_elearn_results = $wpdb->prefix . 'msr_elearn_results';
	$wpdb_results = $wpdb->get_results("SELECT * FROM $wpdb->msr_elearn_results");
?>
		<div class="wrap">
		<h1>Saved Tests</h1>
		<table class="wp-list-table widefat fixed striped pages">
	<thead>
		<tr>
			<th id="result_id" class="manage-column column-result_id" style="width:30px;">ID</th>
			<th scope="col" id="diagonisma" class="manage-column column-title">Test</th>
			<th scope="col" id="onoma" class="manage-column column-name">Full Name</th>
			<th scope="col" id="am" class="manage-column column-am">Registration Number</th>
			<th scope="col" id="status" class="manage-column column-status">Status</th>
			<th scope="col" id="status" class="manage-column column-vathmologia">Grade</th>
			<th scope="col" id="date" class="manage-column column-date">Date</th>
		</tr>
	</thead>

	<tbody id="the-list">
		<?php
		foreach( $wpdb_results as $result) {
			$time_submitted = $result->time_submitted;
			$date = strtotime( $time_submitted );
			if( $result->status == 'finalized' ) {
				$status = 'Finalized';
			} elseif( $result->status == 'open' ) {
				$status = 'Open';
			} elseif( $result->status == 'checked' ) {
				$status = 'Checked';
			}
		?>
		<tr id="post-<?php echo $result->result_id; ?>" class="iedit author-self level-0 post-58 type-page status-publish hentry">
			<td class="msr-erotiseis-type column-msr-erotiseis-type" data-colname="ID"><?php echo $result->result_id; ?></td>
			<td class="title column-title has-row-actions column-primary page-title" data-colname="Διαγώνισμα"><strong><a class="row-title" href="/wp-admin/admin.php?page=msr-elearn-results-single&result_id=<?php echo $result->result_id; ?>" title="Επεξεργασία"><?php echo get_the_title( $result->diagonisma_id ); ?></a></strong>
			</td>
			<td class="msr-erotiseis-type column-msr-erotiseis-type" data-colname="Ονοματεπώνυμο"><?php echo $result->second_name.' '.$result->first_name; ?></td>
			<td class="msr-erotiseis-type column-msr-erotiseis-type" data-colname="Α.Μ."><?php echo $result->am; ?></td>
			<td class="msr-erotiseis-type column-msr-erotiseis-type" data-colname="Κατάσταση"><?php echo $status; ?></td>
			<td class="msr-erotiseis-type column-msr-erotiseis-type" data-colname="Βαθμολογία"><?php echo $result->vathmologia; ?></td>
			<td class="msr-erotiseis-type column-msr-erotiseis-type" data-colname="Ημερομηνία"><?php echo date( 'j/m/Y', $date ); ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>

	<tfoot>
		<tr>
			<th id="result_id" class="manage-column column-result_id" style="width:30px;">ID</th>
			<th scope="col" id="diagonisma" class="manage-column column-title">Test</th>
			<th scope="col" id="onoma" class="manage-column column-name">Full Name</th>
			<th scope="col" id="am" class="manage-column column-am">Registration Number</th>
			<th scope="col" id="status" class="manage-column column-status">Status</th>
			<th scope="col" id="status" class="manage-column column-vathmologia">Grade</th>
			<th scope="col" id="date" class="manage-column column-date">Date</th>
		</tr>
	</tfoot>

</table>
		</div>
<?php
}

function msr_elearn_results_single() {
	global $wpdb;
	if( isset( $_POST['save'] ) ) {
		$wpdb->show_errors = TRUE;
		$table_name = $wpdb->prefix . 'msr_elearn_results';
		$result_id = $_GET['result_id'];
		$telikos_vathmos = $_POST['telikos_vathmos'];
		$anaptiksis_id_strip = stripslashes_deep( $_POST['anaptiksis_id_serialize'] );
		$anaptiksis_id_unserialize = unserialize( $anaptiksis_id_strip );
		foreach( $anaptiksis_id_unserialize as $id_anaptiksis ) {
			$telikos_vathmos = $telikos_vathmos + $_POST['vathmos-'.$id_anaptiksis];
		} 
		$data = array(
			'status' => 'checked',
			'vathmologia' => $telikos_vathmos,
		);
		$wpdb->update( $table_name, $data, array( 'result_id' => $result_id ) );
	}
	$result_id = $_GET['result_id'];
	$wpdb->msr_elearn_results = $wpdb->prefix . 'msr_elearn_results';
	$wpdb_result = $wpdb->get_row("SELECT * FROM $wpdb->msr_elearn_results where result_id = $result_id");
?>
	<div class="wrap">
		<h1><?php echo get_the_title( $wpdb_result->diagonisma_id ).'<br />'.$wpdb_result->second_name.' '.$wpdb_result->first_name.'<br />'.$wpdb_result->am; ?></h1>
		<form method="post" id="resultsingleform" name="resultsingleform">
			<?php
			$result_strip = stripslashes_deep( $wpdb_result->answers );
			$result_unserialize = unserialize( $result_strip );
			$telikos_vathmos = 0;
			$erotisi_counter = 0;
			foreach( $result_unserialize as $erotisi ) { 
				$stored_meta = get_post_meta( $erotisi['erotisi_id'] );
				$erotisi_titlos = esc_attr( strip_tags( get_the_title( $erotisi['erotisi_id'] ) ) );
				$erotisi_counter = $erotisi_counter + 1;
				if( $erotisi['correct_answer'] == $erotisi['apantisi'] ) {
					$erotisi_status = 'True';
				} else {
					$erotisi_status = 'False';
				}
			?>
				<h4><?php echo $erotisi_counter.'. '.$erotisi_titlos.' ('.$erotisi['vathmos'].')'; ?></h4>
				<?php
				if( $stored_meta['msr-erotiseis-type'][0] == 'multiple' ) {
				?>
					<ul>
						<li <?php if( $erotisi['apantisi'] == 'apanta' ) { echo 'style="font-weight:bold;"'; } ?>>A. <?php echo $stored_meta['msr-erotiseis-apanta'][0]; ?><li>
						<li <?php if( $erotisi['apantisi'] == 'apantb' ) { echo 'style="font-weight:bold;"'; } ?>>B. <?php echo $stored_meta['msr-erotiseis-apantb'][0]; ?><li>
						<li <?php if( $erotisi['apantisi'] == 'apantc' ) { echo 'style="font-weight:bold;"'; } ?>>C. <?php echo $stored_meta['msr-erotiseis-apantc'][0]; ?><li>
						<li <?php if( $erotisi['apantisi'] == 'apantd' ) { echo 'style="font-weight:bold;"'; } ?>>D. <?php echo $stored_meta['msr-erotiseis-apantd'][0]; ?><li>
					</ul>
					<?php
					if( $erotisi_status == 'True' ) {
						echo '<p style="color:#008000;"><strong>TRUE</strong></p>';
						$telikos_vathmos = $telikos_vathmos + $erotisi['vathmos'];
					} else {
						echo '<p><strong><span style="color:#008000;">FALSE</span>, (The correct answer is: '.$stored_meta['msr-erotiseis-'.$erotisi['correct_answer']][0].')</strong></p>';
					}
				} elseif( $stored_meta['msr-erotiseis-type'][0] == 'anaptiksis' ) {
					$anaptiksis_id[] = $erotisi['erotisi_id'];
					echo '<p>'.$erotisi['apantisi'].'</p>'; ?>
					Grade: <input type="text" name="vathmos-<?php echo $erotisi['erotisi_id']; ?>" id="vathmos-<?php echo $erotisi['erotisi_id']; ?>" /> / <?php echo $erotisi['vathmos']; ?>
				<?php
				}
				?>
			<?php
			}
			
			$anaptiksis_id_serialize = serialize( $anaptiksis_id );
			?>
			<input type="hidden" name="telikos_vathmos" value="<?php echo esc_html( $telikos_vathmos ); ?>" />
			<input type="hidden" name="anaptiksis_id_serialize" value="<?php echo esc_html( $anaptiksis_id_serialize ); ?>" />
			<p><input type="submit" name="save" value="Save" id="savebutton" /></p>
		</form>
	</div>
<?php
}