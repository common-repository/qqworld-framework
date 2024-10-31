<?php
define('QQWORLD_FW_RESOURCE_CSS_URL', QQWORLD_FW_URL . 'resource/css/');
class qqworld_resource_css extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('CSS', QQWORLD_FW);
		$this->guid = 'css';
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
		foreach ($this->resources() as $resource) $this->getResource($resource);
	}

	public function resources() {
		$resources = get_theme_support('qqworld_fw_resource_css')[0];
		return apply_filters('qqworld_fw_resource_css_resources', $resources);
	}

	public function getResource($name) {
		switch ($name) {
			case 'Animate':
				wp_register_style('animate', QQWORLD_FW_RESOURCE_CSS_URL .'animate.min.css');
				wp_enqueue_style('animate');
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
						<pre class="brush: php">add_filter('qqworld_fw_resource_css_resources', 'add_css_resources');
function add_css_resources($resources) {
	array_push($resources, 'Animate');
	return $resources;
}</pre>
						<?php echo sprintf(__('%1$s have enabled the %2$s: ', QQWORLD_FW), __('Resource', QQWORLD_FW), __('CSS', QQWORLD_FW)) ?>：
						<?php echo implode(", ", $this->resources()); ?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_resource_css;
?>