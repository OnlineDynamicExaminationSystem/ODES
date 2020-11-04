<?php
get_header();
?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
			</header><!-- .archive-header -->

			<?php
			$args = array(
				'posts_per_page' => 20,
				'order' => 'DESC',
				'orderby' => 'date',
				'post_type' => 'diagonisma',
				'paged' => get_query_var('paged'),
				'ignore_sticky_posts' => false
			);
		
			$msr_query = new WP_Query( $args );
			
			if( $msr_query->have_posts() ) {
				while ( $msr_query->have_posts() ) : $msr_query->the_post();
					$stored_meta = get_post_meta( $post->ID );
					$katigoria_id = $stored_meta['msr-katigoria-diag'][0];
					$katigoria = get_term ( $katigoria_id, 'erotiseis_cat' );
					$num_erotiseon = $stored_meta['msr-pollaplis-num-diag'][0] + $stored_meta['msr-anaptiksis-num-diag'][0]; ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h1 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>Category: <?php echo $katigoria->name; ?><br />Questions: <?php echo $num_erotiseon; ?></p>
						</div>
					</article>
				<?php
				endwhile;

				twentytwelve_content_nav( 'nav-below' );
			}
			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
