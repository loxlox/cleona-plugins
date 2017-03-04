<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: Testimonial
 */
function cleona_testimonial_widget() {
	register_widget( 'cleona_testimonial' );
}
add_action( 'widgets_init', 'cleona_testimonial_widget' );

class cleona_testimonial extends WP_Widget {
	/**
	 * Widget Setup
	 */
	function cleona_testimonial() {
		WP_Widget::__construct( 
			'cleona_testimonial', 
			esc_html__( 'Cleona Testimonial', 'cleona-plugins' ), 
			array( 
				'classname'		=> 'cleona_testimonial', 
				'description'	=> esc_html__( 'A widget that displays an Testimonial from User.', 'cleona-plugins' ) 
			), 
			array( 
				'width'			=> 250, 
				'height'		=> 350, 
				'id_base'		=> 'cleona_testimonial' 
			)
		);
	}

	/**
	 * Widget Form
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults	= array( 
			'title' => 'Testimonial',
			'shown' => 3,
			'slide'	=> true
		);
		$instance	= wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<!-- Shown -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'shown' ) ); ?>"><?php esc_html_e( 'Show Item(s)', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="number" min="1" id="<?php echo esc_attr( $this->get_field_id( 'shown' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shown' ) ); ?>" value="<?php echo esc_attr( $instance['shown'] ); ?>"/>
		</p>
		<!-- Display as slider -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool)$instance['slide'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'slide' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slide' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'slide' ) ); ?>"><?php esc_html_e( 'Show as Slider', 'cleona-plugins' ); ?></label><br />
		</p>

	<?php }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = wp_kses( $new_instance['title'], array( 'strong' => array() ) );
		$instance['shown'] = esc_attr( $new_instance['shown'] );
		$instance['slide'] = esc_attr( $new_instance['slide'] );
		return $instance;
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? wp_kses( $instance['title'], array( 'strong' => array() ) ) : '';
		$shown = isset( $instance['shown'] ) ? esc_attr( $instance['shown'] ) : '';
		$slide = isset( $instance['slide'] ) ? esc_attr( $instance['slide'] ) : '';

		print( $before_widget );

		$custom_args = array(
			'post_type'				=> 'testimonial',
			'posts_per_page'		=> (int)$shown,
			'orderby'				=> 'meta_value_num',
			'meta_key'				=> 'cleona_testimonial_rating',
			'ignore_sticky_posts'	=> true
		);
		$post_loop		= new WP_Query( $custom_args );
		$slider_class	= ( $slide == 'on' ) ? 'swiper-slide' : '';

		if ( $title ) print( $before_title . $title . $after_title ); ?>
		
		<?php if ( is_page_template( 'page-templates/homepage.php' ) && ( is_active_sidebar( 'cleona-home-widget-1' ) || is_active_sidebar( 'cleona-home-widget-2' ) || is_active_sidebar( 'cleona-home-widget-3' ) || is_active_sidebar( 'cleona-home-widget-4' ) ) ) : ?>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
		<?php endif; ?>

				<?php if ( $post_loop->have_posts() ) : ?>
					<div class="cleona-widget-testimonial">
						<?php if ( $slide == 'on' ) : ?>
							<div class="swiper-container cleona-testimonial-slider">
								<div class="swiper-wrapper">
						<?php endif;
						while( $post_loop->have_posts() ) : $post_loop->the_post();
							$content	= get_post_meta( get_the_id(), 'cleona_testimonial_content', true );
							$headline	= get_post_meta( get_the_id(), 'cleona_testimonial_headline', true );
							$rating		= get_post_meta( get_the_id(), 'cleona_testimonial_rating', true ); ?>
							<div <?php post_class( $slider_class ); ?>>
								<div class="entry-header">
									<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_the_permalink() ) . '">', '</a></h4>' ); ?>
									<select id="testimonial_rating_<?php echo get_the_id(); ?>" class="testimonial-rating">
										<option value="1" <?php echo $rating == 1 ? esc_attr( 'selected' ) : ''; ?>>1</option>
										<option value="2" <?php echo $rating == 2 ? esc_attr( 'selected' ) : ''; ?>>2</option>
										<option value="3" <?php echo $rating == 3 ? esc_attr( 'selected' ) : ''; ?>>3</option>
										<option value="4" <?php echo $rating == 4 ? esc_attr( 'selected' ) : ''; ?>>4</option>
										<option value="5" <?php echo $rating == 5 ? esc_attr( 'selected' ) : ''; ?>>5</option>
									</select>
								</div>
								<div class="entry-summary">
									<span class="headline"><?php echo esc_html( $headline ); ?></span>
									<p><?php echo esc_html( $content ); ?></p>
								</div>
								<div class="clear"></div>
							</div>
						<?php endwhile;
						if ( $slide == 'on' ) : ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="cleona-widget-testimonial">
						<div class="cleona-not-found">
							<?php esc_html_e( 'No testimonial found.', 'cleona-plugins' ); ?>
						</div>
					</div>
				<?php endif; ?>

		<?php if ( is_page_template( 'page-templates/homepage.php' ) && ( is_active_sidebar( 'cleona-home-widget-1' ) || is_active_sidebar( 'cleona-home-widget-2' ) || is_active_sidebar( 'cleona-home-widget-3' ) || is_active_sidebar( 'cleona-home-widget-4' ) ) ) : ?>
			</div>
		</div>
		<?php endif; ?>

		<?php wp_reset_query();
		print( $after_widget );
	}
}