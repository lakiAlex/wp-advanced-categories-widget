<?php

/**
 * The main widget class.
 *
 * @since      1.0.0
 * @package    wpacw
 */

function wpacw_widget() {
	register_widget( 'Wpacw_Widget' );
}
add_action( 'widgets_init', 'wpacw_widget' );

Class Wpacw_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'Wpacw_Widget',
			__( 'Advanced Categories', 'wpacw' ),
			array(
				'classname' => 'wpacw',
				'description' => esc_html__( 'Displays your categories with auto-generated background image.', 'wpacw' )
			)
		);
	}
	
	public function widget( $args, $instance ) {
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$layout = empty( $instance['layout'] ) ? 'style1' : $instance['layout'];
		$number = empty( $instance['number'] ) ? 5 : $instance['number'];
		$sort = empty( $instance['sort'] ) ? 'name' : $instance['sort'];
		$order = empty( $instance['order'] ) ? 'ASC' : $instance['order'];
		$count = empty( $instance['count'] ) ? 'on' : $instance['count'];
		
		echo $args['before_widget'];
		 
		do_action( 'wpacw_before_widget', $instance );
		?>
	
			<?php if ( $title ) echo $args['before_title'] . wp_kses_post( $title ) . $args['after_title']; ?>

			<div class="wpacw__cats <?php echo esc_html( $layout ); ?>">
				<?php
					$count = count( get_categories( array(
						'parent' => 0,
						'hide_empty' => 0
					) ) );
					if ( $count > 0 ) {
						$i = 1;
						
						$categories = get_categories(
							array(
								'orderby' => $sort,
                                'order'   => $order,
                                'count'   => $count
							)
						);
						
						foreach( $categories as $cat ) {
	
							if ( $i <= $number ) {
					            ?>
					            
				                    <a class="wpacw__cat" href="<?php echo esc_url( get_term_link( $cat ) ); ?>" data-bg-wpacw="<?php esc_url( the_post_thumbnail_url( 'landscape-sm' ) ); ?>">
										<div>
											<span><?php echo esc_html( $cat->name ); ?></span>
											<span><?php echo esc_html( $cat->count ); ?></span>
										</div>
				                    </a>
				                    
				                <?php
							}
							
							$i++;
				        }
	
					} else {
						esc_html_e("You don't have any categories yet.");
					}
				?>
			</div>
		
		<?php
		do_action( 'wpacw_after_widget', $instance );
		echo $args['after_widget'];
	}
	
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => __( 'Categories', 'wpacw' ),
			'layout' => 'style1',
			'number' => 5,
			'sort' => 'name',
			'order' => 'ASC',
			'count' => 'on'
		) );
		$title = $instance['title'];
		$layout = $instance['layout'];
		$number = absint( $instance['number'] );
		$sort = $instance['sort'];
		$order = $instance['order'];
		$count = $instance['count'];
		?>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title', 'wpacw' ); ?>:</strong> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><strong> <?php esc_html_e( 'Layout', 'wpacw' ); ?>:</strong></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" class="widefat">
				<option value="style1" <?php selected( 'style1', $layout ); ?>><?php esc_html_e( 'Box', 'wpacw' ); ?></option>
				<option value="style2" <?php selected( 'style2', $layout ); ?>><?php esc_html_e( 'Box 2', 'wpacw' ); ?></option>
				<option value="style3" <?php selected( 'style3', $layout ); ?>><?php esc_html_e( 'Box 3', 'wpacw' ); ?></option>
				<option value="style4" <?php selected( 'style4', $layout ); ?>><?php esc_html_e( 'Thumbnails List', 'wpacw' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><strong><?php esc_html_e( 'Number of Categories', 'wpacw' ); ?>:</strong> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>"><strong><?php esc_html_e( 'Sort by', 'wpacw' ); ?>:</strong></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sort' ) ); ?>" class="widefat">
				<option value="name" <?php selected( 'name', $sort ); ?>><?php esc_html_e( 'Name', 'wpacw' ); ?></option>
				<option value="ID" <?php selected( 'ID', $sort ); ?>><?php esc_html_e( 'ID', 'wpacw' ); ?></option>
				<option value="count" <?php selected( 'count', $sort ); ?>><?php esc_html_e( 'Post Count', 'wpacw' ); ?></option>
			</select>
		</p>
		
		<p>			
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><strong><?php esc_html_e( 'Order', 'wpacw' ); ?>:</strong></label><br>
            <input name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="radio" value="ASC" <?php echo esc_attr( $order == 'ASC' ? 'checked' : '' ); ?> /> <?php esc_html_e( 'ASC', 'wpacw' ); ?><br>
            <input name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="radio" value="DESC" <?php echo esc_attr( $order == 'DESC' ? 'checked' : '' ); ?> /> <?php esc_html_e( 'DESC', 'wpacw' ); ?><br>     
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><strong><?php esc_html_e('Show Counter', 'wpacw'); ?></strong></label>
			<label class="codemade-switch__switch">
				<input class="widefat codemade-switch__input" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="checkbox" <?php checked($instance['count'], 'on'); ?>/>
				<span class="codemade-switch__slider"></span>
			</label>
		</p>
		
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['layout'] = ( ( 'style1' === $new_instance['layout'] || 'style2' === $new_instance['layout'] || 'style3' === $new_instance['layout'] || 'style4' === $new_instance['layout'] ) ? $new_instance['layout'] : 'style1' );
		$instance['number'] = ! absint( $new_instance['number'] ) ? 5 : $new_instance['number'];
		$instance['sort'] = ( ( 'name' === $new_instance['sort'] || 'ID' === $new_instance['sort'] || 'count' === $new_instance['sort'] ) ? $new_instance['sort'] : 'name' );
		$instance['order'] = ( ( 'ASC' === $new_instance['order'] || 'DESC' === $new_instance['order'] ) ? $new_instance['order'] : 'ASC' );
		$instance['count'] = $new_instance['count'];
		return $instance;
	}

}
