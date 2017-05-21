<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: Custom Product
 */
function cleona_custom_product_widget() {
	register_widget( 'cleona_custom_product' );
}
add_action( 'widgets_init', 'cleona_custom_product_widget' );

class cleona_custom_product extends WP_Widget {
	/**
	 * Widget Setup
	 */
	function cleona_custom_product() {
		WP_Widget::__construct( 
			'cleona_custom_product', 
			esc_html__( 'Cleona Custom Product', 'cleona-plugins' ), 
			array( 
				'classname'		=> 'cleona_custom_product', 
				'description'	=> esc_html__( 'A widget that displays an Product WooCommerce with image.', 'cleona-plugins' ) 
			), 
			array( 
				'width'			=> 250, 
				'height'		=> 350, 
				'id_base'		=> 'cleona_custom_product' 
			)
		);
	}

	/**
	 * Widget Form
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults	= array( 
			'title'			=> 'Products',
			'shown'			=> '6',
			'coloumn'		=> '3',
			'display'		=> '',
			'orderby'		=> 'date',
			'order'			=> 'desc',
			'hide_free'		=> FALSE,
			'hidden'		=> FALSE,
		);
		$instance	= wp_parse_args( (array) $instance, $defaults );
		$display	= array(
			''			=> esc_html__( 'All products',		'cleona-plugins' ),
			'featured'	=> esc_html__( 'Featured products',	'cleona-plugins' ),
			'onsale'	=> esc_html__( 'On-sale products',	'cleona-plugins' )
		);
		$orderby	= array(
			'date'		=> esc_html__( 'Date',		'cleona-plugins' ),
			'price'		=> esc_html__( 'Price',		'cleona-plugins' ),
			'rand'		=> esc_html__( 'Random',	'cleona-plugins' ),
			'sales'		=> esc_html__( 'Sales',		'cleona-plugins' ),
		);
		$order		= array(
			'asc'		=> esc_html__( 'ASC',	'cleona-plugins' ),
			'desc'		=> esc_html__( 'DESC',	'cleona-plugins' ),
		);
		?>

		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>

		<!-- Shown Items -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'shown' ) ); ?>"><?php esc_html_e( 'Number of products to display', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="number" min="1" id="<?php echo esc_attr( $this->get_field_id( 'shown' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shown' ) ); ?>" value="<?php echo esc_attr( $instance['shown'] ); ?>"/>
		</p>

		<!-- Coloumns -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'coloumn' ) ); ?>"><?php esc_html_e( 'Coloumns of products to display', 'cleona-plugins' ); ?></label><br />
			<input class="widefat" type="number" min="1" max="6" id="<?php echo esc_attr( $this->get_field_id( 'coloumn' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'coloumn' ) ); ?>" value="<?php echo esc_attr( $instance['coloumn'] ); ?>"/>
		</p>

		<!-- Display Items -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>"><?php esc_html_e( 'Display as', 'cleona-plugins' ); ?></label><br />
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'display' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>">
				<?php foreach ( $display as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php $instance['display'] == $key ? selected( $instance['display'], $key ) : ''; ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<!-- Order By -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by', 'cleona-plugins' ); ?></label><br />
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<?php foreach ( $orderby as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php $instance['orderby'] == $key ? selected( $instance['orderby'], $key ) : ''; ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<!-- Order -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order', 'cleona-plugins' ); ?></label><br />
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<?php foreach ( $order as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php $instance['order'] == $key ? selected( $instance['order'], $key ) : ''; ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<!-- Hide Free Product -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool)$instance['hide_free'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_free' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_free' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_free' ) ); ?>"><?php esc_html_e( 'Hide Free Products', 'cleona-plugins' ); ?></label><br />
		</p>

		<!-- Show Hidden Product -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool)$instance['hidden'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'hidden' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hidden' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hidden' ) ); ?>"><?php esc_html_e( 'Show Hidden Products', 'cleona-plugins' ); ?></label><br />
		</p>

	<?php }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title']		= wp_kses( $new_instance['title'], array( 'strong' => array() ) );
		$instance['shown']		= esc_attr( $new_instance['shown'] );
		$instance['coloumn']	= esc_attr( $new_instance['coloumn'] );
		$instance['display']	= esc_attr( $new_instance['display'] );
		$instance['orderby']	= esc_attr( $new_instance['orderby'] );
		$instance['order']		= esc_attr( $new_instance['order'] );
		$instance['hide_free']	= esc_attr( $new_instance['hide_free'] );
		$instance['hidden']		= esc_attr( $new_instance['hidden'] );
		return $instance;
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title							= isset( $instance['title'] ) ? wp_kses( $instance['title'], array( 'strong' => array() ) ) : '';
		$shown							= isset( $instance['shown'] ) ? esc_attr( $instance['shown'] ) : '6';
		$coloumn						= isset( $instance['coloumn'] ) ? esc_attr( $instance['coloumn'] ) : '3';
		$display						= isset( $instance['display'] ) ? esc_attr( $instance['display'] ) : '';
		$orderby						= isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'date';
		$order							= isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'desc';
		$hide_free						= isset( $instance['hide_free'] ) ? esc_attr( $instance['hide_free'] ) : FALSE;
		$hidden							= isset( $instance['hidden'] ) ? esc_attr( $instance['hidden'] ) : FALSE;
		$product_visibility_term_ids	= wc_get_product_visibility_term_ids();

		print( $before_widget );

		/* Main Product Query */
		$query_args = array(
			'posts_per_page'	=> $shown,
			'post_status'		=> 'publish',
			'post_type'			=> 'product',
			'no_found_rows'		=> 1,
			'order'				=> $order,
			'meta_query'		=> array(),
			'tax_query'			=> array(
				'relation'	=> 'AND',
			),
		);
		/* Show Hidden Product */
		if ( empty( $hidden ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy'	=> 'product_visibility',
				'field'		=> 'term_taxonomy_id',
				'terms'		=> is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
				'operator'	=> 'NOT IN',
			);
			$query_args['post_parent'] = 0;
		}
		/* Hide Free Product */
		if ( ! empty( $hide_free ) ) {
			$query_args['meta_query'][] = array(
				'key'		=> '_price',
				'value'		=> 0,
				'compare'	=> '>',
				'type'		=> 'DECIMAL',
			);
		}
		/* Hide Out of Stock Product */
		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				),
			);
		}
		/* Display Product */
		switch ( $display ) {
			case 'featured' :
				$query_args['tax_query'][] = array(
					'taxonomy'	=> 'product_visibility',
					'field'		=> 'term_taxonomy_id',
					'terms'		=> $product_visibility_term_ids['featured'],
				);
				break;
			case 'onsale' :
				$product_ids_on_sale	= wc_get_product_ids_on_sale();
				$product_ids_on_sale[]	= 0;
				$query_args['post__in']	= $product_ids_on_sale;
				break;
		}
		/* Order Product By */
		switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key']	= '_price';
				$query_args['orderby']	= 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby']	= 'rand';
				break;
			case 'sales' :
				$query_args['meta_key']	= 'total_sales';
				$query_args['orderby']	= 'meta_value_num';
				break;
			default :
				$query_args['orderby']	= 'date';
		}
		$products = new WP_Query( $query_args );

		switch ( $coloumn ) {
			case '6':
				$coloumn_class = 'coloumn-6';
				break;
			case '5':
				$coloumn_class = 'coloumn-5';
				break;
			case '4':
				$coloumn_class = 'coloumn-4';
				break;
			case '3':
				$coloumn_class = 'coloumn-3';
				break;
			case '2':
				$coloumn_class = 'coloumn-2';
				break;
			default:
				$coloumn_class = 'coloumn-1';
				break;
		}

		if ( $title ) print( $before_title . $title . $after_title );

		if ( $products->have_posts() ) : ?>
			<div class="cleona-widget-post woocommerce">
				<div class="row">
					<?php while ( $products->have_posts() ) : $products->the_post();
						global $product; ?>
						<div id="product-<?php the_id(); ?>" <?php post_class( $coloumn_class ); ?>>
							<div class="inner-wrapper">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="entry-image">
										<a href="<?php echo esc_url( get_the_permalink() ); ?>">
											<?php the_post_thumbnail( 'shop_catalog' ); ?>
										</a>
									</div>
								<?php endif; ?>
								<div class="entry-content">
									<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_the_permalink() ) . '">', '</a></h3>' ); ?>
									<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
									<?php echo $product->get_price_html(); ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		<?php endif;
		wp_reset_postdata();
		print( $after_widget );
	}
}