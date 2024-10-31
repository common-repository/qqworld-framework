<?php
class qqworld_runtime_sidebars extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Sidebars', QQWORLD_FW);
		$this->guid = 'sidebars';
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
			add_action( 'widgets_init', array($this, 'register_sidebars') );
		}
	}

	public function register_sidebars() {
		foreach ( $this->get_sidebars() as $sidebar) register_sidebar( $sidebar );
	}

	public function get_sidebars() {
		$sidebars = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $sidebar) $sidebars[] = $sidebar;
		return apply_filters( 'qqworld_fw_runtime_sidebars', $sidebars );
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
						$sidebars = array();
						foreach ( $this->get_sidebars() as $sidebar ) $sidebars[]=$sidebar['name'];
						echo implode(", ", $sidebars);
						?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_sidebars;
?>