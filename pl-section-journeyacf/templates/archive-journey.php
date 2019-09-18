<?php if ( have_posts() ) : ?>
<section class="journey-acf">
	<?php
	while ( have_posts() ) :
		the_post();

		$permalink = get_permalink();
		$info = get_field( 'archive-information' );
		?>
	<article <?php post_class( 'journey-post' ) ?>>
		<figure><a href="<?php echo esc_url( $permalink ) ?>">
			<?php the_post_thumbnail( 'medium' ) ?>
		</a></figure>
		<div class="journey-stats">
			<div class="journey-stat">
				<div class="icon">
					<i class="far fa-tags"></i>
				</div>
				<div class="right">
					<div class="top"><?php esc_html_e( 'Price', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['price'] ) ?></div>
				</div>
			</div>
			<div class="journey-stat">
				<div class="icon">
					<i class="far fa-hourglass"></i>
				</div>
				<div class="right">
					<div class="top"><?php esc_html_e( 'Ideal Length', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['ideal-length'] ) ?></div>
				</div>
			</div>
			<div class="journey-stat">
				<div class="icon">
					<i class="far fa-calendar-alt"></i>
				</div>
				<div class="right">
					<div class="top"><?php esc_html_e( 'Time to Travel', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['time-to-travel'] ) ?></div>
				</div>
			</div>
		</div>
		<?php the_title( sprintf( '<h3 class="journey-title"><a href="%s">', esc_url( $permalink ) ), '</a></h3>' ) ?>
		<?php the_field( 'archive-description' ) ?>
	</article><!-- .journey-post -->
		<?php
	endwhile;
	?>
</section>
	<?php
endif;
