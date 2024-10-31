<?php
define('QQWORLD_FW_RUNTIME_EDITOR_BUTTONS_URL', QQWORLD_FW_URL . 'runtime/editor_buttons/');

class qqworld_runtime_editor_buttons extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Editor Buttons', QQWORLD_FW);
		$this->guid = 'editor_buttons';
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
			add_action('admin_print_footer_scripts', array($this, 'add_buttons_in_textmode') );
			add_action( 'wp_ajax_get_ajax_nextpage', array($this, 'get_ajax_nextpage') );
			add_action( 'wp_ajax_nopriv_get_ajax_nextpage', array($this, 'get_ajax_nextpage') );
			add_action( 'init', array($this, 'add_buttons_in_visualmode') );
		}
	}

	public function add_buttons_in_textmode() {
		if (wp_script_is('quicktags')) : ?>
<script>
<?php foreach ($this->get_buttons() as $button) :
		$callback = isset($button['text']['callback']) ? ' ,'.$button['text']['callback'] : '';
		$args = '"' . implode('", "', $button['text']['args']) . '"' . $callback;
?>
QTags.addButton( <?php echo $args; ?> );
<?php endforeach; ?>
</script>
	<?php endif;
	}
	public function get_buttons() {
		$buttons = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $key => $button) $buttons[$key] = $button;
		return apply_filters('qqworld_fw_runtime_editor_buttons', $buttons);
	}
	
	public function add_buttons_in_visualmode() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array($this, 'add_tinymce_plugin') );
			add_filter( 'mce_buttons', array($this, 'register_button') );
		}
	}
	public function add_tinymce_plugin( $plugin_array ) {
		foreach ($this->get_buttons() as $button) {
			if ($button['rich']) {
				$data = array();
				$data['action'] = 'get_ajax_nextpage';
				$data['data'] = $button['rich'];
				$plugin_array[$button['rich']['name']] = admin_url( 'admin-ajax.php?'.http_build_query($data), 'relative' );
			}
		}
		return $plugin_array;
	}
	public function get_ajax_nextpage() {
		header("Content-type: application/x-javascript");
		global $_REQUEST;
		$name = stripslashes($_REQUEST['data']['name']);
		$title = stripslashes($_REQUEST['data']['title']);
		$image = stripslashes($_REQUEST['data']['image']);
		$onclick = stripslashes($_REQUEST['data']['onclick']);
?>
(function() {
	tinymce.create('tinymce.plugins.<?php echo $name;?>', {
		init: function(ed, url) {
			ed.addButton('<?php echo $name;?>', {
				title: '<?php echo $title;?>',
				image: '<?php echo $image;?>',
				onclick: <?php echo $onclick;?>
			});
		},
		createControl: function(n, cm) {
			return null;
		},
	});
	tinymce.PluginManager.add('<?php echo $name;?>', tinymce.plugins.<?php echo $name;?>);
})();
<?php
		exit;
	}
	public function register_button( $buttons ) {
		foreach ($this->get_buttons() as $button) {
			if ($button['rich']) {
				array_push( $buttons, "|", $button['rich']['name'] );
			}
		}
		return $buttons;
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
						$buttons = array();
						foreach ($this->get_buttons() as $key => $button) $buttons[]=$key;
						echo implode(", ", $buttons);
						?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_editor_buttons;
?>