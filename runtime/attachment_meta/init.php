<?php
class qqworld_attachment_meta extends qqworld_fw_members {
	protected $_fields = [];

	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Attachment Meta', QQWORLD_FW);
		$this->guid = 'attachment_meta';
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
			add_action('qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel'));
			if (!is_admin()) return;
			add_filter( 'attachment_fields_to_edit', array($this, 'add_attachment_fields'), 10, 2 );
			//add_action( 'edit_attachment', array($this, 'save_attachment_fields') );
			add_filter( 'attachment_fields_to_save', array($this, 'save_attachment_fields'), null, 2 );
		}
	}

	public function define_attachment_meta() {
		$form_fields = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $attachment_meta ) $form_fields[] = $attachment_meta;
		return apply_filters( 'qqworld_fw_define_attachment_meta', $form_fields );
	}

    //Adds the Attachment Meta container
    public function add_attachment_fields($form_fields, $post) {
		foreach ($this->define_attachment_meta() as $key => $meta) {
			$field_value = get_post_meta( $post->ID, $key, true );
			$form_fields[$key] = $meta;
			$form_fields[$key]['value'] = $field_value ? $field_value : '';
		}
		return $form_fields;
    }

	//Sava Attachment Meta using for 'edit_attachment'
	/*
	public function save_attachment_fields($attachment_id) {
		foreach ( $this->define_attachment_meta() as $key => $meta ) {
			if ( isset( $_REQUEST['attachments'][$attachment_id][$key] ) ) {
				$website = $_REQUEST['attachments'][$attachment_id][$key];
				update_post_meta( $attachment_id, $key, $website );
			}
		}
	}
	*/
	public function save_attachment_fields($post, $attachment_data) {
		foreach ( $this->define_attachment_meta() as $key => $meta ) {
			if ( isset( $attachment_data[$key] ) && ! empty( $attachment_data[$key] ) )
				update_post_meta( $post['ID'], $key, sanitize_text_field( $attachment_data[$key] ) );
		}
		return $post;
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p>
							<?php echo sprintf(__('Have enabled the %s: ', QQWORLD_FW), $this->name ) ?>: 
							<?php foreach ( $this->define_attachment_meta() as $key => $meta ) : ?>
								<?php echo $key; ?>
							<?php endforeach; ?>
						</p>
					</div>
				</fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_attachment_meta;
?>