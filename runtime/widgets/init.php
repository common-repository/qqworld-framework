<?php
class qqworld_runtime_widget extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Widgets', QQWORLD_FW);
		$this->guid = 'widgets';
		$this->parent = 'runtime';
		$this->core = false;
		$qqworld_fw_members[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
	}

	public function init() {
		if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid ) || $this->core ) {
			add_action('qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));
			add_action( 'widgets_init', array($this, 'register_widgets') );
		}
	}

	public function register_widgets() {
		foreach ( $this->get_widgets() as $widget) register_widget( $widget );
	}

	public function get_widgets() {
		$widgets = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $widget) $widgets[] = $widget;
		return apply_filters( 'qqworld_fw_runtime_widgets', $widgets );
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php echo sprintf(__('Have enabled the %s: ', QQWORLD_FW), $this->name ); ?></p>
						<?php
						$widgets = array();
						foreach ( $this->get_widgets() as $widget ) $widgets[]=$widget;
						echo implode(", ", $widgets);
						?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_widget;



function wxq_latest_products() {
	global $wpdb;

	// Get products
	$latest_products = get_posts( array(
		'post_type'   => 'wpsc-product',
		'numberposts' => 3,
		'orderby'     => 'post_date',
		'post_parent' => 0,
		'post_status' => 'publish',
		'order'       => 'DESC'
	) );

	if ( count( $latest_products ) > 0 ) {
		foreach ( $latest_products as $latest_product ) {
	?>
	<li>
		<article>
			<?php
			$arg = array(
				'id' => $latest_product->ID,
				'before' => '<figure class="article_pic">',
				'after' => '</figure>',
				'type' => 'link',
				'lightbox' => false
			);
			echo get_thumbnail($arg);
			?>
			<h5><a href="<?php echo esc_url( wpsc_product_url( $latest_product->ID, null ) ); ?>"><?php echo apply_filters( 'the_title', $latest_product->post_title ) ?></a></h5>
			<?php
			$args = array(
				'id' => $latest_product->ID,
				'output_you_save' => 0,
				'output_old_price' => 0
			);
			wpsc_the_product_price_display($args);
			?>
		</article>
	</li>
	<?php
		}
	}
}

//Advertisement
class qqworld_advertisement_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'qqworld_advertisement', // Base ID
			__( 'Advertisement Widget', TPL ), // Name
			array( 'description' => __( 'Advertisement Widget', TPL ), ) // Args
		);
	}
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
?>
	<ul id="widget-advertisements" class="widget-post-list">
		<li class="qqworld-open-container">
			<div class="open">
				<img title="去看看QQWorld Slider！" src="<?php bloginfo('template_directory')?>/images/ads/qqworld-slider.jpg" alt="QQWorld Slider" width="250" height="130">
			</div>
			<a target="_blank" class="back" href="http://demo.qqworld.org/jQuery/qqworld-slider/" title="QQWorld Slider">了解详情</a>
		</li>
		<li class="qqworld-open-container">
			<div class="open">
				<img title="QQWorld Photocutter" src="<?php bloginfo('template_directory')?>/images/ads/qqworld-photocutter.jpg" alt="QQWorld Photocutter" width="250" height="130">
			</div>
			<a target="_blank" class="back" href="http://project.qqworld.org/archives/1306" title="QQWorld Photocutter">了解详情</a>
		</li>
		<li class="qqworld-open-container">
			<div class="open">
				<img title="QQWorld Nav BG Slider" src="<?php bloginfo('template_directory')?>/images/ads/qqworld-nav-slide-bg.jpg" alt="QQWorld Nav BG Slider" width="250" height="130">
			</div>
			<a target="_blank" class="back" href="http://demo.qqworld.org/jQuery/qqworld-nav-slide-bg/" title="QQWorld Nav BG Slider">了解详情</a>
		</li>
	</ul>
<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	function form($instance) {
		$title = esc_attr($instance['title']);
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title:'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</label>
	</p>
	<?php
	}
}

//最热文章的小工具
class qqworld_hot_posts_widget extends WP_Widget {
	function __construct() {
		$this->WP_Widget(false, __('Hot Posts', TPL));
	}
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
?>
	<ul class="widget-post-list">
		<?php
		$arg = array(
			'orderby' => 'comment_count',
			'numberposts' => 6
		);
		$hotposts = get_posts($arg);
		foreach ($hotposts as $hotpost) :
			$id = $hotpost->ID;
			$title = $hotpost->post_title;
		?>
			<li class="qqworld-open-container">
				<div class="open">
					<?php echo get_the_post_thumbnail( $id, 'thumbnail'); ?>
				</div>
				<a class="back" href="<?php echo get_permalink($id ); ?>" title="<?php echo $title; ?>">了解详情</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$title = esc_attr($instance['title']);
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title:'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</label>
	</p>
	<?php
	}
}

//最热商品的小工具
class qqworld_hot_products_widget extends WP_Widget {
	function qqworld_Hot_Products_Widget() {
		$this->WP_Widget(false, __('Hot Products', TPL));
	}
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
?>
	<ul class="widget-post-list">
		<?php
		$arg = array(
			'orderby' => 'comment_count',
			'numberposts' => 6,
			'post_type' => 'wpsc-product'
		);
		$hotposts = get_posts($arg);
		foreach ($hotposts as $hotpost) :
			$id = $hotpost->ID;
			$title = $hotpost->post_title;
		?>
			<li class="qqworld-open-container">
				<div class="open">
					<?php echo get_the_post_thumbnail( $id, 'thumbnail'); ?>
				</div>
				<a class="back" href="<?php echo get_permalink($id ); ?>" title="<?php echo $title; ?>">了解详情</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$title = esc_attr($instance['title']);
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title:'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</label>
	</p>
	<?php
	}
}
?>