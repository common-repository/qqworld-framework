<?php
class qqworld_runtime_breadcrumb extends qqworld_fw_members {
	var $pageBreadcrumb = "";
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Breadcrumb', QQWORLD_FW);
		$this->guid = 'breadcrumb';
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
			add_action( 'qqworld_runtime_breadcrumb', array($this, 'show') );
		}
	}

	private function the_pages_breadcrumb($parent_ID) {		
		if ($parent_ID != 0) {
			$parent = get_page($parent_ID);
			$this->pageBreadcrumb = "<span><a href=\"" . $parent->guid . "\">".$parent->post_title."</a></span> &raquo; " . $this->pageBreadcrumb;
			$this->the_pages_breadcrumb($parent->post_parent);
		} elseif ( $parent_ID == 0 ) {
			$this->pageBreadcrumb .= "<span>" . get_the_title(). "</span>";
			echo $this->pageBreadcrumb;
		}
	}
	private function getParentList($str) {
		$arr = explode("|",$str);
		for ($i=0; $i<count($arr)-1; $i++) $arr[$i] = '<span>'.$arr[$i].'</span> &raquo; ';
		return implode("", $arr);
	}
	private function is_wp_commerce_page() {
		if ( function_exists('wpsc_is_product') && function_exists('wpsc_is_in_category') ) {
			if ( wpsc_is_product() || wpsc_is_in_category() ) return true;
			else return false;
		} else return false;
	}
	public function show() {
		global $post;
		echo '<nav id="bread-crumbs">';
		if ( ! is_home() ) {
			echo '<span id="bread-crumbs-title">' . __('Location:', QQWORLD_FW) . '</span>';
			echo "<span><a href=\"".get_option('home')."\" title=\"".get_bloginfo('name')."\">" . __('Home') . "</a></span> &raquo; ";
			if ( $this->is_wp_commerce_page() ) { // Breadcrumbs for WP Commerce
				wpsc_output_breadcrumbs(array (
					'before-breadcrumbs' => '',
					'after-breadcrumbs'  => '',
					'before-crumb'       => '<span>',
					'after-crumb'        => '</span>',
					'show_home_page'     => false
				));
				if (wpsc_is_single_product()) echo '&raquo; <span>'. get_the_title() .'</span>';
				elseif ( wpsc_is_in_category() ) echo " &raquo; <span>" . __('Products list', QQWORLD_FW) . "</span>";
				else echo  __('Tags:', QQWORLD_FW) . single_tag_title('', false) . "</strong></span> &raquo; <span>" . __('Products list', QQWORLD_FW) . "</span>";
			} else if ( is_category() ) {
				$cate = single_term_title("",false);
				$cat = get_cat_ID($cate);
				echo $this->getParentList(get_category_parents($cat, TRUE,"|"));
				echo "<span>" . __('Articles list', QQWORLD_FW) . "</span>";
			} elseif ( is_archive() && !is_category() ) {
				echo "<span><strong>";
				if ( is_tag() ) echo __('Tags:', QQWORLD_FW) . single_tag_title('', false) . "</strong></span> &raquo; <span>" . __('Articles list', QQWORLD_FW) . "</span>";
				elseif ( is_day() ) echo the_time('M d,Y') . "</strong></span> &raquo; <span>" . __('Articles list', QQWORLD_FW) . "</span>";
				elseif ( is_month() ) echo the_time('M,Y') . "</strong></span> &raquo; <span>" . __('Articles list', QQWORLD_FW) . "</span>";
				elseif ( is_year() ) echo the_time('Y') . "</strong></span> &raquo; <span>" . __('Articles list', QQWORLD_FW) . "</span>";
				elseif ( is_author() ) {
					$curauth = wp_get_current_user();
					echo $curauth->display_name . "</strong></span> &raquo; <span>" . __('Articles list', QQWORLD_FW) . "</span>";
				} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) echo "blog</strong>";
				echo "</span>";
			} elseif ( is_search() ) {
				echo "<span>".__('Your search is:', QQWORLD_FW)."</span><strong>";
				echo the_search_query() . "</strong></span> &raquo; <span>" . __('Articles list', QQWORLD_FW) . "</span>";
			} elseif ( is_404() ) {
				echo "<span>".__('Oops, Look seems we lost something...(404)', QQWORLD_FW)."</span>";
			} elseif ( is_single() && !is_attachment() ) {
				$category = get_the_category($post->ID);
				//echo wpsc_output_breadcrumbs();
				if (count($category)!=0) echo $this->getParentList(get_category_parents($category[0]->cat_ID, TRUE, '|'));
				echo "<span>".get_the_title()."</span>";
			} elseif ( is_page() ) {
				$this->the_pages_breadcrumb($post->post_parent);
			} elseif ( is_attachment() ) {
				if ( ! empty( $post->post_parent ) ) : ?>
					<span><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( sprintf( __( 'Return to %s', QQWORLD_FW ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>" rel="gallery">
					<?php echo get_the_title( $post->post_parent ); ?></a> &raquo; </span>
				<?php endif; ?>
					<span><?php echo get_the_title() . __('Attachment', QQWORLD_FW); ?></span>
				<?php
			}
		}
		echo "</nav>";
	}

	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<p><?php _e('For example:', QQWORLD_FW); ?></p>
						<pre class="brush: php">&lt;?php do_action('qqworld_runtime_breadcrumb'); ?&gt;</pre>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
$qqworld_runtime_breadcrumb = new qqworld_runtime_breadcrumb;
?>