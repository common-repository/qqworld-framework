if (!QQWorldFramework) var QQWorldFramework = {};

QQWorldFramework.WP_media = function(opts) {
	/*
	opts.button: object of target,
	opts.insert: function(button, attachment) {
		var data = {
			action: 'get_slider_image',
			id: attachment.id
		};
		$.post(ajaxurl, data, function(data) {
			button.replaceWith( '<li class="slider_image">' + data + '<input type="hidden" name="meta_key[slider_image]" value="'+attachment.id+'" /></li>' );
		});
	}

	*/
	var $ = jQuery;
	var file_frame;
	var button;
	var open = function(e) {
		e.preventDefault();
		button = $(this);
		var post_id = button.attr('data-post-id') ? button.attr('data-post-id') : '0'; // Set post_id
		
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.uploader.uploader.param( 'post_id', post_id );
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = post_id;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			frame: 'post',
			state: 'insert',
			title: button.data( 'uploader_title' ),
			button: {
				text: button.data( 'uploader_button_text' ),
			},
			library: {
				type: 'image',
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		file_frame.on( 'open', function() {
			if ( button.attr('data-attachment-id') ) {
				var selection = file_frame.state().get('selection');			
			
				var attachment_ids = [button.attr('data-attachment-id')];

				attachment_ids.forEach(function(id) {
					attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				});
			}
		});

		file_frame.on( 'menu:render:default', function(view) {
			// Store our views in an object.
			var views = {};

			// Unset default menu items
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');

			// Initialize the views in our view object.
			view.set(views);
		});

		// When an image is selected, run a callback.
		file_frame.on( 'insert', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			opts.insert(button, attachment, post_id);
		});

		// Finally, open the modal
		file_frame.open();	
	}
	this.action = {
		allow: function() {
			$(document).on('click', opts.button, open);
		},
		disable: function() {
			$(document).off('click', opts.button, open);
		}
	}
	this.action.allow();
	return this;
}

// for Qtag addbutton callback
QQWorldFramework.getSelectedText = function(canvas){ // "canvas" is what they call the textarea of the editor
	canvas.focus();
	if (document.selection) { // IE
		return document.selection.createRange().text;
	}else{ // standards
		return canvas.value.substring(canvas.selectionStart, canvas.selectionEnd);
	}
}

//判断对象是否在数组中
QQWorldFramework.in_array = function(obj, arr) {
	for (var a in arr ) {
		if (obj == arr[a]) return true;
	}
	return false;
}

// Set and Get Cookies
QQWorldFramework.cookies = {
	Get: function (sName) {
		var aCookie = document.cookie.split("; ");
		for (var i=0; i < aCookie.length; i++) {
			var aCrumb = aCookie[i].split("=");
			if (sName == aCrumb[0]) return unescape(aCrumb[1]);
		}
		return null;
	},
	Set: function(sName, sValue, time) {
		date = new Date();
		date.setTime(date.getTime() + time);
		document.cookie = sName + "=" + escape(sValue) + "; expires=" + date.toGMTString();
	}
};

//随机数函数
QQWorldFramework.getRandom = function(x, y) {
	return parseInt(Math.random()*(x-y-1)+y+1);
};

// tabs for cpanel.php
QQWorldFramework.tabs = function() {
	var $ = jQuery, current=0, keyword;
	if ($('.QQWorld_tabs').length) {
		keyword = QQWorldFramework.cookies.Get('card_name');
		for (var i=0; i<$('.QQWorld_tabs li').length; i++) {
			if ($('.QQWorld_tabs li').eq(i).hasClass(keyword)) current = i;
		}
		$('.tb_unit').hide().eq(current).show();
		$('.QQWorld_tabs li').eq(current).addClass('current');
		$(document).on('click', '.QQWorld_tabs li', function() {
			var index = $(this).index();
			QQWorldFramework.cookies.Set('card_name', $(this).attr('class').split(" ")[0]);
			if ($('.tb_unit').eq(index).is(':hidden')) {
				$('.QQWorld_tabs li.current').removeClass('current');
				$('.QQWorld_tabs li').eq(index).addClass('current');
				
				$('.tb_unit:visible').slideUp();
				$('.tb_unit').eq(index).slideDown();
			}
		});
	}
	$(document).on('click', '.QQWorld_admin_table fieldset > legend', function() {
		if ( $('span', this).html() == '-' ) $('span', this).html('+');
		else $('span', this).html('-');
		$(this).next().toggle('normal');
	});
}

// Style of upload images for forms
QQWorldFramework.imageUploader = function() {
	var $ = jQuery;
	var file_frame;
	$(document).on('click', 'a.qqworld_image_uploader', function(e) {
		var _this = this;
		e.preventDefault();
		$('body').data('qqworld_current_slider_image', $(this));
		var set_to_post_id = $(_this).attr('rel') != '' ? $(_this).attr('rel') : '0'; // Set this
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = set_to_post_id;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			frame: 'post',
			state: 'insert',
			title: $(_this).data( 'uploader_title' ),
			button: {
				text: $(_this).data( 'uploader_button_text' ),
			},
			library: {
				type: 'image',
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		file_frame.on( 'menu:render:default', function(view) {
			// Store our views in an object.
			var views = {};

			// Unset default menu items
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');

			// Initialize the views in our view object.
			view.set(views);
		});

		// When an image is selected, run a callback.
		file_frame.on( 'insert', function() {
			//alert($(_this).html())
			var attachment = file_frame.state().get('selection').first().toJSON();
			//	console.log(attachment);
			$('body').data('qqworld_current_slider_image').children('img').removeClass('upload_images_button').attr('src', attachment.url);
			$('body').data('qqworld_current_slider_image').next('input').val(attachment.url);
			//	window.formfield.find('').val(attachment.title);
		});

		// Finally, open the modal
		file_frame.open();
	});
}

QQWorldFramework.fileUploader = function() {
	var $ = jQuery;
	// WP 3.5+ uploader
	var file_frame;	
	$(document).on('click', 'input[type="button"].button.extendd-browse', function(e) {
		e.preventDefault();
		var button = $(this);
		var set_to_post_id = button.attr('rel') != '' ? button.attr('rel') : '0'; // Set this
		
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = set_to_post_id;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			frame: 'post',
			state: 'insert',
			title: button.data( 'uploader_title' ),
			button: {
				text: button.data( 'uploader_button_text' ),
			},
			library: {
				type: 'image',
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		file_frame.on( 'menu:render:default', function(view) {
			// Store our views in an object.
			var views = {};

			// Unset default menu items
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');

			// Initialize the views in our view object.
			view.set(views);
		});

		// When an image is selected, run a callback.
		file_frame.on( 'insert', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
		//	console.log(attachment);
			button.prev().val(attachment.url);
		//	window.formfield.find('').val(attachment.title);
		});

		// Finally, open the modal
		file_frame.open();
	});
	
	jQuery('input[type="button"].button.extendd-browse').next().on('click', function(e) {  
		e.preventDefault();		
		jQuery(this).prev().prev().val('');
	});
}

// 模擬菜單樣式
QQWorldFramework.simulate_select = function() {
	jQuery('.selectstyle').chosen({
		allow_single_deselect: true
	});
}

//開關按鈕樣式
QQWorldFramework.switch_button_action = function() {
	var $ = jQuery;
	$('.switch_button').click(function() {
		if ($(this).hasClass('on')) {
			$(this).removeClass('on').next('input').val('false');
		} else {			
			$(this).addClass('on').next('input').val('true');
		}
	});
}

QQWorldFramework.color_picker = function() {
	var $ = jQuery;
	$('.wxq_colors').wpColorPicker();
}

QQWorldFramework.radioStyle = function() {
	var $ = jQuery;
	if ($('.wxq_radios').length) {
		$('.wxq_radios').append('<div style="clear: both;"></div>').children('.wxq_radio').bind('click', function() {
			$(this).parent().children('.wxq_radio').removeClass('checked');
			$(this).addClass('checked');
			$(this).parent().find('input').val($(this).attr('rel'));
		});
	}
}

QQWorldFramework.checkboxStyle = function() {
	var $ = jQuery;
	if ($('.wxq_checkboxs').length) {
		$('.wxq_checkboxs').append('<div style="clear: both;"></div>').children('.wxq_checkbox').on('click', function() {
			var value = [];
			$(this).toggleClass('checked');
			if ($(this).hasClass('checked')) $(this).prev().attr('checked', 'true');
			else $(this).prev().removeAttr('checked');
		});
	}
}

QQWorldFramework.datepicker = function() {
	var $ = jQuery;
	$.datepicker.regional['zh-CN'] = {
		closeText: '关闭',
		prevText: '&#x3c;上月',
		nextText: '下月&#x3e;',
		currentText: '今天',
		monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		monthNamesShort: ['一','二','三','四','五','六','七','八','九','十','十一','十二'],
		dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
		dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
		dayNamesMin: ['日','一','二','三','四','五','六'],
		weekHeader: '周',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '年'
	};
	$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
	$( ".wxq_datepicker" ).datepicker({
		//changeMonth: true,
		changeYear: true
	});
}

/* For Slider */
QQWorldFramework.slider_upload_image = function() {
	var $ = jQuery;
	var upload = QQWorldFramework.WP_media({
		button: 'li.upload_images',
		insert: function(button, attachment, post_id) {
			var data = {
				action: 'get_slider_image',
				id: attachment.id
			};
			$.post(ajaxurl, data, function(data) {
				button.before( '<li class="slider_image" data-attachment-id="'+attachment.id+'" data-post-id="'+post_id+'">' + data + '<input type="hidden" name="meta_key[slider_image][]" value="'+attachment.id+'" /></li>' );
			});
		}
	})

	var change = QQWorldFramework.WP_media({
		button: 'li.slider_image',
		insert: function(button, attachment, post_id) {
			var data = {
				action: 'get_slider_image',
				id: attachment.id
			};
			$.post(ajaxurl, data, function(data) {
				button.replaceWith( '<li class="slider_image" data-attachment-id="'+attachment.id+'" data-post-id="'+post_id+'">' + data + '<input type="hidden" name="meta_key[slider_image][]" value="'+attachment.id+'" /></li>' );
			});
		}
	})

	$('li.slider_image').QQWorldTouch({
		onmove: function(t) {
			change.action.disable();
			t.action.goal({
				target: $('li.remove_images')
			});
		},
		onend: function(t) {
			if (t.status.move) {
				$(t.target).animate({top: 0, left: 0}, 'normal');
				setTimeout(change.action.allow, 10);
				var removeCurrent = function() {
					$(t.current).remove();
				}
				if (t.status.goal) {
					var del = confirm('Are you sure?');
					if (del) {
						$(t.current).hide(500);
						setTimeout(removeCurrent, 500);
					}
				}
			}
		}
	});
}

/* The notification on save attachment custom fields by ajax */
QQWorldFramework.save_attachment_custom_fields_by_ajax = function() {
	var $ = jQuery;
	var ajax_is_running = false;
	$(document).on('change', '.compat-item input, .compat-item textarea', function() {
		$('.settings-save-status .spinner').show();
		ajax_is_running = true;
	}).on('focus', '.compat-item input, .compat-item textarea', function() {
		if (ajax_is_running) {		
			$('.settings-save-status .spinner').hide();
			$('.settings-save-status .saved').show();
			window.setTimeout("jQuery('.settings-save-status .saved').hide()", 1000);
			ajax_is_running = false;
		}
	});
}

jQuery(function($) {
	QQWorldFramework.imageUploader();
	QQWorldFramework.fileUploader();
	QQWorldFramework.simulate_select();
	QQWorldFramework.slider_upload_image();
	QQWorldFramework.switch_button_action();
	QQWorldFramework.color_picker();
	QQWorldFramework.radioStyle();
	QQWorldFramework.checkboxStyle();
	QQWorldFramework.tabs();
	QQWorldFramework.datepicker();
	QQWorldFramework.save_attachment_custom_fields_by_ajax();
});