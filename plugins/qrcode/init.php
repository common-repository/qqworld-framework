<?php
define('QQWORLD_FW_PLUGINS_QRCODE_TMP_DIR', WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'qrcode');
define('QQWORLD_FW_PLUGINS_QRCODE_TMP_URL', WP_CONTENT_URL.'/uploads/qrcode');

class qqworld_qrcode extends qqworld_fw_members {

	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('QRCode', QQWORLD_FW);
		$this->guid = 'qrcode';
		$this->parent = 'plugins';
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

	static function make($arg) { // $lever: L/M/Q/H ; $size: 1/2/3/4/5/6/7/8/9/10
		include_once "phpqrcode/qrlib.php";
		$data = isset($arg['data']) ? $arg['data'] : '';
		$level = isset($arg['level']) ? $arg['level'] : 'L';
		$size = isset($arg['size']) ? $arg['size'] : 4;
		if (!file_exists(QQWORLD_FW_PLUGINS_QRCODE_TMP_DIR)) mkdir(QQWORLD_FW_PLUGINS_QRCODE_TMP_DIR);
		$filepath = QQWORLD_FW_PLUGINS_QRCODE_TMP_DIR . "/".md5($data)."_".$level."_".$size.".png";
		$fileurl = QQWORLD_FW_PLUGINS_QRCODE_TMP_URL . "/".md5($data)."_".$level."_".$size.".png";
		if (!file_exists($filepath)) {
			QRcode::png($data, $filepath, $level, $size, 2);
		}
		echo $fileurl;
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php echo sprintf(__('Use following code to call %s runtime in template files:', QQWORLD_FW), __('QRCode', QQWORLD_FW)); ?></p>
						<pre class="brush: php">qqworld_qrcode::make( array(
	'data' =&gt; get_option('siteurl')."?p=".$post->ID,
	'level' =&gt; 'Q',
	'size' =&gt; 10
) );</pre>
						<ol>
							<li><?php _ex('<strong>data</strong> is data of QRCode (Required).', 'qrcode', QQWORLD_FW); ?></li>
							<li><?php _ex('<strong>level</strong> is level of QRCode, There are L / M / Q / H optional (optional - defaults to L).', 'qrcode', QQWORLD_FW); ?></li>
							<li><?php _ex('<strong>data</strong> is size of QRCode (optional - defaults to 4).', 'qrcode', QQWORLD_FW); ?></li>
						</ol>
						<p><?php _e('For example:', QQWORLD_FW); ?></p>
						<pre class="brush: php">&lt;?php if ( class_exists('qqworld_qrcode') ) : ?&gt;
&lt;a href="&lt;?php @qqworld_qrcode::make( array('data'=&gt;get_option('siteurl')."?p=".$post->ID, 'level'=&gt;'Q', 'size'=&gt;10) )?&gt;" target="_blank"&gt;
	&lt;img src="&lt;?php @qqworld_qrcode::make( array('data'=&gt;get_option('siteurl')."?p=".$post->ID) )?&gt;" width="80" height="80" alt="QRCode" title="QRCode" /&gt;
&lt;/a&gt;
&lt;?php endif; ?&gt;</pre>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_qrcode;
?>