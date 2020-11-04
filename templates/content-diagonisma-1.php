<form method="post" id="diagonismapreform" name="diagonismapreform" action="">
	<div class="diagonisma-meta">
		<span class="diagonisma-meta-header">Test Details</span>
		<ul class="diagonisma-meta-ul">
			<li>Category: <?php echo $katigoria->name; ?></li>
			<li>Number of Questions: <?php echo $num_erotiseon; ?></li>
			<li>ID Test: <?php echo $diagonisma_id; ?></li>
		</ul>
	</div>
	<div class="diagonisma-content">
		<h3>Student Information</h3>
		<table>
			<tr>
				<td>Name:</td>
				<td><input type="text" name="first_name" required></td>
			</tr>
			<tr>
				<td>Surname:</td>
				<td><input type="text" name="second_name" required></td>
			</tr>
			<tr>
				<td>Student Register Number:</td>
				<td><input type="text" name="am" required></td>
			</tr>
			<tr>
				<td>Year of Studies:</td>
				<td><input type="text" name="etos_spoudon" required></td>
			</tr>
			<tr>
				<td>Lesson / Department:</td>
				<td><input type="text" name="tmima" required></td>
			</tr>
		</table>
	</div>
	<div class="diagonisma-erotiseis">
		<?php
		$args = array(
			'posts_per_page' => $num_pollaplis,
			'order' => 'ASC',
			'orderby' => $tyxaio,
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
			while ( $msr_query->have_posts() ) { $msr_query->the_post();
				$stored_meta = get_post_meta( $post->ID );
				$erotisi_id = get_the_ID();
				$epilegmeni_apantisi = $_POST['erotisi'.$erotisi_id];
				$correct_answer = $stored_meta['msr-erotiseis-apantsosti'][0];

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
			'posts_per_page' => $num_anaptiksis,
			'order' => 'ASC',
			'orderby' => $tyxaio,
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
				$erotisi_id = get_the_ID();

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
	<input type="hidden" name="answers_hidden" value="<?php echo esc_html( $answers_serialize ); ?>" />
	<input type="hidden" name="diagonisma_id" value="<?php echo esc_html( $diagonisma_id ); ?>" />
	<input type="hidden" name="status" value="open" />
	<input type="submit" name="start" value="Start" id="startbutton" />
</form>