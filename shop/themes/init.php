<?php
class qqworld_themes extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Themes Shop', QQWORLD_FW);
		$this->guid = 'themes';
		$this->parent = 'shop';
		$this->core = true;
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
		}
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<!--<iframe src="http://www.qqworld.org" height="768" width="100%"></iframe>-->
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_themes;
?>