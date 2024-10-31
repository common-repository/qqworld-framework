<?php
class qqworld_init_js extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('init.js', QQWORLD_FW);
		$this->guid = 'init_js';
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
			add_action( 'qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel') );
			add_action( 'wp_enqueue_scripts', array($this, 'setup_script') );
			add_action( 'wp_ajax_get_init_js', array($this, 'get_init_js') );
			add_action( 'wp_ajax_nopriv_get_init_js', array($this, 'get_init_js') );
		}
	}

	public function setup_script() {
		wp_register_script('qqworld_init_js', admin_url( 'admin-ajax.php?action=get_init_js', 'relative' ), array('jquery'));
		wp_enqueue_script('qqworld_init_js');
	}

	public function get_init_js() {
		header("Content-type: application/x-javascript");
?>jQuery(function($) {
<?php do_action( 'qqworld_fw_runtime_init_js' ); ?>
});<?php
		die();
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_init_js;
?>