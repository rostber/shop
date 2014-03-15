jQuery(function ($) {

	pyro.published = {
		init: function () {
			$(".check, .not_check").click(function(event) {
				if ( $(this).hasClass("not_check") ) $(this).removeClass('not_check').addClass('check');
				else $(this).removeClass('check').addClass('not_check');
				
				$.ajax($(this).attr("href"), {});
				
				event.preventDefault();
			});
		}
	};
	
	pyro.image_delete = {
		init: function () {
			$(".delete_image").click(function(event) {
				$(this).parent().html('<input type="hidden" name="delete_image" value="'+$(this).attr("data-key")+'" />');
				event.preventDefault();
			});
		}
	};

	pyro.published.init();	
	pyro.image_delete.init();

});