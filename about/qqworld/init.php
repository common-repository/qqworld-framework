<?php
class qqworld_about_qqworld extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('QQWorld', QQWORLD_FW);
		$this->guid = 'qqworld';
		$this->parent = 'about';
		$this->core = true;
		$qqworld_fw_members[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
	}

	public function init() {
		if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid) || $this->core ) {
			add_action('qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));
		}
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<h3><?php _ex('About QQWorld', 'about', QQWORLD_FW); ?></h3>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_about_qqworld;
?>