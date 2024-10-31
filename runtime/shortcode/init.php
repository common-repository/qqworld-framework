<?php
define('QQWORLD_FW_RUNTIME_SHORTCODE_URL', QQWORLD_FW_URL . '/runtime/shortcode/');

class qqworld_runtime_shortcode extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Shortcode', QQWORLD_FW);
		$this->guid = 'shortcode';
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
			foreach ( $this->get_shortcodes() as $key => $shortcode ) add_shortcode($key, array($this, $key) );
		}
	}

	public function get_shortcodes() {
		$shortcodes = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $key => $shortcode ) $shortcodes[$key] = $shortcode;
		return apply_filters('qqworld_fw_runtime_shortcodes', $shortcodes);
	}

	public function __call($name, $value) {
		foreach ( $this->get_shortcodes() as $key => $shortcode ) {
			if ($key == $name) {
				if ( !empty($value[0]) ) foreach ( $value[0] as $a => $arg ) $shortcode = str_replace("%$a%", $arg, $shortcode);
				return str_replace("%CONTENT%", strip_tags($value[1]), $shortcode);
			}
		}
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
						$shortcodes = array();
						foreach ( $this->get_shortcodes() as $key => $shortcode ) $shortcodes[]=$key;
						echo implode(", ", $shortcodes);
						?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_shortcode;
?>