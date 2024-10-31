<?php
/*
Plugin Name: QQWorld Framework
Plugin URI: http://www.qqworld.org
Description: For commercial website design and production.
Version: 1.2.1
Author: Michael Wang
Author URI: http://www.qqworld.org
*/

define('QQWORLD_FW_DIR', dirname(__FILE__));
define('QQWORLD_FW_URL', plugin_dir_url(__FILE__));
define('QQWORLD_FW', 'qqworld-framework'); // using for lang

$qqworld_fw_features;
$qqworld_fws; //All frameworks infomation
$qqworld_fw_members; //All libs's infomation

class qqworld_fw {
	var $name;
	var $guid;
	var $parent;
	var $core;
	var $members;

	public function __construct() {
		add_action( 'plugins_loaded', array($this, 'sign_up') );
		add_action( 'plugins_loaded', array($this, 'load_dir') );
		add_action( 'plugins_loaded', array($this, 'include_members') );
		$this->init();
	}

	/* Sign up */
	public function sign_up() {
		global $qqworld_fws;
		$qqworld_fws =  array(
			array(
				'name' => __("Plugins", QQWORLD_FW),
				'guid' => 'plugins'
			),
			array(
				'name' => __("Lightbox", QQWORLD_FW),
				'guid' => 'lightbox'
			),
			array(
				'name' => __("Sliders", QQWORLD_FW),
				'guid' => 'sliders'
			),
			array(
				'name' => __("Resource", QQWORLD_FW),
				'guid' => 'resource'
			),
			array(
				'name' => __("Runtime", QQWORLD_FW),
				'guid' => 'runtime'
			),
			array(
				'name' => __("Menus", QQWORLD_FW),
				'guid' => 'menus'
			),
			array(
				'name' => __("Patch", QQWORLD_FW),
				'guid' => 'patch'
			),
			array(
				'name' => __("Shop", QQWORLD_FW),
				'guid' => 'shop'
			),
			array(
				'name' => __("About", QQWORLD_FW),
				'guid' => 'about'
			)			
		);
	}

	/* Load all member init.php files from root directory  */
	public function load_dir() {
		global $qqworld_fws;
		$this->members = array();
		foreach ($qqworld_fws as $fw) {
			if ($fw['guid'] !== Null) {				
				$dir = QQWORLD_FW_DIR . DIRECTORY_SEPARATOR . $fw['guid'];
				if (is_dir($dir) && $handle = dir($dir)) {
					while (false !== ($file = $handle->read())) {
						$fullpath = $dir. DIRECTORY_SEPARATOR . $file;
						if ($file!="." && $file!=".." && is_dir($fullpath) && file_exists($fullpath.DIRECTORY_SEPARATOR.'init.php')) {
							$this->members[] = array(
								'path' =>$fullpath.DIRECTORY_SEPARATOR.'init.php'
							);
						}
					}
				}
			}
		}
	}

	public function include_members() {
		$this->load_dir();
		if ($this->members) foreach ($this->members as $member) {
			include_once $member['path'];
		}
	}

	/* init */
	public function init() {
		add_action( 'after_setup_theme', array($this, 'add_theme_supports'), 9 );
		add_action( 'plugins_loaded', array($this, 'load_language'), 1 );
		add_action( 'admin_menu', array($this, 'create_menu') );		
		add_action( 'admin_init', array($this, 'add_settings_error') );
		add_action( 'admin_enqueue_scripts', array($this, 'setup_script_style') );
		add_action( 'admin_head', array($this, 'add_to_admin_head') );
		add_filter( 'plugin_row_meta', array($this, 'plugin_row_meta'),10,2 );
		add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );
	}

	// reg theme supports
	public function get_theme_supports() {
		global $qqworld_fw_features;
		$theme_supports = array();
		if ( count($qqworld_fw_features)>0 ) foreach ( $qqworld_fw_features as $feature => $theme_support ) $theme_supports[$feature] = $theme_support;
		return apply_filters('qqworld_fw_theme_support', $theme_supports);
	}
	public function add_theme_supports() {
		if ( count($this->get_theme_supports()) ) foreach ($this->get_theme_supports() as $feature => $args) {
			if ($args == Null) add_theme_support( $feature );
			else add_theme_support( $feature, $args );
		}
	}

	//add link to plugin row meta
	function plugin_row_meta($links, $file) {
		$base = plugin_basename(__FILE__);
		if ($file == $base) {
			$links[] = '<a href="' . menu_page_url( 'qqworld-framework', 0 ) . '">' . __('Settings') . '</a>';
		}
		return $links;
	}
	//add link to plugin action links
	function plugin_action_links( $links, $file ) {
		if ( plugin_basename( __FILE__ ) === $file ) {
			$settings_link = '<a href="' . menu_page_url( 'qqworld-framework', 0 ) . '">' . __( 'Settings' ) . '</a>';
			array_unshift( $links, $settings_link ); // before other links
		}
		return $links;
	}

	public function add_settings_error() {
		if ( isset( $_GET['updated'] ) && isset( $_GET['page'] ) ) {
			add_settings_error('qqworld-framework', 'settings_updated', __('Settings saved.'), 'updated');
		}
	}

	public function load_language() {
		load_plugin_textdomain( QQWORLD_FW, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	public function create_menu() {
		$page_title = 'QQWorld Framework';
		$menu_title = __('QQWorld Framework', QQWORLD_FW);
		$capability = 'administrator';
		$menu_slug = 'qqworld-framework';
		$function = array($this, 'fn');
		$icon_url = '';
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);
	}
	public function fn() {
		include_once 'cpanel.php';
	}
	public function setup_script_style() {
		//for 3.5+ uploader
		wp_enqueue_media();

		//for 5.1 wp color picker
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

		// add style.css & color.css.php & googgle font
		wp_register_style('admin_style', QQWORLD_FW_URL.'style/style.css');
		wp_enqueue_style('admin_style');
		wp_register_style('jquery_ui_theme', QQWORLD_FW_URL.'style/themes/cupertino/jquery-ui-1.10.3.custom.min.css');
		wp_enqueue_style('jquery_ui_theme');
		wp_register_script('admin_script', QQWORLD_FW_URL.'js/lib.js', array('jquery', 'jQuery-ui'));
		wp_enqueue_script('admin_script');

		$default_script = array('jQuery-UI', 'QQWorld_Touch', 'chosen');
		$scripts = apply_filters('qqworld_fw_default_javascript', $default_script);
		foreach ( $scripts as $name ) qqworld_resource_javascript::getResource($name);

		// add syntaxHighLighter
		wp_register_script( 'syntaxHighLighter', QQWORLD_FW_URL.'plugins/syntaxHighLighter/scripts/shCore.js');
		wp_enqueue_script( 'syntaxHighLighter' );
		wp_register_script( 'syntaxHighLighter-php', QQWORLD_FW_URL.'plugins/syntaxHighLighter/scripts/shBrushPhp.js', array('syntaxHighLighter'));
		wp_enqueue_script( 'syntaxHighLighter-php' );
		wp_register_style( 'syntaxHighLighter',  QQWORLD_FW_URL.'plugins/syntaxHighLighter/styles/shCore.css');
		wp_enqueue_style( 'syntaxHighLighter' );
		wp_register_style( 'syntaxHighLighter-theme',  QQWORLD_FW_URL.'plugins/syntaxHighLighter/styles/shCoreDefault.css');
		wp_enqueue_style( 'syntaxHighLighter-theme' );

	}
	public function add_to_admin_head() {
	?>
<script type="text/javascript">
SyntaxHighlighter.all();
</script>
	<?php
	}

	public function create_form($args, $value='') {
		$value			= isset($args['value']) ? $args['value'] : $value;
		$class			= isset($args['class']) ? $args['class'] : 'formstyle';
		$id				= isset($args['id']) ? ' id="'. $args['id'] .'"' : '';
		$name			= isset($args['name']) ? $args['name'] : "meta_key[$id]";
		$for			= isset($args['id']) ? ' for="'. $args['id'] .'"' : '';
		$heading		= isset($args['heading']) ? '<label'. $for .'>'. $args['heading'] .'</label>' : '';
		$description	= isset($args['description']) ? '<span class="description">'. $args['description'] .'</span>' : '';
		$type			= isset($args['type']) ? $args['type'] : 'textfield';
		$before			= isset($args['before']) ? $args['before'] : '<aside class="admin_box_unit">';
		$after			= isset($args['after']) ? $args['after'] : '</aside>';
		$field_before	= isset($args['field_before']) ? $args['field_before'] : '';
		$field_after	= isset($args['field_after']) ? $args['field_after'] : '';
		$options		= isset($args['options']) ? $args['options'] : '';
		$size			= isset($args['size']) ? ' '.$args['size'].'-size' : ' medium-size';
		$rel			= isset($args['rel']) ? $args['rel'] : $_GET['post']; //transport post-ID
		$postid			= isset($args['postid']) ? $args['postid'] : 0;
		$placeholder	= isset($args['placeholder']) ? ' data-placeholder="'.$args['placeholder'].'"' : '';

		$val = get_post_meta($postid, $name, true);
		/***************************************************************************/
		$output .= $before;
		$output .= $field_before . $heading . $field_after;
		$blank_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0RjhCOTZEMzM5MkYxMUUzQkU2OUE1MjVENDk5REZBNCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0RjhCOTZENDM5MkYxMUUzQkU2OUE1MjVENDk5REZBNCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjRGOEI5NkQxMzkyRjExRTNCRTY5QTUyNUQ0OTlERkE0IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjRGOEI5NkQyMzkyRjExRTNCRTY5QTUyNUQ0OTlERkE0Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+ZeSCDgAAABBJREFUeNpi+P//PwNAgAEACPwC/tuiTRYAAAAASUVORK5CYII=';
		switch ($type) {
			// textfield
			case 'textfield':
				$output .= $field_before . '<input class="'.$class.$size.'" type="text"'.$id.' name="' . $name. '" value="' . $value. '" />' . $description . $field_after;
				break;
			// Password
			case 'password':
				$output .= $field_before . '<input class="'.$class.$size.'" type="password"'.$id.' name="' . $name. '" value="' . $value. '" />' . $description . $field_after;
				break;
			// Textarea
			case 'textarea':
				$output .= $field_before . '<textarea rows="5" class="'.$class.$size.'" class="textarea"'.$id.' name="' . $name. '">' . $value. '</textarea>' . $description . $field_after;
				break;
			//單選下拉菜單
			case 'select':
				$output .= $field_before . '<select'.$placeholder.' class="selectstyle" '.$id.' name="' . $name. '">';
				foreach ($options as $key => $option) {
					$selected = $option == $value ? ' selected="selected"' : '';
					$key = array_values($options) === $options ? $option : $key; // 如果是纯数字索引，则调用option作为名称
					$output .= '<option value="'. $option .'"'. $selected .'>'. $key .'</option>';
				}
				$output .= '</select>' . $description . $field_after;
				break;
			//多選下拉菜單
			case 'multiple-select':
				$vArray = explode(',', $value);
				$output .= $field_before . '<select class="multiple-selectstyle" class="multiple-select" size="'. $size .'" multiple="multiple" onchange="jQuery(\'#'. $args['id'] .'\').val(jQuery(this).val())">';
				foreach ($options as $key => $option) {
					$selected = in_Array($option, $vArray) ? ' selected="selected"' : '';
					$output .= '<option value="'. $option .'"'. $selected .'>'. $key .'</option>';
				}
				$output .= '</select><input'.$id.' name="' . $name. '" type="hidden" value="'. $value .'" />' . $description . $field_after;
				break;
			//单选按钮
			case 'radio':
				$vArray = explode('|', $value);
				$output .= $field_before . '<div class="wxq_radios">'."\n";
				foreach ($options as $key => $option) {
					$checked = in_array($option, $vArray) ? ' checked' : '';
					$output .= '<div class="wxq_radio'.$checked.'" rel="'.$option.'"><span></span>'.$key.'</div>'."\n";
				}
				$output .= '<input type="hidden"'.$id.' name="'. $name .'" value="'.$value.'"></div>' . $description . $field_after;
				break;
			// checkbox
			case 'checkbox':
				$output .= $field_before . '<div'.$id.'class="wxq_checkboxs">'."\n";
				foreach ($options as $key => $option) {
					$checked = in_array($option, $value) ? ' checked' : '';
					$output .= '<input name="'. $name .'" type="checkbox" value="'.$option.'"'.$checked.' /><div class="wxq_checkbox'.$checked.'" rel="'.$option.'"><span></span>'.$key.'</div>'."\n";
				}
				$output .= '</div>' . $description . $field_after;
				break;
			// Image from media
			case 'image':
				$uimg = empty($value) ? '<img src="'.$blank_img.'" class="upload_images_button" />' : '<img src="'.$value.'" />';
				$title = empty($value) ? __('Add an Image') : __('Upload Images');
				$post_id = empty($rel) ? '' : 'post_id='.$rel.'&amp;';
				$output .= $field_before . '<a class="qqworld_image_uploader" rel="'.$rel.'" href="media-upload.php?'.$post_id.'type=image&amp;TB_iframe=1" title="'.$title.'">'. $uimg .'</a><input type="hidden"'.$id.' name="'. $name .'" value="'. $value .'" />' . $description . $field_after;
				break;
			// Any file from media
			case 'file':
				$uimg = empty($value) ? '<input type="button" class="upload_images_button" value="" />' : '<img src="'.$value.'" width="300" />';
				$post_id = empty($rel) ? '' : ' rel="'.$rel.'"';
				$output .= $field_before . '<input type="text" class="formstyle medium-size" name="'. $name .'" value="'.$value.'"/>
				<input type="button" '.$post_id.'" class="button extendd-browse" value="' . __('Browse') . '" />
				<input type="button" class="button extendd-clear" value="' . __('Clear') . '" />' .  $description . $field_after;
				break;
			//switch
			case 'switch':
				$on = $value === 'true' || $value === '1' ? ' on' : '';
				$output .= $field_before . '<img class="switch_button'.$on.'" src="'.$blank_img.'" /><input type="hidden"'.$id.' name="'. $name.'" value="'.$value.'" />' . $description . $field_after;
				break;
			//Color picker
			case 'color_picker':
				$output .= $field_before . '<input type="input"'.$id.' name="'. $name.'" class="wxq_colors" value="'.$value.'" />' . $description . $field_after;
				break;
			//date & time
			case 'date':
				$output .= $field_before . '<input type="input"'.$id.' name="'. $name.'" class="wxq_datepicker" value="'.$value.'" />' . $description . $field_after;
				break;
			//wp category selector
			case 'category_selector':
				$output .= $field_before . '<select class="selectstyle" class="select"'.$id.' name="' . $name. '">';
				$output .= '<optgroup label="'. __('Categories') .'">';
				$args = array(
					'orderby' => 'term_group',
					'hide_empty' => 0,
					'hierarchical' => 1
				);
				$cates = get_categories($args);
				foreach ($cates as $cate) {
					$prestr = $cate->parent ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '';
					$selected = $cate->cat_ID == $value ? ' selected="selected"' : '';
					$output .= '<option value="'. $cate->cat_ID .'"'.$selected.'>'. $prestr . $cate->name .'</option>';
				}
				$output .= '</optgroup></select>' . $description . $field_after;
				break;
			//wp page selector
			case 'page_selector':
				$output .= $field_before . '<select class="selectstyle" class="select"'.$id.' name="' . $name. '">';
				$output .= '<optgroup label="'. __('Pages') .'">';
				$args = array(
					'hierarchical' => 1,
					'offset' => 0,
				);
				$pages = get_pages($args);
				foreach ($pages as $page) {
					$prestr = $page->post_parent ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '';
					$selected = $page->ID == $value ? ' selected="selected"' : '';
					$output .= '<option value="'. $page->ID .'"'.$selected.'>'. $prestr . $page->post_title .'</option>';
				}
				$output .= '</optgroup></select>' . $description . $field_after;
				break;
		}
		$output .= $after;
		return $output;
	}

	// Format array
	public static function format_array($array) {
		$temp = array();
		foreach ($array as $a) $temp[$a] = $a;
		return $temp;
	}
}
new qqworld_fw;

class qqworld_fw_members extends qqworld_fw {
	public function __construct() {
		$this->sign_up();
		add_action( 'after_setup_theme', array($this, 'init') );
	}
	public function sign_up() {
	}
	public function init() {
	}
}

include_once 'default.php';
?>