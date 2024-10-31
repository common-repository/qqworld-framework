<?php
class qqworld_sliders extends qqworld_fw_members {
	var $post_type;
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('Sliders', QQWORLD_FW);
		$this->guid = 'sliders';
		$this->parent = 'sliders';
		$this->core = false;
		$qqworld_fw_members[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
	}

	public function init() {
		$this->post_type = 'qqworld_slider';
		if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid ) || $this->core ) {
			if ( !current_theme_supports('qqworld_fw_runtime_metabox') ) add_theme_support('qqworld_fw_runtime_metabox');
			if ( !current_theme_supports('qqworld_fw_runtime_posttype') ) add_theme_support('qqworld_fw_runtime_posttype');
			if ( !current_theme_supports('qqworld_fw_runtime_attachment_meta') ) add_theme_support('qqworld_fw_runtime_attachment_meta');

			add_filter( 'manage_'.$this->post_type.'_posts_columns', array($this, 'sliders_columns'), 0 );
			add_action( 'manage_'.$this->post_type.'_posts_custom_column', array($this, 'custom_slider_columns'), 2 );
			add_filter( 'qqworld_fw_define_custom_posttypes', array($this, 'add_post_type') );
			add_filter( 'qqworld_fw_define_meta_box', array($this, 'add_metabox') );
			add_action( 'wp_ajax_get_slider_image', array($this, 'get_slider_image') );
			add_action( 'wp_ajax_nopriv_get_slider_image', array($this, 'get_slider_image') );
			add_filter( 'qqworld_fw_define_attachment_meta', array($this, 'add_attachment_meta') );
			add_action( 'home_slider', array($this, 'render_home_slier') );
			add_filter( 'qqworld_fw_define_meta_box', array($this, 'add_metabox') );
		}
	}

	public function render_home_slier() {
		$post_id = get_option('qqworld_fw_sliders_home_slider');
		if ( empty($post_id) ) {
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'qqworld_slider',
			);
			$slider = get_posts($args);
			if (count($slider) == 1) $post_id = $slider[0]->ID;
		}
		$args = array( $post_id, 'home_slider' );
		do_action_ref_array('qqworld_fw_slider_render_home_slider', $args);
	}

	public function add_attachment_meta($form_fields) {
		$form_fields["website"] = array(
			"label" => __( 'Website', QQWORLD_FW ),
			'helps' => __( 'Website for Slider.', QQWORLD_FW )
		);
		return $form_fields;
	}

	public function sliders_columns(){
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title'),
			'shortcode' => __('Shortcode', QQWORLD_FW),
			'author' => __('Author'),
			'slider_image' => __('Slider Images', QQWORLD_FW),
			'date' => __('Date'),
		);
	}

	public function custom_slider_columns( $column ) {
		global $post;
		switch ($column) {
			case "name" :
				break;
			case 'shortcode':
				echo '[qqworldSlider id="'.$post->ID.'"]';
				break;
			case 'slider_image':
				$slider_image = get_post_meta( $post->ID, 'slider_image', true);
?>
<ul class="upload_images_block small_size">
	<?php if ( !empty($slider_image) ) foreach ($slider_image as $attachment_id) : ?>
		<li><?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?><input type="hidden" name="meta_key[slider_image][]" value="<?php echo $attachment_id; ?>" /></li>
	<?php endforeach; ?>
</ul>
<?php
				break;
		}
	}

	public function get_slider_image() {
		$attachment_id = $_POST['id'];
		echo wp_get_attachment_image( $attachment_id, 'thumbnail' );		
		die();
	}

	public function add_post_type($posttypes) {
		$posttypes[] = array(
			'post_type' => 'qqworld_slider',
			'singular_name' => __('Slider', QQWORLD_FW),
			'plural_name' => __('Sliders', QQWORLD_FW),
			'args' => array(
				'description' => __('QQWorld Sliders', QQWORLD_FW),
				'show_in_menu' => true,
				'supports' => array('title'),
				'show_ui' => true
			)
		);
		return $posttypes;
	}

	public function add_metabox($metaboxs) {
		global $post;
		$metaboxs[] = array(
			'id' => 'preview',
			'title' => __('Preview Slider', QQWORLD_FW),
			'post_type' => array('qqworld_slider'),
			'callback' => array($this, 'preview_slider')
		);
		$metaboxs[] = array(
			'id' => 'upload_images',
			'title' => __('Add Images of Slider', QQWORLD_FW),
			'post_type' => array('qqworld_slider'),
			'callback' => array($this, 'insert_images'),
			'fields' => array(
				array(
					'id' => 'slider_image'
				)
			)
		);
		$settings = get_post_meta($post->ID, 'slider_config', true);
		if (!$settings) $settings = array();
		$fields = apply_filters( 'qqworld_fw_slider_configuration', '', $settings );
		$metaboxs[] = array(
			'id' => 'slider_configuration',
			'title' => __('Slider configuration', QQWORLD_FW),
			'post_type' => array($this->post_type),
			'fields' => $fields
		);
		$metaboxs[] = array(
			'id' => 'quick_upload',
			'title' => __('Quick Upload', QQWORLD_FW),
			'post_type' => array($this->post_type),
			'callback' => array($this, 'quick_upload'),
		);
		return $metaboxs;
	}

	public function preview_slider() {
		$args = array( $_GET['post'], 'qqworld-slider-'.$_GET['post'] );
		do_action_ref_array( 'qqworld_fw_render_slider_preview', $args );
	}

	public function quick_upload() {
		global $post;			
		wp_enqueue_script('plupload-handlers');
		
		$form_class='media-upload-form type-form validate';
		$post_id = $post->ID;
		$_REQUEST['post_id'] = $post_id;
		?>
		<style>#media-items { width: auto; }</style>
	
		<?php media_upload_form(); ?>
	
		<script type="text/javascript">
		var post_id = <?php echo $post_id; ?>;
		var shortform = 3;
		</script>
		<div id="media-items" class="hide-if-no-js"></div>
	<?php
	}

	public function insert_images() {
		wp_nonce_field( 'qqworld_slider_qqworld_meta_box', 'qqworld_slider_qqworld_meta_box_nonce' );
		$post_id = $_GET['post'];
		$slider_image = get_post_meta( $post_id, 'slider_image', true);
		if (!$slider_image) $slider_image = array();
?>
		<ul class="upload_images_block">
			<?php if ( !empty($slider_image) ) foreach ($slider_image as $attachment_id) :?>
				<li class="slider_image" data-attachment-id="<?php echo $attachment_id; ?>" data-post-id="<?php echo $post_id; ?>"><?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?><input type="hidden" name="meta_key[slider_image][]" value="<?php echo $attachment_id; ?>" /></li>
			<?php endforeach ?>
			<li class="upload_images" data-post-id="<?php echo $_GET['post']; ?>" title="<?php _e('Upload a Image', QQWORLD_FW); ?>">+<input type="hidden" name="meta_key[slider_image][]" value="" /></li>
			<li class="remove_images" data-post-id="<?php echo $_GET['post']; ?>" title="<?php _e('Remove a Image', QQWORLD_FW); ?>"><?php _e('Drag to here', QQWORLD_FW) ?></li>
		</ul>
		<div style="clear: both;"></div>
<?php
	}
}
new qqworld_sliders;
?>