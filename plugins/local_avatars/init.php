<?php
class qqworld_local_avatars extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Local Avatars', QQWORLD_FW);
		$this->guid = 'local_avatars';
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
			add_action('load-profile.php', array($this, 'load_profile_php'));
			add_action('show_user_profile', array($this, 'show_user_profile'));
			add_filter('get_avatar', array($this, 'get_avatar'), 1, 5);
		}
	}

	function str_replace_once($needle, $replace, $haystack) {
		$pos = strpos($haystack, $needle);
		if($pos === false) {
			return $haystack;
		}
		return substr_replace($haystack, $replace, $pos, strlen($needle));
	}

	public function avatar_dir() {
		$siteurl = get_option('siteurl');
		$uploads['path'] = WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'avatar';
		$uploads['url'] = content_url().'/avatar';
		$uploads['subdir'] = '';
		$uploads['basedir'] = $uploads['path'];
		$uploads['baseurl'] = $uploads['url'];
		$uploads['error'] = false;
		return $uploads;
	}

	public function load_profile_php() {
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_FILES['avatar']['name'] && check_admin_referer('avatar-upload', '_wpnonce-avatar-upload')) {
			add_filter('upload_dir', array(__CLASS__, 'avatar_dir'));
			$user_id = (int)$_POST['user_id'];
			$overrides = array('test_form' => false);
			$uploaded_file = $_FILES['avatar'];
			$wp_filetype = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'], false );
			$path_parts = pathinfo($uploaded_file['name']);
			$uploaded_file['name'] = $user_id.'_avatar.'.$path_parts['extension'];
			if ( ! wp_match_mime_types( 'image', $wp_filetype['type'] ) )
				wp_die( __( 'The uploaded file is not a valid image. Please try again.' ) );
	
			$file = wp_handle_upload($uploaded_file, $overrides);
			if ( isset($file['error']) )
				wp_die( $file['error'],  __( 'Image Upload Error' ) );

			$avatar_dir = self::avatar_dir();
			@unlink(str_replace(content_url(), WP_CONTENT_DIR, get_user_meta($user_id, 'avatar', true)));
			$image = wp_get_image_editor($file['file']);
			$image->resize(96, 96);
			$image->save($file['file']);
			update_user_meta($user_id, 'avatar', $file['url']);
		}
		ob_start();
	}

	public function show_user_profile($user) {
		$html = ob_get_clean();
		$html = str_replace('<form id="your-profile"', '<form id="your-profile" enctype="multipart/form-data"', $html);
		ob_start();
		?>
		<tr>
			<th scope="row"><?php _e('Avatars'); ?></th>
			<td valign="middle">
				<?php echo get_avatar($user->ID); ?><br />
				<label for="upload"><?php _e( 'Choose an image from your computer:' ); ?></label><br />
				<input type="file" id="upload" name="avatar" />
				<?php wp_nonce_field('avatar-upload', '_wpnonce-avatar-upload'); ?>
			</td>
		</tr>
		<?php
		$avatar = ob_get_clean();
		$html = self::str_replace_once('<tr', $avatar.'<tr', $html);
		echo $html;
	}

	public function get_avatar($avatar, $id_or_email, $size, $default, $alt) {
		if(!is_numeric($id_or_email)) {
			return $avatar;
		}
		$avatar_img = get_user_meta($id_or_email, 'avatar', true);
		return $avatar_img?'<img alt="'.$alt.'" src="'.$avatar_img.'" class="avatar avatar-'.$size.' photo" height="'.$size.'" width="'.$size.'">':$avatar;
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php _e('Allows users upload local avatar to website.', QQWORLD_FW); ?></p>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_local_avatars;
?>