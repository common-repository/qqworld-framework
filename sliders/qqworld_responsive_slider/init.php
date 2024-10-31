<?php
class qqworld_sliders_qqworld_responsive_slider extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('QQWorld Responsive Slider', QQWORLD_FW);
		$this->guid = 'qqworld_responsive_slider';
		$this->parent = 'sliders';
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
			if ( !current_theme_supports('qqworld_fw_sliders_sliders') ) add_theme_support('qqworld_fw_sliders_sliders');			
			add_action('qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));
			add_action( 'admin_init', array($this, 'register') );
			add_action( 'qqworld_fw_runtime_init_js', array($this, 'add_home_slider_script') );
			add_filter( 'qqworld_fw_resource_js_resources', array($this, 'add_scripts_style') );
			add_filter( 'qqworld_fw_slider_configuration', array($this, 'add_slider_fields'), 10, 2 );
			add_action( 'qqworld_fw_render_slider_preview', array($this, 'render_slider'), 10, 2 );
			add_action( 'qqworld_fw_slider_render_home_slider', array($this, 'render_slider'), 10, 2 );
			add_filter( 'qqworld_fw_default_javascript', array($this, 'add_default_script_to_admin') );
		}
	}

	public function add_default_script_to_admin($default_script) {
		$new_resources = array('QQWorld_Loadimgs', 'QQWorld_Responsive_Slider');
		return array_merge($default_script, $new_resources);
	}

	public function add_slider_fields($slider_fields, $settings) {
		return array(
			array('heading' => 'content',
				'description' => sprintf(__("'image'/'html'，Choose %s for Images, Choose %s for HTML content.", QQWORLD_FW), __('Images', QQWORLD_FW), __('HTML', QQWORLD_FW)),
				'type' => 'select',
				'name' => 'meta_key[slider_config][content]',
				'id' => 'content',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'placeholder' => __('Please select content type...', QQWORLD_FW),
				'options' => array(
					__('Images', QQWORLD_FW) => 'image',
					__('HTML', QQWORLD_FW) => 'html',
				),
				'value' => $settings['content']
			),
			array('heading' => 'direction',
				'description' => __("Rolling direction of the slide.", QQWORLD_FW),
				'type' => 'select',
				'name' => 'meta_key[slider_config][direction]',
				'id' => 'direction',
				'field_before' => '<td>',
				'field_after' => '</td>',									
				'placeholder' => __('Please select direction...', QQWORLD_FW),
				'options' => array(
					__('Horizontal', QQWORLD_FW) => 'horizontal',
					__('Vertical', QQWORLD_FW) => 'vertical',
				),
				'value' => $settings['direction']
			),
			array('heading' => 'width',
				'description' => __("The width of the slider image.", QQWORLD_FW),
				'type' => 'textfield',
				'name' => 'meta_key[slider_config][width]',
				'id' => 'width',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['width']
			),
			array('heading' => 'height',
				'description' => __("The height of the slider image.", QQWORLD_FW),
				'type' => 'textfield',
				'name' => 'meta_key[slider_config][height]',
				'id' => 'height',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['height']
			),
			array('heading' => 'container_id',
				'description' => __("The container ID of outermost layer for custom style.", QQWORLD_FW),
				'type' => 'textfield',
				'name' => 'meta_key[slider_config][container_id]',
				'id' => 'container_id',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['container_id']
			),
			array('heading' => 'speed',
				'description' => __("The speed of slider play, in milliseconds.", QQWORLD_FW),
				'type' => 'textfield',
				'name' => 'meta_key[slider_config][speed]',
				'id' => 'speed',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['speed']
			),
			array('heading' => 'pause',
				'description' => __("Slideshow interval, in milliseconds.", QQWORLD_FW),
				'type' => 'textfield',
				'name' => 'meta_key[slider_config][pause]',
				'id' => 'pause',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['pause']
			),
			array('heading' => 'hoverStopPlay',
				'description' => __("Mouse over to stop play.", QQWORLD_FW),
				'type' => 'switch',
				'name' => 'meta_key[slider_config][hoverStopPlay]',
				'id' => 'pause',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['hoverStopPlay']
			),
			array('heading' => 'showNav',
				'description' => __("Display the page navigation.", QQWORLD_FW),
				'type' => 'switch',
				'name' => 'meta_key[slider_config][showNav]',
				'id' => 'showNav',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['showNav']
			),
			array('heading' => 'autoHideNav',
				'description' => __("Auto Hide Navigation.", QQWORLD_FW),
				'type' => 'switch',
				'name' => 'meta_key[slider_config][autoHideNav]',
				'id' => 'autoHideNav',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['autoHideNav']
			),
			array('heading' => 'showPager',
				'description' => __("Show Pager.", QQWORLD_FW),
				'type' => 'switch',
				'name' => 'meta_key[slider_config][showPager]',
				'id' => 'showPager',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['showPager']
			),
			array('heading' => 'autoHidePager',
				'description' => __("Auto Hide pagination.", QQWORLD_FW),
				'type' => 'switch',
				'name' => 'meta_key[slider_config][autoHidePager]',
				'id' => 'autoHidePager',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['autoHidePager']
			),
			array('heading' => 'auto',
				'description' => __("Auto Play.", QQWORLD_FW),
				'type' => 'switch',
				'name' => 'meta_key[slider_config][auto]',
				'id' => 'auto',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'value' => $settings['auto']
			),
			array('heading' => 'easing',
				'description' => __("used with jquery.easing.1.3.js - see http://gsgd.co.uk/sandbox/jquery/easing/ for available options", QQWORLD_FW),
				'type' => 'select',
				'name' => 'meta_key[slider_config][easing]',
				'id' => 'easing',
				'field_before' => '<td>',
				'field_after' => '</td>',
				'options' => qqworld_fw::format_array(array("random","swing","easeInQuad","easeOutQuad","easeInOutQuad","easeInCubic","easeOutCubic","easeInOutCubic","easeInQuart","easeOutQuart","easeInOutQuart","easeInQuint","easeOutQuint","easeInOutQuint","easeInSine","easeOutSine","easeInOutSine","easeInExpo","easeOutExpo","easeInOutExpo","easeInCirc","easeOutCirc","easeInOutCirc","easeInElastic","easeOutElastic","easeInOutElastic","easeInBack","easeOutBack","easeInOutBack","easeInBounce","easeOutBounce","easeInOutBounce")),
				'value' => $settings['easing']
			)
		);
	}

	public function register() {
		register_setting('qqworld-framework', 'qqworld_fw_sliders_home_slider');
	}

	//add Plugin qqworldFlybox
	function add_scripts_style($resources) {
		$resources[] = 'QQWorld_Responsive_Slider';
		return $resources;
	}

	public function add_home_slider_script() {
		$settings = get_option('qqworld_fw_sliders_qqworld_responsive_slider_settings', get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] );
?>
	var home_slider = $("#home_slieder").QQWorldResponsiveSlider(<?php echo json_encode($settings, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);?>);
<?php
	}

	//show slider
	function render_slider($post_id, $slider_id) {
		$images = get_post_meta($post_id, 'slider_image', true);
		$settings = get_post_meta($post_id, 'slider_config', true );
		if ( !empty($images) ) : ?>
		<ul id="<?php echo $slider_id; ?>" class="slider-list">
			<?php foreach ($images as $attachment_id) :
				$website = get_post_meta($attachment_id, 'website', true);
				$attr = array(
					'alt'   => trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) )),
					'title'   => trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ))
				);
				$image_before = !empty($website) ? '<a href="' . $website . '">' : '';
				$image_after = !empty($website) ? '</a>' : '';
			?>
			<li><?php echo $image_before . wp_get_attachment_image( $attachment_id, 'full', false, $attr ) . $image_after; ?></li>
			<?php endforeach; ?>
		</ul>
		<script>
		jQuery(function($) { jQuery("#<?php echo $slider_id; ?>").QQWorldResponsiveSlider(<?php echo json_encode($settings, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);?>); });
		</script>
		<?php endif; ?>
	<?php
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="qqworld_responsive_slider">
						<p><?php _e('请选择首页幻灯片');
						$args = array(
							'posts_per_page' => -1,
							'post_type' => 'qqworld_slider',
						);
						$sliders = get_posts($args);
						?>
						<select class="selectstyle" name="qqworld_fw_sliders_home_slider">
							<optgroup label="请选择首页幻灯片...">
							<?php if (!empty($sliders)) foreach ($sliders as $slider) :	?>							
								<option value="<?php echo $slider->ID ?>" <?php selected( get_option('qqworld_fw_sliders_home_slider'), $slider->ID ); ?>><?php echo $slider->post_title; ?></option>
							<?php endforeach?>
							</optgroup>
						<select></p>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_sliders_qqworld_responsive_slider;
?>