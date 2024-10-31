<?php
class qqworld_fw_default {
	public function __construct() {
		add_action('after_setup_theme', array($this, 'init'));
	}

	public function init() {
		add_editor_style();
		add_filter('qqworld_fw_define_custom_posttypes', array($this, 'define_custom_posttypes'));
		add_filter('qqworld_fw_runtime_editor_buttons', array($this, 'define_custom_editor_buttons'));
		add_filter('qqworld_fw_runtime_customize', array($this, 'define_custom_custommize'));
	}

	public function define_custom_custommize($customize) {
		$customize[] = array(
			'section' => 'qqworld_theme_logo_website_settings_section',
			'add_section' => true,
			'args' => array(
				'title' => __( 'Website Settings', QQWORLD_FW ),
				'priority' => 30,
				'capability' => 'edit_theme_options',
				'description' => __('Upload a logo to replace the default site name and description in the header, and change ICP infomation.', QQWORLD_FW)
			),
			'settings' => array(
				'qqworld_theme_logo' => array(
					'args' => array(
						'default' => constant('qqworld_theme_logo'),
						'type' => 'option',
						'capability' => 'edit_theme_options',
						'transport' => 'postMessage'
					),
					'control' => array(
						'type' => 'Image',
						'args' => array(
							'label' => __( 'Logo', QQWORLD_FW ),
							'section' => 'qqworld_theme_logo_website_settings_section',
							'settings' => 'qqworld_theme_logo'
						)
					),
					'live_preview' => <<<EOF
		$('#logo img').attr({src: newval});\n
EOF
				),
				'qqworld_ICP' => array(
					'args' => array(
						'type' => 'option',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh'
					),
					'control' => array(
						'args' => array(
							'label' => __( 'ICP', QQWORLD_FW ),
							'section' => 'qqworld_theme_logo_website_settings_section',
							'settings' => 'qqworld_ICP'
						)
					)
				)
			)					
		);
		return $customize;
	}

	public function define_custom_posttypes($custom_posttypes) {
		$custom_posttypes[] = array(
			'post_type' => 'slider_parent',
			'singular_name' => 'Parent of Slider',
			'plural_name' => 'Parent of Slider',
			'args' => array(
				'public' => false
			)
		);
		return $custom_posttypes;
	}

	public function define_custom_editor_buttons($buttons) {
		$buttons['h1'] = array(
			'text' => array(
				'args' => array("_h1", "h1", '<h1>', '</h1>', 'h1', __('Heading 1') )
			)
		);
		$buttons['h2'] = array(
			'text' => array(
				'args' => array("_h2", "h2", '<h2>', '</h2>', 'h2', __('Heading 2') )
			)
		);
		$buttons['h3'] = array(
			'text' => array(
				'args' => array("_h3", "h3", '<h3>', '</h3>', 'h3', __('Heading 3') )
			)
		);
		$buttons['h4'] = array(
			'text' => array(
				'args' => array("_h4", "h4", '<h4>', '</h4>', 'h4', __('Heading 4') )
			)
		);
		$buttons['h5'] = array(
			'text' => array(
				'args' => array("_h5", "h5", '<h5>', '</h5>', 'h5', __('Heading 5') )
			)
		);
		$buttons['h6'] = array(
			'text' => array(
				'args' => array("_h6", "h6", '<h6>', '</h6>', 'h6', __('Heading 6') )
			)
		);
		$buttons['hr'] = array(
			'text' => array(
				'args' => array("_hr", "hr", '<hr />', '', __('Insert horizontal ruler') )
			)
		);
		$buttons['nextpage'] = array(
			'text' => array(
				'args' => array("_nextpage", __("Next page"), '<!--nextpage-->', '',  'nextpage', __('Insert Page Break') )
			),
			'rich' => array(
				'name' => '_nextpage',
				'title' => __('Insert Page Break'),
				'image' => QQWORLD_FW_RUNTIME_EDITOR_BUTTONS_URL . 'icons/nextpage.gif',
				'onclick' => <<<EOF
function() {
	ed.selection.setContent('<img class="mce-wp-nextpage mceItemNoResize" title="{__("Next page...")}" alt="" />');
}
EOF
			)
		);

		return $buttons;
	}
}
new qqworld_fw_default;
?>