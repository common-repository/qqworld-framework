<?php
class qqworld_metabox extends qqworld_fw_members {
	protected $_fields = [];

	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Meta Box', QQWORLD_FW);
		$this->guid = 'metabox';
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
			//call add_meta_boxs
			add_action( 'add_meta_boxes', array($this, 'add_meta_box') );
			add_action( 'save_post', array($this, 'save_post') );
		}
	}

	public function define_meta_box() {
		$custom_meta_box = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $meta_box ) $custom_meta_box[] = $meta_box;
		return apply_filters( 'qqworld_fw_define_meta_box', $custom_meta_box );
	}

    //Adds the meta box container
    public function add_meta_box() {
		foreach ($this->define_meta_box() as $args) {
			$id = $args['id'];
			$title = $args['title'];
			$callback = isset($args['callback']) ? $args['callback'] : array( $this, 'render_meta_box_content' );
			$context = isset($args['context']) ? $args['context'] : 'advanced';
			$priority = isset($args['priority']) ? $args['priority'] : 'default';
			$callback_args = isset($args['callback_args']) ? $args['callback_args'] : null;
			$this->_fields[$id] = isset($args['fields']) ? $args['fields'] : '';
			if ( is_array($args['post_type']) ) {
				foreach ( $args['post_type'] as $post_type) {
					add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );
				}
			} else {
					add_meta_box( $id, $title, $callback, $args['post_type'], $context, $priority, $callback_args );
			}
		}
    }

    //Render Meta Box content
    public function render_meta_box_content($post, $id) {
		wp_nonce_field( $post->post_type . '_qqworld_meta_box', $post->post_type . '_qqworld_meta_box_nonce' );
?>
		<table id="<?php echo $id['id']; ?>" class="qqworld_meta_box">
			<thead>
				<tr>
					<th class="meta_box_title"><?php echo _x('Name', 'meta name');?></th>
					<th class="meta_box_title"><?php _e('Value');?></th>
				</tr>
			</thead>
			<tbody>
<?php

		if ($this->_fields[$id['id']]) foreach ($this->_fields[$id['id']] as $fields) {
			$value = get_post_meta($post->ID, $fields['id'], true);
			echo '<tr>'.qqworld_fw::create_form($fields, $value).'</tr>';
		}
?>
			</tbody>
		</table>
<?php
    }

	//Sava Meta Box
	public function save_post() {
		$post_id = $_POST['post_ID'];

		// Check if our nonce is set.
		if ( ! isset( $_POST[$_POST['post_type'] . '_qqworld_meta_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST[$_POST['post_type'] . '_qqworld_meta_box_nonce'];
		if ( !wp_verify_nonce($nonce , $_POST['post_type'] . '_qqworld_meta_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;	
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
		foreach ($_POST['meta_key'] as $id => $field) {
			// Sanitize the user input.
			$mydata = is_array($field) ? array_filter($field) : sanitize_text_field( $field );
			// Update the meta field.
			update_post_meta( $post_id, $id, $mydata );
		}
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php echo sprintf(__('Have enabled the %s: ', QQWORLD_FW), $this->name ) ?></p>
						<ul>
						<?php
						foreach ( $this->define_meta_box() as $metabox ) :
						?>
							<li>
								<p><?php echo sprintf(_x('The post meta for %s:', 'metabox', QQWORLD_FW), $metabox['post_type'][0] ) ?></p>
								<ol>
								<?php if ($metabox['fields']) :
									foreach ( $metabox['fields'] as $fields ) : ?>
								<li><?php echo $fields['heading'] ? $fields['heading'] : $fields['id']; ?></li>
								<?php
									endforeach;
								elseif ($metabox['callback']) : ?>
								<li><?php echo $metabox['callback']; ?></li>
								<?php endif; ?>
								</ol>
							</li>
						<?php
						endforeach;
						?>
						</ol>
					</div>
				</fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_metabox;
?>