<?php
define('QQWORLD_FW_RESOURCE_JAVASCRIPT_URL', QQWORLD_FW_URL . 'resource/javascript/');
class qqworld_resource_javascript extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Javascript', QQWORLD_FW);
		$this->guid = 'javascript';
		$this->parent = 'resource';
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
			add_action( 'qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel') );
			add_action( 'wp_enqueue_scripts', array($this, 'setup_script_style') );
		}
	}

	public function setup_script_style() {
		wp_enqueue_script('jquery');
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script('comment-reply');
		foreach ($this->resources() as $resource) $this->getResource($resource);
	}

	public function resources() {
		$resources = get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0];
		return apply_filters('qqworld_fw_resource_js_resources', $resources);
	}

	public function getResource($name) {
		switch ($name) {
			case 'jQuery-UI':
				wp_register_script('jQuery-ui', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery-ui/jquery-ui.min.js', array('jquery'), '1.10.3', true);
				wp_enqueue_script('jQuery-ui');
				break;
			case 'Easing':
				wp_register_script('Easing', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery.easing.1.3.js', array('jquery'), '1.3', true);
				wp_enqueue_script('Easing');
				break;
			case 'scrollTo':
				wp_register_script('scrollTo', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery.scrollto-min.js', array('jquery'), '1.4.3.1', true);
				wp_enqueue_script('scrollTo');
				break;
			case 'QQWorld_Loadimgs':
				wp_register_script('qqworld_loadimgs', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery.qqworld_loadimgs-min.js', array('jquery'), '1.1.0', true);
				wp_enqueue_script('qqworld_loadimgs');
				break;
			case 'QQWorld_Touch':
				wp_register_script('qqworld_touch', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery.qqworld_touch-min.js', array('jquery'), '1.3.5', true);
				wp_enqueue_script('qqworld_touch');
				break;
			case 'QQWorld_Flybox':
				wp_register_style('qqworld_flybox', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld-flybox/theme-base.css');
				wp_enqueue_style('qqworld_flybox');
				wp_register_script('qqworld_flybox', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL. 'qqworld-flybox/jquery.qqworld_flybox-min.js', array('jquery', 'qqworld_touch'), '1.6', true);
				wp_enqueue_script('qqworld_flybox');
				break;
			case 'QQWorld_Responsive_Slider':
				wp_register_style('qqworld_responsive_slider', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld_responsive_slider/qqworld_responsive_slider.css');
				wp_enqueue_style('qqworld_responsive_slider');
				wp_register_script('qqworld_responsive_slider', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld_responsive_slider/jquery.qqworld_responsive_slider-min.js', array('jquery', 'qqworld_touch', 'qqworld_loadimgs'), '1.3', true);
				wp_enqueue_script('qqworld_responsive_slider');	
				break;
			case 'QQWorld_Door2':
				wp_register_script('QQWorld_Door2', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery.qqworld-door2.min.js', array('jquery'), '1.0.0', true);
				wp_enqueue_script('QQWorld_Door2');
				break;
			case 'QQWorld_Matrix_Slider':
				wp_register_script('qqworld_matrix_slider', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld_matrix_slider/jquery.qqworld_matrix_slider-min.js', array('jquery'), '1.0.3', true);
				wp_enqueue_script('qqworld_matrix_slider');
				wp_register_style('qqworld_matrix_slider', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld_matrix_slider/qqworld_matrix_slider.css');
				wp_enqueue_style('qqworld_matrix_slider');
				break;
			case 'QQWorld_Responsive_Drapdown_Menu':
				wp_register_script('qqworld_dropdown_menu', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld-dropdown-menu/jquery.qqworld_dropdown_menu-min.js', array('jquery'), '1.1.0', true);
				wp_enqueue_script('qqworld_dropdown_menu');
				wp_register_style('qqworld_dropdown_menu', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld-dropdown-menu/qqworld_dropdown_menu.css');
				wp_enqueue_style('qqworld_dropdown_menu');
				break;
			case 'QQWorld_Zoom':
				wp_register_script('qqworld_zoom', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld-zoom/jquery.qqworld_zoom-min.js', array('jquery', 'qqworld_touch', 'qqworld_matrix_slider', 'qqworld_flybox'), '1.2', true);
				wp_enqueue_script('qqworld_zoom');
				wp_register_style('qqworld_zoom', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'qqworld-zoom/qqworld_zoom.css');
				wp_enqueue_style('qqworld_zoom');
				break;
			case 'chosen':
				wp_register_script('chosen', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'chosen/chosen.jquery.min.js', array('jquery'), '1.0.0', true);
				wp_enqueue_script('chosen');
				wp_register_style('chosen', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'chosen/chosen.min.css');
				wp_enqueue_style('chosen');
				break;
			case 'Isotope':
				wp_register_script('isotope', QQWORLD_FW_RESOURCE_JAVASCRIPT_URL . 'jquery.isotope.min.js', array('jquery'), '1.5.25');
				wp_enqueue_script('isotope');
				break;
			case 'HTML5':
				?><!--[if lt IE 9]><script src="<?php echo QQWORLD_FW_RESOURCE_JAVASCRIPT_URL; ?>html5.js"></script><![endif]--><?php
				break;
		}
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php _e('For example:', QQWORLD_FW); ?></p>
						<pre class="brush: php">add_filter('qqworld_fw_resource_js_resources', 'add_javascript_resources');
function add_javascript_resources($resources) {
	array_push($resources, 'HTML5', 'jQuery-UI', 'Easing', 'scrollTo', 'QQWorld_Loadimgs', 'QQWorld_Touch', 'QQWorld_Door2', 'QQWorld_Matrix_Slider', 'QQWorld_Responsive_Drapdown_Menu', 'Isotope', 'QQWorld_Zoom', 'chosen');
	return $resources;
}</pre>
						<?php echo sprintf(__('%1$s have enabled the %2$s: ', QQWORLD_FW), __('Resource', QQWORLD_FW), __('Javascript', QQWORLD_FW)) ?>
						<?php echo implode(", ", $this->resources()); ?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_resource_javascript;
?>