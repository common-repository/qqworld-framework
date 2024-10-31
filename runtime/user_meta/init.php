<?php
class qqworld_runtime_user_meta extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('User Meta', QQWORLD_FW);
		$this->guid = 'user_meta';
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
			add_filter( 'user_contactmethods', array($this, 'user_contactmethods') );
		}
	}

	public function user_contactmethods($user_contactmethods) {
		$usermeta = get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0];
		if ( count( $usermeta )>0 ) {
			if ( count( $usermeta['unset_user_contactmethods'] )>0 ) {
				foreach ( $usermeta['unset_user_contactmethods'] as $key) unset($user_contactmethods[$key]);
			}
			if ( count( $usermeta['add_user_contactmethods'] )>0 ) {
				foreach ( $usermeta['add_user_contactmethods'] as $key => $title ) $user_contactmethods[$key] = $title;
			}
		}
		return $user_contactmethods;
	}

	/*public function register_widgets() {
		foreach ( $this->get_widgets() as $widget) register_widget( $widget );
	}

	public function get_widgets() {
		$widgets = array();
		if ( count( get_theme_support('qqworld_fw_runtime_widgets')[0] )>0 ) foreach ( get_theme_support('qqworld_fw_runtime_widgets')[0] as $widget) $widgets[] = $widget;
		return apply_filters( 'qqworld_fw_runtime_widgets', $widgets );
	}*/

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
					<?php
					$usermeta = get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0];
					if ( count( $usermeta )>0 ) :
						if ( count( $usermeta['unset_user_contactmethods'] )>0 ) :
							$unset = array();
							foreach ( $usermeta['unset_user_contactmethods'] as $key) array_push($unset, $key);
					?>
						<p><?php _ex('Disabled user contact information: ', 'User Meta', QQWORLD_FW); echo implode(", ", $unset); ?></p>
					<?php
						endif;
						if ( count( $usermeta['add_user_contactmethods'] )>0 ) :
							$add = array();
							foreach ( $usermeta['add_user_contactmethods'] as $key => $title ) array_push($add, $key);
					?>
						<p><?php _ex('Added user contact information: ', 'User Meta', QQWORLD_FW); echo implode(", ", $add); ?></p>
					<?php
						endif;
					endif;
					?>
						<?php
						$current_user = wp_get_current_user();
						echo '<pre>';
						//print_r($current_user);
						echo '</pre>';
						$user_id = 1;
						//the_author_meta('qq', $user_id);
$key = '_level_of_awesomeness';
$awesome_level = 1000;
$single = false;
//add_user_meta( $user_id, $key, $awesome_level, true);
//print_r(get_user_meta( $user_id, $key, $single));
						?>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_user_meta;
?>