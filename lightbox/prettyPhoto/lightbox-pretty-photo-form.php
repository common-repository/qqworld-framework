<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2>Plugin - prettyPhoto Settings</h2>
	<?php if ($_GET['settings-updated']=='true') { ?><div class="updated settings-error" id="setting-error-settings_updated"><p><strong>Settings saved.</strong></p></div><?php }; ?>
	<form action="options.php" method="post">
		<?php settings_fields('register_wxq_prettyPhoto'); ?>
		<h3>Javascript Settings</h3>
		<?php $values = explode('|', get_option(REGION.'prettyPhoto_js_settings', constant(REGION.'prettyPhoto_js_settings'))); ?>
		<div class="tb_unit">
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th scope="col" class="manage-column check-column"></th>
					<th scope="col" class="manage-column">Attribute</th>
					<th scope="col" class="manage-column">Value &amp; Description</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col" class="manage-column check-column"></th>
					<th scope="col" class="manage-column">Attribute</th>
					<th scope="col" class="manage-column">Value &amp; Description</th>
				</tr>
			</tfoot>

			<tbody>
				<tr>
					<th class="check-column"></th><td><strong>animationSpeed</strong></td>
					<td><select name="js_set" id="animationSpeed">
<?php
						$animationSpeed = array('fast', 'normal', 'slow');
						foreach ($animationSpeed as $e) {
							$current = $values[0]==$e?' selected="selected"':"";
?>
							<option value="<?php echo $e; ?>"<?php echo $current;?>><?php echo $e; ?></option>
<?php
						}
?>
						</select> Animation speed</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Slideshow</strong></td>
					<td><input type="text" name="js_set" id="slideshow" value="<?php echo $values[1]; ?>" /> /* false OR interval time in ms</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Autoplay Slideshow</strong></td>
					<td><select name="js_set" id="autoplay_slideshow">
<?php
						$autoplay_slideshow = array('true', 'false');
						foreach ($autoplay_slideshow as $e) {
							$current = $values[2]==$e?' selected="selected"':"";
?>
							<option value="<?php echo $e; ?>"<?php echo $current;?>><?php echo $e; ?></option>
<?php
						}
?>
						</select></td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Opacity</strong></td>
					<td><input type="text" name="js_set" id="opacity" value="<?php echo $values[3]; ?>" /> Background opacity</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Show Title</strong></td>
					<td><select name="js_set" id="showTitle">
<?php
						$showTitle = array('true', 'false');
						foreach ($showTitle as $e) {
							$current = $values[4]==$e?' selected="selected"':"";
?>
							<option value="<?php echo $e; ?>"<?php echo $current;?>><?php echo $e; ?></option>
<?php
						}
?>
						</select> Show title top of the photo</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Allow resize</strong></td>
					<td><select name="js_set" id="allowresize">
<?php
						$allowresize = array('true', 'false');
						foreach ($allowresize as $e) {
							$current = $values[5]==$e?' selected="selected"':"";
?>
							<option value="<?php echo $e; ?>"<?php echo $current;?>><?php echo $e; ?></option>
<?php
						}
?>
						</select> Allow resize the photo if it's too big</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>default_width</strong></td>
					<td><input type="text" name="js_set" id="default_width" value="<?php echo $values[6]; ?>" /> Default width</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>default_height</strong></td>
					<td><input type="text" name="js_set" id="default_height" value="<?php echo $values[7]; ?>" /> Default height</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>counter_separator_label</strong></td>
					<td><input type="text" name="js_set" id="counter_separator_label" value="<?php echo $values[8]; ?>" /> Counter separator label</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>theme</strong></td>
					<td><select name="js_set" id="theme">
<?php
						$theme = array('dark_rounded', 'dark_square', 'facebook', 'light_rounded', 'light_square');
						foreach ($theme as $e) {
							$current = $values[9]==$e?' selected="selected"':"";
?>
							<option value="<?php echo $e; ?>"<?php echo $current;?>><?php echo $e; ?></option>
<?php
						}
?>
						</select></td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>hideflash</strong></td>
					<td><select name="js_set" id="hideflash">
<?php
						$hideflash = array('true', 'false');
						foreach ($hideflash as $e) {
							$current = $values[10]==$e?' selected="selected"':"";
?>
							<option value="<?php echo $e; ?>"<?php echo $current;?>><?php echo $e; ?></option>
<?php
						}
?>
						</select>
</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>wmode</strong></td>
					<td><select name="js_set" id="wmode">
<?php
						$wmode = array('window', 'opaque', 'transparent');
						foreach ($wmode as $n) {
							$current = $values[11]==$n?' selected="selected"':"";
?>
							<option value="<?php echo $n; ?>"<?php echo $current;?>><?php echo $n; ?></option>
<?php
						}
?>
						</select>
</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>autoplay</strong></td>
					<td><select name="js_set" id="autoplay">
<?php
						$autoplay = array('true', 'false');
						foreach ($autoplay as $link) {
							$current = $values[12]==$link?' selected="selected"':"";
?>
							<option value="<?php echo $link; ?>"<?php echo $current;?>><?php echo $link; ?></option>
<?php
						}
?>
						</select>
</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>modal</strong></td>
					<td><select name="js_set" id="modal">
<?php
						$modal = array('true', 'false');
						foreach ($modal as $h) {
							$current = $values[13]==$h?' selected="selected"':"";
?>
							<option value="<?php echo $h; ?>"<?php echo $current;?>><?php echo $h; ?></option>
<?php
						}
?>
						</select>
</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Overlay Gallery</strong></td>
					<td><select name="js_set" id="overlay_gallery">
<?php
						$overlay_gallery = array('true', 'false');
						foreach ($overlay_gallery as $h) {
							$current = $values[14]==$h?' selected="selected"':"";
?>
							<option value="<?php echo $h; ?>"<?php echo $current;?>><?php echo $h; ?></option>
<?php
						}
?>
						</select> If set to true, a gallery will overlay the fullscreen image on mouse over

</td>
				</tr>
				<tr>
					<th class="check-column"></th><td><strong>Keyboard Shortcuts</strong></td>
					<td><select name="js_set" id="keyboard_shortcuts">
<?php
						$keyboard_shortcuts = array('true', 'false');
						foreach ($keyboard_shortcuts as $h) {
							$current = $values[15]==$h?' selected="selected"':"";
?>
							<option value="<?php echo $h; ?>"<?php echo $current;?>><?php echo $h; ?></option>
<?php
						}
?>
						</select> Set to false if you open forms inside prettyPhoto
</td>
				</tr>

			</tbody>
		</table>
		</div>
		<p><input type="button" value="Reset to default" id="reset_value" /></p>
		<script>
		jQuery('#reset_value').mouseup(function(){
			if (window.confirm("Are you sure to reset all values?")) {
				jQuery('#<?php echo REGION;?>prettyPhoto_js_settings').val('<?php echo constant(REGION.'prettyPhoto_js_settings');?>');
				document.forms[0].submit();
			}
		});
		</script>
		<input type="hidden" name="<?php echo REGION; ?>prettyPhoto_js_settings" id="<?php echo REGION; ?>prettyPhoto_js_settings" value="<?php echo get_option(REGION.'prettyPhoto_js_settings', constant(REGION.'prettyPhoto_js_settings')); ?>" />
		<script>
		var sets = new changeToUpdateData();
		sets.obj = document.getElementsByName('js_set');
		sets.target = '<?php echo REGION; ?>prettyPhoto_js_settings';
		sets.init();
		</script>

		<p class="submit"><input type="submit" value="<?php _e('Save Changes') ?>" class="button-primary" name="Submit" /></p>
	</form>