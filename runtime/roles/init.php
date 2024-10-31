<?php
class qqworld_roles extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Roles', QQWORLD_FW);
		$this->guid = 'roles';
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
			//ajax for update user role
			add_action( 'wp_ajax_add_user_roles', array($this, 'add_user_roles') );
			add_action( 'wp_ajax_nopriv_add_user_roles', array($this, 'add_user_roles') );
			//ajax for update user role
			add_action( 'wp_ajax_updata_user_roles', array($this, 'updata_user_roles') );
			add_action( 'wp_ajax_nopriv_updata_user_roles', array($this, 'updata_user_roles') );
			//ajax for delete user role
			add_action( 'wp_ajax_delete_user_roles', array($this, 'delete_user_roles') );
			add_action( 'wp_ajax_nopriv_delete_user_roles', array($this, 'delete_user_roles') );
		}
	}

	public function add_user_roles() {
		if ( current_user_can('level_10') ) {
			add_role( $_POST['new_user_role']['role'], $_POST['new_user_role']['display_name'] );
		}
		die();
	}
	public function updata_user_roles() {
		if ( current_user_can('level_10') ) {
			global $wp_roles;
			foreach ($_POST as $role => $caps ) {
				$currentRole = get_role( $role );
				foreach ( $wp_roles->roles['administrator']['capabilities'] as $cap => $bl ) {
					if ( in_array($cap, $caps) ) $currentRole->add_cap($cap);
					else $currentRole->remove_cap($cap);
				}
			}
		}
		die();
	}
	public function delete_user_roles() {
		if ( current_user_can('level_10') ) {
			foreach ($_POST as $roles)
				foreach ($roles as $role)
					remove_role( $role );
		}
		die();
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<h5><?php _e('Add a new user role:', QQWORLD_FW); ?></h5>
						<p><label for="new_user_role"><?php _e('New role code (The alphanumeric and underlined):', QQWORLD_FW); ?></label><br /><input type="text" name="new_user_role[role]" id="new_user_role" /></p>
						<p><label for="new_user_role_display_name"><?php _e('Display Name:', QQWORLD_FW); ?></label><br /><input type="text" name="new_user_role[display_name]" id="new_user_role_display_name" /></p>
						<p><?php submit_button(__('Add'), 'primary button', 'add_user_roles', false); ?></p>
						<?php if (count($wp_roles->roles) > 5): ?>
						<h5><?php echo sprintf(__('Have enabled the %s: ', QQWORLD_FW), $this->name ); ?></h5>
						<?php
						global $wp_roles;
						$default_roles = array('super_admin', 'administrator', 'editor', 'author', 'contributor', 'subscriber');
						?>
						<table class="QQWorld_admin_table widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col" class="manage-column check-column"></th>
									<th width="100" scope="col" class="manage-column"><?php _e('Roles', QQWORLD_FW); ?></th>
									<th scope="col" class="manage-column"><?php _e('Capabilities', QQWORLD_FW); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th scope="col" class="manage-column check-column"></th>
									<th scope="col" class="manage-column"><?php _e('Roles', QQWORLD_FW); ?></th>
									<th scope="col" class="manage-column"><?php _e('Capabilities', QQWORLD_FW); ?></th>
								</tr>
							</tfoot>

							<tbody>
							<?php
							foreach ( $wp_roles->roles as $role => $object) :
								if ( !in_array($role, $default_roles) )	:
							?>
								<tr>
									<td><input type="checkbox" value="<?php echo $role; ?>" id="<?php echo $role; ?>" name="delete_role[]" /></td>
									<td><label for="<?php echo $role; ?>"><?php echo in_array($role, $default_roles) ? _x( $wp_roles->role_names[$role], 'User role' ) : __( $wp_roles->role_names[$role], $this->get_roles()[$role]['textdomain'] ); ?></label></td>
									<td><?php
									$capabilities = array();
									foreach ( $wp_roles->roles['administrator']['capabilities'] as $name => $bl ) $capabilities[$name] = $name;
									$field = array(
										'type' => 'checkbox',
										'name' => $role.'_capabilities[]',
										'id' => $role.'_capabilities',
										'options' => $capabilities
									);
									$capabilities = array();
									foreach ( $object['capabilities'] as $name => $bl ) $capabilities[] = $name;
									echo qqworld_fw::create_form($field, $capabilities);
									?></td>
								</tr>
							<?php
								endif;
							endforeach;
							?>
							</tbody>
						</table>
						<p class="submit"><?php submit_button(__('Update capabilities of user roles', QQWORLD_FW), 'primary button', 'update_roles', false); ?> <?php submit_button(__('Delete user roles', QQWORLD_FW), 'button', 'delete_roles', false); ?></p>
						<script>
						jQuery('#add_user_roles').on('click', function() {
							var json = jQuery("#qqworld_fw_form").serializeArray();
							var re = /new_user_role\[/;
							var data = new Array();
							for (var d in json) {
								if ( re.test(json[d]['name']) ) {
									if (json[d]['value']=='') return false;
									data.push(json[d]['name']+'='+json[d]['value']);
								}
							}
							jQuery.post("<?php echo admin_url( 'admin-ajax.php?action=add_user_roles', 'relative' ); ?>", data.join('&'), function(data) {
								window.location.reload();
							});
							return false;
						});
						jQuery('#update_roles').on('click', function() {
							var json = jQuery("#qqworld_fw_form").serializeArray();
							var re = /_capabilities\[\]/;
							var data = new Array();
							for (var d in json) {
								if ( re.test(json[d]['name']) ) {
									var name = json[d]['name'].replace(re, '');
									data.push(name+'[]='+json[d]['value']);
								}
							}
							if (!data.length) return false;
							jQuery.post("<?php echo admin_url( 'admin-ajax.php?action=updata_user_roles', 'relative' ); ?>", data.join('&'), function(data) {
								window.location.reload();
							});
							return false;
						});
						jQuery('#delete_roles').on('click', function() {
							var json = jQuery("#qqworld_fw_form").serializeArray();
							var re = /delete_role\[\]/;
							var data = new Array();
							for(var d in json){
								if ( re.test(json[d]['name']) ) {
									data.push(json[d]['name']+'='+json[d]['value']);
								}							
							}
							if (!data.length) return false;
							jQuery.post("<?php echo admin_url( 'admin-ajax.php?action=delete_user_roles', 'relative' ); ?>", data.join('&'), function(data) {
								window.location.reload();
							});
							return false;
						});
						</script>
						<?php else: ?>
						<p><?php _e('No custom user roles in this website.', QQWORLD_FW); ?></p>
						<?php endif; ?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_roles;
?>