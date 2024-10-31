<?php
class qqworld_runtime_customize extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Customize', QQWORLD_FW);
		$this->guid = 'customize';
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
			add_action( 'customize_register', array($this, 'customize') );
			add_action( 'wp_ajax_get_live_preview', array($this, 'get_live_preview') );
			add_action( 'wp_ajax_nopriv_get_live_preview', array($this, 'get_live_preview') );
			add_action( 'customize_preview_init' , array( $this, 'live_preview' ) );
		}
	}

	function customize($wp_customize) {
		if ( count($this->get_customize()) ) foreach ( $this->get_customize() as $custom) {
			if ($custom['add_section']) {
				$wp_customize->add_section( $custom['section'], $custom['args'] );
			}
			if ( count($custom['settings']) ) {
				foreach ( $custom['settings'] as $s => $setting ) {
					$wp_customize->add_setting( $s, $setting['args']);
					switch ($setting['control']['type']) {
						case 'Image':
							$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $s, $setting['control']['args']) );
							break;
						case 'Color':
							$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $s, $setting['control']['args']) );
							break;
						case 'Upload':
							$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $s, $setting['control']['args']) );
							break;
						case 'Background_Image':
							$wp_customize->add_control( new WP_Customize_Background_Image_Control( $wp_customize, $s, $setting['control']['args']) );
							break;
						case 'Header_Image':
							$wp_customize->add_control( new WP_Customize_Header_Image_Control( $wp_customize, $s, $setting['control']['args']) );
							break;
						default:
							$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $s, $setting['control']['args']) );
							break;
					}
				}
			}
		}
	}

	function live_preview() {
		wp_enqueue_script('qqworld-themecustomizer', admin_url( 'admin-ajax.php?action=get_live_preview', 'relative' ), array( 'jquery', 'qqworld_lib' ), '', true);
	}

	function get_live_preview() {
		header("Content-type: application/x-javascript");
?>
(function($) {
<?php if ( count($this->get_customize()) ) foreach ( $this->get_customize() as $custom) :
	if ( count($custom['settings']) ) foreach ( $custom['settings'] as $s => $setting ) :
		if ( !empty($setting['live_preview']) ) : ?>
	wp.customize( '<?php echo $s; ?>', function(value) {
		value.bind( function(newval) {
<?php echo $setting['live_preview']; ?>
		});
	});
<?php endif;
	endforeach;
endforeach; ?>
})(jQuery);
<?php
	die();
	}

	public function get_customize() {
		$customize = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $custom ) $customize[] = $custom;
		return apply_filters('qqworld_fw_runtime_customize', $customize);
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
					<p><?php echo sprintf(__('Have enabled the %s: ', QQWORLD_FW), __('Customize', QQWORLD_FW)) ?></p>
					<?php
					echo '<ol>';
					if ( count($this->get_customize()) ) foreach ( $this->get_customize() as $custom) {
						echo '<li>';
						if ($custom['add_section']) echo sprintf( _x( "Add new section: <strong>%s</strong><br />", 'customize', QQWORLD_FW ), $custom['section'] );
						else echo sprintf( _x( "Using existing section: <strong>%s</strong><br />", 'customize', QQWORLD_FW ), $custom['section'] );
						$settings = array();
						if ( count($custom['settings']) ) foreach ( $custom['settings'] as $s => $setting ) $settings[] = $s;
						echo sprintf( _x( "Setting in this section: %s.", 'customize', QQWORLD_FW ), implode(",", $settings) ) . '</li>';
					}
					echo '</ol>';
					?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_customize;
?>