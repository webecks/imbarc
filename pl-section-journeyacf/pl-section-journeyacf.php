<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_tax_query

/*
Plugin Name: PageLines Section JourneyACF
Description: Add ACF fields in journey single post
Version: 1.0
PageLines: JourneyACF
Filter: component
Loading: refresh
*/

if ( ! class_exists( 'PL_Section' ) ) {
	return;
}

class JourneyACF extends PL_Section {
	function section_opts() {
		$options = [];

		if ( is_post_type_archive( 'journey' ) ) {
			$categories = get_terms( [ 'taxonomy' => 'journey_category' ] );
			$tags = get_terms( [ 'taxonomy' => 'journey_tags' ] );
			$term_opts = [];

			if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					$term_opts[ $category->term_id ] = [ 'name' => $category->name . ' (' . $category->count . ')' ];
				}
			}

			if ( ! empty( $tags ) ) {
				foreach ( $tags as $tag ) {
					$term_opts[ $tag->term_id ] = [ 'name' => $tag->name . ' (' . $tag->count . ')' ];
				}
			}

			if ( ! empty( $term_opts ) ) {
				$options[] = [
					'type' => 'select',
					'key' => 'taxonomy',
					'title' => __( 'Taxonomy', 'pagelines' ),
					'label' => __( 'Term', 'pagelines' ),
					'opts' => $term_opts,
				];
			}
		}

		return $options;
	}

	function section_styles() {
		wp_enqueue_script( 'fontawesome-script', 'https://kit.fontawesome.com/2b70d4c02c.js', [ 'jquery' ], '5.9.0', false );

		if ( is_archive() ) {
			pl_style( 'journey-acf-style', $this->base_url . '/assets/archive-journey.min.css' );
		} else {
			pl_style( 'journey-acf-style', $this->base_url . '/assets/single-journey.min.css' );

			pl_script( 'simple-parallax', $this->base_url . '/assets/parallax.min.js' );
			pl_script( 'journey-acf-script', $this->base_url . '/assets/single-journey.min.js' );
		}
	}

	function section_template() {
		if ( is_post_type_archive( 'journey' ) ) {
			$term = (int) $this->opt( 'taxonomy' );
			$cat = term_exists( $term, 'journey_category' );
			$tag = term_exists( $term, 'journey_tags' );
			$is_cat = 0 !== $cat && null !== $cat;
			$is_tag = 0 !== $tag && null !== $tag;

			if ( ! empty( $term ) && ( $is_cat || $is_tag ) ) {
				global $wp_query;

				$tmp_query = $wp_query;
				$wp_query = null;
				$wp_query = new WP_Query( [
					'post_type' => 'journey',
					'tax_query' => [
						'relation' => 'OR',
						[
							'taxonomy' => 'journey_category',
							'terms' => $term,
						],
						[
							'taxonomy' => 'journey_tags',
							'terms' => $term,
						],
					],
				] );
			}

			include_once $this->base_dir . '/templates/archive-journey.php';

			if ( ! empty( $term ) && ( $is_cat || $is_tag ) ) {
				wp_reset_query();
				$wp_query = null;
				$wp_query = $tmp_query;
			}
		} else {
			include_once $this->base_dir . '/templates/single-journey.php';
		}
	}
}
