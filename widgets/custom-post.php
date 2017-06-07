<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: Custom Post
 */
function cleona_custom_post_widget() {
	register_widget( 'cleona_custom_post' );
}
add_action( 'widgets_init', 'cleona_custom_post_widget' );


class cleona_custom_post extends WP_Widget {
	/**
	 * Widget Setup
	 */
	function cleona_custom_post() {
		WP_Widget::__construct( 
			'cleona_custom_post', 
			esc_html__( 'Cleona Custom Post', 'cleona-plugins' ), 
			array( 
				'classname'		=> 'cleona_custom_post', 
				'description'	=> esc_html__( 'A widget that displays an Custom Post of Site.', 'cleona-plugins' ) 
			), 
			array( 
				'width'			=> 250, 
				'height'		=> 350, 
				'id_base'		=> 'cleona_custom_post' 
			)
		);
	}

	/**
	 * Widget Form
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults	= array( 
			'title'		=> 'Custom Post',
			'type'		=> '',
			'big_size'	=> false,
			'shown'		=> 4,
			'orderby'	=> 'comment',
			'sortby'	=> 'desc'
		);
		$instance	= wp_parse_args( (array) $instance, $defaults );
		$terms		= get_terms( 'category' );
		$orders		= array(
			'comment_count'	=> esc_html__( 'Comments', 'cleona-plugins' ),
			'date'			=> esc_html__( 'Date', 'cleona-plugins' ),
			'rand'			=> esc_html__( 'Random', 'cleona-plugins' )
		);
		$sorts		= array(
			'desc'	=> esc_html__( 'DESC', 'cleona-plugins' ),
			'asc'	=> esc_html__( 'ASC', 'cleona-plugins' )
		); ?>

		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<!-- Banner Type -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Category', 'cleona-plugins' ); ?></label><br />
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
				<option value=""><?php echo esc_html( 'Select Category', 'cleona-plugins' ); ?></option>
				<?php foreach ( $terms as $key ) : ?>
					<option value="<?php echo esc_attr( $key->slug ); ?>" <?php $instance['type'] == $key->slug ? selected( $instance['type'], $key->slug ) : ''; ?>><?php echo esc_html( $key->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<!-- Shown -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'shown' ) ); ?>"><?php esc_html_e( 'Show Item(s)', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="number" min="1" id="<?php echo esc_attr( $this->get_field_id( 'shown' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shown' ) ); ?>" value="<?php echo esc_attr( $instance['shown'] ); ?>"/>
		</p>
		<!-- Order By -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'cleona-plugins' ); ?></label><br />
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<?php foreach ( $orders as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php $instance['orderby'] == $key ? selected( $instance['orderby'], $key ) : ''; ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<!-- Sort By -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php esc_html_e( 'Sort', 'cleona-plugins' ); ?></label><br />
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>">
				<?php foreach ( $sorts as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php $instance['sortby'] == $key ? selected( $instance['sortby'], $key ) : ''; ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<!-- Display as big size post -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool)$instance['big_size'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'big_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'big_size' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'big_size' ) ); ?>"><?php esc_html_e( 'Show as big size post', 'cleona-plugins' ); ?></label><br />
		</p>

	<?php }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title']		= wp_kses( $new_instance['title'], array( 'strong' => array() ) );
		$instance['type']		= esc_attr( $new_instance['type'] );
		$instance['shown']		= esc_attr( $new_instance['shown'] );
		$instance['orderby']	= esc_attr( $new_instance['orderby'] );
		$instance['sortby']		= esc_attr( $new_instance['sortby'] );
		$instance['big_size']	= esc_attr( $new_instance['big_size'] );
		return $instance;
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title		= isset( $instance['title'] ) ? wp_kses( $instance['title'], array( 'strong' => array() ) ) : '';
		$type		= isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
		$shown		= isset( $instance['shown'] ) ? esc_attr( $instance['shown'] ) : '';
		$orderby	= isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : '';
		$sortby		= isset( $instance['sortby'] ) ? esc_attr( $instance['sortby'] ) : '';
		$big_size	= isset( $instance['big_size'] ) ? esc_attr( $instance['big_size'] ) : '';

		print( $before_widget );

		$custom_args = array(
			'post_type'				=> 'post',
			'posts_per_page'		=> (int)$shown,
			'order'					=> esc_attr( $sortby ),
			'orderby'				=> esc_attr( $orderby ),
			'ignore_sticky_posts'	=> true
		);
		if ( !empty( $type ) ) {
			$custom_args['tax_query'] = array(
				array(
					'taxonomy'	=> 'category',
					'field'		=> 'slug',
					'terms'		=> $type
				)
			);
		}
		$post_loop = new WP_Query( $custom_args );

		if ( $title ) print( $before_title . $title . $after_title );

			if ( $post_loop->have_posts() ) : ?>
				<div class="cleona-widget-post">
					<?php if ( $big_size === '1' || $big_size === 'on' ) : ?>
						<div class="row">
							<?php while( $post_loop->have_posts() ) : $post_loop->the_post(); ?>
								<div <?php post_class( 'col-md-4 col-sm-6' ); ?>>
									<div class="cleona-inner-wrap text-center">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="entry-media">
												<a href="<?php echo esc_url( get_the_permalink() ); ?>">
													<?php the_post_thumbnail( 'full' ); ?>
												</a>
											</div>
										<?php endif; ?>
										<div class="entry-header">
											<div class="entry-category">
												<?php cleona_post_categories(); ?>
											</div>
											<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
											<div class="entry-posted">
												<?php cleona_posted_date(); ?>
											</div>
										</div>
										<div class="entry-summary">
											<?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
										</div>
										<div class="entry-footer">
											<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="read-more">
												<?php esc_html_e( 'Read More', 'cleona-plugins' ); ?>
											</a>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<?php while( $post_loop->have_posts() ) : $post_loop->the_post(); ?>
							<div <?php post_class(); ?>>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="entry-image">
										<a href="<?php echo esc_url( get_the_permalink() ); ?>">
											<?php the_post_thumbnail( 'thumbnail' ); ?>
										</a>
									</div>
								<?php endif; ?>
								<div class="entry-summary">
									<?php
									the_title( '<h4 class="entry-title"><a href="' . esc_url( get_the_permalink() ) . '">', '</a></h4>' );
									cleona_posted_date();
									?>
								</div>
								<div class="clear"></div>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		<?php
		wp_reset_query();
		print( $after_widget );
	}
}