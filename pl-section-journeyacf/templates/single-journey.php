<?php
$page_title = get_the_title();
$page_title = false !== strpos( $page_title, '&#038;' ) ? str_replace( '&#038;', '&#038;<br>', $page_title ) : $page_title;
$info = get_field( 'archive-information' );
$region = get_field( 'region' );
$schedules = get_field( 'schedule' );
?>
<ul class="journey-schedule-nav">
<?php for ( $i = 0; $i < count( $schedules ); $i++ ) : ?>
	<li>
		<a href="#<?php echo esc_attr( str_replace( ' ', '', $schedules[ $i ]['title'] ) ) ?>">
			<span class="icon"></span>&nbsp;&nbsp;
			<span class="right"><?php echo esc_html( $schedules[ $i ]['title'] ) ?><span>
		</a>
	</li>
<?php endfor ?>
</ul><!-- .journey-schedule-nav -->
<section class="journey-acf">
	<header class="journey-header fix" style="background-image:url(<?php the_field( 'image' ) ?>)">
		<h2 class="journey-title"><?php echo wp_kses( $page_title, [ 'br' => [] ] ) ?><br>
			<small><?php echo esc_html( get_field( 'title' ) ) ?></small></h2>
	</header><!-- .journey-header -->
	<div class="journey-description">
		<?php the_content() ?>
		<span class="journey-book booknow"><?php esc_html_e( 'Enquire Now', 'pagelines' ) ?></span>
	</div><!-- .journey-description -->
	<div class="journey-stats">
		<div>
			<div class="journey-stat">
				<div class="globe">
					<div class="top"><?php echo wp_kses( $page_title, [ 'br' => [] ] ) ?></div>
					<div class="bottom"><?php echo $region ? esc_html( $region ) : '&nbsp;' ?></div>
				</div>
			</div>
			<div class="journey-stat">
				<div class="tags">
					<div class="top"><?php esc_html_e( 'Starting from', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['price'] ) ?></div>
				</div>
			</div>
			<div class="journey-stat">
				<div class="hourglass">
					<div class="top"><?php esc_html_e( 'Ideal Length', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['ideal-length'] ) ?></div>
				</div>
			</div>
			<div class="journey-stat">
				<div class="calendar">
					<div class="top"><?php esc_html_e( 'Best time to go', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['time-to-travel'] ) ?></div>
				</div>
			</div>
		</div>
	</div><!-- .journey-stats -->
	<div class="journey-content">
		<?php
		if ( have_rows( 'schedule' ) ) {
			while ( have_rows( 'schedule' ) ) {
				the_row();

				$schedule_title = get_sub_field( 'title' );
				?>
		<div id="<?php echo esc_attr( str_replace( ' ', '', $schedule_title ) ) ?>" class="journey-schedule">
			<h3 class="schedule-title"><?php echo esc_html( $schedule_title ) ?><br>
				<span><?php the_sub_field( 'subtitle' ) ?></span></h3>
				<?php
				if ( have_rows( 'activities' ) ) {
					while ( have_rows( 'activities' ) ) {
						the_row();

						$image = (int) get_sub_field( 'image' );
						$note = get_sub_field( 'border-note' );
						$title = get_sub_field( 'title' );
						$description = get_sub_field( 'description' );

						if ( $image ) {
							if ( get_sub_field( 'is-parallax' ) ) {
								?>
			<div
				class="activity-image"
				data-android-fix="true"
				data-image-src="<?php echo esc_url( wp_get_attachment_url( $image ) ) ?>"
				data-ios-fix="true"
				data-parallax="scroll"
			></div>
								<?php
							} else {
								?>
			<div class="activity-image no-lax">
								<?php echo wp_get_attachment_image( $image, 'full' ) ?>
			</div>
								<?php
							}
						}

						$no_text_class = ! $note && ! $title && ! $description ? ' no-text' : '';
						?>
			<div class="activity-text<?php echo esc_attr( $no_text_class ) ?>">
						<?php
						if ( $note ) {
							?>
				<div class="border-note"><?php echo esc_html( $note ) ?></div>
							<?php
						}

						if ( $title ) {
							?>
				<h4 class="activity-title"><?php echo esc_html( $title ) ?></h4>
							<?php
						}

						if ( $description ) {
							?>
				<div class="activity-description"><?php the_sub_field( 'description' ) ?></div>
							<?php
						}
						?>
			</div>
						<?php
					}
				}
				?>
		</div>
				<?php
			}
		}
		?>
	</div><!-- .journey-content -->
</section><!-- .journey-acf -->
