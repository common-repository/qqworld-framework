	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2><?php _e('QQWorld Framework', QQWORLD_FW)?></h2>
		<?php settings_errors(); ?>
		<p><?php _e('For commercial website design and production.', QQWORLD_FW); ?></p>
		<form id="qqworld_fw_form" method="post" action="options.php">
			<?php settings_fields('qqworld-framework'); ?>
			<ul class="QQWorld_tabs">
			<?php
			global $qqworld_fws;
			foreach ($qqworld_fws as $key => $fw) :
			?>
				<li class="<?php echo $fw['guid']; ?>"><a href="#<?php echo $fw['guid']; ?>"><?php echo $fw['name']; ?></a></li>
			<?php endforeach; ?>
			</ul>
			<?php
			foreach ($qqworld_fws as $key => $fw) : ?>
			<div class="tb_unit">
			<table class="QQWorld_admin_table widefat">
				<tbody>
					<?php do_action('qqworld-fw-'.$fw['guid']); ?>
				</tbody>
			</table>
			</div>
			<?php endforeach; ?>
			<div class="clearfloat"></div>
			<?php submit_button(); ?>
		</form>
	</div>