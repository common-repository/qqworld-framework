<?php
class qqworld_menus_dropdown extends qqworld_fw_members {
	var $dropdown_menus;
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Dropdown Menu', QQWORLD_FW);
		$this->guid = 'dropdown';
		$this->parent = 'menus';
		$this->core = false;
		$qqworld_fw_members[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
		$this->dropdown_menus = array(
			'QQWorld-Drapdown-Menu' => array()
		);
	}

	public function init() {
	//	if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid ) || $this->core ) {
			add_action( 'qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel') );
			add_action( 'admin_init', array($this, 'register') );
			add_action( 'qqworld_fw_menus_dropdown_menu_form', array($this, get_theme_support('qqworld_fw_menus_dropdown')[0]['type']) );
			add_action( 'qqworld_fw_runtime_init_js', array($this, 'add_script') );
	//	}
	}

	public function register() {
		register_setting('qqworld-framework', 'qqworld_fw_menus_qqworld_dropdown_menu_settings');
	}

	public function add_script() {
		$settings = get_option('qqworld_fw_menus_qqworld_dropdown_menu_settings', get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0]['args'] );
?>
	jQuery('#nav-container').QQWorldDropdownMenu(<?php echo json_encode($settings, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);?>);
<?php
	}

	public function __call($name, $arguments) {
		switch ($name) {
			case 'qqworld_dropdown_menu':
?>
				<h3><?php _e('QQWorld Dropdown Menu', QQWORLD_FW); ?></h3>
				<p><?php _e('Michael Wang original drop-down menu, responsive design, and support the touch events.', QQWORLD_FW ); ?></p>
				<?php
				$settings = get_option('qqworld_fw_menus_qqworld_dropdown_menu_settings', get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] );
				?>
				<table class="QQWorld_admin_table widefat" cellspacing="0">
					<thead>
						<tr>
							<th scope="col" class="manage-column check-column"></th>
							<th scope="col" class="manage-column"><?php _e('Attribute', QQWORLD_FW); ?></th>
							<th scope="col" class="manage-column"><?php _e('Value &amp; Description', QQWORLD_FW); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="manage-column check-column"></th>
							<th scope="col" class="manage-column"><?php _e('Attribute', QQWORLD_FW); ?></th>
							<th scope="col" class="manage-column"><?php _e('Value &amp; Description', QQWORLD_FW); ?></th>
						</tr>
					</tfoot>

					<tbody>
					<?php
					$fields = array(
						array('heading' => 'Direction',
							'description' => __("The direction of menu.", QQWORLD_FW),
							'type' => 'select',
							'name' => 'qqworld_fw_menus_qqworld_dropdown_menu_settings[direction]',
							'id' => 'direction',
							'before' => '<td></td>',
							'field_before' => '<td>',
							'field_after' => '</td>',
							'options' => array(
								__('Horizontal', QQWORLD_FW) => 'horizontal',
								__('Vertical', QQWORLD_FW) => 'vertical',
							),
							'value' => $settings['direction']
						),
						array('heading' => 'effect.show',
							'description' => __("The style of showing dropdown menu.", QQWORLD_FW),
							'type' => 'select',
							'name' => 'qqworld_fw_menus_qqworld_dropdown_menu_settings[effect][show]',
							'id' => 'effect-show',
							'before' => '<td></td>',
							'field_before' => '<td>',
							'field_after' => '</td>',
							'options' => array(
								'random', 'flash', 'bounce', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipInY', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'lightSpeedIn', 'rollIn'
							),
							'value' => $settings['effect']['show']
						),
						array('heading' => 'effect.hide',
							'description' => __("The style of hiding dropdown menu.", QQWORLD_FW),
							'type' => 'select',
							'name' => 'qqworld_fw_menus_qqworld_dropdown_menu_settings[effect][hide]',
							'id' => 'effect-hide',
							'before' => '<td></td>',
							'field_before' => '<td>',
							'field_after' => '</td>',
							'options' => array(
								'random', 'flipOutX', 'flipOutY', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedOut', 'hinge', 'rollOut'
							),
							'value' => $settings['effect']['hide']
						)
					);
					foreach ($fields as $f => $field) {
						echo '<tr>'.qqworld_fw::create_form($field).'</tr>';
					}
					?>
					</tbody>
				</table>
<?php
			break;
		}
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<?php do_action('qqworld_fw_menus_dropdown_menu_form') ?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_menus_dropdown;
?>