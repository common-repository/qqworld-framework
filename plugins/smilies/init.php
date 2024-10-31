<?php
define('QQWORLD_FW_PLUGINS_SMILIES_THEME', 'qq-square');

class qqworld_smilies extends qqworld_fw_members {
	var $theme;

	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Smilies', QQWORLD_FW);
		$this->guid = 'smilies';
		$this->parent = 'plugins';
		$this->core = false;
		$qqworld_fw_members[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
		$this->theme = get_option('qqworld_fw_plugins_smilies_theme', QQWORLD_FW_PLUGINS_SMILIES_THEME);
	}

	public function init() {
		if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid ) || $this->core ) {
			add_action( 'qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));
			add_action( 'init', array($this,'setup') );
			add_filter( 'qqworld_smilies', array($this, 'get_smilies') );
			add_action( 'admin_init', array($this, 'register') );
		}
	}

	public function register() {
		register_setting('qqworld-framework', 'qqworld_fw_plugins_smilies_theme');
	}

	public function setup() {
		add_filter('smilies_src', array($this, 'custom_smilies_src'), 1, 10);
	}
	//替换为主题自带的表情
	public function custom_smilies_src($img_src, $img, $siteurl){
		return QQWORLD_FW_URL.'plugins/smilies/images/'.$this->theme.'/'.$img;
	}
	public function get_smilies() {
		add_filter('comment_text', array(&$this, 'convert_smilies'));
		global $wpsmiliestrans;
		$smilies = array_unique($wpsmiliestrans);
		$link='';
		foreach ($smilies as $key => $smile) {
			$file = QQWORLD_FW_URL.'plugins/smilies/images/'.$this->theme.'/'.$smile;
			$value = " ".$key." ";
			$img = "<img src=\"{$file}\" alt=\"{$smile}\" />";
			$imglink = htmlspecialchars($img);
			$link .= "<a href=\"#commentform\" title=\"{$smile}\" onclick=\"document.getElementById('comment').value += '{$value}'\">{$img}</a>&nbsp;";
		}
		return '<div class="wp_smilies">'.$link.'</div>';
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<?php
						$smilies = array();
						$dir = dirname(__FILE__) . '/images/';
						if ($handle = dir($dir)) while (false !== ($file = $handle->read())) if ($file!="." && $file!=".." && is_dir($dir.$file)) array_push($smilies, $file);
						foreach ($smilies as $smilie) :
							$url = QQWORLD_FW_URL.'plugins/smilies/images/' . $smilie . '/';
							$checked = $smilie == get_option('qqworld_fw_plugins_smilies_theme', QQWORLD_FW_PLUGINS_SMILIES_THEME) ? ' checked="checked"' : '';
						?>
						<p><input<?php echo $checked;?> id="<?php echo $smilie; ?>" type="radio" name="qqworld_fw_plugins_smilies_theme" value="<?php echo $smilie; ?>" /><label for="<?php echo $smilie; ?>">
						<?php
							$sdir = $dir . $smilie . '/';
							if ($handle = dir($sdir)) :
								while (false !== ($file = $handle->read())) :
									if ($file!="." && $file!="..") :
						?>
							<img src="<?php echo $url . $file; ?>" />
						<?php
									endif;
								endwhile;
							endif;
						?>
						<label></p>
						<?php
						endforeach;
						?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_smilies;
?>