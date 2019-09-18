<?php
/*
Plugin Name:  PageLines Section Loops Journey
Description:  A powerful section for controlling the native WordPress loop and WP Query. With layout controls.
Version:      5.0.20
PageLines:    PL_Loops_Journey_Section
Filter:       content
Category:     framework, sections, free, featured
Tags:         loop, grid, magazine, taxonomy, posts, cpt
*/

if ( ! class_exists( 'PL_Section' ) ) {
	return;
}

class PL_Loops_Journey_Section extends PL_Section {

	function section_persistent() {

	  add_filter('pl_binding_' . $this->id, array( $this, 'callback'), 10, 2);

	  $this->add_shortcodes();

	  add_action( 'template_redirect', array( $this, 'check_post_object' ) );
	}

	function check_post_object() {
	  if( ! isset( $this->p ) ) {
		global $post;
		$this->p = $post;
	  }
	}

	function callback( $response, $data ){

	  $response['template'] = $this->do_callback( $data['value']);


	  return $response;
	}

	function section_opts(){

		$options   = array();



		$options[] = array(
			'title' => __('Layout Options', 'pl-section-loops'),
			'type'  => 'multi',
			'conf'  => true,
			'opts'  => array(
				array(
					'key'           => 'shortcodes',
					'default'       => sprintf('[loops_media]%1$s[loops_date]%1$s[loops_title]%1$s[loops_excerpt]', "\n"),
					'type'          => 'textarea',
					'label'         => __( 'Loops Shortcodes / HTML', 'pl-section-loops' ),
					'ref'           => $this->shortcode_doc(),

				),
				array(
					'key'       => 'columns',
					'type'      => 'select',
					'label'     => __( 'Grid Columns Standard', 'pl-section-loops' ),
					'default'   => 3,
					'opts'          => array(
						'12'    => array('name' => __( '1 Column (default)', 'pl-section-loops' ) ),
						'6'     => array('name' => __( '2 Columns', 'pl-section-loops' ) ),
						'4'     => array('name' => __( '3 Columns', 'pl-section-loops' ) ),
						'3'     => array('name' => __( '4 Columns', 'pl-section-loops' ) ),
						'2'     => array('name' => __( '6 Columns', 'pl-section-loops' ) )
					),
					'priv'  => 'pro',
				),
				array(
					'key'       => 'columns_mobile',
					'type'      => 'select',
					'label'     => __( 'Grid Columns On Mobile', 'pl-section-loops' ),
					'default'   => 6,
					'opts'          => array(
						'12'    => array('name' => __( '1 Column (default)', 'pl-section-loops' ) ),
						'6'     => array('name' => __( '2 Columns', 'pl-section-loops' ) ),
						'4'     => array('name' => __( '3 Columns', 'pl-section-loops' ) ),
						'3'     => array('name' => __( '4 Columns', 'pl-section-loops' ) ),
						'2'     => array('name' => __( '6 Columns', 'pl-section-loops' ) )
					),
					'priv'  => 'pro',
				),

				array(
					'key'           => 'loopfontsize',
					'conf'          => false,
					'default'       => 14,
					'count_start'   => 10,
					'count_number'  => 32,
					'type'          => 'count_select',
					'label'         => __( 'Base Font Size (px)', 'pl-section-loops' ),
				),
				'priv'  => 'pro',
			)
		);

		$options[] = array(
			'title' => __('Query Options', 'pl-section-loops'),
			'conf'  => true,
			'type'  => 'multi',
			'opts'  => array(
				array(
					'key'       => 'default_query',
					'type'      => 'check',
					'default'   => 'false',
					'label'     => __( 'Use default query object?', 'pl-section-loops' ),
					'help'      => __( 'If selected Loops will use the standard query object provided by WordPress and all the query options below will be ignored. You can use this option on search pages, archives etc.', 'pl-section-loops' )
				),
				array(
					'key'       => 'post_type',
					'type'      => 'select',
					'opts'      => pl_post_types_with_thumbs(),
					'default'   => 'journey',
					'label'     => __('Select Post Type', 'pl-section-loops'),
					'priv'  => 'pro',
				),
				array(
					'key'       => 'taxonomy',
					'type'      => 'select_term',
					'trigger'   => 'post_type',
					'label'     => __('Select Taxonomy Term', 'pl-section-loops'),
				),
				array(
					'key'       => 'order',
					'type'      => 'select',
					'label'     => __( 'Sort elements by postdate', 'pl-section-loops' ),
					'default'   => 'DESC',
					'priv'  => 'pro',
					'opts'          => array(
						'DESC'      => array('name' => __( 'Date Descending (default)', 'pl-section-loops' ) ),
						'ASC'       => array('name' => __( 'Date Ascending', 'pl-section-loops' ) ),
						'rand'      => array('name' => __( 'Random', 'pl-section-loops' ) )
					)
				),
				array(
					'key'           => 'posts_per_page',
					'type'          => 'count_select',
					'default'       => 8,
					'count_number'  => 32,
					'label'         => __( 'Posts Per Page (adds pagination)', 'pl-section-loops' ),
				),
				array(
					'key'           => 'post_offset',
					'type'          => 'count_select',
					'default'       => 0,
					'count_number'  => '30',
					'priv'  => 'pro',
					'label'         => __( 'Posts Offset', 'pl-section-loops' ),
				),
				array(
				  'key' => 'meta_query_opts',
				  'title' => __( 'Meta Query Options', 'pl-section-loops' ),
				   'conf'  => false,
				  'type'  => 'multi',
				  'help'   => __( 'Click <a href="https://codex.wordpress.org/Class_Reference/WP_Query#Custom_Field_Parameters" target ="_blank">here</a> for WP_Query Documentation on the WordPress Codex<br />(opens in new tab)', 'pl-section-loops' ),
				  'opts'  => array(
					array(
					  'key' => 'relation',
					  'label' => __( 'Relation', 'pl-section-loops' ),
					  'help'  => __( 'The logical relationship between each meta_query when there is more than one.', 'pl-section-loops' ),
					  'default' => 'OR',
					  'type'  => 'select',
					  'opts'  => array(
						'OR'  => array( 'name' => 'OR' ),
						'AND'  => array( 'name' => 'AND' ),
					  )
					),
					array(
					  'type'  => 'accordion',
					  'label' => 'ops',
					  'key' => 'meta_opts',
					  'opts'  => array(
						array(
						  'key' => 'key',
						  'label' => 'Meta Key',
						  'default' => '',
						  'type'  => 'text'
						),
						array(
						  'key' => 'value',
						  'label' => 'Meta Value',
						  'default' => '',
						  'type'  => 'text'
						),
						array(
						  'key' => 'compare',
						  'label' => 'Compare',
						  'type'  => 'select',
						  'default' => '=',
						  'opts' => array(
							'='      => array('name' => '='),
							'!='     => array('name' => '!='),
							'>'      => array('name' => '>'),
							'<'      => array('name' => '<'),
							'LIKE'   => array('name' => 'LIKE'),
							'NOT LIKE'   => array('name' => 'NOT LIKE'),
						  )
						)
					  )
					)
				  )
				)
			)
		);

		return $options;

	}

	/**
	 * For some reason the styles are getting encoded twice,
	 * So put a workaround here... although probably should figure out why they getting loaded twice.
	 * Reason is: pl-platform section class autoloads the style.css if section is on the page.
	 * So if a shortcode requires css, either the section HAS to be on the page, or we do this.
	 */
	function styles() {

	  global $pl_live_styles;
	  $slug  = sprintf( 'pl-%s', $this->id );
	  $check = wp_style_is( $slug, 'registered' );

	  if( ! isset( $pl_live_styles[$this->id] ) && ! $check ) {
		pl_style( $slug, $this->base_url . '/style.css' );
	  }
	}


	function section_template(){
	  ?>
	  <div class="loops-wrap" data-bind="<?php echo pl_make_callback( $this->get_config() );?>" data-callback="<?php echo $this->id;?>"> <?php echo $this->do_callback( $this->get_config() ); ?></div>
	  <?php
	}

	function do_callback( $config ){

	  $out   = '';
	  $query = $this->fetch_posts( $config );
	  if( isset( $query->query_vars['paged'] ) ) {

		// make sure if we are on root page that current is 1, not 0.
		$current = ( 0 === $query->query_vars['paged'] ) ? 1 : $query->query_vars['paged'];
		$total   = $query->max_num_pages;
		$pagination = paginate_links( array(
		  'current' => $current,
		  'total'   => $total
		)
		);
	  }

	  $pagination = ( $pagination != '' ) ? sprintf('<div class="pl-pagination-simple">%s</div>', $pagination) : '';

	  $posts = (array) $query->posts;

	  if( $posts ){

		foreach( $posts as $p ) {

		  global $post;
		  $post = $p;
		  $this->p = $p;
		  setup_postdata( $post );

		  $out .= '<article class="journey-post">';

		  $out .=  do_shortcode( $config['shortcodes'] );

		  $out .=  '</article>';
		  wp_reset_postdata();
		}
	  }

	  else{
		  $out .= $this->posts_404();
	  };

	  return sprintf( '<section class="journey-acf">%s</section>%s', $out, $pagination );

	}


	function posts_404(){

		$nothing_found = $this->opt('nothing_found');

		$head = ( $nothing_found ) ? $nothing_found  : 'Nothing Found';

		$subhead = __("Sorry, what you are looking for isn't here.", 'pl-section-loops');

		$the_text = sprintf('<h3>%s</h3><p class="subhead center">%s</p>', $head, $subhead);

		return sprintf( '<section class="pl-billboard">%s</section>', apply_filters('pagelines_posts_404', $the_text));

	}


	function fetch_posts( $config ) {

		global $wp_query;

		if( '1' === $this->opt( 'default_query' ) ) {
		  return $wp_query;
		}

		$defaults = array(
		  'post_type'   => 'posts',
		  'post_status' => 'publish',
		  'taxonomy'    => '',
		  'paged'       => isset( $wp_query->query['paged'] ) ? (int) $wp_query->query['paged'] : 0
		);

		$args     = wp_parse_args( $config, $defaults );
		$meta     = $this->opt( 'meta_opts' );
		$relation = ( '' != $this->opt( 'relation' ) ) ? $this->opt( 'relation' ) : 'OR';

		if( 'rand' == $args['order'] ) {
		  $args['orderby'] = 'rand';
		}

		if( isset( $args['post_offset'] ) && ! isset( $wp_query->query['paged'] ) ) {
		  $args['offset'] = $args['post_offset'];
		}

		if(  $config['taxonomy'] != '' ) {

		 $bits = explode( '__', $config['taxonomy'] );

		 $args['tax_query'] = array(
			 array(
			   'taxonomy' => $bits[0],
			   'field'    => 'slug',
			   'terms'    => array( $bits[1] )
			 )
		 );
		}

	  if( is_array( $meta ) && ! empty( $meta ) ) {
		$args['meta_query'] = array( 'relation' => $relation );
		foreach( $meta as $k => $data ) {
		  if( isset( $data['key'] ) && '' != $data['key'] && isset( $data['value'] ) && '' != $data['value'] ) {
			$args['meta_query'][] = array(
			  'key' => $data['key'],
			  'value' => $data['value'],
			  'compare' => ( '' != $data['compare'] ) ? $data['compare'] : '='
			);
		  }
		}
	  }
	  global $pl_page;
	  if( $pl_page->is_posts_page() ) {
		$args['posts_per_page'] = get_option( 'posts_per_page' );
	  }

	  $query = new WP_Query( $args );

	  return $query;

	}

	// function get_terms( $post_type = false ) {

	//   $post_type = ( ! empty( $post_type ) ) ? $post_type : 'post';

	//   $taxonomies = get_object_taxonomies( $post_type, 'objects' );

	//   $opts = array();

	//   foreach( $taxonomies as $slug => $data ) {

	//     $terms = get_terms( $slug );

	//     foreach( $terms as $k => $term ) {

	//       $joint = sprintf( '%s_%s', $slug, $term->slug );

	//       $opts[ $joint ] = array(
	//         'name'  => sprintf( '%s -> %s (%s)', $data->labels->name, $term->name, $term->count )
	//       );
	//     }
	//   }

	//   return $opts;

	// }

	function add_shortcodes() {
	  add_shortcode( 'loops_media',   array( $this, 'loops_media' ) );
	  add_shortcode( 'loops_title',   array( $this, 'loops_title' ) );
	  add_shortcode( 'loops_date',    array( $this, 'loops_date' ) );
	  add_shortcode( 'loops_author',  array( $this, 'loops_author' ) );
	  add_shortcode( 'loops_content', array( $this, 'loops_content' ) );
	  add_shortcode( 'loops_excerpt', array( $this, 'loops_excerpt' ) );
	  add_shortcode( 'loops_link',    array( $this, 'loops_link' ) );
	  add_shortcode( 'loops_avatar',  array( $this, 'loops_avatar' ) );
	  add_shortcode( 'loops_comments',  array( $this, 'loops_comments' ) );
	}

	function shortcode_doc(){
	  $doc = '<strong>Shortcodes</strong>
				<p>Use shortcodes to control the dynamic post info. Example shortcodes:</p>

				<ul>
					<li><strong>[loops_title align="left"]</strong> - Post Title<br/>
					<em><strong> align options:</strong> left, right, center.</em></li>
					<li><strong>[loops_media size="thumbnail" align="left"]</strong> - Post thumbnail or Post Format Element (Audio, Video, Quote, Link or Gallery). <br/>
					<em><strong>size options:</strong> thumbnail, medium, large, full, aspect-thumb, basic-thumb, landscape-thumb, tall-thumb, big-thumb.</em><br/>
					<em><strong>align options:</strong> left, right, center.</em></li>
					<li><strong>[loops_content]</strong> - Post Content</li>
					<li><strong>[loops_comments]</strong> - Post/Page Comments</li>
					<li><strong>[loops_excerpt]</strong> - Post Excerpt</li>
					<li><strong>[loops_author]</strong> - Post Author</li>
					<li><strong>[loops_date format="F j, Y"]</strong> - Post Publish Date<br />
					<em><strong>Format Options: </strong>By default PowerLoop will use the date setting from WordPress Settings.</em>
					</li>
					<li><strong>[loops_link text="Read More" align="left"]</strong> - Post Link<br/>
					<em><strong>text options:</strong> any content</em>
					<em><strong>align options:</strong> left, right, center.</em></li>
					<li><strong>[loops_avatar size="64" align="left"]</strong> - Post Author Avatar<br/>
					<em><strong>size options:</strong> Avatar display size (max is 512).</em><br/>
					<em><strong>align options:</strong> left, right, center.</em></li>
				</ul>';

		return $doc;
	}

	function loops_avatar( $atts ) {

	  global $post;
	  $defaults = array(
		'class'   => '',
		'size'    => 64,
		'align'   => 'left'
	  );

	  $atts = shortcode_atts( $defaults, $atts );

	  $this->styles();

	  $out = sprintf( '<div class="%s %s pl-loops pl-loops-avatar">%s</div>',
		$atts['class'],
		$atts['align'],
		get_avatar( get_the_author_meta( 'ID' ), $atts['size'] )
	  );

	  return $out;
	}

	function loops_title( $atts ) {

	  $defaults = array(
		'class' => '',
		'align' => ''
	  );

	  $atts = shortcode_atts( $defaults, $atts );

	  $this->styles();

	  $out = sprintf('<h3 class="journey-title"><a href="%s">%s</a></h3>',
		esc_url( get_permalink( $this->p->ID ) ),
		esc_html( get_the_title( $this->p->ID ) )
	  );

	  return $out;
	}


	function loops_media( $atts ) {

	  global $post;

	  $out = '';

	  $defaults = array(
			'class' => '',
			'size'  => 'medium',
			'align' => ''
		);

	  $atts = shortcode_atts( $defaults, $atts );

	  $align = 'align' . $atts['align'];

	  $thumb = ( has_post_thumbnail( $this->p->ID ) ) ? get_the_post_thumbnail(  $this->p->ID , $atts['size'], array( 'class' => $align ) ) : sprintf('<img src="%s" />', pl_fallback_image( $atts['size'] ) );

	  $out = sprintf( '<figure><a href="%s">%s</a></figure>',
		esc_url( get_permalink( $this->p->ID ) ),
		$thumb
	  );

	  return $out;
	}


	function loops_date( $atts ) {

	   $defaults = array(
		 'class'  => '',
		 'format' => get_option( 'date_format' )
	   );

	   $atts = shortcode_atts( $defaults, $atts );

		$out = sprintf('<span class="%s pl-loops-date">%s</span>',
		  $atts['class'],
		  get_the_time( $atts['format'], $this->p->ID )
		);

		$info = get_field( 'archive-information', $this->p->ID );

		ob_start();
		?>
		<div class="journey-stats">
			<div class="journey-stat">
				<div class="icon">
					<i class="far fa-tags"></i>
				</div>
				<div class="right">
					<div class="top"><?php esc_html_e( 'Starting from', 'pagelines' ) ?></div>
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
					<div class="top"><?php esc_html_e( 'Best time to go', 'pagelines' ) ?></div>
					<div class="bottom"><?php echo esc_html( $info['time-to-travel'] ) ?></div>
				</div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}


	function loops_author( $atts ) {

	  global $post;

	  $defaults = array(
	   'class' => ''
	  );
	  $atts = shortcode_atts( $defaults, $atts );

	  $author     = get_the_author_meta( 'display_name', $this->p->post_author );

	  $out = sprintf('<span class="%s pl-loops-author">%s</span>',
		$atts['class'],
		$author
	  );

	  return $out;

	}


	function loops_content( $atts ) {
	  global $post;

	  $defaults = array(
	   'class' => '',
	   'text'  => '',
	  );
	  $atts = shortcode_atts( $defaults, $atts );


	  $out = sprintf('<div class="%s pl-loops-content">%s</div>',
		$atts['class'],
		do_shortcode( wpautop( $this->p->post_content) )
	  );

	  return $out;

	}


	function loops_excerpt( $atts ) {
	   global $post;

	   $defaults = array(
		 'class'  => '',
		 'length' => 25
	   );
	   $atts = shortcode_atts( $defaults, $atts );


	  $out = sprintf('<div class="%s pl-loops-excerpt">%s</div>',
		$atts['class'],
		pl_excerpt_by_id( $this->p->ID, $atts['length'] )
	  );

	  return wpautop( get_field( 'archive-description', $this->p->ID ) );
	}


	function loops_link( $atts ) {

	  global $post;

	  $defaults = array(
			'class'   => '',
			'text'    => '(Read More)',
			'align'   => 'center'
		);

	  $atts = shortcode_atts( $defaults, $atts );

	  $out = sprintf('<a class="%s pl-loops-link" href="%s">%s</a>',
		$atts['class'],
		get_post_permalink( $this->p->ID ),
		$atts['text']
	  );

	  return $out;
	}

	function loops_comments( $atts ) {

	  $defaults = array(
		  'class'   => '',
		  'align'   => '',
	  );

	  $atts = shortcode_atts( $defaults, $atts );

	  if( ! is_single() && ! is_page() )
		return;

	  $this->styles();

	  ob_start();
	  pl_comments();
	  $comments = ob_get_clean();

	  $out = sprintf('<div class="%s %s pl-loops pl-loops-comments">%s</div>',
		$atts['class'],
		$atts['align'],
		$comments
	  );

	  return $out;
	}
}
