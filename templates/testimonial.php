<?php
/**
 * Template Name: Testimonial
 */
cleona_plugin_insert_testimonial();

get_header(); ?>
	<div class="container">
		<?php breadcrumb_trail(); ?>
		<div class="content-area">
			<?php if ( have_posts() ) : ?>
				<?php while( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="row">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-media col-md-12">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>">
										<?php the_post_thumbnail( 'full' ); ?>
									</a>
								</div>
							<?php endif;
							if ( isset( $_GET['success'] ) ) : ?>
								<div class="cleona-message col-md-12">
									<div class="cleona-message-wrapper">
										<?php esc_html_e( 'Your testimonial has been recieved, We will review before we published your testimonial, quick link ', 'cleona-plugins' ); ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( 'Homepage' ); ?></a>
									</div>
								</div>
							<?php endif; ?>
							<div class="entry-wrapper col-md-6">
								<div class="entry-header">
									<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
								</div>
								<div class="entry-content">
									<?php
									the_content();
									wp_link_pages( array(
										'before'	=> '<div class="page-links">' . esc_html__( 'Pages:', 'cleona-plugins' ),
										'after'		=> '</div>',
									) );
									?>
									<div class="clear"></div>
								</div>
								<?php if ( get_edit_post_link() ) : ?>
									<div class="entry-footer">
										<?php edit_post_link( esc_html__( 'Edit', 'cleona-plugins' ), '<span class="edit-link">', '</span>' ); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-md-6">
								<form id="cleona-testimonial-frontend" method="POST">
									<fieldset>
										<label for="customer_name"><?php esc_html_e( 'Full Name', 'cleona-plugins' ); ?><span class="required">*</span></label>
										<input type="text" name="customer_name" id="customer_name" required="required" />
									</fieldset>
									<fieldset>
										<label for="customer_headline"><?php esc_html_e( 'Headline', 'cleona-plugins' ); ?><span class="required">*</span></label>
										<input type="text" name="customer_headline" id="customer_headline" required="required" />
									</fieldset>
									<fieldset>
										<label for="customer_message"><?php esc_html_e( 'Say Something To Us', 'cleona-plugins' ); ?><span class="required">*</span></label>
										<textarea name="customer_message" id="customer_message" rows="8" cols="30" required="required"></textarea>
									</fieldset>
									<fieldset>
										<label for="customer_rate"><?php esc_html_e( 'Rate Us', 'cleona-plugins' ); ?></label>
										<select id="customer_rate" name="customer_rate">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</fieldset>
									<fieldset>
										<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
										<input type="hidden" name="submitted" id="submitted" value="true" />
										<button type="submit">
											<?php esc_html_e( 'Submit', 'cleona-plugins' ); ?>
											<i class="zmdi zmdi-mail-send"></i>
										</button>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>