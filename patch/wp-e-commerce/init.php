<?php
class qqworld_patch_wp_e_commerce extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('WP e-Commerce', QQWORLD_FW);
		$this->guid = 'wp_e_commerce';
		$this->parent = 'patch';
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
			add_action('qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));

			// wp e-commerce ������������Ҫ�Զ���wpsc-account-purchase-history.phpģ�壬�����ֶ�ָ�� 
			remove_action( 'wpsc_user_profile_section_purchase_history', '_wpsc_action_purchase_history_section' );
			add_action( 'wpsc_user_profile_section_purchase_history', array($this, '_action_purchase_history_section') );

			// wp e-commerce ������������Ҫ�Զ���wpsc-account-edit-profile.phpģ�壬�����ֶ�ָ�� 
			remove_action( 'wpsc_user_profile_section_edit_profile', '_wpsc_action_edit_profile_section' );
			add_action( 'wpsc_user_profile_section_edit_profile', array($this, '_action_edit_profile_section') );

			// wp e-commerce ������������Ҫ�Զ���wpsc-account-downloads.phpģ�壬�����ֶ�ָ�� 
			remove_action( 'wpsc_user_profile_section_downloads', '_wpsc_action_downloads_section' );
			add_action( 'wpsc_user_profile_section_downloads', array($this, '_action_downloads_section') );
		}
	}

	//wpsc��Դ��д���ˣ�ֻ�ܶ�ȡ���Ŀ¼��ģ�壬����Ҫ��д
	function _action_purchase_history_section() {
		include( wpsc_get_template_file_path('wpsc-account-purchase-history.php') );
	}

	//wpsc��Դ��д���ˣ�ֻ�ܶ�ȡ���Ŀ¼��ģ�壬����Ҫ��д
	function _action_edit_profile_section() {
		include( wpsc_get_template_file_path('wpsc-account-edit-profile.php') );
	}

	//wpsc��Դ��д���ˣ�ֻ�ܶ�ȡ���Ŀ¼��ģ�壬����Ҫ��д
	function _action_downloads_section() {
		global $files, $products;

		$items = array();
		if ( wpsc_has_downloads() && ! empty( $files ) ) {
			foreach ( $files as $key => $file ) {
				$item = array();
				if ( $products[$key]['downloads'] > 0 ) {
					$url = add_query_arg(
						'downloadid',
						$products[$key]['uniqueid'],
						home_url()
					);
					$item['title'] = sprintf(
						'<a href="%1$s">%2$s</a>',
						esc_url( $url ),
						esc_html( $file['post_title'] )
					);
				} else {
					$item['title'] = esc_html( $file['post_title'] );
				}

				$item['downloads'] = $products[$key]['downloads'];
				$item['datetime'] = date( get_option( 'date_format' ), strtotime( $products[$key]['datetime'] ) );
				$items[] = (object) $item;
			}
		}
		include( wpsc_get_template_file_path('wpsc-account-downloads.php') );
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<p><?php _ex('WP e-Commerce is so bad, if you wants to customize wpsc-account-purchase-history.php, wpsc-account-edit-profile.php and wpsc-account-downloads.php templates, you must overwrite official actions.', 'patch', QQWORLD_FW); ?></p>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_patch_wp_e_commerce;
?>