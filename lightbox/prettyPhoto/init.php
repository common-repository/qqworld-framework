<?php
class qqworld_pretty_photo extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_runtime;
		$this->name = __('prettyPhoto', QQWORLD_FW);
		$this->guid = 'prettyPhoto';
		$this->parent = 'lightbox';
		$this->core = false;
		$qqworld_fw_runtime[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
	}

	public function init() {
		if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid ) || $this->core ) {
			add_action('qqworld-fw-lightbox', array($this, 'add_to_cpanel'));
			/*add_action('admin_init', array($this, 'register'));
			add_action( 'wp_enqueue_scripts', array($this, 'add_scripts_style') );
			add_action( 'wp_footer', array($this, 'add_script_to_footer') );
			add_filter( 'qqworld_lightbox_selector', array($this, 'selector') );*/
		}
	}

	public function register() {
		register_setting('qqworld-framework', 'qqworld_fw_qqworld_flybox_settings');
	}

	function selector($selector) {
		return 'lightbox[pic]';
	}

	//add Plugin qqworldFlybox
	function add_scripts_style() {
		wp_register_style('qqworld_flybox', QQWORLD_FW_URL.'/lightbox/qqworldflybox/qqworld-flybox/theme-base.css');
		wp_enqueue_style('qqworld_flybox');
		wp_register_script('qqworld_flybox', QQWORLD_FW_URL. '/lightbox/qqworldflybox/qqworld-flybox/jquery.qqworld_flybox-min.js', array('jquery', 'qqworld_touch'));
		wp_enqueue_script('qqworld_flybox');	
	}
	function add_script_to_footer() {
		$qqworld_fw_qqworld_flybox_settings = is_array(get_option('qqworld_fw_qqworld_flybox_settings', unserialize(QQWORLD_FW_LIGHTBOX_QQWORLDFLYBOX))) ? get_option('qqworld_fw_qqworld_flybox_settings', unserialize(QQWORLD_FW_LIGHTBOX_QQWORLDFLYBOX)) : unserialize(get_option('qqworld_fw_qqworld_flybox_settings', unserialize(QQWORLD_FW_LIGHTBOX_QQWORLDFLYBOX)));
	?>
	<script>
	function lightBoxInit() {
		var $ = jQuery;
		jQuery("a[rel^='lightbox']").QQWorldFlybox({
			bg_opacity: <?php echo $qqworld_fw_qqworld_flybox_settings['bg_opacity']; ?>,
			speed: <?php echo $qqworld_fw_qqworld_flybox_settings['speed']; ?>,
			pause: <?php echo $qqworld_fw_qqworld_flybox_settings['pause']; ?>,
			showNav: <?php echo $qqworld_fw_qqworld_flybox_settings['showNav']; ?>,
			showPager: <?php echo $qqworld_fw_qqworld_flybox_settings['showPager']; ?>,
			autoHidePager: <?php echo $qqworld_fw_qqworld_flybox_settings['autoHidePager']; ?>,
			thumbnail: <?php echo $qqworld_fw_qqworld_flybox_settings['thumbnail']; ?>,
			title: <?php echo $qqworld_fw_qqworld_flybox_settings['title']; ?>,
			description: <?php echo $qqworld_fw_qqworld_flybox_settings['description']; ?>,
			link: <?php echo $qqworld_fw_qqworld_flybox_settings['link']; ?>,
			cpanel: <?php echo $qqworld_fw_qqworld_flybox_settings['cpanel']; ?>,
			debug: <?php echo $qqworld_fw_qqworld_flybox_settings['debug']; ?>
		});
	}
	lightBoxInit();
	</script>
	<?php
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p>qqworldFlybox 是我开发的第一款基于jQuery的灯箱插件。开发的初衷是因为我的阿Q的项目第三版使用了Ajax读取文章的技术，但网上找的灯箱插件都无法读取Ajax生成的内容，要想自给自足，只有自力更生了。时值WAiWAi杂志075期的制作。<br />Version 1.2.0</p>					
						<h3><?php _e('Screenshot', QQWORLD_FW); ?></h3>
						<p><img src="<?php echo QQWORLD_FW_URL; ?>/lightbox/qqworldflybox/screenshot.png" /></p>
						<h3><?php _e('Settings'); ?></h3>
						<table class="QQWorld_admin_table widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col" class="manage-column check-column"></th>
									<th scope="col" class="manage-column"><?php _e('Attribute', QQWORLD_FW);?></th>
									<th scope="col" class="manage-column"><?php _e('Value &amp; Description', QQWORLD_FW);?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th scope="col" class="manage-column check-column"></th>
									<th scope="col" class="manage-column"><?php _e('Attribute', QQWORLD_FW);?></th>
									<th scope="col" class="manage-column"><?php _e('Value &amp; Description', QQWORLD_FW);?></th>
								</tr>
							</tfoot>

							<tbody>
								<?php
								$values = is_array(get_option('qqworld_fw_qqworld_flybox_settings', unserialize(QQWORLD_FW_LIGHTBOX_QQWORLDFLYBOX))) ? get_option('qqworld_fw_qqworld_flybox_settings', unserialize(QQWORLD_FW_LIGHTBOX_QQWORLDFLYBOX)) : unserialize(get_option('qqworld_fw_qqworld_flybox_settings', unserialize(QQWORLD_FW_LIGHTBOX_QQWORLDFLYBOX)));

								$fields = array(
									array('heading' => __('bg_opacity'),
										'description' => __('背景颜色透明度，范围在0和1之间，包括0和1', QQWORLD_FW),
										'type' => 'textfield',
										'name' => 'qqworld_fw_qqworld_flybox_settings[bg_opacity]',
										'id' => 'bg_opacity',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['bg_opacity']
									),
									array('heading' => __('speed'),
										'description' => __('动画播放速度，以毫秒为单位', QQWORLD_FW),
										'type' => 'textfield',
										'name' => 'qqworld_fw_qqworld_flybox_settings[speed]',
										'id' => 'speed',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['speed']
									),
									array('heading' => __('pause'),
										'description' => __('动画时间间隔，以毫秒为单位', QQWORLD_FW),
										'type' => 'textfield',
										'name' => 'qqworld_fw_qqworld_flybox_settings[pause]',
										'id' => 'pause',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['pause']
									),
									array('heading' => __('showNav'),
										'description' => __('显示导航(上一幅&下一幅)', QQWORLD_FW),
										'type' => 'switch',
										'name' => 'qqworld_fw_qqworld_flybox_settings[showNav]',
										'id' => 'showNav',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['showNav']
									),
									array('heading' => __('showPager'),
										'description' => __('显示分页', QQWORLD_FW),
										'type' => 'switch',
										'name' => 'qqworld_fw_qqworld_flybox_settings[showPager]',
										'id' => 'showPager',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['showPager']
									),
									array('heading' => __('autoHidePager'),
										'description' => __('自动隐藏分页', QQWORLD_FW),
										'type' => 'switch',
										'name' => 'qqworld_fw_qqworld_flybox_settings[autoHidePager]',
										'id' => 'autoHidePager',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['autoHidePager']
									),
									array('heading' => __('thumbnail'),
										'description' => __('一个数组，可以包含n个函数，每个函数返回可能的缩略图图片对象相对于时间对象的jQuery路径', QQWORLD_FW),
										'type' => 'textarea',
										'name' => 'qqworld_fw_qqworld_flybox_settings[thumbnail]',
										'id' => 'thumbnail',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['thumbnail'],
										'size' => 'large'
									),
									array('heading' => __('title'),
										'description' => __('一个数组，可以包含n个函数，每个函数返回可能的标题对象相对于时间对象的jQuery路径', QQWORLD_FW),
										'type' => 'textarea',
										'name' => 'qqworld_fw_qqworld_flybox_settings[title]',
										'id' => 'title',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['title'],
										'size' => 'large'
									),
									array('heading' => __('description'),
										'description' => __('一个数组，可以包含n个函数，每个函数返回可能的描述文字对象相对于时间对象的jQuery路径', QQWORLD_FW),
										'type' => 'textarea',
										'name' => 'qqworld_fw_qqworld_flybox_settings[description]',
										'id' => 'description',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['description'],
										'size' => 'large'
									),
									array('heading' => __('link'),
										'description' => __('一个数组，可以包含n个函数，每个函数返回可能的描述文字对象相对于时间对象的jQuery路径', QQWORLD_FW),
										'type' => 'textarea',
										'name' => 'qqworld_fw_qqworld_flybox_settings[link]',
										'id' => 'link',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['link'],
										'size' => 'large'
									),
									array('heading' => __('cpanel'),
										'description' => __('显示控制面板', QQWORLD_FW),
										'type' => 'switch',
										'name' => 'qqworld_fw_qqworld_flybox_settings[cpanel]',
										'id' => 'cpanel',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['cpanel']
									),
									array('heading' => __('debug'),
										'description' => __('显示调试窗', QQWORLD_FW),
										'type' => 'switch',
										'name' => 'qqworld_fw_qqworld_flybox_settings[debug]',
										'id' => 'debug',
										'before' => '<td></td>',
										'field_before' => '<td>',
										'field_after' => '</td>',
										'value' => $values['debug']
									)
								);
								foreach ($fields as $k => $field) {
									echo '<tr>'.qqworld_fw::create_form($field, $values[$k]).'</tr>';
								}
								?>

							</tbody>
						</table>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_pretty_photo;
?>