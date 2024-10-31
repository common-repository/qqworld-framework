<?php
class qqworld_menus_menu extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Primary Menu', QQWORLD_FW);
		$this->guid = 'primary_menu';
		$this->parent = 'menus';
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
			add_action( 'qqworld_fw_menus_primary_menu', array($this, 'primary_menu') );
		}
	}

	public function primary_menu() {
		wp_nav_menu( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] );
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php _e('For example:', QQWORLD_FW); ?></p>
						<pre class="brush: php">do_action( 'qqworld_fw_menus_primary_menu' );</pre>
						<table class="QQWorld_admin_table widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col" class="manage-column check-column"></th>
									<th scope="col" class="manage-column"><?php _e('Attribute', QQWORLD_FW); ?></th>
									<th scope="col" class="manage-column"><?php _e('Value &amp; Description', QQWORLD_FW); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th scope="col" class="manage-column check-column"></th>
									<th scope="col" class="manage-column"><?php _e('Attribute', QQWORLD_FW); ?></th>
									<th scope="col" class="manage-column"><?php _e('Value &amp; Description', QQWORLD_FW); ?></th>
								</tr>
							</tfoot>

							<tbody>
							<?php
							if ( count(get_theme_support('qqworld_fw_menus_primary_menu')[0]) ) foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $arg => $value ) {
								$value = is_object($value) ? 'new '.get_class($value) : $value;
								echo "<tr><td></td><td>$arg</td><td>$value</td></tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_menus_menu;

//Walker for wp_nav_menu()
class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=Array(), $id=0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$prepend = '<strong>';
		$append = '</strong>';
		$description  = ! empty( $item->attr_title ) ? '<span>'.esc_attr( $item->attr_title ).'</span>' : '';

		if($depth != 0) {
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

//Walker for wp_nav_menu()
class no_container_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=Array(), $id=0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	}
}
?>