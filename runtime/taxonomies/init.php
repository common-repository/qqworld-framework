<?php
class qqworld_runtime_taxonomies extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Taxonomies', QQWORLD_FW);
		$this->guid = 'taxonomies';
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
			add_action( 'init', array($this, 'build_taxonomies'), 0 );
		}
	}

	public function define_custom_taxonomies() {
		$custom_taxonomies = array();
		if ( count( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] )>0 ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $taxonomy ) $custom_taxonomies[] = $taxonomy;
		return apply_filters( 'qqworld_fw_define_custom_taxonomies', $custom_taxonomies );
	}

	//Build texonomies for custom post types
	function build_taxonomies() {
		foreach ($this->define_custom_taxonomies() as $taxonomy) {
			$tax = $taxonomy['taxonomy'];
			$singular_name = $taxonomy['singular_name'];
			$plural_name = $taxonomy['plural_name'];
			$args = $taxonomy['args'];
			$labels = array(
				'name' => $plural_name,
				'singular_name' => $singular_name,
				'menu_name' => $singular_name,
				'all_items' => sprintf(__( 'All %s', QQWORLD_FW ), $singular_name ),
				'edit_item' => sprintf(__( 'Edit %s', QQWORLD_FW ), $singular_name ),
				'view_item' => sprintf(__( 'View %s', QQWORLD_FW ), $singular_name ),
				'update_item' => sprintf(__( 'Update %s', QQWORLD_FW ), $singular_name ),
				'add_new_item' => sprintf(__( 'Add New %s', QQWORLD_FW ), $singular_name ),
				'new_item_name' => sprintf(__( 'New %s Name', QQWORLD_FW ), $singular_name ),
				'parent_item' => sprintf(__( 'Parent %s', QQWORLD_FW ), $singular_name ),
				'parent_item_colon' => sprintf(__( 'Parent %s', QQWORLD_FW ), $singular_name ),
				'search_items' => sprintf(__('Search %s', QQWORLD_FW), $singular_name ),
				'popular_items' => $plural_name,
				'separate_items_with_commas' => sprintf(__('Separate %s with commas', QQWORLD_FW), $singular_name ),
				'add_or_remove_items' => sprintf(__('Add or remove %s', QQWORLD_FW), $singular_name ),
				'choose_from_most_used' => sprintf(__('Choose from the most used %s', QQWORLD_FW), $singular_name ),
				'not_found' => sprintf(__('No %s found.', QQWORLD_FW), $singular_name, $types )				
			);
			$args['label'] = $plural_name;
			$args['labels'] = $labels;
			register_taxonomy( $tax, Null, $args );
		}
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
						foreach ( $this->define_custom_taxonomies() as $posttype ) $posttypes[]=$posttype['plural_name'];
						echo implode(", ", $posttypes);
						?>
					</div>
				</fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_taxonomies;
?>