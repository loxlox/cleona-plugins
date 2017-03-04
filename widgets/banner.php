<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: Banner
 */
function cleona_banner_widget() {
	register_widget( 'cleona_banner' );
}
add_action( 'widgets_init', 'cleona_banner_widget' );

class cleona_banner extends WP_Widget {
	/**
	 * Widget Setup
	 */
	function cleona_banner() {
		WP_Widget::__construct( 
			'cleona_banner', 
			esc_html__( 'Cleona Banner', 'cleona-plugins' ), 
			array( 
				'classname'		=> 'cleona_banner', 
				'description'	=> esc_html__( 'A widget that displays an Banner Image.', 'cleona-plugins' ) 
			), 
			array( 
				'width'			=> 250, 
				'height'		=> 350, 
				'id_base'		=> 'cleona_banner' 
			)
		);

		add_action( 'wp_head', array( $this, 'cleona_banner_custom_css' ), 999 );
	}

	/**
	 * Widget Form
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults	= array( 
			'title' => 'Banner',
			'type'	=> '',
			'shown' => 3,
			'slide'	=> true
		);
		$instance	= wp_parse_args( (array) $instance, $defaults );
		$terms		= get_terms( 'banner_category' );
		?>

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
		$instance['title']	= wp_kses( $new_instance['title'], array( 'strong' => array() ) );
		$instance['type']	= esc_attr( $new_instance['type'] );
		$instance['shown']	= esc_attr( $new_instance['shown'] );
		$instance['slide']	= esc_attr( $new_instance['slide'] );
		return $instance;
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title	= isset( $instance['title'] ) ? wp_kses( $instance['title'], array( 'strong' => array() ) ) : '';
		$type	= isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
		$shown	= isset( $instance['shown'] ) ? esc_attr( $instance['shown'] ) : '';
		$slide	= isset( $instance['slide'] ) ? esc_attr( $instance['slide'] ) : '';

		print( $before_widget );

		$custom_args = array(
			'post_type'				=> 'banner',
			'posts_per_page'		=> (int)$shown,
			'ignore_sticky_posts'	=> true
		);
		if ( !empty( $type ) ) {
			$custom_args['tax_query'] = array(
				array(
					'taxonomy'	=> 'banner_category',
					'field'		=> 'slug',
					'terms'		=> $type,
				)
			);
		}
		$post_loop = new WP_Query( $custom_args );

		if ( $title ) print( $before_title . $title . $after_title );

		if ( $post_loop->have_posts() ) : ?>
			<div class="cleona-widget-banner">
				<?php if ( $slide == 'on' ) : ?>
					<div class="full-width swiper-container cleona-banner-slider">
						<div class="swiper-wrapper">
							<?php while ( $post_loop->have_posts() ) : $post_loop->the_post();
								$subtitle	= get_post_meta( get_the_id(), 'cleona_banner_subtitle', true );
								$image_src	= wp_get_attachment_image_src( get_post_meta( get_the_id(), 'cleona_banner_image', true ), 'full' );
								$content	= get_post_meta( get_the_id(), 'cleona_banner_content', true );
								$url_text	= get_post_meta( get_the_id(), 'cleona_banner_url_text', true );
								$url		= get_post_meta( get_the_id(), 'cleona_banner_url', true ); ?>
								<div id="cleona-banner-<?php the_id(); ?>" <?php post_class( 'swiper-slide' ); ?>>
									<img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php the_title(); ?>">
									<div class="slider-content">
										<span class="banner-subtitle"><?php echo esc_html( $subtitle ); ?></span>
										<span class="banner-title"><?php the_title(); ?></span>
										<p class="banner-content"><?php echo esc_html( $content ); ?></p>
										<a href="<?php echo esc_url( $url ); ?>" class="read-more">
											<?php echo esc_html( $url_text ); ?>
										</a>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
				<?php else : ?>
					<div class="cleona-banner-masonry">
						<?php while ( $post_loop->have_posts() ) : $post_loop->the_post();
							$image_src	= wp_get_attachment_image_src( get_post_meta( get_the_id(), 'cleona_banner_image', true ), 'full' );
							$url		= get_post_meta( get_the_id(), 'cleona_banner_url', true ); ?>
							<div <?php post_class(); ?>>
								<a href="<?php echo esc_url( $url ); ?>">
									<img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php the_title(); ?>">
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif;

		wp_reset_query();
		print( $after_widget );
	}

	/**
	 * Banner Custom CSS
	 */
	function cleona_banner_custom_css() {
		if ( !is_page_template( 'page-templates/homepage.php' ) ) return;

		$banners = get_posts( array(
			'post_type'				=> 'banner',
			'posts_per_page'		=> -1,
			'ignore_sticky_posts'	=> 1
		) );

		ob_start();

		echo '<style type="text/css" id="custom-widget-css">';
			foreach ( $banners as $banner ) {
				$button_txt_color		= get_post_meta( $banner->ID, 'cleona_banner_button_txt_color', true );
				$button_txt_hvr_color	= get_post_meta( $banner->ID, 'cleona_banner_button_txt_hover_color', true );
				$button_bg_color		= get_post_meta( $banner->ID, 'cleona_banner_button_bg_color', true );
				$button_bg_hvr_color	= get_post_meta( $banner->ID, 'cleona_banner_button_bg_hover_color', true );

				if ( !empty( $button_txt_color ) || !empty( $button_bg_color ) ) {
					echo '.cleona-content #cleona-banner-' . esc_attr( $banner->ID ) . ' .read-more {
						color:' . esc_attr( $button_txt_color ) . ';
						background-color:' . esc_attr( $button_bg_color ) . ';
					}';
				}
				if ( !empty( $button_txt_hvr_color ) || !empty( $button_bg_hvr_color ) ) {
					echo '.cleona-content #cleona-banner-' . esc_attr( $banner->ID ) . ' .read-more:hover {
						color:' . esc_attr( $button_txt_hvr_color ) . ';
						background-color:' . esc_attr( $button_bg_hvr_color ) . ';
					}';
				}
			}
		echo '</style>';
		echo ob_get_clean();
	}
}