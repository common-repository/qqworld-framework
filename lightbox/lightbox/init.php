<?php
class qqworld_lightbox extends qqworld_fw_members {
	public function sign_up() {
		global $qqworld_fw_members;
		$this->name = __('LightBox', QQWORLD_FW);
		$this->guid = 'lightbox';
		$this->parent = 'lightbox';
		$this->core = true;
		$qqworld_fw_members[] =  array(
			'name' => $this->name,
			'guid' => $this->guid,
			'parent' => $this->parent,
			'core' => $this->core
		);
	}

	public function init() {
		if ( current_theme_supports('qqworld_fw_' . $this->parent . '_' . $this->guid ) || $this->core ) {
			add_filter('the_content', array($this, 'replace'));
		}
	}

	public function selector() {
		$selector = 'lightBox';
		return apply_filters('qqworld_lightbox_selector', $selector);
	}
	function replacement($matches) {
		return '<a href="'.$matches[2].$matches[3].$matches[4].'" rel="'.$this->selector().'"><img';
	}
	function replace($string) {
		$pattern = '/(<a(.*?)href="([^"]*.)(bmp|gif|jpeg|jpg|png)"(.*?)><img)/i';
		return preg_replace_callback($pattern, array(&$this, 'replacement'), $string);
	}

}
new qqworld_lightbox;
?>