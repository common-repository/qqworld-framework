<?php
define('QQWORLD_FW_PLUGINS_SYNTAXHIGHLIGHTER2_THEME', "Default");

class qqworld_syntaxHighLighter2 extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('syntaxHighLighter 2', QQWORLD_FW);
		$this->guid = 'syntaxHighLighter2';
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
			add_action( 'admin_init', array($this, 'register') );
			add_action( 'wp_head', array($this, 'setup') );
			add_filter( 'qqworld_fw_runtime_editor_buttons', array($this, 'add_button') );
			add_filter( 'qqworld_fw_runtime_shortcodes', array($this, 'add_shortcode') );
		}
	}

	public function register() {
		register_setting('qqworld-framework', 'qqworld_fw_plugins_syntaxHighLighter2_class');
		register_setting('qqworld-framework', 'qqworld_fw_plugins_syntaxHighLighter2_theme');
	}

	//add syntaxHightLighter shortcode
	function add_shortcode($shortcodes) {
		$shortcodes['syntaxHighLighter'] = '<pre class="brush: %brush%">%CONTENT%</pre>';
		return $shortcodes;
	}

	public function add_button($buttons) {
		$buttons['syntaxHighLighter'] = array(
			'text' => array(
				'args' => array( "syntaxHighLighter", __('syntaxHighLighter', QQWORLD_FW) ),
				'callback' => <<<EOF
function(el, canvas) {
	var types = new Array('as3', 'actionscript3', 'bash', 'shell', 'cf', 'coldfusion', 'cpp', 'c', 'c-sharp', 'csharp', 'css', 'delphi', 'pas', 'pascal', 'diff', 'patch', 'erl', 'erlang', 'groovy', 'java', 'jfx', 'javafx', 'js', 'jscript', 'javascript', 'perl', 'pl', 'php', 'plain', 'text', 'ps', 'powershell', 'py', 'python', 'rails', 'ror', 'ruby', 'scala', 'sql', 'vb', 'vbnet', 'xml', 'xhtml', 'xslt', 'html', 'xhtml');
	var type = prompt("请输入脚本的类型('-'之后的代码)\\n----------------------------------------------------------\\nActionScript3 - as3, actionscript3\\nBash/shell - bash, shell\\nColdFusion - cf, coldfusion\\nC++ - cpp, c\\nC# - c-sharp, csharp\\nCSS - css\\nDelphi - delphi, pas, pascal\\nDiff - diff, patch\\nErlang - erl, erlang\\nGroovy - groovy\\nJava - java\\nJavaFX - jfx, javafx\\nJavaScript - js, jscript, javascript\\nPerl - perl, pl\\nPHP - php\\nPlain Text - plain, text\\nPowerShell - ps, powershell\\nPython - py, python\\nRuby - rails, ror, ruby\\nScala - scala\\nSQL - sql\\nVisual Basic - vb, vbnet\\nXML - xml, xhtml, xslt, html, xhtml");
	if ( type && QQWorldFramework.in_array(type, types) ) QTags.insertContent('[syntaxHighLighter brush="'+type+'"]<pre>' + QQWorldFramework.getSelectedText(canvas) + '</pre>[/syntaxHighLighter]');
	else alert('输入的值不能为空或不符合规范');
}
EOF
			),
			"rich" => array(
				'name' => 'syntaxHighLighter',
				'title' => __('syntaxHighLighter', QQWORLD_FW),
				'image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDplZDQzZDRlZS05NzU2LTZjNGYtYjkzNi0yZjQ3NTY3ZGNjZDMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NzlGN0RDQUQyMzFBMTFFM0JCRjQ4ODcxNDJFN0FDRjYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NzlGN0RDQUMyMzFBMTFFM0JCRjQ4ODcxNDJFN0FDRjYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOmVkNDNkNGVlLTk3NTYtNmM0Zi1iOTM2LTJmNDc1NjdkY2NkMyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDplZDQzZDRlZS05NzU2LTZjNGYtYjkzNi0yZjQ3NTY3ZGNjZDMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7mcVPSAAAA/ElEQVR42uyUOwrCQBCGEy9gm4CCWMRnQCUo3iGFXkwrL2GRg2gnCL4foCBeIv4DEwjjrFqkSOHC12Rmv52d3Y0dx7GV5ShYGY/8Cy3qoaGPZeAo3x2OqR5ThT0wAyXDQjPO+anCNjiCM3CVKUWOE603jxD6YAcuoCNEFTABY67uxLm+SRiAFVMTMqpkD24spOGl8gNNGNFCIBQyasGBq2mIWMhzIk1I21iCTWq7VM2dZXUh63LuguaaekjbWIMHGIIRmIKqkFHsybnep0NJ+rUFVz5ROVyumqprfjvltHQOBoqwz7Gmev0+vBTHcA9d7QUlHvv/+8qf8CXAAD1RpwZl8qnpAAAAAElFTkSuQmCC',
				'onclick' => <<<EOF
function() {
	var types = new Array('as3', 'actionscript3', 'bash', 'shell', 'cf', 'coldfusion', 'cpp', 'c', 'c-sharp', 'csharp', 'css', 'delphi', 'pas', 'pascal', 'diff', 'patch', 'erl', 'erlang', 'groovy', 'java', 'jfx', 'javafx', 'js', 'jscript', 'javascript', 'perl', 'pl', 'php', 'plain', 'text', 'ps', 'powershell', 'py', 'python', 'rails', 'ror', 'ruby', 'scala', 'sql', 'vb', 'vbnet', 'xml', 'xhtml', 'xslt', 'html', 'xhtml');
	var type = prompt("请输入脚本的类型('-'之后的代码)\\n----------------------------------------------------------\\nActionScript3 - as3, actionscript3\\nBash/shell - bash, shell\\nColdFusion - cf, coldfusion\\nC++ - cpp, c\\nC# - c-sharp, csharp\\nCSS - css\\nDelphi - delphi, pas, pascal\\nDiff - diff, patch\\nErlang - erl, erlang\\nGroovy - groovy\\nJava - java\\nJavaFX - jfx, javafx\\nJavaScript - js, jscript, javascript\\nPerl - perl, pl\\nPHP - php\\nPlain Text - plain, text\\nPowerShell - ps, powershell\\nPython - py, python\\nRuby - rails, ror, ruby\\nScala - scala\\nSQL - sql\\nVisual Basic - vb, vbnet\\nXML - xml, xhtml, xslt, html, xhtml");
	if ( type && QQWorldFramework.in_array(type, types) ) ed.selection.setContent('[syntaxHighLighter brush="'+type+'"]<pre>' + ed.selection.getContent() + '</pre>[/syntaxHighLighter]');
	else alert('输入的值不能为空或不符合规范');
}
EOF
			)
		);
		return $buttons;
	}

	//add Plugin SyntaxHighLighter
	function setup() {
		if (is_single() || is_page()) :
		$shl2_path = QQWORLD_FW_URL.'/plugins/syntaxHighLighter2/';	
		$classes = get_option('qqworld_fw_plugins_syntaxHighLighter2_class');
	?>
	<script src="<?php echo $shl2_path; ?>scripts/shCore.js"></script>
	<?php
	foreach ($classes as $class):
	?>
	<script src="<?php echo $shl2_path; ?>scripts/shBrush<?php echo $class; ?>.js"></script>
	<?php
	endforeach;
	?>
	<link rel="stylesheet" href="<?php echo $shl2_path; ?>styles/shCore.css"/>
	<link rel="stylesheet" href="<?php echo $shl2_path; ?>styles/shTheme<?php echo get_option('qqworld_fw_plugins_syntaxHighLighter2_theme', QQWORLD_FW_PLUGINS_SYNTAXHIGHLIGHTER2_THEME); ?>.css"/>
	<script>
	SyntaxHighlighter.config.clipboardSwf = '<?php echo $shl2_path; ?>scripts/clipboard.swf';
	SyntaxHighlighter.all();
	</script>
	<style>
	.syntaxhighlighter {
		width: 99% !important;
		z-index: 10;
		box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
	}
	.syntaxhighlighter:hover {
		width: 135% !important;
	}
	</style>
	<?php
		endif;
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<h3><?php _e('Themes');?></h3>
						<p><?php echo sprintf(__("SyntaxHighlighter %s introduced custom CSS themes.<br />This means that by switching out just one CSS file you can completely change the look and feel of the highlighted syntax.<br />A small number of popular color themes are included with SyntaxHighlighter and you can easily make your own.", QQWORLD_FW), "2.0"); ?></p>
						<p><?php
						$field = array(
							'type' => 'select',
							'name' => 'qqworld_fw_plugins_syntaxHighLighter2_theme',
							'id' => 'qqworld_fw_plugins_syntaxHighLighter2_theme',
							'placeholder' => __('Please select theme...', QQWORLD_FW),
							'options' => qqworld_fw::format_array(array('Default', 'Django', 'Eclipse', 'Emacs', 'FadeToGrey', 'Midnight', 'RDark'))
						);
						echo qqworld_fw::create_form($field, get_option('qqworld_fw_plugins_syntaxHighLighter2_theme', QQWORLD_FW_PLUGINS_SYNTAXHIGHLIGHTER2_THEME));
						?></p>
						<h3><?php _e('Brushes', QQWORLD_FW); ?></h3>
						<p><?php _e('SyntaxHighlighter uses separate syntax files called brushes to define its highlighting functionality.', QQWORLD_FW); ?></p>
						<p><?php
						$field = array(
							'type' => 'checkbox',
							'name' => 'qqworld_fw_plugins_syntaxHighLighter2_class[]',
							'id' => 'qqworld_fw_plugins_syntaxHighLighter2_class',
							'options' => array(
								'ActionScript3 - as3, actionscript3' => 'AS3',
								'Bash/shell - bash, shell' => 'Bash',
								'ColdFusion - cf, coldfusion' => 'ColdFusion',
								'C++ - cpp, c' => 'Cpp',
								'C# - c-sharp, csharp' => 'CSharp',
								'CSS - css' => 'Css',
								'Delphi - delphi, pas, pascal' => 'Delphi',
								'Diff - diff, patch' => 'Diff',
								'Erlang - erl, erlang' => 'Erlang',
								'Groovy - groovy' => 'Groovy',
								'Java - java' => 'Java',
								'JavaFX - jfx, javafx' => 'JavaFX',
								'JavaScript - js, jscript, javascript' => 'JScript',
								'Perl - perl, pl' => 'Perl',
								'PHP - php' => 'Php',
								'Plain Text - plain, text' => 'Plain',
								'PowerShell - ps, powershell' => 'PowerShell',
								'Python - py, python' => 'Python',
								'Ruby - rails, ror, ruby' => 'Ruby',
								'Scala - scala' => 'Scala',
								'SQL - sql' => 'Sql',
								'Visual Basic - vb, vbnet' => 'Vb',
								'XML - xml, xhtml, xslt, html, xhtml' => 'Xml'
							)
						);
						$classes = get_option('qqworld_fw_plugins_syntaxHighLighter2_class');
						echo qqworld_fw::create_form($field, $classes);
						?></p>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_syntaxHighLighter2;
?>