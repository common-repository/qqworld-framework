<?php
add_action('qqworld_lightbox_list', 'the_lightBox_prettyPhoto_menu');
function the_lightBox_prettyPhoto_menu() {
	$is_active = get_option(REGION.'current_lightBox', constant(REGION.'current_lightBox'))=='prettyPhoto';
?>	
	<tr class="<?php echo $is_active?'active':'inactive';?>">
		<th scope='row' class='check-column'><input type="radio" name="<?php echo REGION; ?>current_lightBox" id="prettyPhoto" value="prettyPhoto"<?php if ($is_active) echo ' checked="checked"'; ?> /></th>
		<td scope="row"><label for="prettyPhoto"><strong>PrettyPhoto</strong><br />prettyPhoto is a jQuery lightbox clone. Not only does it support images, it also support for videos, flash, YouTube, iframes and ajax. It’s a full blown media lightbox. It is very easy to setup, yet very flexible if you want to customize it a bit. Plus the script is compatible in every major browser, even IE6. It also comes with useful APIs so prettyPhoto can be launched from nearly anywhere (yes, that includes Flash)!”<br />Read more about jQuery lightbox for images, videos, YouTube, iframes, ajax.</label><p>Version 3.1.4 | By <a href="http://github.com/scaron/prettyphoto/" title="Visit author homepage">Stephane Caron</a> | <a href="http://plugins.jquery.com/project/jquery-lightbox-clone-prettyPhoto" title="Visit plugin site">Visit plugin site</a></p></td>
		<td><label for="prettyPhoto"><img src="<?php echo LIGHTBOXURL;?>prettyPhoto/preview.png" /></label></td>
	</tr>
<?php
}
//default value
define(REGION.'prettyPhoto_js_settings', serialize(array(
	'animationSpeed' => 'normal',
	'slideshow' => 'false',
	'autoplay_slideshow' => 'false',
	'opacity' => '0.80',
	'showTitle' => 'true',
	'allowresize' => 'true',
	'default_width' => '500',
	'default_height' => '344',
	'counter_separator_label' => '/',
	'theme' => 'facebook',
	'hideflash' => 'false',
	'wmode' => 'opaque',
	'autoplay' => 'true',
	'modal' => 'false',
	'overlay_gallery' => 'true',
	'keyboard_shortcuts' => 'true',
	'social_tools' => 'false',)
));

if (get_option(REGION.'current_lightBox', constant(REGION.'current_lightBox'))=='prettyPhoto') array_push($lightBox_menu['submenu'], array('prettyPhoto Settings', 'prettyPhoto', 'wxq-pretty-photo', 'wxq_lightBox_prettyPhoto'));

function wxq_lightBox_prettyPhoto_html() {
	include_once LIGHTBOXDIR . 'prettyPhoto/lightbox-pretty-photo-form.php';	
}

//register settings
function register_wxq_lightBox_prettyPhoto() {
	register_setting('register_wxq_prettyPhoto', REGION.'prettyPhoto_js_settings');
}

//add Plugin prettyPhoto
function add_prettyphoto_to_head() {
?>
<link rel="stylesheet" href="<?php echo LIGHTBOXURL;?>prettyPhoto/css/prettyPhoto.css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo LIGHTBOXURL;?>prettyPhoto/js/jquery.prettyPhoto.js"></script>
<?php
}
function add_prettyphoto_to_footer() {
	$wxq_prettyPhoto_js_settings = is_array(get_option(REGION.'prettyPhoto_js_settings', constant(REGION.'prettyPhoto_js_settings'))) ? get_option(REGION.'prettyPhoto_js_settings', constant(REGION.'prettyPhoto_js_settings')) : unserialize(get_option(REGION.'prettyPhoto_js_settings', constant(REGION.'prettyPhoto_js_settings')));
?>
<script>
function lightBoxInit() {
	jQuery("a[rel^='lightBox']").prettyPhoto({
		animationSpeed: "<?php echo $wxq_prettyPhoto_js_settings['animationSpeed']; ?>",
		slideshow: <?php echo $wxq_prettyPhoto_js_settings['slideshow']; ?>,
		autoplay_slideshow: <?php echo $wxq_prettyPhoto_js_settings['autoplay_slideshow']; ?>,
		opacity: <?php echo $wxq_prettyPhoto_js_settings['opacity']; ?>,
		showTitle: <?php echo $wxq_prettyPhoto_js_settings['showTitle']; ?>,
		allowresize: <?php echo $wxq_prettyPhoto_js_settings['allowresize']; ?>,
		default_width: "<?php echo $wxq_prettyPhoto_js_settings['default_width']; ?>",
		default_height: "<?php echo $wxq_prettyPhoto_js_settings['default_height']; ?>",
		counter_separator_label: "<?php echo $wxq_prettyPhoto_js_settings['counter_separator_label']; ?>",
		theme: "<?php echo $wxq_prettyPhoto_js_settings['theme']; ?>",
		hideflash: "<?php echo $wxq_prettyPhoto_js_settings['hideflash']; ?>",
		wmode: "<?php echo $wxq_prettyPhoto_js_settings['wmode']; ?>",
		autoplay: <?php echo $wxq_prettyPhoto_js_settings['autoplay']; ?>,
		modal: <?php echo $wxq_prettyPhoto_js_settings['modal']; ?>,
		overlay_gallery: <?php echo $wxq_prettyPhoto_js_settings['overlay_gallery']; ?>,
		keyboard_shortcuts: <?php echo $wxq_prettyPhoto_js_settings['keyboard_shortcuts']; ?>,
		social_tools: <?php echo $wxq_prettyPhoto_js_settings['social_tools']; ?>
	});
}
lightBoxInit();
</script>
<?php
}
function qqworld_prettyPhoto_selector($selector) {
	return 'lightBox[pic]';
}
if (get_option(REGION.'current_lightBox', constant(REGION.'current_lightBox'))=='prettyPhoto') {
	if (!is_admin()) {
		add_action('wp_head', 'add_prettyphoto_to_head');
		add_action('wp_footer', 'add_prettyphoto_to_footer');
		add_filter('qqworld_lightbox_selector', 'qqworld_prettyPhoto_selector');
	}
}
?>