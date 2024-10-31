<?php
define('QQWORLD_FW_PLUGIN_COLORS_URL', QQWORLD_FW_URL.'plugins/colors/');

class qqworld_colors extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Theme Colors', QQWORLD_FW);
		$this->guid = 'colors';
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
			add_action( 'qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));
			add_action('wp_footer', array($this, 'add_to_footer') );
			add_action('wp_enqueue_scripts', array($this, 'setup') );
			add_action( 'qqworld_fw_runtime_init_js', array($this, 'add_script') );
		}
	}

	public function add_script() {
?>
	var oDiv = document.createElement('div');
	oDiv.id = 'themeColor';
	oDiv.innerHTML = '<div id="themeColor_toggle">&lsaquo;</div>\
		\<div id="themeColor_save"><?php _e('Save');?></div>\
		\<div id="themeColor_hex">'+qqworld_ajax.themeColor+'</div>\
		\<input class="minicolors inline" data-control="saturation" type="text" value="'+qqworld_ajax.themeColor+'" />';
	jQuery('body').append(oDiv);
	$('#themeColor_toggle').toggle(
		function() {
			$('#themeColor_toggle').html('&rsaquo;');
			$('#themeColor').animate({right: 0}, 'normal');
		},
		function() {
			$('#themeColor_toggle').html('&lsaquo;');
			$('#themeColor').animate({right: '-195px'}, 'normal');
		}
	)
	$('#themeColor_save').on('click', function() {
		QQWorld.cookies.Set('style_color', $('#themeColor_hex').html(), 946080000);
		jQuery(this).fadeOut('normal', function() {
			jQuery(this).html('<?php _e('Saved');?>').fadeIn('normal').delay(3000).fadeOut('normal', function() {
				jQuery(this).html('<?php _e('Save');?>').fadeIn('normal');
			});
		});
	});
	$('.minicolors').each( function() {
		$(this).minicolors({
			control: $(this).attr('data-control') || 'hue',
			defaultValue: $(this).attr('data-default-value') || '',
			inline: $(this).hasClass('inline'),
			letterCase: $(this).hasClass('uppercase') ? 'uppercase' : 'lowercase',
			opacity: $(this).hasClass('opacity'),
			position: $(this).attr('data-position') || 'default',
			styles: $(this).attr('data-style') || '',
			swatchPosition: $(this).attr('data-swatch-position') || 'left',
			textfield: !$(this).hasClass('no-textfield'),
			theme: $(this).attr('data-theme') || 'default',
			change: function(hex, opacity) {
				text = hex ? hex : 'transparent';
				$('#themeColor_hex').html(text);
				$('#changeColor').html(QQWorld.getThemeStyles(text));
			}
		});	
	});
<?php
	}

	function setup() {
		wp_register_script('minicolors', QQWORLD_FW_PLUGIN_COLORS_URL.'minicolors/jquery.minicolors.js', array('jquery'), '2.0.4', true);
		wp_enqueue_script('minicolors');
		wp_register_style('minicolors', QQWORLD_FW_PLUGIN_COLORS_URL.'minicolors/jquery.minicolors.css');
		wp_enqueue_style('minicolors');
	}
	function add_to_footer() {
	?>
	<style>
	#themeColor {
		position: fixed;
		top: 120px;
		right: -195px;
		padding: 5px 10px;
		background: #e7e7e7;
		z-index: 10;
	}
	#themeColor_hex {
		font-size: 14px;
		text-align: center;
		width: 100%;
		height: 30px;
		line-height: 30px;
		border-radius: 20px;
	}
	#themeColor_toggle {
		width: 30px;
		height: 30px;
		position: absolute;
		left: -30px;
		top: 0;
		background: #e7e7e7;
		cursor: pointer;
		text-align: center;
		font-size: 20px;
	}
	#themeColor_toggle:hover {
		background: #000;
		color: #fff;
	}
	#themeColor_save {
		width: 80px;
		height: 30px;
		line-height: 30px;
		background: #333;
		color: #fff;
		position: absolute;
		bottom: -30px;
		left: 0;
		text-align: center;
		font-size: .75em;
		cursor: pointer;
	}
	#themeColor_save:hover {
		background: #fc0;
	}
	</style>
	<?php
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php _e('Visitors can change the color of the theme from the web pages, and color code saved in cookies.', QQWORLD_FW); ?></p>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_colors;
?>