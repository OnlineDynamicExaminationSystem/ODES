<form method="post" id="diagonismaform" name="diagonismaform" onsubmit="return confirm('CAUTION! After finalizing you cannot change your answers')">
	<div class="diagonisma-meta">
		<span class="diagonisma-meta-header">Test Details</span>
		<ul class="diagonisma-meta-ul">
			<li>Category: <?php echo $katigoria->name; ?></li>
			<li>Number of Questions: <?php echo $num_erotiseon; ?></li>
			<li>ID Test: <?php echo $diagonisma_id; ?></li>
		</ul>
	</div>
	<div class="diagonisma-content">
		<?php
		$wpdb->msr_elearn_results = $wpdb->prefix . 'msr_elearn_results';
		$wpdb_result = $wpdb->get_row("SELECT * FROM $wpdb->msr_elearn_results where result_id = $mysql_insert_id");
		?>
		<table>
			<tr>
				<td>Name:</td>
				<td><?php echo $wpdb_result->first_name; ?></td>
			</tr>
			<tr>
				<td>Surname:</td>
				<td><?php echo $wpdb_result->second_name; ?></td>
			</tr>
			<tr>
				<td>Student Register Number:</td>
				<td><?php echo $wpdb_result->am; ?></td>
			</tr>
			<tr>
				<td>Year of Studies:</td>
				<td><?php echo $wpdb_result->etos_spoudon; ?></td>
			</tr>
			<tr>
				<td>Lesson / Department:</td>
				<td><?php echo $wpdb_result->tmima; ?></td>
			</tr>
		</table>
		<?php the_content(); ?>
	</div>
	<div class="diagonisma-erotiseis">
		<?php
		$result_strip = stripslashes_deep( $wpdb_result->answers );
		$result_unserialize = unserialize( $result_strip );
		foreach( $result_unserialize as $erotiseis ) {
			$erotiseis_id[] = $erotiseis['erotisi_id']; 
		}
		$args = array(
			'posts_per_page' => -1,
			'order' => 'ASC',
			'post__in' => $erotiseis_id,
			'post_type' => 'erotisi',
			'meta_key' => 'msr-erotiseis-type',
			'meta_query' => array(
				array(
					'key' => 'msr-erotiseis-type',
					'value' => 'multiple',
				),
			)
		);

		$msr_query = new WP_Query( $args );
		
		if ( $msr_query->have_posts() ) {
			$erotisi_num = 0;
			while ( $msr_query->have_posts() ) { $msr_query->the_post();
				$stored_meta = get_post_meta( $post->ID );
				$erotisi_num = $erotisi_num + 1;
				$erotisi_title = esc_attr( strip_tags( get_the_title() ) );
				$erotisi_id = get_the_ID();
				$correct_answer = $stored_meta['msr-erotiseis-apantsosti'][0];
				$a = '<div class="pollaplis-abcd"><input type="radio" name="erotisi'.$erotisi_id.'" value="apanta" id="erotisi'.$erotisi_id.'_A" /><label for="erotisi'.$erotisi_id.'_A">'.$stored_meta['msr-erotiseis-apanta'][0].'</label></div>';
				$b = '<div class="pollaplis-abcd"><input type="radio" name="erotisi'.$erotisi_id.'" value="apantb" id="erotisi'.$erotisi_id.'_B" /><label for="erotisi'.$erotisi_id.'_B">'.$stored_meta['msr-erotiseis-apantb'][0].'</label></div>';
				$c = '<div class="pollaplis-abcd"><input type="radio" name="erotisi'.$erotisi_id.'" value="apantc" id="erotisi'.$erotisi_id.'_C" /><label for="erotisi'.$erotisi_id.'_C">'.$stored_meta['msr-erotiseis-apantc'][0].'</label></div>';
				$d = '<div class="pollaplis-abcd"><input type="radio" name="erotisi'.$erotisi_id.'" value="apantd" id="erotisi'.$erotisi_id.'_D" /><label for="erotisi'.$erotisi_id.'_D">'.$stored_meta['msr-erotiseis-apantd'][0].'</label></div>';
				$apantiseis = array( $a, $b, $c, $d );
				shuffle( $apantiseis );
				?>
				<div class="erotisi-single erotisi-single-<?php echo $erotisi_num; ?>">
					<div class="erotisi-title"><?php echo '<strong>'.$erotisi_num.'. '.$erotisi_title.'</strong> ('.$var_pollaplis_each.' Units)'; ?></div>
					<div class="erotisi-content">
						<?php the_content(); ?>
					</div>
					<div class="erotisi-answers">
						<?php echo $apantiseis[0]; ?>
						<?php echo $apantiseis[1]; ?>
						<?php echo $apantiseis[2]; ?>
						<?php echo $apantiseis[3]; ?>
					</div>
				</div>
			<?php
				$epilegmeni_apantisi = $_POST['erotisi'.$erotisi_id];
				$answers[] = array (
					'erotisi_id' => $erotisi_id,
					'correct_answer' => $correct_answer,
					'apantisi' => $epilegmeni_apantisi,
					'vathmos' => $var_pollaplis_each,
				);
			}
		}
		
		wp_reset_postdata();
		
		$args = array(
			'posts_per_page' => -1,
			'order' => 'ASC',
			'post__in' => $erotiseis_id,
			'post_type' => 'erotisi',
			'meta_key' => 'msr-erotiseis-type',
			'meta_query' => array(
				array(
					'key' => 'msr-erotiseis-type',
					'value' => 'anaptiksis',
				),
			)
		);
		
		$msr_query = new WP_Query( $args );
		
		if ( $msr_query->have_posts() ) {
			while ( $msr_query->have_posts() ) { $msr_query->the_post();
				$stored_meta = get_post_meta( $post->ID );
				$erotisi_num = $erotisi_num + 1;
				$erotisi_title = esc_attr( strip_tags( get_the_title() ) );
				$erotisi_id = get_the_ID();
				?>
				<div class="erotisi-single erotisi-single-<?php echo $erotisi_num; ?>">
					<div class="erotisi-title"><?php echo '<strong>'.$erotisi_num.'. '.$erotisi_title.'</strong> ('.$var_anaptiksis_each.' Units)'; ?></div>
					<div class="erotisi-content">
						<?php the_content(); ?>
					</div>
					<div class="erotisi-answer">
						<?php echo '<label for="erotisi'.$erotisi_id.'">Your Answer:</label><textarea rows="10" name="erotisi'.$erotisi_id.'" id="erotisi'.$erotisi_id.'" style="width:100%;box-sizing:border-box;"></textarea>'; ?>
					</div>
				</div>
			<?php
				$anaptiksis_apantisi = $_POST['erotisi'.$erotisi_id];
				$answers[] = array (
					'erotisi_id' => $erotisi_id,
					'correct_answer' => '',
					'apantisi' => $anaptiksis_apantisi,
					'vathmos' => $var_anaptiksis_each,
				);
			}
		}
		
		wp_reset_postdata(); 
		
		$answers_serialize = serialize( $answers );
		?>
	</div>

	<input type="hidden" name="answers_hidden2" value="<?php echo esc_html( $answers_serialize ); ?>" />
	<input type="hidden" name="results_id" value="<?php echo esc_html( $mysql_insert_id ); ?>" />
	<input type="hidden" name="status" value="finalized" />
	<input type="submit" name="finalize" value="Finalize" id="finalizebutton" />
</form>