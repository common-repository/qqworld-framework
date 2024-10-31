<?php
class qqworld_runtime_posttype extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Post Type', QQWORLD_FW);
		$this->guid = 'posttype';
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
			add_action( 'init', array($this, 'create') );
			add_filter( 'post_updated_messages', array($this, 'make_messages') );
		}
	}

	public function define_custom_posttypes() {
		$custom_posttypes = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $posttype ) $custom_posttypes[] = $posttype;
		return apply_filters( 'qqworld_fw_define_custom_posttypes', $custom_posttypes );
	}

	//Create custom post types
	function create() {
		foreach ($this->define_custom_posttypes() as $type) {
			$post_type = $type['post_type'];
			$singular_name = $type['singular_name'];
			$plural_name = $type['plural_name'];
			$menu_name = isset($type['menu_name']) ? $type['menu_name'] : $singular_name;
			$args = $type['args'];
			$labels = array(
				'name' => $plural_name,
				'singular_name' => $singular_name,
				'menu_name' => $menu_name,
				'all_items' => sprintf( __('All %s', QQWORLD_FW), $singular_name ),
				'add_new' => sprintf( __('Add New %s', QQWORLD_FW), $singular_name ),
				'add_new_item' => sprintf( __('Add New %s', QQWORLD_FW), $singular_name ),
				'edit_item' => sprintf( __('Edit %s', QQWORLD_FW), $singular_name ),		
				'new_item' => sprintf( __('New %s', QQWORLD_FW), $singular_name ),
				'view_item' => sprintf( __('View %s', QQWORLD_FW), $singular_name ),
				'search_items' => sprintf( __('Search %s', QQWORLD_FW), $singular_name ),
				'not_found' => sprintf( __('No %s found', QQWORLD_FW), $singular_name ),
				'not_found_in_trash' => sprintf( __('No %s found in Trash', QQWORLD_FW), $singular_name )
			);			
			if ( isset($type['parent_item_colon']) ) $labels['parent_item_colon'] = $type['parent_item_colon'];
			$args['label'] = $plural_name;
			$args['labels'] = $labels;
			register_post_type($post_type, $args);
		}
	}

	//Make messages for custom post types
	function make_messages( $messages ) {
		global $post, $post_ID;
		$post_type = get_post_type( $post_ID );

		$obj = get_post_type_object($post_type);
		$singular_name = $obj->labels->singular_name;
		$messages[$post_type] = array(
			0 => '', 
			1 => sprintf(__('%s updated. <a href="%s">View %s</a>', QQWORLD_FW), $singular_name, esc_url(get_permalink($post_ID)), $singular_name ),
			2 => __('Custom field updated.', QQWORLD_FW),
			3 => __('Custom field deleted.', QQWORLD_FW),
			4 => sprintf(__('%s updated.', QQWORLD_FW), $singular_name),
			5 => isset($_GET['revision']) ? sprintf('%s restored to revision from %s', $singular_name, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf(__('%s published. <a href="%s">View %s</a>', QQWORLD_FW), $singular_name, esc_url(get_permalink($post_ID)), $singular_name ),
			7 => sprintf(__('%s saved.', QQWORLD_FW), $singular_name),
			8 => sprintf(__('%s submitted. <a href="%s">Preview %s</a>', QQWORLD_FW), $singular_name, esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))), $singular_name ),
			9 => sprintf( '%s scheduled for: <strong>$s</strong>. <a target="_blank" href="$s">Preview %s</a>', $singular_name, date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID)), $singular_name ),
			10 => sprintf(__('%s draft updated. <a href="%s">Preview %s</a>', QQWORLD_FW), $singular_name, esc_url(get_permalink($post_ID)), $singular_name ),
		); 		
		return $messages;
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php echo sprintf(__('Have enabled the %s: ', QQWORLD_FW), $this->name ); ?></p>
						<?php
						$posttypes = array();
						foreach ( $this->define_custom_posttypes() as $posttype ) $posttypes[]=$posttype['plural_name'];
						echo implode(", ", $posttypes);
						?>
					</div>
				</fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_posttype;
?>