<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: About Me
 */
function cleona_about_me_widget() {
	register_widget( 'cleona_about_me' );
}
add_action( 'widgets_init', 'cleona_about_me_widget' );


class cleona_about_me extends WP_Widget {
	/**
	 * Widget Setup
	 */
	function cleona_about_me() {
		WP_Widget::__construct( 
			'cleona_about_me', 
			esc_html__( 'Cleona About Me', 'cleona-plugins' ), 
			array( 
				'classname'		=> 'cleona_about_me', 
				'description'	=> esc_html__( 'A widget that displays an About Owner of Site.', 'cleona-plugins' ) 
			), 
			array( 
				'width'			=> 250, 
				'height'		=> 350, 
				'id_base'		=> 'cleona_about_me' 
			)
		);
	}

	/**
	 * Widget Form
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults	= array( 
			'title'			=> 'About Me', 
			'image'			=> '', 
			'description'	=> '', 
			'read_more'		=> '' 
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>

		<!-- Image Url -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image URL', 'cleona-plugins' ); ?></label><br />
			<input class="widefat cleona-image-url" type="url" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_url( $instance['image'] ); ?>"/><br />
			<?php if ( !is_customize_preview() ) : ?>
				<button class="upload_image_button button"><?php esc_html_e( 'Upload image', 'cleona-plugins' ) ?></button>
				<button class="remove_image_button button"><?php esc_html_e( 'Remove image', 'cleona-plugins' ) ?></button>
			<?php endif; ?>
		</p>

		<!-- Description -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'cleona-plugins' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" style="width:100%;" rows="6"><?php echo wp_kses_post( $instance['description'] ); ?></textarea>
		</p>

		<!-- Read More Url -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>"><?php esc_html_e( 'Read More Link', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="url" id="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_more' ) ); ?>" value="<?php echo esc_url( $instance['read_more'] ); ?>"/><br />
			<small><?php esc_html_e( 'Paste url here.', 'cleona-plugins' ); ?></small>
		</p>

	<?php }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title']			= wp_kses( $new_instance['title'], array( 'strong' => array() ) );
		$instance['image']			= esc_url( $new_instance['image'] );
		$instance['description']	= do_shortcode( $new_instance['description'] );
		$instance['read_more']		= esc_url( $new_instance['read_more'] );
		return $instance;
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title			= isset( $instance['title'] ) ? wp_kses( $instance['title'], array( 'strong' => array() ) ) : '';
		$image			= isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
		$description	= isset( $instance['description'] ) ? do_shortcode( $instance['description'] ) : '';
		$read_more		= isset( $instance['read_more'] ) ? esc_url( $instance['read_more'] ) : '';

		print( $before_widget ); ?>

		<div class="cleona-widget-about">
			<img class="cleona-avatar" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />

			<?php if ( $title ) print( $before_title . $title . $after_title ); ?>

			<?php if( !empty( $description ) ) : ?>
				<p><?php echo do_shortcode( $description ); ?></p>
			<?php endif; ?>

			<?php if( !empty( $read_more ) ) : ?>
				<a href="<?php echo esc_url( $read_more ); ?>">
					<?php esc_html_e( 'Read More', 'cleona-plugins' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<?php
		print( $after_widget );
	}
}