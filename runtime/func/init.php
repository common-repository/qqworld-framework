<?php
class qqworld_runtime_func extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Function', QQWORLD_FW);
		$this->guid = 'func';
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
		}
	}

	//截取字符串
	static function cut($str, $length, $charset = "utf8") {
		$total_length = mb_strlen($str, $charset);
		if ($length < $total_length && !empty($str)) return mb_substr($str,0, $length, $charset);
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
					<p><?php _e('For example:', QQWORLD_FW); ?></p>
					<pre class="brush: php">&lt;?php qqworld_runtime_func::cut($str, $length, $charset = "utf8") ?&gt;</pre>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_func;
?>