<?php
class qqworld_runtime_common extends qqworld_fw_members {
	var $desc;
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Common', QQWORLD_FW);
		$this->guid = 'common';
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
			foreach ( get_theme_support('qqworld_fw_' . $this->parent . '_' . $this->guid)[0] as $common ) $this->commons($common);
			add_action( 'qqworld-fw-'.$this->parent, array($this, 'add_to_cpanel') );			
		}
	}

	public function commons($common) {
		switch ($common) {
			case 'wp_title':
				add_filter( 'wp_title', array($this, 'wp_title'), 10, 2 );
				$this->desc['wp_title'] = __('Using for page title.', QQWORLD_FW);
				break;
			case 'chinese':
				$qmr_work_tags = array('bloginfo','comment_author','comment_text','list_cats','link_name','link_description','link_notes','single_post_title','term_name','term_description','the_title','the_content','the_excerpt','wp_title','widget_title');
				foreach ( $qmr_work_tags as $qmr_work_tag ) remove_filter ($qmr_work_tag, 'wptexturize');
				$this->desc['chinese'] = __('Ban on WordPress automatically translate half Angle symbol for the Angle of symbol, used in Chinese.', QQWORLD_FW);
				break;
			case 'settings':
				add_action('admin_init', array($this, 'settings') );
				add_action( 'wp_head', array($this, 'add_settings_to_head') );
				add_action( 'wp_footer', array($this, 'add_settings_to_footer') );
				$this->desc['settings'] = __('The custom head and footer code, such as statistical code, site icon code.', QQWORLD_FW);
				break;
			case 'seo':				
				add_action('admin_init', array($this, 'seo_settings') );
				add_action( 'wp_head', array($this, 'seo' ), 9 );
				$this->desc['seo'] = __('Using for SEO.', QQWORLD_FW);
				break;
			case 'login_register':
				add_filter('login_headerurl', array($this, 'wp_login_url') );
				add_filter('login_headertitle', array($this, 'wp_login_title') );
				add_action('admin_init', array($this, 'remove_default_password_nag') );
				$this->desc['login_register'] = __('Using for wp_login.php & wp_singup.php.', QQWORLD_FW);
				break;
		}
	}
	/***********************************************************************************************************/
	public function wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

		return $title;
	}
	/***********************************************************************************************************/
	public function add_settings_to_head() {
		echo get_option('qqworld_fw_header_field');
	}
	public function add_settings_to_footer() {
		echo get_option('qqworld_fw_footer_field');
	}
	public function settings() {
		add_settings_section('theme_general_setting', __('Theme General Settings', QQWORLD_FW), '', 'general');
		// Add the field with the names and function to use for our new settings, put it in our new section
		add_settings_field('header', __('Header(&lt;header&gt;..&lt;/header&gt;)', QQWORLD_FW), array($this, 'header_callback_function'), 'general', 'theme_general_setting', array( 'label_for' => 'qqworld_fw_header_field' ));
		add_settings_field('footer', __('Footer(..&lt;/body&gt;)', QQWORLD_FW), array($this, 'footer_callback_function'), 'general', 'theme_general_setting', array( 'label_for' => 'qqworld_fw_footer_field' ));

		register_setting('general', 'qqworld_fw_header_field');
		register_setting('general', 'qqworld_fw_footer_field');
	}
	public function header_callback_function() {
		$field = array(
			'description' => '<strong>'.__('For example:', QQWORLD_FW).'</strong><br /><br />&lt;link rel="shortcut icon" href="favicon.ico" /&gt;<br />&lt;link rel="icon" href="favicon.gif" type="image/gif" /&gt;',
			'type' => 'textarea',
			'name' => 'qqworld_fw_header_field',
			'id' => 'qqworld_fw_header_field',
			'size' => 'large'
		);						
		echo qqworld_fw::create_form( $field, get_option('qqworld_fw_header_field') );
	}
	public function footer_callback_function() {
		$field = array(
			'description' => "<strong>".__('For example:', QQWORLD_FW)."</strong><br /><br />&lt;script type=\"text/javascript\"&gt;<br />
	<br />
	var _gaq = _gaq || [];<br />
	_gaq.push(['_setAccount', 'UA-*******-*']);<br />
	_gaq.push(['_trackPageview']);<br />
	<br />
	(function() {<br />
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;<br />
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';<br />
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);<br />
	})();<br />
	<br />
	&lt;/script&gt;",
			'type' => 'textarea',
			'name' => 'qqworld_fw_footer_field',
			'id' => 'qqworld_fw_footer_field',
			'size' => 'large'
		);						
		echo qqworld_fw::create_form( $field, get_option('qqworld_fw_footer_field') );
	}
	/***********************************************************************************************************/
	public function seo() {
		global $post;
		if ( !(is_home()) and !(is_single()) ) { ?><meta name=¡±Googlebot¡± content=¡±noindex,follow¡± /><?php };
			$keywords = get_option('qqworld_fw_meta_keywords_field');
			if (is_home()) $description = get_bloginfo('description');
			elseif (is_single()) {
				$description = $post->post_title;
				$tags = wp_get_post_tags($post->ID);
				foreach ($tags as $tag ) $keywords = $keywords . $tag->name . ", ";
			} elseif (is_category()) $description = category_description();
		else $description = get_the_title();
	?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="author" contect="Michael Q Wang" />
<meta name="description" content="<?php echo $description; ?>" />
<?php
	}
	public function seo_settings() {
		add_settings_field('meta_keywords', __('Keywords', QQWORLD_FW), array($this, 'meta_keywords_callback_function'), 'general', 'theme_general_setting', array( 'label_for' => 'qqworld_fw_meta_keywords_field' ));
		register_setting('general', 'qqworld_fw_meta_keywords_field');
	}
	function meta_keywords_callback_function() {
		$field = array(
			'type' => 'textfield',
			'name' => 'qqworld_fw_meta_keywords_field',
			'id' => 'qqworld_fw_meta_keywords_field',
			'description' => __("Using for SEO.", QQWORLD_FW),
			'size' => 'large'
		);						
		echo qqworld_fw::create_form($field, get_option( 'qqworld_fw_meta_keywords_field' ) );
	}
	/***********************************************************************************************************/
	public function wp_login_url() {
		return home_url();
	}
	public function wp_login_title() {
		return get_bloginfo('name') . ' - ' . get_bloginfo('description', 'display');
	}
	function remove_default_password_nag() {
		global $user_ID;
		delete_user_setting('default_password_nag', $user_ID);
		update_user_option($user_ID, 'default_password_nag', false, true);
	}
	/***********************************************************************************************************/
	public function add_to_cpanel() {
?>
		<tr valign="top">
			<td>
				<fieldset>
					<legend><span>-</span> <?php echo $this->name; ?></legend>
					<div class="fieldBox">
						<ol>
						<?php foreach (get_theme_support('qqworld_fw_runtime_common')[0] as $common) : ?>
							<li><strong><?php echo $common; ?></strong> / <?php echo $this->desc[$common]; ?></li>
						<?php endforeach; ?>
						</ul>
					</div>
				 </fieldset>
			</td>
		</tr>
<?php
	}
}
new qqworld_runtime_common;
?>